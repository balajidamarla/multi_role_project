<?php
$pager->setSurroundCount(2);
?>

<nav aria-label="Page navigation" class="inline-flex items-center space-x-1">
    <?php if ($pager->hasPreviousPage()) : ?>
        <a href="<?= $pager->getPreviousPage() ?>" class="px-3 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-sm font-medium text-gray-700">&laquo;</a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
        <a href="<?= $link['uri'] ?>"
            class="px-3 py-2 rounded-md text-sm font-medium <?= $link['active'] ? 'bg-gray-900 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' ?>">
            <?= $link['title'] ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNextPage()) : ?>
        <a href="<?= $pager->getNextPage() ?>" class="px-3 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-sm font-medium text-gray-700">&raquo;</a>
    <?php endif ?>
</nav>