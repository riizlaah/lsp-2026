<x-main>
    <div class="my-4 d-flex gap-2 align-items-center">
        <a href="/student-affairs"><i data-feather="arrow-left"></i></a>
        <h1 class="mb-0">Galeri Foto</h1>
    </div>
    <?php if (empty($galleries)): ?>
        <div class="container-sm mx-auto text-center text-secondary">
            <i>-- Kosong --</i>
        </div>
    <?php endif; ?>
    <div class="row row-cols-2 row-cols-lg-4 g-3">
        <?php

        use Carbon\Carbon;

        foreach ($galleries ?? [] as $record): ?>
            <div class="col">
                <a href="/student-affairs/galleries/<?= $record->refTable ?>/<?= $record->refId ?>" class="text-decoration-none d-block h-100">
                    <div class="h-100 position-relative rounded bg-black">
                        <img src="<?= $record->mediaPath ? "/assets/uploads/" . $record->mediaPath : "/assets/images/no-img.webp" ?>" class="card-img-top w-100 h-100 object-fit-contain" alt="<?= $record?->description ?? "No Description" ?>">
                        <span class="text-end p-3 text-white" style="position: absolute; right: 0px; bottom: 0px; width: 100%; background: linear-gradient(0deg, rgba(0,0,0,0.7), rgba(0,0,0,0))">
                            <?= Carbon::parse($record->createdAt)->locale('id')->translatedFormat("F Y") ?>
                        </span>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <x-pagination />
</x-main>