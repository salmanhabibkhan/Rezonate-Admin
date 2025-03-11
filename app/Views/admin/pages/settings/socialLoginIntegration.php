<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

    <!-- 1st row starts from here -->
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><?= lang('Admin.google_login') ?></h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fab fa-google" style="color: #e63d3d;"></i> <?= lang('Admin.google_login') ?></strong>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-googleLogin'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-googleLogin">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="google_client_id"><?= lang('Admin.google_client_id') ?></label>
                            <input type="text"
                                   class="form-control settings_text"
                                   id="google_client_id"
                                   name="google_client_id"
                                   placeholder="<?= lang('Admin.google_client_id_placeholder') ?>"
                                   value="<?= get_setting('google_client_id') ?>">
                        </div>
                        <div class="form-group">
                            <label for="google_client_secret"><?= lang('Admin.google_client_secret') ?></label>
                            <input type="text"
                                   class="form-control settings_text"
                                   id="google_client_secret"
                                   name="google_client_secret"
                                   placeholder="<?= lang('Admin.google_client_secret_placeholder') ?>"
                                   value="<?= get_setting('google_client_secret') ?>">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><?= lang('Admin.facebook_login') ?></h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fab fa-facebook" style="color: blue;"></i> <?= lang('Admin.facebook_login') ?></strong>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-facebookLogin'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-facebookLogin">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="facebook_client_id"><?= lang('Admin.facebook_client_id') ?></label>
                            <input type="text"
                                   class="form-control settings_text"
                                   id="facebook_client_id"
                                   name="facebook_client_id"
                                   placeholder="<?= lang('Admin.facebook_client_id_placeholder') ?>"
                                   value="<?= get_setting('facebook_client_id') ?>">
                        </div>
                        <div class="form-group">
                            <label for="facebook_client_secret"><?= lang('Admin.facebook_client_secret') ?></label>
                            <input type="text"
                                   class="form-control settings_text"
                                   id="facebook_client_secret"
                                   name="facebook_client_secret"
                                   placeholder="<?= lang('Admin.facebook_client_secret_placeholder') ?>"
                                   value="<?= get_setting('facebook_client_secret') ?>">
                        </div>
                    </div>
                </div>  
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><?= lang('Admin.linkedin_login') ?></h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fab fa-linkedin" style="color: #1e3050;"></i> <?= lang('Admin.linkedin_login') ?></strong>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-linkedinLogin'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-linkedinLogin">
                                    <span class="slider round"></span>
                                </label>
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


<script>
$(document).ready(function() {
    $("body").on('change', '.storage_setting', function(event) {
		event.preventDefault();
		var that = $(this);
		var key = that.data('key');
		var value = that.val();
        $('.storage_setting').prop('checked', false).prop('disabled', false); // Uncheck and enable all checkboxes
        $(this).prop('checked', true).prop('disabled', true); // Check and disable the clicked checkbox

		change_settings_value(key, value, function(res) {
            if(res.success){
                toastr.success("Storage setting is set for uploading is "+value);
            }else{
                showError('Error', res.error);
            }
		});
    });
});
</script>


<?= $this->include('admin/script') ?>



<?= $this->endSection() ?>