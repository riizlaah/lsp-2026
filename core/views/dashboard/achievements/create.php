<x-dashb>
    <form action="/manage-achievements/create" method="post" class="mx-auto shadow rounded my-4 p-4" style="width: min(100%, 40rem);">
        <xcsrf />
        <div class="mb-4 d-flex gap-2 align-items-center">
            <a href="/manage-achievements"><i data-feather="arrow-left"></i></a>
            <h1>Buat Pencapaian Baru</h1>
        </div>
        @err
        <div class="text-danger">
            <ul>
                <?php foreach ($errors ?? [] as $messages): ?>
                    <?php foreach ($messages as $msg): ?>
                        <li><?= $msg ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        @enderr
        <div class="form-floating mb-3">
            <input type="text" name="nama" class="form-control @err('nama') is-invalid @enderr" id="nama" value="@old('nama')" placeholder="Nama" required>
            <label for="nama">Nama</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="rank" class="form-control @err('rank') is-invalid @enderr" id="rank" value="@old('rank')" placeholder="Rank" required>
            <label for="rank">Rank</label>
        </div>
        <div class="mb-3">
            <label for="tingkat">Tingkat</label>
            <select class="form-select @err('tingkat') is-invalid @enderr" id="tingkat" name="tingkat" required>
                <?php
                $opts = [
                    "Tidak diketahui",
                    "Kecamatan",
                    "Kabupaten",
                    "Provinsi",
                    "Nasional",
                    "Internasional"
                ];
                $tingkat = old('tingkat');
                foreach ($opts as $i => $opt): ?>
                    <option value="<?= $opt ?>" <?= (($i == 0 && !$tingkat) xor $tingkat == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-check">
            <input class="form-check-input @err('berjenjang') is-invalid @enderr" type="radio" name="berjenjang" id="berjenjang1" value="t" <?= (old('berjenjang') == "t") ? 'checked' : '' ?>>
            <label class="form-check-label" for="berjenjang1">
                Berjenjang
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input @err('berjenjang') is-invalid @enderr" type="radio" name="berjenjang" id="berjenjang2" value="f" <?= (old('berjenjang') == "f") ? 'checked' : '' ?>>
            <label class="form-check-label" for="berjenjang2">
                Tidak Berjenjang
            </label>
        </div>
        <div class="form-floating mb-3">
            <textarea type="text" name="konten" class="form-control @err('konten') is-invalid @enderr" id="konten" placeholder="Konten..." required style="height: 100px;"><?= old('konten') ?></textarea>
            <label for="konten">Konten</label>
        </div>
        <div class="row gap-2 mb-3">
            <div class="col">
                <div class="form-floating">
                    <input type="text" name="tahun" class="form-control @err('tahun') is-invalid @enderr" id="tahun" value="<?= old('tahun') ?? date("Y") ?>" placeholder="tahun" required>
                    <label for="tahun">Tahun</label>
                </div>
            </div>
            <div class="col">
                <div>
                    <label for="bulan">Bulan</label>
                    <select class="form-select @err('bulan') is-invalid @enderr" name="bulan" id="bulan" required>
                        <?php
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
                        $bulan = old('bulan');
                        foreach ($opts as $idx => $opt): ?>
                            <option value="<?= $idx + 1 ?>" <?= ((!$bulan && $idx == 0) xor $bulan == (string)($idx + 1)) ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Simpan</button>
    </form>
</x-dashb>