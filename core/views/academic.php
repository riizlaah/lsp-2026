<x-main>
    <div class="container-xl shadow p-4 my-3 rounded">
        <h1 class="text-primary">Kurikulum yang Digunakan</h1>
        <p>
            Kurikulum Merdeka diterapkan sebagai kerangka utama sejak tahun ajaran 2024/2025. Pembelajaran berpusat pada siswa melalui pendekatan berdiferensiasi dan proyek penguatan profil pelajar Pancasila (P5). Siswa kelas X dan XI mengikuti program intrakurikuler dengan jam pelajaran fleksibel serta dua pilihan mata pelajaran pendalaman di kelas XI dan XII.
        </p>
    </div>
    <div class="container-xl shadow p-4 my-3 rounded">
        <div class="row row-cols-1 row-cols-lg-2 g-3">
            <div class="col">
                <div class="d-flex flex-column justify-content-evenly align-items-center h-100">
                    <h1 class="text-primary">Kalender Akademik</h1>
                    <div class="hover-blur">
                        <img src="/assets/images/academic-calendar.webp" alt="Kalender Akademik">
                        <a class="fs-3 text-white fw-bold text-decoration-none" href="https://docs.google.com/spreadsheets/d/1CB15WxNKar8yHuYV8JX9EBywVmGdKynXSYmyypkzcnA/edit?usp=sharing">
                            Lihat Lebih Detail...
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-column justify-content-evenly align-items-center h-100">
                    <h1 class="text-primary">Jadwal Pelajaran</h1>
                    <div class="hover-blur mx-auto">
                        <img src="/assets/images/lessons-schedule.webp" alt="Jadwal Pelajaran">
                        <a class="fs-3 text-white fw-bold text-decoration-none" href="https://drive.google.com/drive/folders/1p5eVzqOkxDzAi1RME6duQEje015wKrjZ?usp=drive_link">
                            Lihat Lebih Detail...
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl shadow p-4 my-3">
        <?php
        $ekstrakurikuler = ["OSIS", "Pramuka", "PMR", "PKS", "Bola Basket", "Bola Voli", "Futsal", "Panahan", "Pencak Silat", "Taekwondo", "Kerohanian Islam", "Teater", "Pecinta Alam", "Jurnalistik"];
        ?>
        <h1 class="text-primary">Ekstrakurikuler</h1>
        <div class="row row-cols-2 row-cols-lg-4 g-3">
            <?php foreach ($ekstrakurikuler as $ekstra): ?>
                <div class="col">
                    <div class="alert alert-info h-100" role="alert">
                        <span class="alert-heading"><?= $ekstra ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- 
    - Kurikulum yang Digunakan
    - Kalender Akademik
    - Program Unggulan / Ekstrakurikuler
    - Jadwal Pelajaran / Kegiatan Belajar
    -->
</x-main>