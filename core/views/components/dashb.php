<?php
$clippedRoute = $GLOBALS["clippedRoute"];
$useTrix = $useTrix ?? false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="/assets/bootstrap5/css/bootstrap.min.css">
    <title><?= $title ?? "Document Title" ?></title>
    <script src="/assets/feather.min.js"></script>
    <?php if ($useTrix): ?>
        <link rel="stylesheet" type="text/css" href="/assets/trix/dist/trix.css">
        <script type="text/javascript" src="/assets/trix/dist/trix.umd.min.js"></script>
    <?php endif; ?>
    <style>
        trix-toolbar {
            position: sticky;
            top: 0.5rem;
            z-index: 999;
        }
        button.trix-button {
            background-color: white;
        }
    </style>
</head>

<body>
    <div class="d-flex" style="min-height: 100vh">
        <nav class="offcanvas-lg offcanvas-start d-lg-flex flex-column flex-shrink-0 bg-body border-end" style="width: 260px" tabindex="-1" id="hybridSidebar" aria-labelledby="hybridSidebarLabel">
            <div class="offcanvas-header border-bottom d-lg-none">
                <h5 class="offcanvas-title" id="hybridSidebarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#hybridSidebar" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-lg-flex flex-column p-3">
                <a href="#" class="d-none d-lg-block mb-3 link-body-emphasis text-decoration-none fs-5 fw-semibold"><i class="bi bi-hexagon-half me-2"></i>Menu</a>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item"><a class="nav-link <?= $clippedRoute == "/dashboard" ? "active" : "" ?>" aria-current="page" href="/dashboard"><i data-feather="monitor"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?= str_starts_with($clippedRoute, "/manage-articles") ? "active" : "" ?>" href="/manage-articles"><i data-feather="file-text"></i> Artikel</a></li>
                    <li class="nav-item"><a class="nav-link <?= str_starts_with($clippedRoute, "/manage-announcements") ? "active" : "" ?>" href="/manage-announcements"><i data-feather="bell"></i> Pengumuman</a></li>
                    <li class="nav-item"><a class="nav-link <?= str_starts_with($clippedRoute, "/manage-achievements") ? "active" : "" ?>" href="/manage-achievements"><i data-feather="award"></i> Pencapaian</a></li>
                    <li class="nav-item"><a class="nav-link <?= str_starts_with($clippedRoute, "/dashboard/other") ? "active" : "" ?>" href="/dashboard/other"><i data-feather="info"></i> Lainnya</a></li>
                    <li class="nav-item">
                        <hr>
                    </li>
                    <li class="nav-item"><a href="/dashboard/logout" class="btn btn-primary">Log out</a></li>
                </ul>
            </div>
        </nav>
        <div class="flex-grow-1">
            <header class="d-lg-none border-bottom p-2">
                <button class="btn btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#hybridSidebar" aria-controls="hybridSidebar">
                    <i data-feather="menu"></i>
                </button>
            </header>
            <main class="p-4 container-fluid">
                <!-- SLOT_PLACEHOLDER -->
            </main>
        </div>
    </div>
    <script src="/assets/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>

</html>