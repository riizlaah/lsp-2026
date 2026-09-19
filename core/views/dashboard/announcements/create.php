<x-dashb>
    <form action="/manage-announcements/create" method="post" class="mx-auto shadow rounded my-4 p-4" style="width: min(100%, 44rem);" enctype="multipart/form-data">
        <xcsrf />
        <div class="mb-4 d-flex gap-2 align-items-center">
            <a href="/manage-announcements"><i data-feather="arrow-left"></i></a>
            <h1>Buat Pengumuman Baru</h1>
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
            <input type="text" name="judul" class="form-control @err('judul') is-invalid @enderr" id="judul" value="@old('judul')" placeholder="Nama" required>
            <label for="judul">Judul</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="slug" class="form-control @err('slug') is-invalid @enderr" id="slug" value="@old('slug')" placeholder="Slug" aria-describedby="slugHelper" required>
            <label for="slug">Slug</label>
            <div class="form-text" id="slugHelper">
                Bagian teks yang akan ditampilkan di URL
            </div>
        </div>

        <div class="mb-3">
            <label for="editor" class="form-label">Konten</label>
            <input type="hidden" name="konten" id="konten" value="<?= old('konten') ?>" required>
            <trix-editor input="konten" id="editor" placeholder="Isi konten..."></trix-editor>
        </div>
        <span>Waktu Pengumuman</span>
        <div class="form-check">
            <input class="form-check-input @err('waktuPengumuman') is-invalid @enderr" type="radio" name="waktuPengumuman" id="waktuPengumuman1" value="s" <?= (old('waktuPengumuman') == "s") ? 'checked' : '' ?>>
            <label class="form-check-label" for="waktuPengumuman1">
                Umumkan Setelah Dibuat
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input @err('waktuPengumuman') is-invalid @enderr" type="radio" name="waktuPengumuman" id="waktuPengumuman2" value="t" <?= (old('waktuPengumuman') == "t") ? 'checked' : '' ?>>
            <label class="form-check-label" for="waktuPengumuman2">
                Terjadwal
                <div class="mb-3 d-flex gap-2">
                    <input type="datetime-local" name="jadwalPengumuman" class="form-control @err('jadwalPengumuman') is-invalid @enderr" id="jadwalPengumuman" value="@old('jadwalPengumuman')">
                </div>
            </label>
        </div>
        <div class="mb-3">
            <label for="jadwalKadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
            <input type="datetime-local" name="jadwalKadaluarsa" class="form-control @err('jadwalKadaluarsa') is-invalid @enderr" id="jadwalKadaluarsa" value="@old('jadwalKadaluarsa')" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Simpan</button>
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