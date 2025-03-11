<style>
    /* Add this style in your CSS file or in a style tag in the head of your HTML */
    .dropdown-toggle::after {
        content: none;
        /* Remove the arrow */
    }
</style>


<nav class="main-header navbar navbar-expand navbar-light bg-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="btn btn-success btn-sm m-1" class="nav-link" href="<?= site_url(); ?>" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-link"></i>
                <?= lang('Admin.visit_site') ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                <a class="dropdown-item" target="__blank" href="<?= site_url(); ?>"><?= lang('Admin.new_window') ?></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= site_url(); ?>"><?= lang('Admin.current_window') ?></a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-1" href="#" role="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="image mx-1">
                   <img src="<?= getCurrentUser()['avatar'] ?>" alt=""  style="width:30px;height:30px;border-radius:100%;" >
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <!-- Add your user popup content here -->
                <a class="dropdown-item" href="<?= base_url('admin/users/edit/'.getCurrentUser()['id'])?>"><?= lang('Admin.edit_profile') ?></a>
                <a class="dropdown-item" href="<?= base_url('admin/change-password')?>"><?= lang('Admin.change_password') ?></a>
                

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('logout'); ?>"><?= lang('Admin.logout') ?></a>
            </div>
        </li>

    </ul>
</nav>