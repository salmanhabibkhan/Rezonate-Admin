<div class="row">
    <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box gr-bg-1">
            <div class="inner">
                <i class="fa fa-user icon-left"></i>
                <h3><?= $total_users ?></h3>
                <p><?= lang('Admin.total_users') ?></p>
            </div>
            <a href="<?= site_url('admin/users') ?>" class="small-box-footer"><?= lang('Admin.more_info') ?> <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box gr-bg-2">
            <div class="inner">
                <i class="fa fa-money-bill-wave icon-left"></i>
                <h3><?= $pending_withdraws ?><sup style="font-size: 20px"></sup></h3>
                <p><?= lang('Admin.pending_withdraw') ?></p>
            </div>
            <a href="<?= site_url('admin/withdraw-requests') ?>" class="small-box-footer"><?= lang('Admin.more_info') ?> <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box gr-bg-3">
            <div class="inner">
                <i class="fa fa-briefcase icon-left"></i>
                <h3><?= $total_jobs ?></h3>
                <p><?= lang('Admin.total_jobs') ?></p>
            </div>
            <a href="<?= site_url('admin/jobs') ?>" class="small-box-footer"><?= lang('Admin.more_info') ?> <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box gr-bg-4">
            <div class="inner">
                <i class="fa fa-newspaper icon-left"></i>
                <h3><?= $total_posts ?></h3>
                <p><?= lang('Admin.total_posts') ?></p>
            </div>
            <a href="<?= site_url('admin/posts') ?>" class="small-box-footer"><?= lang('Admin.more_info') ?> <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box gr-bg-5">
            <div class="inner">
                <i class="fa fa-users icon-left"></i>
                <h3><?= $total_groups ?></h3>
                <p><?= lang('Admin.total_groups') ?></p>
            </div>
            <a href="<?= site_url('admin/groups') ?>" class="small-box-footer"><?= lang('Admin.more_info') ?> <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box gr-bg-6">
            <div class="inner">
                <i class="fa fa-file-alt icon-left"></i>
                <h3><?= $total_pages ?></h3>
                <p><?= lang('Admin.total_pages') ?></p>
            </div>
            <a href="<?= site_url('admin/pages') ?>" class="small-box-footer"><?= lang('Admin.more_info') ?> <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
