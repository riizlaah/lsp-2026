<x-main>
    <div class="container-xl mx-auto shadow p-4 mt-4 rounded">
        <h1 class="text-center text-primary">Struktur Organisasi</h1>
        <div class="w-100">
            <object style="height: auto; width: 100%;" data="/assets/images/struktur-organisasi.svg" type="image/svg+xml" id="struktur-organisasi"></object>
        </div>
    </div>
    <div class="container-xl mx-auto mt-4 p-4 shadow rounded">
        <h1 class="text-center text-primary">Jumlah Pengajar dan Tenaga Kependidikan</h1>
        <div class="row row-cols-3 g-4 my-3">
            <?php
            $pengajar = [
                "primary" => ["Jumlah Pengajar Kejuruan", "38"],
                "success" => ["Jumlah Pengajar Mapel Umum & Pilihan", "56"],
                "info" => ["Jumlah Tenaga Kependidikan", "19"],
            ];
            ?>
            <?php foreach ($pengajar as $style => $data): ?>
                <div class="col">
                    <div class="d-flex flex-column justify-content-evenly align-items-center border border-<?= $style ?> text-center p-2 h-100 rounded-top-3">
                        <p class="fs-6 text-<?= $style ?>"><?= $data[0] ?></p>
                        <p class="fw-bold fs-2 my-3 text-<?= $style ?>"><?= $data[1] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container-xl mx-auto mt-4 p-4 shadow rounded">
        <h1 class="text-center text-primary">Fasilitas</h1>
        <div class="row row-cols-2 row-cols-lg-3">
            <?php
            $facilities = [
                "Aula" => ["Aula Graha Wastutama", "aula.webp"],
                "Bengkel TP" => ["Bengkel Teknik Pemesinan", "bengkel-tp.webp"],
                "Bengkel TBSM" => ["Bengkel Teknik Bisnis Sepeda Motor", "bengkel-tbsm.webp"],
                "Bengkel TKR" => ["Bengkel Teknik Kendaraan Ringan", "bengkel-tkr.webp"],
                "Bengkel TAV" => ["Bengkel Teknik Audio Video", "bengkel-tav.webp"],
                "Bengkel TEI" => ["Bengkel Teknik Elektronika Industri", "bengkel-tei.webp"],
                "Bengkel TITL" => ["Bengkel Teknik Instalasi Ketenegalistrikan", "bengkel-titl.webp"],
                "Bengkel RPL" => ["Bengkel Rekayasa Perangkat Lunak", "bengkel-rpl.webp"],
                "Masjid" => ["Masjid Baitul Mujahiddin", "masjid.webp"],
                "Perpustakaan" => ["Perpustakaan Nawasena", "perpus.webp"],
                "Kantin" => ["Kantin Siswa dan Guru", "kantin.webp"],
                "Lapangan" => ["Lapangan Olahraga", "lapangan.webp"],
            ];
            ?>
            <?php foreach ($facilities as $facName => $data): ?>
                <div class="col">
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading"><?= $facName ?></h4>
                        <p><?= $data[0] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container-xl mx-auto mt-4 row row-cols-1 row-cols-lg-2">
        <div class="col d-flex align-items-center">
            <div class="border border-primary p-4 flex-fill rounded d-flex flex-column align-items-center">
                <div class="bg-primary px-4 py-2 rounded fs-1 fw-bold text-white d-flex justify-content-center align-items-center mb-2">A</div>
                <h2>Akreditasi A (Unggul)</h2>
                <p>No. SK: <a href="https://ban-pdm.id/satuanpendidikan/20322711">1857/BAN-SM/SK/2022</a></p>
            </div>
        </div>
        <div class="col">
            <table class="table table-bordered mb-2">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Prestasi</th>
                        <th>Tingkat</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($achievements ?? [] as $record): ?>
                        <tr>
                            <td><?= $record->year ?></td>
                            <td><?= $record->title ?></td>
                            <td><?= $record->level ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="/student-affairs/achievements" role="button" class="btn btn-primary">Lihat Prestasi Lainnya</a>
        </div>
    </div>
    <script src="/assets/svg-pan-zoom.min.js"></script>
    <script>
        window.onload = () => {
            svgPanZoom("#struktur-organisasi", {
                controlIconsEnabled: true,
                fit: true,
                center: true
            });
        };
    </script>
</x-main>