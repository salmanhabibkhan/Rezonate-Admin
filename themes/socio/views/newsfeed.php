<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>



<div class="row g-4">

    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 px-0 col-lg-6 vstack gap-3">

        <!-- Story START -->
        <?php 
            if(get_setting('user_stories') == 1){
                echo $this->include('partials/stories');
            }
        ?>
        <!-- Story END -->

        <!-- create post START -->
        <?= $this->include('partials/create_post') ?>
        <!-- create post END -->

        <?= $this->include('partials/greeting_message') ?>

        <!-- post feed item START -->
        <?php //$this->include('partials/posts') ?>
       
        <div id="post_holder"></div>
        <!-- post feed item END -->
        

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