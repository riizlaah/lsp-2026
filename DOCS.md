# Documentation

Framework ini menggunakan arsitektur MVC, mirip dengan Laravel.

## Routing
Aturan routingnya sebagai berikut:
```
/{controllerClass}/{methodName}/{arg1}/{arg2}/.../{$argn}
```
`controllerClass` dan `methodName` itu *case-sensitive*. Jika `controllerName` tidak disediakan, maka akan fallback ke `index`. Sedangkan jika `methodName` tidak disediakan, maka akan fallback ke `index`.<br>
Ada aturan khusus juga jika request method-nya bukan `GET`. Pertama, jika `methodName` dan request method sama, maka method yang dicari adalah `{requestMethod}_`. Namun, jika keduanya berbeda, maka method yang dicari adalah `{methodName}_{requestMethod}`.
Kemudian semua bagian route setelah `controllerName` dan `methodName` dianggap sebagai argumen atau parameter methodnya. Perlu diperhatikan juga bahwa, semua argumen tersebut masih berupa *string*.<br>
Contoh alurnya seperti berikut:
```
/ (GET) => [index::class, 'index']
/about (GET) => [about::class, 'index']
/auth/login (GET) => [auth::class, 'login']
/auth/login (POST) => [auth::class, 'login_post']
/users/delete/1 (DELETE) => [users::class, 'delete_'], [1]
/carts/item-detail/1/5/ => [carts::class, 'item_detail'], [1,5]
```

## Controller
Semua `Controller` berada di folder `core/controllers`.

## Model
Semua `Model` berada di  `core/models`. Berikut adalah struktur Modelnya:
```php
<?php

require __DIR__ . "/post.php"; // pastikan memanggil require jika memilki relasi dengan model lain.

class User extends Model {
    protected static $tableName = "users"; // nama tabel
    protected static $guarded = ['id']; // nama-nama primary key yang tidak boleh diisi
    protected static $fillable = ['username', 'password', 'fullName', 'email', 'role']; // nama-nama column yang bisa diisi
    protected static $relationships = [
        'posts' => [Model::HAS_MANY, Post::class, 'userId', 'id']
        // '{relationName}' => [{relationType: Model::HAS_ONE | Model::HAS_MANY}, {relatedClassName}, 'foreignKey', 'primaryKey']
    ];
}
```
> Jangan lupa tambahkan/edit `core/.env` supaya sesuai dengan koneksi databasemu.


## View
View kurang lebih sama seperti PHP biasa, hanya saja ada fitur components yang berada di folder `views/components`, sementara views biasa berada di `views`<br>
Untuk merender *view*, bisa seperti berikut:
```php
view($viewName, $variables);
/*
 * $viewName bisa memakai '.' untuk menggantikan '/', misalnya: "users.dashboard"
 * $variables berupa array associative, misalnya: ["title" => "Postingan Utama"]
/*
```
