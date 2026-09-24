<x-main>
    <div class="my-4 d-flex gap-2 align-items-center">
        <a href="/information"><i data-feather="arrow-left"></i></a>
        <h1 class="mb-0">Pengumuman Terbaru</h1>
    </div>
    <div class="input-group mb-3">
        <form action="">
            <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($_GET["search"] ?? "") ?>" placeholder="Cari..." aria-label="Search">
        </form>
    </div>
    <?php if (empty($records)): ?>
        <div class="container-sm mx-auto text-center text-secondary">
            <i>-- Kosong --</i>
        </div>
    <?php endif; ?>
    <div class="row row-cols-2 row-cols-lg-3 g-3">
        <?php foreach ($records ?? [] as $i => $record): ?>
            <div class="col">
                <a href="/information/announcements/<?= $record->slug ?>" class="text-decoration-none h-100 d-block">
                    <div class="alert alert-<?= $i == 0 ? "info" : "secondary"?> m-0 h-100" role="alert">
                        <h4 class="alert-heading"><?= $record->title ?></h4>
                        <p><?= getTextFromElement($record->content) ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <x-pagination />
</x-main>