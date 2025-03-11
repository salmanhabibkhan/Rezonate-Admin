<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">


    <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        <!-- <a href="<?= base_url('admin/groups/create')?>" class="btn btn-success btn-sm mb-3 float-right ">Create New Group</a> -->
                        <div class="table-responsive">
                        <?php if(count($groupmembers)>0):?>
                            <table id="example1" class="table table-hover table-bordered ">
                                <h1 class="table_title"><?= $page_title ?></h1>
                                <thead class="">
                                <tr>
                                    <th><?= lang('Admin.id') ?></th>
                                    <th><?= lang('Admin.user_name') ?></th>
                                    <th><?= lang('Admin.email') ?></th>
                                    <th><?= lang('Admin.gender') ?></th>
                                    <th><?= lang('Admin.profile') ?></th>
                                </tr>

                                </thead>
                                <tbody>
                                    
                                        <?php foreach ($groupmembers as $key=>  $user) :?>
                                        <tr>
                                            <td><?=++$key?></td>
                                            <td><?=$user['username']?>  </td>
                                            <td><?=$user['email']?>  </td>
                                            <td><?=$user['gender']?> </td>
                                            <td><img src="<?= getMedia($user['avatar']) ?>" alt="<?= $user['username']?>" width="50px" height="50px"></td>
                                            
                                        </tr>
                                        <?php endforeach; ?>
                                       
                                </tbody>
                            
                            </table>
                            <?php else:?>
                                <tr>
                                    <td colspan="5">No Member exist in this group</td>
                                </tr>
                            <?php endif;?>
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