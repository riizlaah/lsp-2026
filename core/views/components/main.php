<?php
$clippedRoute = $GLOBALS["clippedRoute"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/bootstrap5/css/bootstrap.min.css">
    <title><?= $title ?? "Document Title" ?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #00b7ffb2; backdrop-filter: blur(6px); -webikt-backdrop-filter: blur(6px);">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">SMKN 1 Kandeman</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?= $clippedRoute === "/" ? "active" : "" ?>" aria-current="page" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= $clippedRoute === "/profile" ? "active" : "" ?>" href="/profile">Profil</a></li>
                    <li class="nav-item"><a class="nav-link <?= $clippedRoute === "/academic" ? "active" : "" ?>" href="/academic">Akademik</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= str_starts_with($clippedRoute, "/student-affairs") ? "active" : "" ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kesiswaan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/student-affairs">Terbaru</a></li>
                            <li><a class="dropdown-item" href="/student-affairs/galeries">Galeri</a></li>
                            <li><a class="dropdown-item" href="/student-affairs/achievements">Pencapaian</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= str_starts_with($clippedRoute, "/information") ? "active" : "" ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/information">Terbaru</a></li>
                            <li><a class="dropdown-item" href="/information/announcements">Pengumuman</a></li>
                            <li><a class="dropdown-item" href="/information/articles">Artikel</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link <?= $clippedRoute === "/contact" ? "active" : "" ?>" href="/contact">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <!-- SLOT_PLACEHOLDER -->
    </div>
    
    <script src="/assets/bootstrap5/js/bootstrap.bundle.min.js"></script>
</body>
</html>