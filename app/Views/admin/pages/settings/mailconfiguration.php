<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>


<div class="">
    <div class="row">
        <!-- Mail Configuration Panel -->
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header border-bottom">
                    <h3 class="card-title"><?= lang('Admin.mail_configuration') ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?= lang('Admin.collapse') ?>">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('save-mail-configuration'); ?>" method="post">
                        <div class="row">
                            <!-- Protocol (MAIL_MAILER) -->
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.protocol') ?> (MAIL_MAILER)</label>
                                    <select name="mail_mailer" id="mail_mailer" class="form-control settings_text" required>
                                        <option value="smtp" <?= $settings['mail_mailer'] == 'smtp' ? 'selected' : '' ?>><?= lang('Admin.smtp') ?></option>
                                        <option value="sendmail" <?= $settings['mail_mailer'] == 'sendmail' ? 'selected' : '' ?>><?= lang('Admin.sendmail') ?></option>
                                    </select>
                                </div>
                            </div>

                            <!-- SMTP Settings -->
                            <div class="smtp-settings" style="display: none; width: 100%;">
                                <!-- SMTP Host -->
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.smtp_host') ?></label>
                                        <input type="text" name="mail_host" class="form-control settings_text" value="<?= $settings['mail_host'] ?? '' ?>">
                                    </div>
                                </div>

                                <!-- SMTP Port -->
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.smtp_port') ?></label>
                                        <input type="text" name="mail_port" class="form-control settings_text" value="<?= $settings['mail_port'] ?? '' ?>">
                                    </div>
                                </div>

                                <!-- SMTP Username -->
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.smtp_username') ?></label>
                                        <input type="text" name="mail_username" class="form-control settings_text" value="<?= $settings['mail_username'] ?? '' ?>">
                                    </div>
                                </div>

                                <!-- SMTP Password -->
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.smtp_password') ?></label>
                                        <input type="password" name="mail_password" class="form-control settings_text" value="<?= $settings['mail_password'] ?? '' ?>">
                                    </div>
                                </div>

                                <!-- SMTP Encryption -->
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.smtp_encryption') ?></label>
                                        <select name="mail_encryption" class="form-control settings_text">
                                            <option value="tls" <?= $settings['mail_encryption'] == 'tls' ? 'selected' : '' ?>><?= lang('Admin.tls') ?></option>
                                            <option value="ssl" <?= $settings['mail_encryption'] == 'ssl' ? 'selected' : '' ?>><?= lang('Admin.ssl') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- MAIL_FROM_ADDRESS -->
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.from_address') ?></label>
                                    <input type="email" name="email_from_address" id="email_from_address" class="form-control settings_text" value="<?= $settings['email_from_address'] ?? '' ?>">
                                </div>
                            </div>

                            <!-- MAIL_FROM_NAME -->
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                <div class="form-group text-black">
                                    <label><?= lang('Admin.from_name') ?></label>
                                    <input type="text" name="mail_from_name" id="mail_from_name" class="form-control settings_text" value="<?= $settings['mail_from_name'] ?? '' ?>">
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <button type="submit" class="btn btn-primary"><?= lang('Admin.save_changes') ?></button>
                            </div> -->
                        </div>
                    </form>
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
    // Function to show/hide SMTP settings based on mail_mailer value
    function toggleSMTPSettings() {
        if ($('#mail_mailer').val() === 'smtp') {
            $('.smtp-settings').show();
        } else {
            $('.smtp-settings').hide();
        }
    }

    // Initial check on page load
    toggleSMTPSettings();

    // Check on mail_mailer change
    $('#mail_mailer').change(function() {
        toggleSMTPSettings();
    });
});
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>