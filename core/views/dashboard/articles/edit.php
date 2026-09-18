<x-dashb>
    <?php $record = $record ?? new \App\Models\Article; ?>
    <form action="/manage-articles/edit/<?= $record->id ?>" method="post" class="mx-auto shadow rounded my-4 p-4" style="width: min(100%, 44rem);" enctype="multipart/form-data">
        <xm-put />
        <xcsrf />
        <div class="mb-4 d-flex gap-2 align-items-center">
            <a href="/manage-articles"><i data-feather="arrow-left"></i></a>
            <h1>Edit Artikel</h1>
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
            <label for="headerImgInput" class="form-label">Gambar Tajuk</label>
            <img src="/assets/uploads/<?= $record->headerImage ?>" alt="Gambar Tajuk" id="imgPreview" class="w-75 object-fit-contain mb-1 mx-auto d-block">
            <input class="form-control" type="file" name="gambarTajuk" id="headerImgInput" accept="image/*" aria-describedby="gambarTajukHelper">
            <div class="form-text" id="gambarTajukHelper">
                Gambar utama yang akan ditampilkan
            </div>
        </div>
        <div class="mb-3">
            <label for="kategori">Kategori</label>
            <select class="form-select @err('kategori') is-invalid @enderr" id="kategori" name="kategori" required>
                <?php
                $kategori = old('kategori') ?? $record->categoryId;
                foreach ($categories ?? [] as $i => $opt): ?>
                    <option value="<?= $opt->id ?>" <?= (($i == 0 && !$kategori) xor $kategori == $opt->id) ? 'selected' : '' ?>><?= $opt->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="editor" class="form-label">Konten</label>
            <input type="hidden" name="konten" id="konten" value="<?= old('konten') ?? htmlspecialchars($record->content, ENT_COMPAT | ENT_SUBSTITUTE) ?>" required>
            <trix-editor input="konten" id="editor" placeholder="Isi konten..."></trix-editor>
        </div>
        <span>Status</span>
        <div class="form-check">
            <input class="form-check-input @err('status') is-invalid @enderr" type="radio" name="status" id="status1" value="d" <?= (old('status') == "d" || (!old('status') && !$record->isReleased)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="status1">
                Draft
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input @err('status') is-invalid @enderr" type="radio" name="status" id="status2" value="r" <?= (old('status') == "r" || (!old('status') && $record->isReleased)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="status2">
                Rilis
            </label>
        </div>
        <div class="d-flex gap-2">
            <a href="/manage-achievements" class="btn btn-secondary flex-fill">Batal</a>
            <button type="submit" class="btn btn-primary flex-fill">Simpan</button>
        </div>
    </form>
    <script>
        let timeoutId = 0;
        let titleInp = document.querySelector("#judul");
        let slugInp = document.querySelector("#slug");
        let imgInp = document.querySelector("#headerImgInput");
        let imgPreview = document.querySelector("#imgPreview");
        let csrfToken = document.querySelector("#_csrf_token");
        titleInp.oninput = () => {
            if (timeoutId) clearTimeout(timeoutId);
            if (titleInp.value.trim() == "") {
                slugInp.value = "";
                return;
            }
            timeoutId = setTimeout(() => {
                let encStr = encodeURI(titleInp.value.trim());
                fetch("/manage-articles/generate-slug?title=" + encStr)
                    .then(res => res.json()).then(data => {
                        slugInp.value = data.slug;
                    });
            }, 500);
        };
        imgInp.onchange = () => {
            const file = imgInp.files[0];
            if (file) {
                const objURL = URL.createObjectURL(file);
                imgPreview.src = objURL;
                imgPreview.style.display = "block";
                imgPreview.onload = () => {
                    URL.revokeObjectURL(objURL);
                };
            } else {
                imgPreview.src = "";
                imgPreview.style.display = "none";
            }
        };
        addEventListener("before-trix-initialize", (event) => {
            const trixEditor = event.target

            trixEditor.willCreateInput = false
        })
        document.addEventListener("trix-attachment-add", (e) => {
            if (e.attachment.file) {
                uploadAttachment(e.attachment);
            }
        });

        function uploadAttachment(attachment) {
            const form = new FormData();
            form.append("file", attachment.file);
            form.append("_csrf_token", csrfToken.value);
            fetch("/upload-images", {
                    method: "POST",
                    body: form
                }).then(res => res.json())
                .then(json => {
                    attachment.setAttributes({
                        url: json.url,
                        href: json.url
                    });
                    csrfToken.value = json.newToken;
                }).catch(e => {
                    console.error("Upload failed: ", e);
                    attachment.remove();
                })
        }
    </script>
</x-dashb>