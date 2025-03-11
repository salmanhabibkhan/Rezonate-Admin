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
                        <h3 class="card-title"><?= lang('Admin.general') ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.developer_mode') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.developer_mode_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['developer_mode'] == 1 ? 'checked="checked"' : ''; ?> data-key="developer_mode">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.maintenance_mode') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.maintenance_mode_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-maintenance_mode'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-maintenance_mode">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.welcome_page_users') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.welcome_page_users_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-profile_privacy'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-profile_privacy">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.reserved_usernames_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.reserved_usernames_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-reserved_usernames_system'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-reserved_usernames_system">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="censored_words"><?= lang('Admin.censored_words') ?></label>
                                    <textarea rows="5" class="form-control settings_text" id="censored_words" name="censored_words" placeholder="<?= lang('Admin.censored_words_placeholder') ?>"><?= $settings['censored_words'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1st row 2nd column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.login_registration') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.user_registration') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.user_registration_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-user_registration'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-user_registration">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.password_complexity_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.password_complexity_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-password_complexity_system'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-password_complexity_system">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.recaptcha') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.recaptcha_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-reCaptcha'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-reCaptcha">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recaptcha_sitekey"><?= lang('Admin.recaptcha_sitekey') ?></label>
                                <input type="text" class="form-control settings_text" id="recaptcha_sitekey" name="recaptcha_sitekey" value="<?= $settings['recaptcha_sitekey'] ?>"> 
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recaptcha_secret_key"><?= lang('Admin.recaptcha_secret_key') ?></label>
                                <input type="text" class="form-control settings_text" id="recaptcha_secret_key" name="recaptcha_secret_key" value="<?= $settings['recaptcha_secret_key'] ?>"> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2nd row starts from here -->
        <div class="row">
            <!-- 2nd row 1st column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.user_configuration') ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.user_account_deletion') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.user_account_deletion_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-deleteAccount'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-deleteAccount">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2nd row 2nd column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.notifications_settings') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.email_notifications') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.email_notifications_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-emailNotification'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-emailNotification">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.profile_visit_notifications') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.profile_visit_notifications_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-profileVisit'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-profileVisit">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i><?= lang('Admin.notification_on_new_post') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.notification_on_new_post_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-notify_new_post'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-notify_new_post">
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
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
