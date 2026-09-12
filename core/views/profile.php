<x-main>
    <div class="container-xl mx-auto bg-primary-subtle bg-gradient p-4 mt-4">
        <h1>Struktur Organisasi</h1>
        <div class="w-100">
            <object style="height: auto; width: 100%;" data="/assets/images/struktur-organisasi.svg" type="image/svg+xml" id="struktur-organisasi"></object>
        </div>
    </div>
    <div class="container-xl mx-auto mt-4">
        <h1 class="text-center">Jumlah Pengajar dan Tenaga Kependidikan</h1>
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
    <div class="container-xl mx-auto row">
        <div class="col">
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
                "Perpustakaan" => ["Perpustakaan ...", "perpus.webp"],
                "Kantin" => ["Kantin", "kantin.webp"],
                "Lapangan" => ["Lapangan", "lapangan.webp"],
            ];
            ?>
            <!-- list fasilitas -->
        </div>
        <div class="col">
            <!-- foto fasilitas yg dipilih -->
        </div>
    </div>
    <div class="container-xl mx-auto row">
        <div class="col">
            <!-- Akreditasi -->
        </div>
        <div class="col">
            <a href="/student-affairs/achievements" role="button">Prestasi</a>
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