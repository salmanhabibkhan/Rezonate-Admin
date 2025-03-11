<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="pt-5 pb-0 position-relative" style="background-image: url(<?= load_asset('images/movies.jpg'); ?>); background-repeat: no-repeat; background-size: cover; background-position: top center;">
    <div class="bg-overlay bg-dark opacity-8"></div>
    <!-- Container START -->
    <div class="container">
        <div class="py-5">
            <div class="row position-relative">
                <div class="col-lg-9 mx-auto">
                    <div class="text-center">
                        <!-- Title -->
                        <h1 class="text-white"><?= lang('Web.movies_title') ?></h1>
                        <p class="text-white"><?= lang('Web.discover_new_movies') ?></p>
                    </div>
                    <div class="mx-auto bg-mode shadow rounded p-4 mt-5">
                        <!-- Form START -->
                        <form class="row align-items-end g-4" action="<?= site_url('movies'); ?>">
                            <!-- Search input -->
                            <div class="col-sm-6 col-lg-10">
                                <input type="text" name="movie_name" placeholder="<?= lang('Web.search_movies') ?>" class="form-control" value="">
                            </div>
                            <!-- Search button -->
                            <div class="col-sm-6 col-lg-2">
                                <button type="submit" class="btn btn-primary w-100"><?= lang('Web.search') ?></button>
                            </div>
                        </form>
                        <!-- Form END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row g-3 mt-1">
    <?= $this->include('partials/sidebar_movies') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-12">
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.movies') ?> <?= isset($_GET['genre']) ? '(' . $_GET['genre'] . ')' : '' ?></h1>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($movies)) { ?>
                    <div class="row g-3">
                        <?php foreach ($movies as $movie) { ?>
                            <div class="col-sm-6 col-xl-4">
                                <div class="card h-100">
                                    <div class="card-body position-relative p-0" style="text-align:center; margin:0 auto">
                                        <div class="position-relative" style="max-height: 200px; overflow: hidden;">
                                            <a href="<?= $movie['cover_pic'] ?>" target="_blank"><img class="img-fluid rounded-top" src="<?= $movie['cover_pic'] ?>" alt="<?= $movie['movie_name'] ?>"></a>
                                        </div>
                                        <h6 class="mt-3"><a href="<?= site_url('movies/' . $movie['id']); ?>"><?= $movie['movie_name'] ?></a></h6>
                                        <p class="mb-0 small"><i class="bi bi-star-fill pe-1"></i> <?= lang('Web.stars') ?>: <?= $movie['stars'] ?></p>
                                        <p class="small"><i class="bi bi-person pe-1"></i> <?= lang('Web.producer') ?>: <?= $movie['producer'] ?></p>
                                        <p class="small"><i class="bi bi-calendar pe-1"></i> <?= lang('Web.release_year') ?>: <?= $movie['release_year'] ?></p>
                                        <p class="small"><i class="bi bi-clock pe-1"></i> <?= lang('Web.duration') ?>: <?= $movie['duration'] ?> <?= lang('Web.minutes') ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="my-sm-5 py-sm-5 text-center">
                            <i class="display-1 text-body-secondary bi bi-film"></i>
                            <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_movies_found') ?></h4>
                            <!-- <a href="<?= site_url('movies'); ?>"><?= lang('Web.back_to_movies') ?></a> -->
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="card-footer">
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <nav aria-label="<?= lang('Web.movie_pagination') ?> border-top mt-2">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item mx-2 <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= site_url('movies?page=' . $i) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
