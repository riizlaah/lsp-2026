<x-main>
    <?php

    use Carbon\Carbon;

    $cover = $cover ?? new \App\Models\Gallery();
    $extras = $extras ?? [];
    ?>
    <div class="container-sm mx-auto my-4 shadow rounded p-4">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/student-affairs">Kesiswaan</a></li>
                <li class="breadcrumb-item"><a href="/student-affairs/galleries">Galeri</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">#</a></li>
            </ol>
        </nav>
        <div class="d-flex gap-2 mb-3 align-items-center">
            <?php $refRecord = $cover->getReference() ?>
            <a href="/information/articles/<?= $refRecord->slug ?>"><i data-feather="arrow-up-right"></i> <?= $refRecord?->title ?? "?" ?></a>
            <span class="fs-6 text-secondary"><?= Carbon::parse($cover->createdAt)->locale('id')->translatedFormat("Y-m-d H:i") ?></span>
        </div>
        <hr>
        <div class="container-md my-3 mx-auto row">
            <div class="col" style="height: fit-content;">
                <div class="position-relative rounded h-75">
                    <img src="<?= $cover->mediaPath ? "/assets/uploads/" . $cover->mediaPath : "/assets/images/no-img.webp" ?>" class="card-img-top w-100 h-100 object-fit-contain bg-black" alt="<?= $cover?->description ?? "No Description" ?>">
                </div>
            </div>
        </div>
        <div class="container-fluid mb-3 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php foreach ($extras as $record): ?>
                <div class="col">
                    <div class="h-100 position-relative rounded">
                        <img src="<?= $record->mediaPath ? "/assets/uploads/" . $record->mediaPath : "/assets/images/no-img.webp" ?>" class="w-100 h-100 object-fit-contain bg-black" alt="<?= $record?->description ?? "No Description" ?>">
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <hr>
        <a href="/student-affairs/galleries" class="btn btn-primary">Kembali</a>
    </div>
</x-main>