<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

    <!-- 1st row starts from here -->
        <div class="row">

            <!-- 1st row 1st column -->
            <div class="col-md-6 offset-md-3">
                <div class="card card-primary">
                    <div class="card-header border-bottom">
                        <h4 class="card-title"><?= lang('Admin.paypal') ?></h4>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?= lang('Admin.collapse') ?>">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fab fa-paypal mr-1"></i><?= lang('Admin.paypal') ?></strong>   
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-paypal'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-paypal">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.paypal_client_id') ?></label>
                                    <input type="text" name="paypal_public_key" id="" class="form-control  settings_text" value="<?=$settings['paypal_public_key']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.paypal_client_secret') ?></label>
                                    <input type="text" name="paypal_secret_key" class="form-control settings_text" value="<?=$settings['paypal_secret_key']?>">
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card card-primary">
                    <div class="card-header border-bottom">
                        <h4 class="card-title"><?= lang('Admin.stripe') ?></h4>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?= lang('Admin.collapse') ?>">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fab fa-stripe-s mr-1"></i><?= lang('Admin.stripe') ?></strong>   
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-stripe'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-stripe">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.stripe_public_key') ?></label>
                                    <input type="text" name="stripe_public_key" id="" class="form-control  settings_text" value="<?=$settings['stripe_public_key']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.stripe_secret_key') ?></label>
                                    <input type="text" name="stripe_secret_key" class="form-control settings_text" value="<?=$settings['stripe_secret_key']?>">
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card card-primary">
                    <div class="card-header border-bottom">
                        <h4 class="card-title"><?= lang('Admin.paystack') ?></h4>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?= lang('Admin.collapse') ?>">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fab fa-product-hunt mr-1"></i><?= lang('Admin.paystack') ?></strong>   
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-paystack'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-paystack">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.paystack_public_key') ?></label>
                                    <input type="text" name="paystack_public_key" id="" class="form-control  settings_text" value="<?=$settings['paystack_public_key']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.paystack_secret_key') ?></label>
                                    <input type="text" name="paystack_secret_key" id="" class="form-control  settings_text" value="<?=$settings['paystack_secret_key']?>">
                                </div>
                            </div>
                        </div>
                        
                    </div>                    
                </div>
                <div class="card card-primary">
                    <div class="card-header border-bottom">
                        <h4 class="card-title"><?= lang('Admin.flutterwave') ?></h4>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?= lang('Admin.collapse') ?>">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-f mr-1"></i><?= lang('Admin.flutterwave') ?></strong>   
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-flutterwave'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-flutterwave">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.flutterwave_public_key') ?></label>
                                    <input type="text" name="flutterwave_public_key" id="" class="form-control  settings_text" value="<?=$settings['flutterwave_public_key']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.flutterwave_secret_key') ?></label>
                                    <input type="text" name="flutterwave_secret_key" id="" class="form-control  settings_text" value="<?=$settings['flutterwave_secret_key']?>">
                                </div>
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
