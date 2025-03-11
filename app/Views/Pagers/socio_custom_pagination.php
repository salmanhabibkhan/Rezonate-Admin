<div class="mt-4">
    <nav aria-label="navigation">
        <ul class="pagination pagination-light d-inline-block d-md-flex justify-content-center" style="position: relative;">
            <?php if ($pager->hasPreviousPage()) : ?>
                <li class="page-item">
                    <a href="<?= $pager->getFirst() ?>" class="page-link" aria-label="First">
                        <span aria-hidden="true">&laquo;&laquo;</span> First
                    </a>
                </li>
                <li class="page-item">
                    <a href="<?= $pager->getPreviousPage() ?>" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span> Previous
                    </a>
                </li>
            <?php endif; ?>

            <?php foreach ($pager->links() as $link) : ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                    <a href="<?= $link['uri'] ?>" class="page-link"><?= $link['title'] ?></a>
                </li>
            <?php endforeach; ?>
   
            <?php if ($pager->hasNextPage()) : ?>
                <li class="page-item">
                    <a href="<?= $pager->getNextPage() ?>" class="page-link" aria-label="Next">
                        Next <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a href="<?= $pager->getLast() ?>" class="page-link" aria-label="Last">
                        Last <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
