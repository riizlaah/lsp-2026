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
            <input class="form-check-input @err('status') is-invalid @enderr" type="radio" name="status" id="status1" value="d" <?= (old('status') == "d") ? 'checked' : '' ?>>
            <label class="form-check-label" for="status1">
                Umumkan Setelah Dibuat
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input @err('status') is-invalid @enderr" type="radio" name="status" id="status2" value="r" <?= (old('status') == "r") ? 'checked' : '' ?>>
            <label class="form-check-label" for="status2">
                Terjadwal
                <div class="mb-3 d-flex gap-2">
                    <input type="date" name="tanggalPublikasi" class="form-control @err('tanggalPublikasi') is-invalid @enderr" id="tanggalPublikasi" value="@old('tanggalPublikasi')">
                    <div class="d-flex gap-1 align-items-center">
                        <select name="jam" id="jam" class="form-select">
                            <?php for ($i = 0; $i <= 23; $i++): $val = str_pad((string)$i, 2, "0", STR_PAD_LEFT); ?>
                                <option value="<?= $val ?>"><?= $val ?></option>
                            <?php endfor; ?>
                        </select>
                        :
                        <select name="menit" id="menit" class="form-select">
                            <?php for ($i = 0; $i <= 59; $i++): $val = str_pad((string)$i, 2, "0", STR_PAD_LEFT); ?>
                                <option value="<?= $val ?>"><?= $val ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Simpan</button>
    </form>
    <script>
        let timeoutId = 0;
        let titleInp = document.querySelector("#judul");
        let slugInp = document.querySelector("#slug");
        let csrfToken = document.querySelector("#_csrf_token");
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
                e.attachment.remove();
            }
        });
    </script>
</x-dashb>