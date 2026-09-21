<x-main>
    <div class="my-4 d-flex gap-2 align-items-center">
        <a href="/information"><i data-feather="arrow-left"></i></a>
        <h1>Galeri Foto</h1>
    </div>
    <div class="input-group mb-3">
        <form action="">
            <input type="text" name="search" value="<?= htmlspecialchars($_GET["search"] ?? "") ?>" class="form-control" placeholder="Cari..." aria-label="Search">
        </form>
    </div>
    <div class="row row-cols-2 row-cols-lg-4 g-3">
        <?php

        use Carbon\Carbon;

        foreach ($galleries ?? [] as $record): ?>
            <div class="col">
                <a href="/student-affairs/galeries/<?= $record->refTable ?>/<?= $record->refId ?>" class="text-decoration-none d-block h-100">
                    <div class="h-100 position-relative rounded bg-black">
                        <img src="<?= $record->mediaPath ? "/assets/uploads/" . $record->mediaPath : "/assets/images/no-img.webp" ?>" class="card-img-top w-100 h-100 object-fit-contain" alt="<?= $record?->description ?? "No Description" ?>">
                        <span class="text-end p-3 text-white" style="position: absolute; right: 0px; bottom: 0px; width: 100%; background: linear-gradient(0deg, rgba(0,0,0,0.7), rgba(0,0,0,0))">
                            <?= Carbon::parse($record->createdAt)->locale('id')->format("F Y") ?>
                        </span>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</x-main>