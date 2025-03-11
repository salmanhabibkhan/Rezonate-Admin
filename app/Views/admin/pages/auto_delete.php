<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

    <!-- 1st row starts from here -->
        <div class="row">

            <!-- 1st row 1st column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.auto_delete_website_data') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?= lang('Admin.collapse') ?>">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('admin/deleteautodata') ?>" method="post">
                            <div class="alert alert-info"><?= lang('Admin.backup_recommendation') ?></div>
                            <div class="form-group">
                                <label for="date_style"><?= lang('Admin.choose_one') ?></label>
                                <select id="date_style" class="form-control custom-select" name="data_type">                            
                                    <option value="1"><?= lang('Admin.delete_inactive_users') ?></option>
                                    <option value="2"><?= lang('Admin.delete_users_not_logged_in_1_week') ?></option>
                                    <option value="3"><?= lang('Admin.delete_users_not_logged_in_1_month') ?></option>
                                    <option value="4"><?= lang('Admin.delete_users_not_logged_in_1_year') ?></option>
                                    <option value="5"><?= lang('Admin.delete_posts_older_than_1_week') ?></option>
                                    <option value="6"><?= lang('Admin.delete_posts_older_than_1_month') ?></option>
                                    <option value="7"><?= lang('Admin.delete_posts_older_than_1_year') ?></option>
                                </select>
                            </div>
                            <div class="alert alert-warning"><?= lang('Admin.process_warning') ?></div>
                            <button class="btn btn-danger" type="submit"><?= lang('Admin.submit') ?></button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
