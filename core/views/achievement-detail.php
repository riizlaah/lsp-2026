<x-main>
    <?php $record = $record ?? new \App\Models\Achievement() ?>
    <div class="container-sm mx-auto my-4 shadow rounded p-4">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/student-affairs">Kesiswaaan</a></li>
                <li class="breadcrumb-item"><a href="/student-affairs/achievements">Pencapaian</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href=""><?= $record->title ?></a></li>
            </ol>
        </nav>
        <h1 class="mb-1"><?= $record->title ?></h1>
        <div class="d-flex gap-2 mb-3 d-flex align-items-center">
            <span class="fs-6 badge text-bg-secondary"><?= getIDNMonthName($record->month) . " " . (string)$record->year ?></span>
            <span class="fs-6 badge text-bg-primary"><?= "Tingkat " . $record->level ?></span>
            <span class="fs-6 badge text-bg-primary"><?= $record->isTiered ? "Berjenjang" : "Tidak Berjenjang" ?></span>
            <?php if($record->rank > 0): ?>
                <span class="fs-6 badge text-bg-primary"><?= "#" . $record->rank ?></span>
            <?php endif; ?>
        </div>
        <?php if($record->headerImage): ?>
            <img src="/assets/uploads/<?= $record->headerImage ?>" alt="<?= $record->title ?>" class="w-50 d-block mx-auto object-fit-contain mb-2">
        <?php endif; ?>
        <p><?= $record->content ?></p>
        <a href="/student-affairs/achievements" class="btn btn-primary mt-4">Kembali</a>
    </div>
</x-main>