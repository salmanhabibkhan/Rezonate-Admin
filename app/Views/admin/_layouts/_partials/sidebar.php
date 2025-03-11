<aside class="main-sidebar sidebar-dark-info">
    <!-- Brand Logo -->
    <a href="<?= site_url('admin/dashboard'); ?>" class="brand-link d-flex">
        <div>
            <?php
            $site_logo = get_setting('site_logo');
            if (empty($site_logo)) {
            ?>
                <span class="brand-text font-weight-light"><?= get_setting('site_name'); ?></span>
            <?php
            } else {
            ?>
                <span class="brand-text font-weight-light"><?= get_setting('site_name'); ?></span>
            <?php
            }
            ?>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden os-host-transition">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="admin_sidebar nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= site_url('admin/dashboard'); ?>" class="nav-link <?= check_active_url('admin/dashboard'); ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p><?= lang('Admin.dashboard') ?></p>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            <?= lang('Admin.setting') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/website_information'); ?>" class="nav-link <?= check_active_url('admin/website_information'); ?>">
                                <i class="fas fa-info-circle nav-icon"></i>
                                <p><?= lang('Admin.website_information') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/enable_disable_features'); ?>" class="nav-link <?= check_active_url('admin/enable_disable_features'); ?>">
                                <i class="fas fa-toggle-on nav-icon"></i>
                                <p><?= lang('Admin.enabledisable_feature') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/general_settings'); ?>" class="nav-link <?= check_active_url('admin/general_settings'); ?>">
                                <i class="fas fa-cog nav-icon"></i>
                                <p><?= lang('Admin.general_setting') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/settings/mail-configuration'); ?>" class="nav-link <?= check_active_url('admin/settings/mail-configuration'); ?>">
                                <i class="fas fa-envelope nav-icon"></i>
                                <p><?= lang('Admin.mail_configuration') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/settings/gateway-intigration'); ?>" class="nav-link <?= check_active_url('admin/settings/gateway-intigration'); ?>">
                                <i class="fas fa-credit-card nav-icon"></i>
                                <p><?= lang('Admin.gateway_integration') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/settings/storage-configuration'); ?>" class="nav-link <?= check_active_url('admin/settings/storage-configuration'); ?>">
                                <i class="fas fa-database nav-icon"></i>
                                <p><?= lang('Admin.storage_configuration') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/settings/social-login-integration'); ?>" class="nav-link <?= check_active_url('admin/settings/social-login-integration'); ?>">
                                <i class="fas fa-sign-in-alt nav-icon"></i>
                                <p><?= lang('Admin.social_login') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Users -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            <?= lang('Admin.manage_users') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/users'); ?>" class="nav-link <?= check_active_url('admin/users'); ?>">
                                <i class="fas fa-user-edit nav-icon"></i>
                                <p><?= lang('Admin.manage_users') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/manage-admins'); ?>" class="nav-link <?= check_active_url('admin/manage-admins'); ?>">
                                <i class="fas fa-user-edit nav-icon"></i>
                                <p><?= lang('Admin.manage_admins') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/online-user'); ?>" class="nav-link <?= check_active_url('admin/online-user'); ?>">
                                <i class="fas fa-user-clock nav-icon"></i>
                                <p><?= lang('Admin.online_users') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/verified-user'); ?>" class="nav-link <?= check_active_url('admin/verified-user'); ?>">
                                <i class="fas fa-user-check nav-icon"></i>
                                <p><?= lang('Admin.verified_users') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/unverified-user'); ?>" class="nav-link <?= check_active_url('admin/unverified-user'); ?>">
                                <i class="fas fa-user-slash nav-icon"></i>
                                <p><?= lang('Admin.unverified_users') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Packages -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            <?= lang('Admin.packages') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/packages') ?>" class="nav-link <?= check_active_url('admin/packages'); ?>">
                                <i class="fas fa-box-open nav-icon"></i>
                                <p><?= lang('Admin.packages') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Movies -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-film"></i>
                        <p>
                            <?= lang('Admin.movies') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/movies') ?>" class="nav-link <?= check_active_url('admin/movies'); ?>">
                                <i class="nav-icon fas fa-film"></i>
                                <p><?= lang('Admin.movies') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Ads -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            <?= lang('Admin.manage_ads') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/manage-advertisements') ?>" class="nav-link <?= check_active_url('admin/manage-advertisements'); ?>">
                                <i class="fas fa-newspaper nav-icon"></i>
                                <p><?= lang('Admin.manage_user_ads') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pages -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            <?= lang('Admin.pages') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/pages') ?>" class="nav-link <?= check_active_url('admin/pages'); ?>">
                                <i class="fas fa-file-signature nav-icon"></i>
                                <p><?= lang('Admin.pages') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Groups -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            <?= lang('Admin.groups') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/groups') ?>" class="nav-link <?= check_active_url('admin/groups'); ?>">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p><?= lang('Admin.groups') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/group-categories') ?>" class="nav-link <?= check_active_url('admin/group-categories'); ?>">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p><?= lang('Admin.groupcategories') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Games -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chess-knight"></i>
                        <p>
                            <?= lang('Admin.games') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/games') ?>" class="nav-link <?= check_active_url('admin/games'); ?>">
                                <i class="fas fa-gamepad nav-icon"></i>
                                <p><?= lang('Admin.games') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Tools -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            <?= lang('Admin.tools') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/auto-like') ?>" class="nav-link <?= check_active_url('admin/auto-like'); ?>">
                                <i class="fas fa-thumbs-up nav-icon"></i>
                                <p><?= lang('Admin.auto_like_page') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/auto-friend') ?>" class="nav-link <?= check_active_url('admin/auto-friend'); ?>">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p><?= lang('Admin.auto_friend') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/auto-join') ?>" class="nav-link <?= check_active_url('admin/auto-join'); ?>">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p><?= lang('Admin.auto_join') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/auto-delete') ?>" class="nav-link <?= check_active_url('admin/auto-delete'); ?>">
                                <i class="fas fa-trash nav-icon"></i>
                                <p><?= lang('Admin.auto_delete') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Withdrawals -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            <?= lang('Admin.withdrawals') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/withdraw-requests') ?>" class="nav-link <?= check_active_url('admin/withdraw-requests'); ?>">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p><?= lang('Admin.withdrawals') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Deposits -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            <?= lang('Admin.deposits') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/deposit-requests') ?>" class="nav-link <?= check_active_url('admin/deposit-requests'); ?>">
                                <i class="nav-icon fas fa-money-check"></i>
                                <p><?= lang('Admin.deposits') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Reports -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            <?= lang('Admin.manage_reports') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/report/reported-post'); ?>" class="nav-link <?= check_active_url('admin/report/reported-post'); ?>">
                                <i class="far fa-flag nav-icon"></i>
                                <p><?= lang('Admin.post_reports') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/report/reported-user'); ?>" class="nav-link <?= check_active_url('admin/report/reported-user'); ?>">
                                <i class="fas fa-flag nav-icon"></i>
                                <p><?= lang('Admin.user_report') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Manage Posts -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            <?= lang('Admin.manage_posts') ?>
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/posts'); ?>" class="nav-link <?= check_active_url('admin/posts'); ?>">
                                <i class="far fa-flag nav-icon"></i>
                                <p><?= lang('Admin.posts') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Custom Pages -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-code"></i>
                        <p><?= lang('Admin.custom_pages') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/custom-page'); ?>" class="nav-link <?= check_active_url('admin/custom-page'); ?>">
                                <i class="fas fa-scroll nav-icon"></i>
                                <p><?= lang('Admin.custom_pages') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Blogs -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-code"></i>
                        <p><?= lang('Admin.blogs') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/blogs'); ?>" class="nav-link <?= check_active_url('admin/blogs'); ?>">
                                <i class="fas fa-scroll nav-icon"></i>
                                <p><?= lang('Admin.blogs') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Gifts -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-gift nav-icon"></i>
                        <p><?= lang('Admin.gifts') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/gifts'); ?>" class="nav-link <?= check_active_url('admin/gifts'); ?>">
                                <i class="fas fa-gift nav-icon"></i>
                                <p><?= lang('Admin.gifts') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Jobs -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p><?= lang('Admin.jobs') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/jobs'); ?>" class="nav-link <?= check_active_url('admin/jobs'); ?>">
                                <i class="fas fa-user-md nav-icon"></i>
                                <p><?= lang('Admin.jobs') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/job-categories'); ?>" class="nav-link <?= check_active_url('admin/job-categories'); ?>">
                                <i class="fas fa-user-md nav-icon"></i>
                                <p><?= lang('Admin.jobcategories') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Filters -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-filter"></i>
                        <p><?= lang('Admin.filters') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/filters'); ?>" class="nav-link <?= check_active_url('admin/filters'); ?>">
                                <i class="fas fa-filter nav-icon"></i>
                                <p><?= lang('Admin.filters') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Products -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fab fa-product-hunt nav-icon"></i>
                        <p><?= lang('Admin.products') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/products'); ?>" class="nav-link <?= check_active_url('admin/products'); ?>">
                                <i class="fab fa-product-hunt nav-icon"></i>
                                <p><?= lang('Admin.products') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/product-categories'); ?>" class="nav-link <?= check_active_url('admin/product-categories'); ?>">
                                <i class="fab fa-product-hunt nav-icon"></i>
                                <p><?= lang('Admin.productscategories') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Spaces -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-handshake nav-icon"></i>
                        <p><?= lang('Admin.spaces') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/spaces'); ?>" class="nav-link <?= check_active_url('admin/spaces'); ?>">
                                <i class="fas fa-handshake nav-icon"></i>
                                <p><?= lang('Admin.spaces') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Events -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p><?= lang('Admin.events') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/events'); ?>" class="nav-link <?= check_active_url('admin/events'); ?>">
                                <i class="far fa-flag nav-icon"></i>
                                <p><?= lang('Admin.events') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Blood -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tint"></i>
                        <p><?= lang('Admin.blood') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/blood-requests'); ?>" class="nav-link <?= check_active_url('admin/blood-requests'); ?>">
                                <i class="far fa-flag nav-icon"></i>
                                <p><?= lang('Admin.blood_requests') ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/blood/donors'); ?>" class="nav-link <?= check_active_url('admin/blood/donors'); ?>">
                                <i class="far fa-user nav-icon"></i>
                                <p><?= lang('Admin.blood_donors') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Post Advertisement -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p><?= lang('Admin.post_advertisement') ?><i class="right fas fa-angle-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/post-advertisment'); ?>" class="nav-link <?= check_active_url('admin/post-advertisment'); ?>">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <p><?= lang('Admin.post_advertisement') ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- System Status -->
                <li class="nav-item">
                    <a href="<?= site_url('system-status'); ?>" class="nav-link <?= check_active_url('system-status'); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p><?= lang('Admin.system_status') ?></p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="<?= site_url('logout'); ?>" class="nav-link <?= check_active_url('admin/logout'); ?>">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p><?= lang('Admin.logout') ?></p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
