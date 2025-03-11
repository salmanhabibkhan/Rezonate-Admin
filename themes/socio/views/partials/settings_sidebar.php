<style>
    .active{
        background-color: lightblue;
    }
</style>
<div class="d-flex align-items-center mb-4 d-lg-none">
    <button class="border-0 bg-transparent" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="btn btn-primary"><i class="fa-solid fa-sliders-h"></i></span>
        <span class="h6 mb-0 fw-bold d-lg-none ms-2"><?= lang('Web.settings') ?></span>
    </button>
</div>
<nav class="navbar navbar-light navbar-expand-lg mx-0">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
        <div class="offcanvas-header">
            <button type="button" class="btn-close text-reset ms-auto" aria-label="<?= lang('Web.close') ?>"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="card w-100">
                <div class="card-body">
                    <ul class="nav nav-pills nav-pills-soft flex-column  gap-2 border-0">
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/general-settings') ?>" href="<?= site_url('settings/general-settings'); ?>">
                                <i class="bi bi-gear-fill fs-6 me-2"></i> <span><?= lang('Web.general_settings') ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/social-settings') ?>" href="<?= site_url('settings/social-settings'); ?>">
                                <i class="bi bi-share-fill fs-6 me-2"></i><span><?= lang('Web.social_links') ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/notification-settings') ?>" href="<?= site_url('settings/notification-settings'); ?>">
                                <i class="bi bi-bell-fill fs-6 me-2"></i><span><?= lang('Web.notification_settings') ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/privacy-settings') ?>" href="<?= site_url('settings/privacy-settings'); ?>">
                                <i class="bi bi-shield-lock-fill fs-6 me-2"></i><span><?= lang('Web.privacy_settings') ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/blocked-users') ?>" href="<?= site_url('settings/blocked-users'); ?>">
                                <i class="bi bi-person-fill-slash fs-6 me-2"></i><span><?= lang('Web.blocked_users') ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/change-language') ?>" href="<?= site_url('settings/change-language'); ?>">
                                <i class="bi bi-translate fs-6 me-2"> </i><span> <?= lang('Web.change_language') ?></span>
                            </a>
                            
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/manage-sessions') ?>" href="<?= site_url('settings/manage-sessions'); ?>">
                                <i class="bi bi-shield-fill-check fs-6 me-2 "></i><span><?= lang('Web.manage_sessions') ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/password-settings') ?>" href="<?= site_url('settings/password-settings'); ?>">
                                <i class="bi bi-shield-lock-fill fs-6 me-2"></i><span><?= lang('Web.password') ?></span>
                            </a>
                        </li>
                        <?php if(get_setting('chck-deleteAccount')): ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex mb-0 <?= isActive('settings/delete-account') ?>" href="<?= site_url('settings/delete-account'); ?>">
                                <i class="bi bi-trash3-fill fs-6 me-2"></i><span><?= lang('Web.delete_account') ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <!-- <li class="nav-item">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="switchdarktheme">
                                <label class="form-check-label" for="switchdarktheme">Dark Theme</label>
                            </div> 
                        </li> -->
                    </ul>
                </div>
                <div class="card-footer text-center py-2">
                    <a class="btn btn-link text-secondary btn-sm" href="<?= site_url($user_data['username']) ?>"><?= lang('Web.view_profile') ?></a>
                </div>
            </div>
        </div>
        <ul class="nav small mt-4 justify-content-center lh-1">
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('page/about') ?>"><?= lang('Web.about_us') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('settings/general-settings') ?>"><?= lang('Web.settings') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" target="_blank" href="<?= site_url('page/support') ?>"><?= lang('Web.support') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('page/terms-and-conditions') ?>"><?= lang('Web.terms_and_conditions') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('page/privacy-policy') ?>"><?= lang('Web.privacy_policy') ?></a>
            </li>
        </ul>

        <p class="small text-center mt-1">©<?= date('Y'); ?> <a class="text-reset" target="_blank" href="<?= site_url(); ?>"> <?= get_setting('site_name'); ?> </a></p>
    </div>
</nav>
<script>

</script>