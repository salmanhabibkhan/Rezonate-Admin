<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>



<div class="row g-4">

    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 px-0 col-lg-6 vstack gap-3">

       
       
        <div id="post_holder" data-post_type="video"></div>
       

    </div>
    <!-- Main content END -->

    <!-- Right sidebar START -->
    <?= $this->include('partials/post_html_models') ?>
    <!-- Right sidebar END -->

    <!-- Right sidebar START -->
    <?= $this->include('partials/right_sidebar') ?>
    <!-- Right sidebar END -->

</div> <!-- Row END -->
<?= $this->endSection() ?>