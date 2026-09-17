<?php

namespace App;

use PDO;
use PDOStatement;
use Throwable;
use Exception;

class Model
{
    public const HAS_ONE = "hasOne";
    public const HAS_MANY = "hasMany";

    private $attributes = [];
    private $relationshipRecords = [];
    protected static $relationships = []; // 'relName' => [relType, relClass, foreignKey, primaryKey]
    protected static $tableName = "";
    protected static $fillable = [];
    protected static $guarded = [];
    private static $whereConditions = [];
    private static $eagerLoads = [];
    private static $orderByStates = [];
    private static $params = [];
    private static $updateArgs = [];
    private static PDO $db;

    public static function initDB()
    {
        $dbName = Config::get('db_name');
        $dbPort = Config::get('db_port');
        $dbHost = Config::get('db_host');
        $dbUsername = Config::get('db_user');
        $dbPassword = Config::get('db_password');
        $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;";
        try {
            self::$db = new PDO($dsn, $dbUsername, $dbPassword, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (Throwable $e) {
            echo "DB Init failed: " . $e->getMessage();
            die;
        }
    }

    public function __get(string $name)
    {
        if (isset(static::$relationships[$name])) {
            if (isset($this->relationshipRecords[$name])) return $this->relationshipRecords[$name];
            $this->loadRelation($name);
            return $this->relationshipRecords[$name];
        }
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, mixed $value)
    {
        if (isset(static::$relationships[$name])) {
            $this->relationshipRecords[$name] = $value;
        } else {
            $this->attributes[$name] = $value;
        }
    }

    private static function constructQuery($mode = "r")
    {
        $query = "";
        $where = "";
        if (!empty(static::$whereConditions)) {
            $where = " WHERE";
            $first = true;
            foreach (static::$whereConditions as $cond) {
                if (!$first) $where .= " " . $cond[3];
                $where .= " `" . $cond[0] . "` " . $cond[1] . " " . $cond[2];
                if ($first) $first = false;
            }
        }
        switch ($mode) {
            case "c":
                $primaryKeys = implode(',', array_map(fn($pk) => "`$pk`", static::$guarded));
                $fillables = implode(',', array_map(fn($c) => "`$c`", static::$fillable));
                $columns = "(" . $primaryKeys . "," . $fillables . ")";
                $colCount = count(static::$fillable);
                $pkCount = count(static::$guarded);
                $paramCount = count(static::$params);
                if ($paramCount % $colCount != 0) throw new Exception("Argument not enough.");
                $row = "(" . trim(str_repeat("NULL,", $pkCount) . str_repeat("?,", $colCount), ',') . "),";
                $rowCount = $paramCount / $colCount;
                $values = trim(str_repeat($row, $rowCount), ',');
                $query .= "INSERT INTO `" . static::$tableName . "` " . $columns . "VALUES " . $values;
                break;
            case "r":
                $orderBy = "";
                if (!empty($orderByStates)) {
                    $orderBy = " ORDER BY";
                    foreach ($orderByStates as $state) {
                        $orderBy .= " `" . $state[0] . " " . ($state[1] ? 'DESC' : 'ASC') . ",";
                    }
                    $orderBy = trim($orderBy, ',');
                }
                $query .= "SELECT * FROM `" . static::$tableName . "`" . $where . $orderBy;
                break;
            case "u":
                $query = "UPDATE `" . static::$tableName . "` SET ";
                $arr = [];
                foreach (static::$updateArgs as $column => $val) {
                    $query .= " `" . $column . "` = ?,";
                    $arr[] = $val;
                }
                static::$params = array_merge($arr, static::$params);
                $query = trim($query, ",");
                $query .= $where;
                break;
            case "d":
                $query = "DELETE FROM `" . static::$tableName . "`" . $where;
                break;
            default:
                $query = "";
        }
        static::$whereConditions = [];
        static::$orderByStates = [];
        static::$updateArgs = [];
        // var_dump($query);
        return $query;
    }

    private static function execQueryWithParams(string $query): PDOStatement
    {
        $stmt = self::$db->prepare($query);
        foreach (static::$params as $i => $val) {
            $type = PDO::PARAM_STR;
            if (is_int($val)) $type = PDO::PARAM_INT;
            elseif (is_bool($val)) $type = PDO::PARAM_BOOL;
            elseif (is_null($val)) $type = PDO::PARAM_NULL;
            $stmt->bindValue($i + 1, $val, $type);
        }
        $stmt->execute();
        static::$params = [];
        return $stmt;
    }

    private function loadRelation(string $relName, array $childRels = [])
    {
        $rel = static::getRelation($relName);
        if (empty($rel)) throw new Exception("Relation not found");
        [$type, $class, $fk, $pk] = $rel;
        switch ($type) {
            case 'hasOne':
                $record = empty($childRels)
                    ? call_user_func_array([$class, 'where'], [$fk, $this->attributes[$pk]])->first()
                    : call_user_func_array([$class, 'with'], [$childRels])->where($fk, $this->attributes[$pk])->first();
                $this->relationshipRecords[$relName] = $record;
                break;
            case 'hasMany':
                $records = empty($childRels)
                    ? call_user_func_array([$class, 'where'], [$fk, $this->attributes[$pk]])->getAll()
                    : call_user_func_array([$class, 'with'], [$childRels])->where($fk, $this->attributes[$pk])->getAll();
                $this->relationshipRecords[$relName] = $records;
                break;
            default:
        }
    }

    private static function eagerLoadRelation(array &$models, string $relName, array $childRels = [])
    {
        $rel = static::getRelation($relName);
        if (empty($rel)) throw new Exception("Relation not found");
        [$type, $class, $fk, $pk] = $rel;
        $ids = array_map(fn($m) => $m->$pk, $models);
        $relationRecords = empty($childRels)
            ? call_user_func_array([$class, 'whereIn'], [$fk, $ids])->getAll()
            : call_user_func_array([$class, 'with'], [$childRels])->whereIn($fk, $ids)->getAll();
        $group = [];
        foreach ($relationRecords as $rec) {
            $group[$rec->$fk][] = $rec;
        }
        foreach ($models as $model) {
            $model->$relName = $type === self::HAS_ONE ? ($group[$model->$pk][0] ?? null) : ($group[$model->$pk] ?? []);
        }
        return $models;
    }



    public static function where(string $column, mixed $value, $operator = '=', $prefix = 'AND')
    {
        static::$whereConditions[] = [$column, $operator, '?', $prefix];
        static::$params[] = $value;
        return new static();
    }
    public static function whereIn(string $column, array $value, $prefix = 'AND')
    {
        static::$whereConditions[] = [$column, 'IN', "(" . trim(str_repeat("?,", count($value)), ',') . ")", $prefix];
        static::$params = array_merge($value, static::$params);
        return new static();
    }
    public static function orWhere(string $column, mixed $value, $operator = '=')
    {
        return static::where($column, $value, $operator, 'OR');
    }
    public static function orWhereIn(string $column, array $value)
    {
        return static::whereIn($column, $value, 'OR');
    }
    public static function orderBy(string $column, $descending = true)
    {
        static::$orderByStates[] = [$column, $descending];
        return new static();
    }
    public static function count(): int
    {
        $query = static::constructQuery();
        $query = str_replace("*", "COUNT(*)", $query);
        $res = self::execQueryWithParams($query);
        $count = $res->fetchColumn();
        return $count;
    }
    public static function any(): bool
    {
        return static::count() > 0;
    }
    public function first()
    {
        $query = static::constructQuery();
        $res = self::execQueryWithParams($query);
        $record = $res->fetch(PDO::FETCH_ASSOC);
        if (!$record) return null;
        if (!empty(static::$eagerLoads) && !empty(static::$relationships)) {
            $eagerLoads = static::$eagerLoads;
            static::$eagerLoads = [];
            foreach ($eagerLoads as $idx => $val) {
                if (is_string($idx)) {
                    $this->loadRelation($idx, $val);
                } else {
                    $this->loadRelation($val);
                }
            }
        }
        $instance = new static();
        foreach ($record as $key => $val) {
            $instance->$key = $val;
        }
        return $instance;
    }
    public static function getAll(): array
    {
        $query = static::constructQuery();
        $res = self::execQueryWithParams($query);
        $records = $res->fetchAll(PDO::FETCH_ASSOC);
        $rows = [];
        foreach ($records as $rec) {
            $row = new static();
            foreach ($rec as $key => $val) {
                $row->$key = $val;
            }
            $rows[] = $row;
        }
        if (empty($rows)) return $rows;
        if (!empty(static::$eagerLoads) && !empty(static::$relationships)) {
            $eagerLoads = static::$eagerLoads;
            static::$eagerLoads = [];
            foreach ($eagerLoads as $idx => $val) {
                if (is_string($idx)) {
                    static::eagerLoadRelation($rows, $idx, $val);
                } else {
                    static::eagerLoadRelation($rows, $val);
                }
            }
        }
        return $rows;
    }
    public static function with(array $relations)
    {
        foreach ($relations as $key => $val) {
            static::$eagerLoads[$key] = $val;
        }
        return new static();
    }
    public static function add(array $data)
    {
        $args = [];
        foreach (static::$fillable as $key) {
            $args[] = $data[$key] ?? null;
        }
        static::$params = $args;
        $query = static::constructQuery("c");
        static::execQueryWithParams($query);
        return self::$db->lastInsertId();
    }
    public static function addMany(array $data)
    {
        $args = [];
        foreach($data as $datum) {
            foreach (static::$fillable as $key) {
                $args[] = $datum[$key] ?? null;
            }
        }
        static::$params = $args;
        $query = static::constructQuery("c");
        $res = static::execQueryWithParams($query);
        return $res->rowCount();
    }
    public static function update(array $data)
    {
        static::$updateArgs = $data;
        $query = static::constructQuery("u");
        $res = static::execQueryWithParams($query);
        static::$updateArgs = [];
        return $res->rowCount();
    }
    public static function delete()
    {
        $query = static::constructQuery("d");
        $res = static::execQueryWithParams($query);
        return $res->rowCount();
    }
    public static function getRelation(string $relNameOrClass): array
    {
        if (isset(static::$relationships[$relNameOrClass])) return static::$relationships[$relNameOrClass];
        foreach (static::$relationships as $rel) {
            if ($rel[1] === $relNameOrClass) return $rel;
        }
        return [];
    }
    public static function beginTransaction() {
        return self::$db->beginTransaction();
    }

    public static function commit() {
        return self::$db->commit();
    }

    public static function rollback() {
        return self::$db->rollBack();
    }

    public function asAssocArray()
    {
        $attr = $this->attributes;
        $relRecords = [];
        foreach ($this->relationshipRecords as $rec) $relRecords[] = $rec->asAssocArray();
        return array_merge($attr, $relRecords);
    }
}
