<x-dashb>
    <form action="/dashboard/change-pass" method="post" class="container-sm mx-auto mb-3 p-4 rounded shadow">
        <xcsrf />
        <h1>Ganti Password</h1>
        @err
        <div class="text-danger">
            <ul>
                <?php
                foreach ($errors ?? [] as $messages): ?>
                    <?php foreach ($messages as $msg): ?>
                        <li><?= $msg ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        @enderr
        <div class="form-floating mb-3">
            <input type="text" name="passwordBaru" class="form-control @err('passwordBaru') is-invalid @enderr" id="passwordBaru" placeholder="Password" required>
            <label for="passwordBaru">Password Baru</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Simpan</button>
    </form>
    <form action="/dashboard/update-settings" method="post" class="container-sm mx-auto p-4 rounded shadow">
        <h1>Pengaturan Tambahan</h1>
        <xcsrf />
        <?php
        use App\Config;
        foreach (Config::getAll() as $key => $val):
        ?>
            <div class="form-floating mb-3">
                <input type="text" name="<?= $key ?>" class="form-control" id="<?= $key ?>" value="<?= $val ?>" placeholder="<?= $key ?>" required>
                <label for="<?= $key ?>"><?= spacify($key) ?></label>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary w-100">Simpan</button>
    </form>
</x-dashb>