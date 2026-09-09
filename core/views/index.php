<x-main>
    <div class="container p-4 my-3 mx-auto bg-primary rounded-4 row align-items-center text-white">
        <div class="col me-6">
            <span class="fs-4 fw-bold d-block mb-2">Sambutan Kepala Sekolah</span>
            <p class="">Berkat rahmat dan karunia Tuhan Yang Maha Esa, website SMK Negeri 1 Kandeman Kabupaten Batang akhirnya dapat dibangun. Tujuan pembangunan website sekolah ini adalah untuk memperkenalkan, memberikan kemudahan, dan memberikan wawasan kepada masyarakat tentang SMK Negeri 1 Kandeman.</p>
        </div>
        <img src="https://placehold.co/200x300?text=Kepala+Sekolah" alt="Kepala Sekolah" class="col-auto">
    </div>
    <div class="container-lg my-3">
        <div id="activities" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php for($i = 1; $i <= 3; $i++): ?>
                    <div class="carousel-item <?= $i === 1 ? "active" : "" ?>">
                        <img src="https://placehold.co/400x200?text=Kegiatan+<?= $i ?>" class="d-block w-100" alt="Kegiatan <?= $i ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Kegiatan <?= $i ?></h5>
                            <p>Deskripsi singkat kegiatan <?= $i ?></p>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#activities" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#activities" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="container-lg my-4">
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Pengumuman Terbaru</h4>
            <p>Deskripsi Pengumuman terbaru.</p>
        </div>
    </div>
    <div class="container-lg my-3">
        <h1>Artikel Terbaru</h1>
        <div class="row row-cols-3 g-3">
            <?php for($i = 1; $i <= 6; $i++): ?>
            <div class="col">
                <div class="card">
                    <img src="https://placehold.co/400x200?text=Berita+<?= $i ?>" class="card-img-top" alt="Berita <?= $i ?>">
                    <div class="card-body">
                        <h5 class="card-title">Berita <?= $i ?></h5>
                        <p class="card-text">Sedikit konten dari berita <?= $i ?></p>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <a href="/information/articles" class="my-3 d-block">Lihat lainnya...</a>
    </div>
    <div class="container-lg">
        <div>
            <h2>50+ Rekanan Industri</h2>
            <p>Meningkatkan kompetensi Peserta didik dengan menghadirkan pembelajaran berstandar industri. Lebih dari 50 perusahaan telah bekerja sama dengan SMK Negeri 1 Kandeman dalam berbagai macam program termasuk rekrutmen tenaga kerja</p>
        </div>
        <div class="row row-cols-5 g-2">
            <img src="/assets/images/iconplus.png" alt="PLN Icon Plus" class="col object-fit-contain">
            <img src="/assets/images/techarea.png" alt="Techarea" class="col object-fit-contain">
            <img src="/assets/images/aski.png" alt="aski" class="col object-fit-contain">
            <img src="/assets/images/honda.png" alt="Honda" class="col object-fit-contain">
            <img src="/assets/images/astra.png" alt="Astra Otoparts" class="col object-fit-contain">
            <img src="/assets/images/barito-pacific.png" alt="Barito Pacific" class="col object-fit-contain">
        </div>
    </div>
    <!-- 
    - Sambutan Kepala Sekolah
    - Banner / Slider kegiatan terbaru
    - Pengumuman dan berita terkini
    - Keunggulan atau profil singkat sekolah
     -->
</x-main>