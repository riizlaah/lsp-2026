<x-dashb>
    <h1 class="mb-4">Kelola Pencapaian</h1>
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
            <a tole="button" href="/manage-achievements/create" class="btn btn-primary">Tambahkan</a>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama</th>
                <th scope="col">Rank/Tingkat</th>
                <th scope="col">Bulan/Tahun</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($records ?? [] as $idx => $row): ?>
                <tr>
                    <td><?= $idx + 1 ?></td>
                    <td><?= $row->title ?></td>
                    <td><?= "#" . (string)$row->rank . "/" . $row->level ?></td>
                    <td><?= getIDNMonthName($row->month) . " " . (string)$row->year  ?></td>
                    <td class="d-flex gap-2">
                        <a href="/student-affairs/achievements/<?= $row->id ?>" class="btn btn-primary"><i data-feather="eye"></i></a>
                        <a href="/manage-achievements/edit/<?= $row->id ?>" class="btn btn-warning"><i data-feather="edit"></i></a>
                        <form action="/manage-achievements/delete/<?= $row->id ?>" method="post" onsubmit="return confirm('Anda yakin ingin menghapus \'<?= $row->title ?>\'')">
                            <xm-delete />
                            <xcsrf />
                            <button type="submit" class="btn btn-danger" ><i data-feather="trash-2"></i></button>
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