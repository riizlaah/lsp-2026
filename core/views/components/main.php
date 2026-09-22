<?php
$clippedRoute = $GLOBALS["clippedRoute"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/bootstrap5/css/bootstrap.min.css">
    <title><?= $title ?? "Document Title" ?></title>
    <script src="/assets/feather.min.js"></script>
    <style>
        :root {
            --bs-font-sans-serif: "PT Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            --bs-body-font-family: var(--bs-font-sans-serif);
        }

        body {
            font-family: var(--bs-body-font-family);
        }

        .hover-blur {
            width: 100%;
            height: 100%;
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
        }

        .hover-blur>img {
            width: 100%;
            height: 100%;
        }

        .hover-blur>a:last-child {
            display: flex;
            justify-content: center;
            align-items: center;
            text-shadow: 0 0 10px #0000008e;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff6e;
            backdrop-filter: blur(5px);
            transition: all 0.3s;
        }

        .hover-blur:hover>a:last-child,
        .hover-blur:focus>a:last-child {
            background-color: #ffffff38;
            backdrop-filter: blur(20px);
        }

        .wrap-imgs img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top px-2 px-md-5 shadow bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/assets/images/skansaka.webp" alt="Logo" width="30" class="d-inline-top align-text-top">
                <span>SMKN 1 Kandeman</span>
            </a>
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
                            <li><a class="dropdown-item" href="/student-affairs/galleries">Galeri</a></li>
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
    <main class="container-fluid">
        <!-- SLOT_PLACEHOLDER -->
    </main>
    <footer class="container-fluid mt-5 bg-black text-secondary p-5">
        <div class="row row-cols-1 row-cols-lg-4 g-4">
            <div class="col">
                <h3>SMKN 1 Kandeman</h3>
                <p class="text-light-emphasis">SMK Negeri 1 Kandeman adalah salah satu SMK Pusat Keunggulan di Kabupaten Batang, Jawa Tengah dengan 7 Konstentrasi Keahlian Berbasis Teknologi Manufaktur & Rekayasa dan Teknologi Informasi</p>
                <h4>Alamat</h4>
                <p class="text-light-emphasis">Jl. Raya Kandeman KM. 04 Kecamatan Kandeman, Kabupaten Batang, Jawa Tengah 51261</p>
            </div>
            <div class="col">
                <h3>Program Keahlian</h3>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/profile#tp">Teknik Pemesinan</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/profile#tkr">Teknik Kendaraan Ringan</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/profile#tbsm">Teknik Bisnis Sepeda Motor</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/profile#tav">Teknik Audio Video</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/profile#tei">Teknik Eletronika Industri</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/profile#titl">Teknik Instalasi Tenaga Listrik</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/profile#rpl">Rekayasa Perangkat Lunak</a></li>
                </ul>
            </div>
            <div class="col">
                <h3>Informasi Lainnya</h3>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/student-affairs/achievements">Pencapaian Siswa</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/student-affairs/galleries">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/information/articles">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link p-0 text-light-emphasis" href="/contact">Kontak</a></li>
                </ul>
            </div>
            <div class="col">
                <div class="row row-cols-2 g-4">
                    <?php
                    $images = [
                        "smk-pk" => "SMK Pusat Keunggulan",
                        "kurikulum-merdeka" => "Kurikulum Merdeka",
                        "vokasi-kuat" => "Vokasi Kuat",
                        "smk-hebat" => "SMK Hebat"
                    ];
                    ?>
                    <?php foreach ($images as $key => $val): ?>
                        <img src="/assets/images/footers/<?= $key ?>.webp" alt="<?= $val ?>" class="col object-fit-contain d-block" height="90">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="w-100 text-end">
            &copy; 2026 | Developed by Naf'an Rizkilah
        </div>
    </footer>
    <script src="/assets/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>

</html>