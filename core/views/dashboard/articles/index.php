<x-dashb>
    <h1 class="mb-4">Kelola Artikel</h1>
    <?php if (flash_exists("message")): ?>
        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            <?= session_flash("message") ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row mb-3">
        <div class="col-auto">
            <div class="input-group">
                <form action="">
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($_GET["search"] ?? "") ?>" aria-label="Search">
                </form>
            </div>
        </div>
        <div class="col"></div>
        <div class="col-auto">
            <a tole="button" href="/manage-articles/create" class="btn btn-primary">Tambahkan</a>
        </div>
    </div>
    <table class="table table-bordered mb-3">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Judul</th>
                <th scope="col">Cuplikan Teks</th>
                <th scope="col">Gambar Kepala</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($records ?? [] as $idx => $row): ?>
                <tr>
                    <td><?= $idx + 1 ?></td>
                    <td><?= $row->title ?></td>
                    <td><?= getTextFromElement($row->content) ?></td>
                    <td><img class="d-block mx-auto w-50" src="/assets/uploads/<?= $row->headerImage ?>" alt="<?= $row->title ?>"></td>
                    <td class="d-flex gap-2">
                        <a href="/information/articles/<?= $row->slug ?>" class="btn btn-primary"><i data-feather="eye"></i></a>
                        <a href="/manage-articles/edit/<?= $row->id ?>" class="btn btn-warning"><i data-feather="edit"></i></a>
                        <form action="/manage-articles/delete/<?= $row->id ?>" method="post" onsubmit="return confirm('Anda yakin ingin menghapus \'<?= $row->title ?>\'')">
                            <xm-delete />
                            <xcsrf />
                            <button type="submit" class="btn btn-danger"><i data-feather="trash-2"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (empty($records)): ?>
        <div class="container-sm mx-auto text-center text-secondary">
            <i>-- Kosong --</i>
        </div>
    <?php endif; ?>
</x-dashb>