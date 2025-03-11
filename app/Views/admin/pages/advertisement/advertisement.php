<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for=""><?= lang('Admin.header_label') ?></label>
                            <textarea class="form-control settings_text" id="header_ad" name="header_ad" ><?= get_setting('header_ad') ?></textarea>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-md-12">
                            <label for=""><?= lang('Admin.sidebar_label') ?></label>
                            <textarea class="form-control settings_text" id="sidebar_ad" name="sidebar_ad" ><?= get_setting('sidebar_ad') ?></textarea>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-md-12">
                            <label for=""><?= lang('Admin.first_post_label') ?></label>
                            <textarea class="form-control settings_text" id="first_post_ad" name="first_post_ad"   ><?= get_setting('first_post_ad') ?></textarea>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-md-12">
                            <label for=""><?= lang('Admin.second_post_label') ?></label>
                            <textarea class="form-control settings_text" id="second_post_ad" name="second_post_ad"  ><?= get_setting('second_post_ad') ?></textarea>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-md-12">
                            <label for=""><?= lang('Admin.third_post_label') ?></label>
                            <textarea class="form-control settings_text" id="third_post_ad" name="third_post_ad"  ><?= get_setting('third_post_ad') ?></textarea>
                        </div>
                   </div>
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
