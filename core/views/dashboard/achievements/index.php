<x-dashb>
    <?php use Carbon\Carbon; ?>
    <!-- search, filter -->
    <!-- create/edit with modals -->
    <h1 class="mb-4">Kelola Pencapaian</h1>
    <div class="row">
        <div class="col-auto">
            <div class="input-group mb-3">
                <form action="">
                    <!-- <label class="input-group-text"><i data-feather="search"></i></label> -->
                    <input type="text" name="search" class="form-control" placeholder="Cari..." aria-label="Search">
                </form>
            </div>
        </div>
        <div class="col"></div>
        <div class="col-auto">
            <a tole="button" href="/manage-achievements/create" class="btn btn-primary">Create New</a>
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
                    <td><?= (Carbon::createFromDate(2026, $row->month, 1))->locale('id')->monthName . " " . (string)$row->year  ?></td>
                    <td class="d-flex gap-2">
                        <a href="/manage-achievements/edit/<?= $row->id ?>" class="btn btn-warning"><i data-feather="edit"></i></a>
                        <form action="/manage-achievements/delete/<?= $row->id ?>" method="post">
                            <xm-delete />
                            <xcsrf />
                            <button type="submit" class="btn btn-danger" onclick="confirm('Anda yakin ingin menghapus \'<?= $row->title ?>\'')"><i data-feather="trash-2"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</x-dashb>