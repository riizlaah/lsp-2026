<x-main>
    <?php

    use Carbon\Carbon;

    $record = $record ?? new \App\Models\Article() ?>
    <div class="container-sm mx-auto my-4 shadow rounded p-4">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/information">Informasi</a></li>
                <li class="breadcrumb-item"><a href="/information/announcements">Pengumuman</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href=""><?= $record->title ?></a></li>
            </ol>
        </nav>
        <h1 class="mb-1 fw-bold"><?= $record->title ?></h1>
        <hr>
        <div class="container-fluid mb-4 wrap-imgs">
            <?= $record->content ?>
        </div>
        <hr>
        <div class="d-flex justify-content-between align-content-center">
            <a href="/information/announcements" class="btn btn-primary">Kembali</a>
            <i class="text-end text-secondary d-flex align-items-center">Terakhir update: <?= Carbon::parse($record->updatedAt)->locale('id')->diffForHumans(Carbon::now()) ?></i>
        </div>
    </div>
</x-main>