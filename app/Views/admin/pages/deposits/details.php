<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-4">
           
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border-0">
                                <tr>
                                    <th><?= lang('Admin.username') ?></th>
                                    <td><?= $deposit_request['username'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Admin.amount') ?></th>
                                    <td><?= $deposit_request['amount'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
           
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border-0">
                                <tr>
                                    <th><?= lang('Admin.username') ?></th>
                                    <td><?= $deposit_request['username'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Admin.deposit_via') ?></th>
                                    <td><?= $deposit_request['gateway_name'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Admin.status') ?></th>
                                    <td>
                                        <?php if ($deposit_request['status'] == 'pending'): ?>
                                            <span class='badge badge-primary'><?= lang('Admin.pending') ?></span>
                                        <?php elseif ($deposit_request['status'] == 'approved'): ?>
                                            <span class='badge badge-success'><?= lang('Admin.approved') ?></span>
                                        <?php elseif ($deposit_request['status'] == 'rejected'): ?>
                                            <span class='badge badge-danger'><?= lang('Admin.rejected') ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if ($deposit_request['status'] == 'pending'): ?>
                                    <tr>
                                        <th><?= lang('Admin.action') ?></th>
                                        <td>
                                            <a href="<?= base_url('admin/deposit-requests/approve/'.$deposit_request['id']) ?>" class="btn btn-success btn-sm">
                                                <i class='fa fa-check' title="<?= lang('Admin.approve') ?>"></i> <?= lang('Admin.approve') ?>
                                            </a>
                                            <a href="<?= base_url('admin/deposit-requests/reject/'.$deposit_request['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('<?= lang('Admin.are_you_sure') ?>')">
                                                <i class='fa fa-times ml-2' title="<?= lang('Admin.reject') ?>"></i> <?= lang('Admin.reject') ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
