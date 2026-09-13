<?php
$clippedRoute = $GLOBALS["clippedRoute"];

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
</head>

<body>
    
    <main class="container-fluid">
        <!-- SLOT_PLACEHOLDER -->
    </main>
    <footer class="container-fluid bg-primary text-white p-2">
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