<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-3">
        <?= $this->include('partials/settings_sidebar') ?>
    </div>

    <div class="col-lg-6 vstack gap-4">
        <div class="py-0 mb-0">
            <div class="card mb-4">
                <div class="card-header border-0 border-bottom">
                    <h1 class="h5 card-title"><?= lang('Web.social_settings') ?></h1>
                </div>
                <div class="card-body">
                    <form id="socialSettingsForm" class="row g-3">
                        <!-- Facebook -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.facebook') ?></label>
                            <div class="input-group">
                                <span class="input-group-text border-0"> <i class="bi bi-facebook text-facebook"></i> </span>
                                <input type="text" class="form-control" name="facebook" placeholder="<?= lang('Web.facebook_placeholder') ?>" value="<?= esc($userdata['facebook']) ?>">
                            </div>
                        </div>
                        <!-- Twitter -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.twitter') ?></label>
                            <div class="input-group">
                                <span class="input-group-text border-0"> <i class="bi bi-twitter text-twitter"></i> </span>
                                <input type="text" class="form-control" name="twitter" placeholder="<?= lang('Web.twitter_placeholder') ?>" value="<?= esc($userdata['twitter']) ?>">
                            </div>
                        </div>
                        <!-- Instagram -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.instagram') ?></label>
                            <div class="input-group">
                                <span class="input-group-text border-0"> <i class="bi bi-instagram text-instagram"></i> </span>
                                <input type="text" class="form-control" name="instagram" placeholder="<?= lang('Web.instagram_placeholder') ?>" value="<?= esc($userdata['instagram']) ?>">
                            </div>
                        </div>
                        <!-- LinkedIn -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.linkedin') ?></label>
                            <div class="input-group">
                                <span class="input-group-text border-0"> <i class="bi bi-linkedin text-linkedin"></i> </span>
                                <input type="text" class="form-control" name="linkedin" placeholder="<?= lang('Web.linkedin_placeholder') ?>" value="<?= esc($userdata['linkedin']) ?>">
                            </div>
                        </div>
                        <!-- YouTube -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.youtube') ?></label>
                            <div class="input-group">
                                <span class="input-group-text border-0"> <i class="bi bi-youtube text-youtube"></i> </span>
                                <input type="text" class="form-control" name="youtube" placeholder="<?= lang('Web.youtube_placeholder') ?>" value="<?= esc($userdata['youtube']) ?>">
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary mb-0"><?= lang('Web.save_changes') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    
    function translate(key) {
           
        var translations = {
            'social_update_success': '<?= lang('Web.social_update_success') ?>',
            'social_update_error': '<?= lang('Web.social_update_error') ?>',
            'facebook': '<?= lang('Web.facebook') ?>',
            'twitter': '<?= lang('Web.twitter') ?>',
            'instagram': '<?= lang('Web.instagram') ?>',
            'linkedin': '<?= lang('Web.linkedin') ?>',
            'youtube': '<?= lang('Web.youtube') ?>',
            'update_status':'<?=lang('Web.update_status')?>',
        };

            return translations[key] || key;
        }
    $(document).ready(function() {
        $('#socialSettingsForm').validate({
            rules: {
                // Add validation rules as necessary
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/settings/update-user-profile', // API endpoint
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.code == 200) {
                            showAlert(response.message, translate('update_status'), 'success');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: '<?= lang('Web.social_update_error') ?>'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            text: '<?= lang('Web.social_update_error') ?>'
                        });
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
