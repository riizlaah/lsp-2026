<x-main>
    <div class="my-4 d-flex gap-2 align-items-center">
        <a href="/student-affairs"><i data-feather="arrow-left"></i></a>
        <h1>Pencapaian yang Telah Diraih</h1>
    </div>
    <div class="input-group mb-3">
        <form action="">
            <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($_GET["search"] ?? "") ?>" placeholder="Cari..." aria-label="Search">
        </form>
    </div>
    <div class="row row-cols-2 row-cols-lg-4">
        <?php foreach ($achievements ?? [] as $record): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= $record->headerImage ?? "/assets/images/no-img.webp" ?>" class="card-img-top" alt="<?= $record->title ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $record->title ?></h5>
                        <p class="card-text"><?= $record->content ?></p>
                        <a href="/student-affairs/achievements/<?= $record->id ?>" class="btn btn-primary">Lihat Detail</a>
                    </div>
                    <div class="card-footer text-end">
                        <?= getIDNMonthName($record->month) . " " . (string)$record->year ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</x-main>