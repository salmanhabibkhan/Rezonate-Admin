<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row g-3 mt-1">
    <div class="col-lg-8">
        <div class="bg-mode p-4">
            <?php if (!empty($blogs)) : ?>
                <h1 class="h4 mb-4 font-weight-bold text-center"><?= esc(lang('Web.blogs')) ?></h1> <!-- Translate "Blogs" -->
      
                <?php foreach ($blogs as $blog) : ?>
                    <div class="card bg-transparent border-0">
                        <div class="row g-3">
                            <div class="col-4">
                                <!-- Blog image -->
                                <img class="rounded" src="<?= $blog['thumbnail'] ?>" alt="">
                            </div>
                            <div class="col-8">
                                <!-- Blog caption -->
                                <a href="#" class="badge bg-danger bg-opacity-10 text-danger mb-2 fw-bold"><?= BLOG_CATEGORIES[$blog['category']] ?></a>
                                <h5><a href="<?= site_url('blog-details/'.$blog['id']) ?>" class="btn-link stretched-link text-reset fw-bold"><?= $blog['title'] ?></a></h5>
                                <div class="d-none d-sm-inline-block">
                                    <a href="<?= site_url('blog-details/'.$blog['id']) ?>" class="btn-link"><?= esc(lang('Web.read_more')) ?></a> <!-- Translate "Read More" -->
                                    <!-- Blog date -->
                                    <a class="small text-secondary" href="#!">
                                        <i class="bi bi-calendar-date pe-1"></i> <?= date('M d, Y', strtotime($blog['created_at'])) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                <?php endforeach; ?>
          
                <?= $pager_links ?>
        
            <?php else : ?>
                <div class="card bg-transparent border-0">
                    <div class="row">
                        <div class="my-sm-5 py-sm-5 text-center">
                            <i class="display-1 text-body-secondary bi bi-people"></i>
                            <h4 class="mt-2 mb-3 text-body"><?= esc(lang('Web.blogs_not_exist')) ?></h4> <!-- Translate "Blogs not existed" -->
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?= $this->include('pages/blog/blog_sidebar') ?>

</div>

<?= $this->endSection() ?>
