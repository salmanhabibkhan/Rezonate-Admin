<!-- app/Views/pages/blog/blog_detail.php -->

<?= $this->extend('layouts/custom_pages') ?>

<?= $this->section('content') ?>


<div class="row g-4">
      <!-- Main content START -->
      <div class="col-lg-8 mx-auto">
        <!-- Privacy & terms START -->
        <div class="card">
          <div class="card-header">
            <h1 class="card-title h4 mb-0"><?= $custompage['page_title'] ?></h1>
          </div>
          <div class="card-body">
           
          <?= $custompage['page_content'] ?>
        </div>
        <!-- Privacy & terms END -->
      </div>
    </div>






<script>
    $(document).ready(function(){
        // Add your existing AJAX script for recent tags if needed
        // ...
    });
</script>

<?= $this->endSection() ?>
