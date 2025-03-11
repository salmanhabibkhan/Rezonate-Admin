<!-- app/Views/pages/blog/blog_detail.php -->

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row g-3 mt-1">
    <div class="col-lg-8">
        <div class="bg-mode p-4">
            <?php if ($blog): ?>
                <div class="card bg-transparent border-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <!-- Blog image -->
                            <h1 class="h2 text-center"><?= $blog['title'] ?></h1>
                            <img class="mt-3" src="<?= getMedia($blog['thumbnail']) ?>" alt="<?= $blog['title'] ?>" style="width:100%;">
                        </div>
                        <div class="col-12">
                            <!-- Blog caption -->
                            <a href="#" class="badge bg-danger bg-opacity-10 text-danger mb-2 fw-bold"><?= BLOG_CATEGORIES[$blog['category']] ?></a>
                            <p class="small text-secondary"><i class="bi bi-calendar-date pe-1"></i><?= date('M d, Y', strtotime($blog['created_at'])) ?></p>
                            <p><?= $blog['content'] ?></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center text-danger"><?= esc(lang('Web.blog_not_found')) ?></p> <!-- Translate "Blog not found" -->
            <?php endif; ?>
        </div>
    </div>

    <?= $this->include('pages/blog/blog_sidebar') ?>

</div>

<?= $this->endSection() ?>
