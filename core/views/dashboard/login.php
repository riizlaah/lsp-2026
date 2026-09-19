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
    <main class="container-fluid d-flex align-items-center" style="height: 100vh;">
        <div class="container-sm mx-auto mt-4">
            <form action="/dashboard" method="post" class="mx-auto shadow rounded my-4 p-3" style="width: min(100%, 24rem);">
                <xcsrf />
                <h1 class="text-center mb-4">Login</h1>
                @err
                    <div class="text-danger">
                        <ul>
                            <?php foreach($errors ?? [] as $messages): ?>
                                <?php foreach($messages as $msg): ?>
                                    <li><?= $msg ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                @enderr
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control @err('email') is-invalid @enderr" id="email" value="@old('email')" placeholder="name@example.com" required>
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control @err('password') is-invalid @enderr" id="password" placeholder="password" required>
                    <label for="password">Password</label>
                </div>
                <!-- <div class="mb-3 form-check">
                    <input type="checkbox" name="rememberMe" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Check me out</label>
                </div> -->
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <span class="w-100 d-block text-center mt-3">
                    <a href="/" class="text-decoration-none">Kembali</a>
                </span>
            </form>
        </div>
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