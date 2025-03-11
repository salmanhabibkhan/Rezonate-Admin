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
                        <a href="<?= base_url('admin/jobs')?>" class="btn btn-success btn-sm mb-3 float-right "> <i class="fa-solid fa-circle-left"></i><?= lang('Admin.back') ?></a>
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <h1 class="table_title"><?= $page_title ?></h1>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.username') ?></th>
                                        <th><?= lang('Admin.email') ?></th>
                                        <th><?= lang('Admin.gender') ?></th>
                                        <th><?= lang('Admin.profile') ?></th>
                                        <th><?= lang('Admin.phone') ?></th>
                                        <th><?= lang('Admin.cv') ?></th>
                                        <th><?= lang('Admin.address') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($applicants)>0):?>
                                        <?php foreach ($applicants as $key=>  $user) :?>
                                        <tr>
                                            <td><?=++$key?></td>
                                            <td><?=$user['username']?>  </td>
                                            <td><?=$user['email']?>  </td>
                                            <td><?=$user['gender']?> </td>
                                            <td><img src="<?= getMedia($user['avatar']) ?>" alt="<?= $user['username']?>" width="50px" height="50px"></td>
                                            <td><?=$user['phone']?>  </td>
                                            <td>
                                                <a href="<?= getMedia($user['cv_file']) ?>" class="btn btn-success btn-xs" download=""><?= lang('Admin.download_cv') ?></a>                                                  
                                            </td>
                                            <td><?=$user['location']?>  </td>

                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else:?>
                                        <tr>
                                        <td colspan="8" class="text-center text-danger"><?= lang('Admin.no_applicant') ?></td>
                                        </tr>
                                        <?php endif;?>
                                </tbody>
                            
                            </table>
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
