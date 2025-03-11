<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content" style="height: 75vh;">
    <div class="container-fluid h-100">
        <!-- 1st row starts from here -->
        <div class="row h-100 d-flex align-items-center justify-content-center">
            <div class="col-12 text-center">
                <div>
                    <img src="<?= base_url('public/system-status.png') ?>" alt="<?= lang('Admin.systemStatusImageAlt') ?>">
                    <h2><?= lang('Admin.systemPerfectCondition') ?></h2>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
