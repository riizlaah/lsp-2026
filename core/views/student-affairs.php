<x-main>
    <div class="container-sm mx-auto my-4 p-3 rounded shadow row row-cols-1 row-cols-lg-2 g-3">
        <div class="col">
            <h1>OSIS dan MPK</h1>
            <p>Wadah berorganisasi untuk melatih kepemimpinan, kolaborasi, dan tanggung jawab sosial siswa.</p>
        </div>
        <div class="col">

        </div>
    </div>
    <!--
    Informasi OSIS dan MPK
    -->
    <div class="container-sm mx-auto mb-4 p-3 rounded shadow row row-cols-1 row-cols-lg-2 g-3">
        <div class="col order-1 order-lg-0">
            <div class="row row-cols-2 g-3">
                <?php

                use Carbon\Carbon;

                foreach ($galleries ?? [] as $record): ?>
                    <div class="col">
                        <a href="/student-affairs/galeries/<?= $record->refTable ?>/<?= $record->refId ?>" class="text-decoration-none d-block h-100">
                            <div class="h-100 position-relative rounded bg-black">
                                <img src="<?= $record->mediaPath ? "/assets/uploads/" . $record->mediaPath : "/assets/images/no-img.webp" ?>" class="card-img-top w-100 h-100 object-fit-contain" alt="<?= $record?->description ?? "No Description" ?>">
                                <span class="text-end p-3 text-white" style="position: absolute; right: 0px; bottom: 0px; width: 100%; background: linear-gradient(0deg, rgba(0,0,0,0.7), rgba(0,0,0,0))">
                                    <?= Carbon::parse($record->createdAt)->locale('id')->format("F Y") ?>
                                </span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="/student-affairs/galeries" class="mt-2 w-100 text-center d-block">Lihat Lebih Banyak...</a>
        </div>
        <div class="col d-flex flex-column justify-content-center align-items-center">
            <h1 class="text-primary fw-bold">Arsip galeri</h1>
            <p>Lihat foto-foto kegiatan yang telah kami laksanakan</p>
        </div>
        
    </div>
    <div class="container-sm mx-auto rounded shadow mb-4 p-4 row row-cols-1 row-cols-lg-2 g-3">
        <div class="col d-flex flex-column justify-content-center align-items-center">
            <h1 class="text-success fw-bold">Pencapaian</h1>
            <p>Prestasi-prestasi yang telah dicapai oleh siswa kami </p>
        </div>
        <div class="col">
            <div class="row row-cols-2 g-3">
                <?php foreach ($achievements ?? [] as $record): ?>
                    <div class="col">
                        <a href="/student-affairs/achievements/<?= $record->id ?>" class="text-decoration-none d-block h-100">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $record->title ?></h5>
                                </div>
                                <div class="card-footer text-end">
                                    <?= getIDNMonthName($record->month) . " " . (string)$record->year ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="/student-affairs/achievements" class="w-100 d-block text-center mt-3">Lihat Prestasi & Karya</a>
        </div>
    </div>
</x-main>