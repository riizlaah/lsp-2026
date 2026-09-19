<x-dashb>
    <?php
    $record = $record ?? new \App\Models\Announcement;
    $publishedAt = substr($record->publishedAt, 0, -3);
    $expiredAt = substr($record->expiredAt, 0, -3);
    ?>
    <form action="/manage-announcements/edit/<?= $record->id ?>" method="post" class="mx-auto shadow rounded my-4 p-4" style="width: min(100%, 44rem);" enctype="multipart/form-data">
        <xm-put />
        <xcsrf />
        <div class="mb-4 d-flex gap-2 align-items-center">
            <a href="/manage-announcements"><i data-feather="arrow-left"></i></a>
            <h1>Edit Pengumuman</h1>
        </div>
        @err
        <div class="text-danger">
            <ul>
                <?php foreach ($errors ?? [] as $messages): ?>
                    <?php foreach ($messages as $msg): ?>
                        <li><?= $msg ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        @enderr
        <div class="form-floating mb-3">
            <input type="text" name="judul" class="form-control @err('judul') is-invalid @enderr" id="judul" value="@old('judul', $record->title)" placeholder="Nama" required>
            <label for="judul">Judul</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="slug" class="form-control @err('slug') is-invalid @enderr" id="slug" value="@old('slug', $record->slug)" placeholder="Slug" aria-describedby="slugHelper" required>
            <label for="slug">Slug</label>
            <div class="form-text" id="slugHelper">
                Bagian teks yang akan ditampilkan di URL
            </div>
        </div>

        <div class="mb-3">
            <label for="editor" class="form-label">Konten</label>
            <input type="hidden" name="konten" id="konten" value="<?= old('konten') ?? htmlspecialchars($record->content, ENT_COMPAT | ENT_SUBSTITUTE) ?>" required>
            <trix-editor input="konten" id="editor" placeholder="Isi konten..."></trix-editor>
        </div>
        <div class="form-check">
            <label for="jadwalPengumuman">Jadwal Diumumkan</label>
            <input type="datetime-local" name="jadwalPengumuman" class="form-control @err('jadwalPengumuman') is-invalid @enderr" id="jadwalPengumuman" value="@old('jadwalPengumuman', $publishedAt)">
        </div>
        <div class="mb-3">
            <label for="jadwalKadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
            <input type="datetime-local" name="jadwalKadaluarsa" class="form-control @err('jadwalKadaluarsa') is-invalid @enderr" id="jadwalKadaluarsa" value="@old('jadwalKadaluarsa', $expiredAt)" required>
        </div>
        <div class="d-flex gap-2">
            <a href="/manage-announcements" class="btn btn-secondary flex-fill">Batal</a>
            <button type="submit" class="btn btn-primary flex-fill">Simpan</button>
        </div>
    </form>
    <script src="/assets/script.js"></script>
    <script>
        let timeoutId = 0;
        let titleInp = query("#judul");
        let slugInp = query("#slug");
        let csrfToken = query("#_csrf_token");
        titleInp.oninput = () => {
            if (timeoutId) clearTimeout(timeoutId);
            if (titleInp.value.trim() == "") {
                slugInp.value = "";
                return;
            }
            timeoutId = setTimeout(() => {
                let encStr = encodeURI(titleInp.value.trim());
                fetch("/manage-announcements/generate-slug?title=" + encStr)
                    .then(res => res.json()).then(data => {
                        slugInp.value = data.slug;
                    });
            }, 500);
        };
        addEventListener("before-trix-initialize", (event) => {
            const trixEditor = event.target

            trixEditor.willCreateInput = false
        })
        document.addEventListener("trix-attachment-add", (e) => {
            if (e.attachment.file) {
                uploadAttachment(e.attachment, csrfToken);
            }
        });
    </script>
</x-dashb>