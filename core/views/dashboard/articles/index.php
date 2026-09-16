<x-dashb>
    <h1 class="mb-4">Kelola Artikel</h1>
    <?php if (flash_exists("message")): ?>
        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            <?= session_flash("message") ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-auto">
            <div class="input-group mb-3">
                <form action="">
                    <input type="text" name="search" class="form-control" placeholder="Cari..." aria-label="Search">
                </form>
            </div>
        </div>
        <div class="col"></div>
        <div class="col-auto">
            <a tole="button" href="/manage-articles/create" class="btn btn-primary">Tambahkan</a>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama</th>
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
                        <a href="/manage-articles/edit/<?= $row->id ?>" class="btn btn-warning"><i data-feather="edit"></i></a>
                        <form action="/manage-articles/delete/<?= $row->id ?>" method="post">
                            <xm-delete />
                            <xcsrf />
                            <button type="submit" class="btn btn-danger" onclick="confirm('Anda yakin ingin menghapus \'<?= $row->title ?>\'')"><i data-feather="trash-2"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</x-dashb>