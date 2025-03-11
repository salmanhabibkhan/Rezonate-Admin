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
                                    <td><?= $withdraw_request['username'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Admin.amount') ?></th>
                                    <td><?= $withdraw_request['amount'] ?></td>
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
                                    <td><?= $withdraw_request['username'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Admin.withdraw_via') ?></th>
                                    <td><?= $withdraw_request['type'] ?></td>
                                </tr>
                               <?php if($withdraw_request['type'] == 'Paypal'): ?>
                                <tr>
                                    <th><?= lang('Admin.paypal_email') ?></th>
                                    <td><?= $withdraw_request['paypal_email'] ?></td>
                                </tr>
                                <?php else: ?>
                                    <tr>
                                        <th><?= lang('Admin.country') ?></th>
                                        <td><?= $withdraw_request['country'] ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.full_name') ?></th>
                                        <td><?= $withdraw_request['full_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.iban') ?></th>
                                        <td><?= $withdraw_request['iban'] ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.swift_code') ?></th>
                                        <td><?= $withdraw_request['swift_code'] ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th><?= lang('Admin.status') ?></th>
                                    <td>
                                        <?php if ($withdraw_request['status'] == 1): ?>
                                            <span class='badge badge-primary'><?= lang('Admin.pending') ?></span>
                                        <?php elseif ($withdraw_request['status'] == 2): ?>
                                            <span class='badge badge-success'><?= lang('Admin.approved') ?></span>
                                        <?php elseif ($withdraw_request['status'] == 3): ?>
                                            <span class='badge badge-danger'><?= lang('Admin.rejected') ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                    
                                <?php if($withdraw_request['status'] == 1): ?>
                                    <tr>
                                        <th><?= lang('Admin.action') ?></th>
                                        <td>
                                            <a href="<?= base_url('admin/withdraw-requests/approve/'.$withdraw_request['id'])?>" class="btn btn-success btn-sm">
                                                <i class='fa fa-check' title="<?= lang('Admin.approve') ?>"></i> <?= lang('Admin.approve') ?>
                                            </a>
                                            <a href="<?= base_url('admin/withdraw-requests/reject/'.$withdraw_request['id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?= lang('Admin.are_you_sure') ?>')">
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
