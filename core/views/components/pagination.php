<?php
$page = $page ?? 0;
$maxPage = $maxPage ?? 0;
$items = $items ?? 0;
?>
<?php if ($items > 1): ?>
    <div class="d-flex justify-content-center my-4">
        <div class="btn-group" role="group">
            <?php if($page > 1): ?>
                <a href="?page=1" role="button" class="btn btn-outline-primary">&laquo;</a>
            <?php endif; ?>
            <?php for($i = max($page - 2, 1); $i < min($page + 2, $maxPage + 1); $i++): ?>
                <a href="?page=<?= $i ?>" role="button" class="btn btn-outline-primary"><?= $i ?></a>
            <?php endfor?>
            <?php if($page != $maxPage): ?>
                <a href="?page=<?= $maxPage ?>" role="button" class="btn btn-outline-primary">&raquo;</a>
            <?php endif; ?>
        </div>
        <!-- SLOT_PLACEHOLDER -->
    </div>
<?php endif; ?>