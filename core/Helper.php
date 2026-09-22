<?php


use App\Models\User;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

function sanitizeHTML(string $str)
{
    $config = (new HtmlSanitizerConfig())
        ->allowSafeElements()
        ->allowElement('figure')
        ->allowElement('figcaption')
        ->allowElement('img', ['src', 'alt', 'width', 'height'])
        ->allowElement('a', ['href', 'target', 'rel'])
        ->allowLinkSchemes(['http', 'https', 'mailto'])
        ->allowAttribute('data-trix-attributes', ['figure'])
        ->allowAttribute('data-trix-attachment', ['figure'])
        ->allowAttribute('data-trix-content-type', ['figure'])
        ->allowRelativeLinks()
        ->allowRelativeMedias()
        ->allowMediaSchemes(['http', 'https'])
        ->forceAttribute('a', 'rel', 'noopener noreferrer')
        ->withMaxInputLength(65556);
    return (new HtmlSanitizer($config))->sanitize($str);
}

function validateRememberToken($token) {}

function isLoggedIn()
{
    return isset($_SESSION["auth"]);
}

function ensureAuthenticated()
{
    if (!isLoggedIn()) {
        errCode(401, "Pengguna Belum Terautentikasi");
    }
}

function ensureIsRole(string $role)
{
    ensureAuthenticated();
    if (getAuthData()["role"] !== $role) {
        errCode(403, "Perlu akun admin");
    }
}

function isAdmin()
{
    return isLoggedIn() && getAuthData()["role"] === "admin";
}

function ensureIsAdmin()
{
    ensureIsRole("admin");
}


function getAuthData()
{
    return $_SESSION["auth"] ?? null;
}

function getIDNMonthName(int $n)
{
    $opts = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    return $opts[$n - 1] ?? "?";
}


function getTextFromElement(string $str, $len = 100)
{
    $str = html_entity_decode(strip_tags($str), ENT_QUOTES | ENT_HTML5);
    $str = trim(preg_replace("/[a-z](([A-Z])[a-zA-Z0-9]+)/", " $1", $str));
    return mb_substr($str, 0, $len, 'UTF-8') . (strlen($str) > $len ? "..." : "");
}

function safeUnlink(string $filename)
{
    if (file_exists($filename)) unlink($filename);
}

function getFilenamesFromHTMLContent(string $content)
{
    $files = [];
    if (!empty($content)) {
        if (preg_match_all("#(?:src|href)\s*=\s*[\"']/assets/uploads/([^\"']+)[\"']#i", $content, $matches)) {
            foreach ($matches[1] as $path) {
                $path = strtok($path, '?#');
                $filename = trim(basename($path));
                if ($filename !== '') {
                    $files[] = $filename;
                }
            }
        }
    }

    return array_values(array_unique($files));
}
