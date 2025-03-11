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
                        <!-- Greeting System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-sun mr-1"></i><?= lang('Admin.greeting_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.greeting_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-afternoon_system'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-afternoon_system">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Stories System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-sun mr-1"></i><?= lang('Admin.stories_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.stories_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['user_stories'] == 1 ? 'checked="checked"' : ''; ?> data-key="user_stories">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <!-- Games System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-gamepad mr-1"></i><?= lang('Admin.games_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.games_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-games'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-games">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Pages System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-flag mr-1"></i><?= lang('Admin.pages_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.pages_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-pages'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-pages">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Groups System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-users mr-1"></i><?= lang('Admin.groups_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.groups_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-groups'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-groups">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Blogs System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-blog mr-1"></i><?= lang('Admin.blogs_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.blogs_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-blogs'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-blogs">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Events System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-calendar-alt mr-1"></i><?= lang('Admin.events_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.events_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-events'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-events">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Movies System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-film mr-1"></i><?= lang('Admin.movies_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.movies_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-movies'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-movies">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-handshake mr-1"></i><?= lang('Admin.space_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.space_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-space'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-space">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Nearby Friends System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-user-friends mr-1"></i><?= lang('Admin.nearby_friends_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.nearby_friends_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-find_friends'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-find_friends">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Jobs System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-briefcase mr-1"></i><?= lang('Admin.jobs_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.jobs_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-job_system'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-job_system">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Friend System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-user-friends mr-1"></i><?= lang('Admin.friend_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.friend_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['is_friend_system'] == 1 ? 'checked="checked"' : ''; ?> data-key="is_friend_system">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Market Place -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-shopping-cart mr-1"></i><?= lang('Admin.market_place') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.market_place_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-product'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-product">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Blood Donation -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-tint"></i><?= lang('Admin.blood_donation') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.blood_donation_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-blood'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-blood">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Wallet -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-wallet"></i><?= lang('Admin.wallet') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.wallet_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-wallet'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-wallet">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1st row 2nd column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.upgrade_to_pro_system') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Package System -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-layer-group mr-1"></i><?= lang('Admin.package_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.package_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-point_level_system'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-point_level_system">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-award mr-1"></i><?= lang('Admin.upgrade_to_pro_system') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.upgrade_to_pro_system_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-upgrade_to_pro_system'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-upgrade_to_pro_system">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.email_verification_system') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- User Registration -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-user-plus mr-1"></i><?= lang('Admin.allow_user_registration') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.allow_user_registration_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-user_registration'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-user_registration">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <!-- Verify New Register Account -->
                        <div class="row">
                            <div class="col-10">
                                <strong><i class="fas fa-user-check mr-1"></i><?= lang('Admin.verify_new_register_account') ?></strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.verify_new_register_account_desc') ?></small>
                                </p>
                            </div>
                            <div class="col-2">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?= $settings['chck-verify_email'] == 1 ? 'checked="checked"' : ''; ?> data-key="chck-verify_email">
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
