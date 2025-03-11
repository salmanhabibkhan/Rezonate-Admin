<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Online  Users</h3><br>
                        <small>Check user status</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <form method="get">
                                    <div class="row ">
                                        <div class="col-md-3">
                                            <label class="form-label search-form">
                                            Search for Username, E-mail, First or Last name
                                            </label>
                                            <input type="text" name="search" class="form-control "  placeholder="Search users...">
                                        </div>
                                        <div class='col-md-2'>
                                            <label class="form-label search-form">
                                            User Type
                                            </label>
                                            <select name="filter" class="form-control">
                                                <option value="">All Users</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="co-l-md-1 pt-4 mt-2">
                                        
                                        <button type="submit" class="btn btn-success ">Search</button>
                                        <a href="<?= current_url()?>" class="btn btn-default"> Reset</a>
                                        </div>
                                        
                                    </div>
                                </form> -->
                                
                                
                                <div class="table-responsive">
                                    <table class="cisocial_table table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $key=> $user) : ?>
                                                <tr>
                                                    <td><?= ++$key?> </td>
                                                    <td><?= $user['username'] ?></td>
                                                    <td><img width="20" class="rounded-circle mr-2" height="20" src="<?=getMedia($user['avatar'],'avatar');?>" ><?= $user['first_name']." ".$user['last_name'] ?></td>
                                                    <td><?= $user['email'] ?></td>
                                                    
                                                    <td><?= $user['status'] ? 'Active' : 'Inactive' ?></td>
                                                    <td>
                                                    <div class="dropdown" style="display: inline;">
                                                        <svg style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                                                        <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-167px, -79px, 0px);" x-out-of-boundaries="">
                                                            <!-- <a class="dropdown-item" href="javascript:void(0)" onclick="getUserId(254379);" data-toggle="modal" data-target="#FollowersForm">Add Followers</a> -->
                                                            <a class="dropdown-item" href="<?= base_url('admin/users/assign-role/' . $user['id']) ?>">Assign Role</a>
                                                            <a class="dropdown-item"  href="<?=base_url('admin/users/edit/'.$user['id'])?>">Edit</a>
                                                            <a class="dropdown-item" href="<?= base_url('admin/users/delete/'.$user['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                                            
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
                                
                            <?php if ($pager) :?>
                                    <?php 
                                    $pagination = $pager->links();

                                    // Add Bootstrap Pagination Class
                                    $pagination = str_replace('<a', '<a class="page-link"', $pagination);
                                    $pagination = str_replace('<ul>', '<ul class="pagination"', $pagination);
                                    $pagination = str_replace('<li', '<li class="page-item"', $pagination);
                                    $pagination = str_replace('span', 'a', $pagination);
                                    $pagination = str_replace('Previous', '&laquo;', $pagination);
                                    $pagination = str_replace('Next', '&raquo;', $pagination);

                                    // Highlight the active page
                                    $currentPage = $pager->getCurrentPage();
                                    $pagination = preg_replace('/<li class="page-item"><a class="page-link" href="#">' . $currentPage . '<\/a><\/li>/', '<li class="page-item active"><a class="page-link" href="#">' . $currentPage . '</a></li>', $pagination);

                                    echo $pagination;
                                    ?>
                                <?php endif; ?>
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