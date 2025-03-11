<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        <!-- <a href="<?= base_url('admin/packages/create')?>" class="btn btn-success btn-sm mb-3 float-right "><?= lang('Admin.create_new_package') ?></a> -->
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <h1 class="table_title"><?= $page_title ?></h1>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.username') ?></th>
                                        <th><?= lang('Admin.withdraw_via') ?></th>
                                        <th><?= lang('Admin.amount') ?></th>
                                        <th><?= lang('Admin.status') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($withdraw_requests as $key=> $withdraw_request) : ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $withdraw_request['username'] ?></td>
                                        <td><?= $withdraw_request['type'] ?></td>
                                        <td><?= $withdraw_request['amount'] ?></td>
                                        <td>
                                        <?php if ($withdraw_request['status'] == 1): ?>
                                           <span class='badge badge-primary'><?= lang('Admin.pending') ?></span>
                                        <?php elseif ($withdraw_request['status'] == 2): ?>
                                            <span class='badge badge-success'><?= lang('Admin.approved') ?></span>
                                        <?php elseif ($withdraw_request['status'] == 3): ?>
                                            <span class='badge badge-danger'><?= lang('Admin.rejected') ?></span>
                                         <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- <?php if($withdraw_request['status'] == 1): ?>
                                                <a href="<?= base_url('admin/withdraw-requests/approve/'.$withdraw_request['id'])?>" class="btn btn-success btn-sm">
                                                    <i class='fa fa-check ' title="<?= lang('Admin.approve') ?>"></i> <?= lang('Admin.approve') ?>
                                                </a>
                                                <a href="<?= base_url('admin/withdraw-requests/reject/'.$withdraw_request['id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?= lang('Admin.are_you_sure') ?>')">
                                                    <i class='fa fa-times ml-2 ' title="<?= lang('Admin.reject') ?>"></i> <?= lang('Admin.reject') ?>
                                                </a>
                                            <?php endif; ?> -->
                                            <a href="<?= base_url('admin/withdraw-requests/details/'.$withdraw_request['id'])?>" class="btn btn-info btn-sm">
                                                <i class='fa fa-eye ml-2' title="<?= lang('Admin.details') ?>"></i> <?= lang('Admin.details') ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
