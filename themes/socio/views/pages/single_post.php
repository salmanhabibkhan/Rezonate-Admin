<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">

    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 px-0 col-lg-6 vstack gap-3">

        <div id="post_holder" class="single_post" data-post_type="single_post" data-postid="<?=$post_id?>"></div>
     
    </div>
    <?= $this->include('partials/right_sidebar') ?>

</div>
<?= $this->endSection() ?>