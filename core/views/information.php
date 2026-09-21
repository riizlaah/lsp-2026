<x-main>
    <div class="container-sm mx-auto mb-4 p-3 rounded shadow row row-cols-1 row-cols-lg-2 g-3">
        <h1 class="text-primary fw-bold">Pengumuman Resmi</h1>
        <div class="row row-cols-1 row-cols-lg-2">
            <?php foreach ($announcements ?? [] as $i => $record): ?>
                <div class="col">
                    <a href="/information/announcements/<?= $record->slug ?>" class="text-decoration-none">
                        <div class="alert alert-<?= $i == 0 ? "info" : "secondary" ?>" role="alert">
                            <h4 class="alert-heading"><?= $record->title ?></h4>
                            <p><?= getTextFromElement($record->content) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="/information/announcements" class="mt-2 w-100 text-center d-block">Lihat Lebih Banyak...</a>
    </div>
    <div class="container-sm mx-auto rounded shadow mb-4 p-4 row row-cols-1 row-cols-lg-2 g-3">
        <h1 class="text-success fw-bold">Artikel</h1>
        <div class="row row-cols-2 g-3">
            <?php

            use Carbon\Carbon;

            foreach ($articles ?? [] as $record): ?>
                <div class="col">
                    <a href="/information/articles/<?= $record->slug ?>" class="text-decoration-none d-block">
                        <div class="card h-100">
                            <img src="<?= $record->headerImage ? "/assets/uploads/" . $record->headerImage : "/assets/images/no-img.webp" ?>" class="card-img-top" alt="<?= $record->title ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $record->title ?></h5>
                                <p class="card-text"><?= getTextFromElement($record->content) ?></p>
                            </div>
                            <div class="card-footer text-end">
                                <?= Carbon::parse($record->createdAt)->locale('id')->diffForHumans(Carbon::now()) ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="/information/articles" class="w-100 d-block text-center mt-3">Lihat Prestasi & Karya</a>
    </div>
    <div class="container-sm mx-auto my-4 p-3 rounded shadow row row-cols-1 row-cols-lg-2 g-3">
        <div class="col">
            <h1>Agenda Kegiatan</h1>
        </div>
        <div class="col">
            <div class="hover-blur">
                <img src="/assets/images/academic-calendar.webp" alt="Kalender Akademik">
                <a class="fs-3 text-white fw-bold text-decoration-none" href="https://docs.google.com/spreadsheets/d/1CB15WxNKar8yHuYV8JX9EBywVmGdKynXSYmyypkzcnA/edit?usp=sharing">
                    Lihat Lebih Detail...
                </a>
            </div>
            <a class="d-lg-none" href="https://docs.google.com/spreadsheets/d/1CB15WxNKar8yHuYV8JX9EBywVmGdKynXSYmyypkzcnA/edit?usp=sharing">Lihat Lebih Banyak</a>
        </div>
    </div>
    <!--
    Agenda?
    -->
</x-main>