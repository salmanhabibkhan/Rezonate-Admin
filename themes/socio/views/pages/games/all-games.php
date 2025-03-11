<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 col-lg-6 vstack gap-4">
        <!-- Card START -->
        <div class="card">
            <!-- Card header START -->
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-2">
                        <!-- Card title -->
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.all_games') ?></h1> <!-- Use 'all_games' translation key -->
                    </div>
                   
                </div>
            </div>
            <!-- Card header END -->
            
            <!-- Card body START -->
            <div class="card-body">
                <?php if (!empty($games)): ?>
                    <div class="row g-4">
                        <?php foreach ($games as $game): ?>
                            <div class="col-sm-6 col-lg-4">
                                <!-- Card START -->
                                <div class="card">
                                    <div class="h-80px rounded-top" style="background-image:url(<?= getMedia($game['image']) ?>); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                                    <!-- Card body START -->
                                    <div class="card-body text-center pt-0">
                                        <!-- Info -->
                                    </div>
                                    <!-- Card body END -->
                                </div>
                                <!-- Card END -->
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- No Groups Found START -->
                    <div class="my-sm-5 py-sm-5 text-center">
                        <i class="display-1 text-body-secondary bi bi-controller"></i>
                        <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_games_found') ?></h4> <!-- Use 'no_games_found' translation key -->
                    </div>
                    <!-- No Groups Found END -->
                <?php endif; ?>
            </div>
            <!-- Card body END -->
        </div>
        <!-- Card END -->
    </div>
    <!-- Main content END -->
</div>

<?= $this->endSection() ?>
