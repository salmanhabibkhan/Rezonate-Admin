<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>
<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>
<?= $this->include('admin/pages/users/assignrole') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $page_title ?></h3>
                        <?php 
                            $baseUrl = base_url(); // Get the base URL
                            $currentUrl = current_url(); // Get the current URL
                            
                            $cleanUrl = str_replace($baseUrl, '', $currentUrl); 
                            
                            // Remove base URL from current URL
                        ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if($cleanUrl=="admin/users" || $cleanUrl=='admin/manage-admins'):?>
                                <form method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label search-form">
                                                <?= lang('Admin.search_label') ?>
                                            </label>
                                            <input type="text" name="search" class="form-control" placeholder="<?= lang('Admin.search_placeholder') ?>" value="<?= $search??'' ?>">
                                        </div>
                                        <div class='col-md-2'>
                                            <label class="form-label search-form">
                                                <?= lang('Admin.user_type') ?>
                                            </label>
                                            <select name="filter" class="form-control">
                                                <option value=""><?= lang('Admin.all_users') ?></option>
                                                <option value="active" <?= ($filter=='active')?'selected':'' ?>><?= lang('Admin.active') ?></option>
                                                <option value="inactive" <?= ($filter=='inactive')?'selected':'' ?>><?= lang('Admin.inactive') ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 pt-4 mt-2">
                                            <button type="submit" class="btn btn-success"><?= lang('Admin.search') ?></button>
                                            <a href="<?= current_url() ?>" class="btn btn-default"><?= lang('Admin.reset') ?></a>
                                        </div>
                                        <?php 
                                        if($cleanUrl=='admin/manage-admins'):?>
                                            <div class="col-md-3 ">
                                                <a href="<?=base_url('admin/add-new-admin')?>" class="btn btn-success mt-4 float-right"> <i class="fa fa-plus-circle "></i> <?= lang('Admin.add_admin') ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </form>
                                <?php endif;?>
                                <div class="table-responsive">
                                    <table class="cisocial_table table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><?= lang('Admin.id') ?></th>
                                                <th><?= lang('Admin.username') ?></th>
                                                <th><?= lang('Admin.name') ?></th>
                                                <th><?= lang('Admin.email') ?></th>
                                                <th><?= lang('Admin.role') ?></th>
                                                <th><?= lang('Admin.status') ?></th>
                                                <th><?= lang('Admin.action') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $key => $user) : ?>
                                                <tr>
                                                    <td><?= ++$key ?></td>
                                                    <td><?= $user['username'] ?></td>
                                                    <td><img width="20" class="rounded-circle mr-2" height="20" src="<?= getMedia($user['avatar'], 'avatar'); ?>"><?= $user['first_name'] . " " . $user['last_name'] ?></td>
                                                    <td><?= $user['email'] ?></td>
                                                    <td><?= ($user['role']==1)?'<span class="badge bg-info">'.lang('Admin.user').'</span>':'<span class="badge bg-success">'.lang('Admin.admin').'</span>' ?></td>
                                                    <td><?= $user['status'] ? lang('Admin.active') : lang('Admin.inactive') ?></td>
                                                    <td>
                                                        <div class="dropdown" style="display: inline;">
                                                            <svg style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                                <line x1="4" y1="21" x2="4" y2="14"></line>
                                                                <line x1="4" y1="10" x2="4" y2="3"></line>
                                                                <line x1="12" y1="21" x2="12" y2="12"></line>
                                                                <line x1="12" y1="8" x2="12" y2="3"></line>
                                                                <line x1="20" y1="21" x2="20" y2="16"></line>
                                                                <line x1="20" y1="12" x2="20" y2="3"></line>
                                                                <line x1="1" y1="14" x2="7" y2="14"></line>
                                                                <line x1="9" y1="8" x2="15" y2="8"></line>
                                                                <line x1="17" y1="16" x2="23" y2="16"></line>
                                                            </svg>
                                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <a data-toggle="modal" data-target="#exampleModal" data-user_id="<?= $user['id'] ?>" data-user_role="<?= $user['role']?>" href="#" class="dropdown-item assigrole"><i class="fas fa-user-plus"></i> <?= lang('Admin.assign_role') ?></a>
                                                                <a class="dropdown-item" href="<?= base_url('admin/users/edit/' . $user['id']) ?>"><i class="fa fa-pen"></i> <?= lang('Admin.edit') ?></a>
                                                                <?php if(!IS_DEMO):?>
                                                                    <a class="dropdown-item" href="<?= base_url('admin/users/change-password/' . $user['id']) ?>"><i class="fas fa-wrench"></i> <?= lang('Admin.change_password') ?></a>
                                                                <?php endif;?>
                                                                <a class="dropdown-item" href="<?= base_url('admin/users/delete/' . $user['id']) ?>" onclick="return confirm('<?= lang('Admin.are_you_sure') ?>')"><i class="fa fa-trash"></i> <?= lang('Admin.delete') ?></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($pager->getPageCount() > 1){ 
                                    echo  $pager->links(); 
                                } ?>
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

<script>
    $(document).ready(function(){
        $('.assigrole').click(function(){
            var that = $(this); 
            var user_id = that.data('user_id');
            var role = that.data('user_role');
            var selected = '';
            if(role==2)
            {
                selected = "selected";
            }
            $('#user_id').val(user_id);
            var roles = `<option value="1"><?= lang('Admin.user') ?></option>
                        <option value="2" ${selected}><?= lang('Admin.admin') ?></option>`;
            $('#users_role').html(roles);
        });
    });
</script>

<?= $this->endSection() ?>