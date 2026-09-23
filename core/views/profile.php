<x-main>
    <div class="container-xl mx-auto mt-4 shadow p-4 rounded">
        <div class="row row-cols-1 row-cols-lg-2 g-2">
            <div class="col">
                <img src="/assets/images/skansaka.webp" alt="Logo SMK Negeri 1 Kandeman" class="w-50 w-lg-100 h-auto mx-auto d-block">
            </div>
            <div class="col">
                <h1 class="text-center text-primary fw-bold">Sejarah Singkat</h1>
                <p>Secara umur SMK Negeri 1 Kandeman merupakan sekolah yang telah berumur menengah bukan sekolah lama dan tidak terlalu baru. SMK Negeri 1 Kandeman berdiri pada Tahun 2003 dan pada tahun 2024 ini berarti telah berumur 21 tahun. Pada awalnya SMK Negeri 1 Kandeman dibuka dengan 3 (tiga) program keahlian yaitu Teknik Mekanik Otomotif (sekarang TKR), Teknik Mesin (sekarang Teknik Pemesinan), dan Teknik Audio Video. Kini SMK Negeri 1 Kandeman telah memiliki 7 (tujuh) paket keahlian yaitu, Teknik Kendaraan Ringan Otomotif (TKR)), Teknik Pemesinan (TP), Teknik Audio Video (TAV), Teknik Bisnis Sepeda Motor (TBSM), Teknik Elektronika Industri (TEI), Teknik Instalasi Tenaga Listrik (TITL), dan Rekayasa Perangkat Lunak (RPL)</p>
            </div>
        </div>
    </div>
    <div class="container-xl mx-auto mt-4">
        <div class="row row-cols-1 row-cols-lg-2 g-2 mb-3">
            <div class="col">
                <div class="shadow p-4 rounded h-100">
                    <h1 class="text-center text-primary fw-bold">Visi</h1>
                    <p class="fs-3 fst-italic">Terwujudnya tamatan yang berakhlak mulia, kompeten, kompetitif dan berwawasan lingkungan</p>
                </div>
            </div>
            <div class="col">
                <div class="shadow p-4 rounded h-100">
                    <h1 class="text-center text-primary fw-bold">Misi</h1>
                    <ol>
                        <li>Meningkatkan kualitas peserta didik yang agamis dan berbudaya dalam setiap aktifitas</li>
                        <li>Melaksanakan proses pembelajaran secara optimal yang kondusif berdasarkan kurikulum yang berlaku</li>
                        <li>Meningkatkan hubungan kerjasama antara sekolah dengan dunia usaha (DU) dan dunia industri (DI) secara berkeseimbangan tahun</li>
                        <li>Membudayakan peserta didik peduli dalam pelestarian lingkungan</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="shadow p-4 rounded">
            <h1 class="text-center text-primary fw-bold">Tujuan</h1>
            <ol>
                <li>Mempersiapkan peserta didik agar secara aktif mengembangkan potensi dirinya untuk memiliki kekuatan spiritual keagamaan, pengendalian diri, kepribadian, kecerdasan, akhlak mulia, dalam kehidupan bermasyarakat, berbangsa dan bernegara.</li>
                <li>Mempersiapkan peserta didik agar menjadi manusia produktif, mampu bekerja mandiri, mengisi lowongan pekerjaan yang ada di DU/DI sebagai tenaga kerja tingkat menengah, sesuai dengan kompetensi dalam program keahlian pilihannya.</li>
                <li>Membekali peserta didik agar mampu memilih karier, ulet dan gigih dalam berkompetisi, beradaptasi di lingkungan kerja dan mengembangkan sikap profesional dalam bidang keahlian yang diminatinya.</li>
                <li>Membekali peserta didik dengan ilmu pengetahuan, teknologi, dan seni agar mampu mengembangkan diri di kemudian hari baik secara mandiri maupun melalui jenjang pendidikan yang lebih tinggi.</li>
                <li>Membekali peserta didik dengan wawasan lingkungan dan jiwa kemandirian dengan sikap dan tindakan yang mendorong dirinya untuk menghasilkan sesuatu yang berguna bagi masyarakat dan lingkungannya.</li>
            </ol>
        </div>
    </div>
    <div class="container-xl mx-auto shadow p-4 mt-4 rounded">
        <h1 class="text-center text-primary fw-bold">Struktur Organisasi</h1>
        <div class="w-100">
            <object style="height: auto; width: 100%;" data="/assets/images/struktur-organisasi.svg" type="image/svg+xml" id="struktur-organisasi"></object>
        </div>
    </div>
    <div class="container-xl mx-auto mt-4 p-4 shadow rounded">
        <h1 class="text-center text-primary fw-bold">Jumlah Pengajar dan Tenaga Kependidikan</h1>
        <div class="row row-cols-2 row-cols-lg-3 g-4 my-3 justify-content-center">
            <?php

            use App\Config;

            $data = [
                "Jumlah Pengajar Kejuruan",
                "Jumlah Pengajar Mapel",
                "Jumlah Tenaga Kependidikan"
            ];
            ?>
            <?php foreach ($data as $datum): ?>
                <div class="col">
                    <div class="d-flex flex-column justify-content-evenly align-items-center border border-primary text-center p-2 h-100 rounded">
                        <p class="fs-6 text-primary text-break"><?= $datum ?></p>
                        <p class="fw-bold fs-2 my-3 text-primary"><?= Config::get(str_replace(' ', '', $datum)) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container-xl-mx-auto mt-4 p-4">
        <h1 class="text-center text-primary fw-bold">Jurusan Kami</h1>
        <div class="row row-cols-2 row-cols-lg-4 g-3 justify-content-center">
            <?php
            $majors = [
                ["Rekayasa Perangkat Lunak", "rpl"],
                ["Teknik Audio Video", "tav"],
                ["Teknik Elektronika Industri", "tei"],
                ["Teknik Instalasi Tenaga Listrik", "titl"],
                ["Teknik Kendaraan Ringan", "tkr"],
                ["Teknik Pemesinan", "tp"],
                ["Teknik dan Bisnis Sepeda Motor", "tbsm"],
            ];
            foreach ($majors as $major): ?>
                <div class="col" id="<?= $major[1] ?>">
                    <div class="shadow p-4 rounded d-flex flex-column align-items-center gap-1 h-100">
                        <img src="/assets/images/jurusan/<?= $major[1] ?>.webp" alt="Logo <?= $major[0] ?>" class="w-50">
                        <h2 class="fw-bold"><?= strtoupper($major[1]) ?></h2>
                        <span class="fst-italic text-secondary text-center"><?= $major[0] ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container-xl mx-auto mt-4 p-4 shadow rounded">
        <h1 class="text-center text-primary fw-bold">Fasilitas</h1>
        <div class="row row-cols-2 row-cols-lg-3 g-3">
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
                    <div class="alert alert-warning h-100" role="alert">
                        <h4 class="alert-heading"><?= $facName ?></h4>
                        <p><?= $data[0] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container-xl mx-auto mt-4 row row-cols-1 row-cols-lg-2 g-3">
        <div class="col d-flex align-items-center">
            <div class="border border-primary p-4 flex-fill rounded d-flex flex-column align-items-center">
                <div class="bg-primary px-4 py-2 rounded fs-1 fw-bold text-white d-flex justify-content-center align-items-center mb-2">A</div>
                <h2>Akreditasi A (Unggul)</h2>
                <p>No. SK: <a href="https://ban-pdm.id/satuanpendidikan/20322711">1857/BAN-SM/SK/2022</a></p>
            </div>
        </div>
        <div class="col">
            <h1 class="text-center text-primary fw-bold">Prestasi Terbaru</h1>
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
    <div class="container-xl mx-auto mt-4 p-4 shadow rounded">
        <h1 class="text-center text-primary fw-bold">Ringkasan</h1>
        <?php
        $summary = [
            "Nama Sekolah" => "SMK Negeri 1 Kandeman",
            "Status" => "Negeri",
            "Bentuk Pendidikan" => "SMK",
            "Akreditasi" => "A",
            "NPSN" => "20322711",
            "Telepon" => "0285392274",
            "Email" => "smkn1kandeman@yahoo.com",
            "Alamat" => "Jl. Raya Kandeman No.KM. 04, Kaliongkek, Kandeman, Kec. Kandeman, Kabupaten Batang, Jawa Tengah 51261",
            "Luas Tanah" => "49.000 m²",
        ];
        ?>
        <table class="table table-bordered mb-2">
            <tbody>
                <?php foreach ($summary as $key => $value): ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $value ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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