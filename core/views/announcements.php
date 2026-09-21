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
    <div class="row row-cols-2 row-cols-lg-3">
        <?php foreach ($records ?? [] as $i => $record): ?>
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
</x-main>