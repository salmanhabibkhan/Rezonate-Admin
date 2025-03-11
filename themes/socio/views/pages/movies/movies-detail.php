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
                        <h1 class="text-white"><?= lang('Web.movies') ?></h1>
                        <p class="text-white"><?= lang('Web.discover_new_movies') ?></p>
                    </div>
                    <div class="mx-auto bg-mode shadow rounded p-4 mt-5">
                        <!-- Form START -->
                        <form class="row align-items-end g-4"  action="<?=site_url('movies');?>">

                            <!-- Search Movies -->
                            <div class="col-sm-6 col-lg-10">
                                <input type="text" name="movie_name" placeholder="<?= lang('Web.search_for_movies') ?>" class="form-control" value="">
                            </div>
                            <!-- Search Button -->
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
                    <div class="post-meta">
                            <h3 style="margin-top: 0px; margin-bottom: 5px;"><?= esc($movie['movie_name']); ?></h3>
                            <span class="text-muted"><?= lang('Web.release_year') ?>: <?= esc($movie['release_year']); ?></span> ‧
                            <span class="text-muted"><?= lang('Web.duration') ?>: <?= esc($movie['duration']); ?> <?= lang('Web.minutes') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="article-wrapper" style="border-radius: 16px;">
                    <div>
                        <!-- Movie Image and Details -->
                        <div class="post-avatar">
                            <div class="post-avatar-picture" style="background-image:url('<?= esc($movie['cover_pic']); ?>');">
                            </div>
                        </div>
                        
                    </div>

                    <!-- Movie Trailer -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ratio ratio-16x9">
                                <video controls autoplay>
                                    <source src="<?= getMedia($movie['video']) ?>" type="video/mp4">
                                    <?= lang('Web.video_not_supported') ?>
                                </video>
                            </div>
                        </div>
                    </div>

                    <!-- Movie Description -->
                    <div class="article-text my-4">
                        <?= lang('Web.movie_description') ?>: <?= esc($movie['description']); ?>
                    </div>

                    <!-- Movie Stars -->
                    <div>
                        <strong><?= lang('Web.stars') ?>:</strong>
                        <?= esc($movie['stars']); ?>
                    </div>

                    <!-- Additional Movie Information -->
                    <div class="mt-3">
                        <strong><?= lang('Web.release') ?>:</strong> <?= esc($movie['release_year']); ?>
                    </div>
                    <div class="mt-3">
                        <strong><?= lang('Web.duration') ?>:</strong> <?= esc($movie['duration']); ?> <?= lang('Web.minutes') ?>
                    </div>

                    <!-- IMDB Link -->
                    <div class="mt-3">
                        <strong><?= lang('Web.imdb') ?>:</strong>
                        <a href="<?= esc($movie['imdb_link']); ?>" target="_blank"><?= esc($movie['imdb_link']); ?></a>
                    </div>

                    <!-- Views Count -->
                    <!-- <div class="mt-3">
                        <strong><?= lang('Web.views') ?>:</strong> <?= esc($movie['views']); ?>
                    </div> -->

                    <!-- Social Share Buttons -->
                    <!-- <div class="mt-3">
                        <strong><?= lang('Web.share') ?>:</strong>
                        <!-- Social buttons here -->
                    </div> -->
                </div>

            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
