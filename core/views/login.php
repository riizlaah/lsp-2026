<x-main>
    <div class="container-sm mx-auto mt-4">
        <form action="/dashboard/auth" method="post" class="mx-auto shadow rounded my-4 p-3" style="width: 24rem;">
            <h1 class="text-center mb-4">Login</h1>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="password">
                <label for="password">Password</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="rememberMe" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</x-main>