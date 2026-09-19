<x-main>
    <div class="container p-4 my-3 mx-auto bg-primary bg-gradient rounded-4 row align-items-center text-white">
        <img src="/assets/images/kepala-sekolah.webp" alt="Kepala Sekolah" class="col-auto w-25">
        <div class="col me-6">
            <span class="fs-4 fw-bold d-block mb-2">Sambutan Kepala Sekolah</span>
            <p class="">Berkat rahmat dan karunia Tuhan Yang Maha Esa, website SMK Negeri 1 Kandeman Kabupaten Batang akhirnya dapat dibangun. Tujuan pembangunan website sekolah ini adalah untuk memperkenalkan, memberikan kemudahan, dan memberikan wawasan kepada masyarakat tentang SMK Negeri 1 Kandeman.</p>
        </div>
    </div>
    <div class="container-lg my-3">
        <div id="activities" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($activities ?? [] as $i => $activity): ?>
                    <a class="carousel-item <?= $i === 0 ? "active" : "" ?> text-decoration-none" href="/information/articles/<?= $activity->slug ?>">
                        <img src="<?= $activity->headerImage ? "/assets/uploads/" . $activity->headerImage : "/assets/images/no-img.webp" ?>" class="d-block w-100" alt="<?= $activity->title ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= $activity->title ?></h5>
                            <p><?= getTextFromElement($activity->content) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#activities" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#activities" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Selanjutnya</span>
            </button>
        </div>
    </div>
    <?php if (isset($announcement)): ?>
        <div class="container-lg my-4">
            <a href="" class="text-decoration-none">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading"><?= $announcement->title ?></h4>
                    <p><?= getTextFromElement($announcement->content) ?></p>
                </div>
            </a>
        </div>
    <?php endif; ?>
    <div class="container-lg my-3">
        <h1>Artikel Terbaru</h1>
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <?php foreach ($articles ?? [] as $article): ?>
                <div class="col">
                    <a class="card text-decoration-none" href="/information/articles/<?= $article->slug ?>">
                        <img src="<?= $article->headerImage ? "/assets/uploads/" . $article->headerImage : "/assets/images/no-img.webp" ?>" class="card-img-top" alt="<?= $article->title ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $article->title ?></h5>
                            <p class="card-text"><?= getTextFromElement($article->content) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="/information/articles" class="my-3 d-block">Lihat lainnya...</a>
    </div>
    <div class="container-lg">
        <div class="mx-auto w-75 my-5">
            <h2 class="text-center">Belasan Rekanan Industri</h2>
            <p class="text-center">Meningkatkan kompetensi Peserta didik dengan menghadirkan pembelajaran berstandar industri. Lebih dari 50 perusahaan telah bekerja sama dengan SMK Negeri 1 Kandeman dalam berbagai macam program termasuk rekrutmen tenaga kerja</p>
        </div>
        <?php
        $partners = [
            "iconplus" => "PLN Icon Plus",
            "techarea" => "Techarea",
            "aski" => "Astra Komponen Indonesia",
            "honda" => "Honda",
            "astra" => "Astra Otoparts",
            "barito-pacific" => "Barito Pacific",
            "bumitama-gunajaya" => "Bumitama Gunajaya Agro",
            "djarum-foundation" => "Djarum Foundation",
            "mitsuboshi" => "Mitsuboshi",
            "panasonic" => "Panasonic",
            "gs-battery" => "GS Battery",
            "hino" => "Hino",
            "sis" => "SIS",
            "sinarmas" => "Sinarmas",
            "kpp" => "KPP"
        ];
        ?>
        <div class="row row-cols-2 row-cols-md-5 g-4">
            <?php foreach ($partners as $key => $value): ?>
                <img src="/assets/images/partners/<?= $key ?>.webp" alt="<?= $value ?>" class="col object-fit-contain" style="height: 150px;">
            <?php endforeach; ?>
        </div>
    </div>
</x-main>