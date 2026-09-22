<x-main>
    <div class="my-4 d-flex gap-2 align-items-center">
        <a href="/information"><i data-feather="arrow-left"></i></a>
        <h1 class="mb-0">Artikel</h1>
    </div>
    <div class="input-group mb-3">
        <form action="">
            <input type="text" name="search" value="<?= htmlspecialchars($_GET["search"] ?? "") ?>" class="form-control" placeholder="Cari..." aria-label="Search">
        </form>
    </div>
    <?php if (empty($records)): ?>
        <div class="container-sm mx-auto text-center text-secondary">
            <i>-- Kosong --</i>
        </div>
    <?php endif; ?>
    <div class="row row-cols-1 row-cols-lg-4 g-3">
        <?php

        use Carbon\Carbon;

        foreach ($records ?? [] as $record): ?>
            <div class="col">
                <a href="/information/articles/<?= $record->slug ?>" class="text-decoration-none card h-100">
                    <img src="<?= $record->headerImage ? "/assets/uploads/" . $record->headerImage : "/assets/images/no-img.webp" ?>" class="card-img-top" alt="<?= $record->title ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $record->title ?></h5>
                        <p class="card-text"><?= getTextFromElement($record->content) ?></p>
                    </div>
                    <div class="card-footer text-end">
                        <?= Carbon::parse($record->createdAt)->locale('id')->diffForHumans(Carbon::now()) ?>
                    </div>
                    <div class="badge text-bg-primary position-absolute" style="top: 1rem; left: 1rem;"><?= $record->category->name ?></div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</x-main>