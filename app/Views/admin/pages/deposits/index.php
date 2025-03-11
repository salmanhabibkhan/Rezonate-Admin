<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <h1 class="table_title"><?= $page_title ?></h1>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.username') ?></th>
                                        <th><?= lang('Admin.deposit_via') ?></th>
                                        <th><?= lang('Admin.amount') ?></th>
                                        <th><?= lang('Admin.status') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($deposit_requests as $key => $deposit) : ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $deposit['username'] ?></td>
                                        <td><?= $deposit['name'] ?></td>
                                        <td><?= $deposit['amount'] ?></td>
                                        <td>
                                            <?php if ($deposit['status'] == 'pending'): ?>
                                                <span class='badge badge-primary'><?= lang('Admin.pending') ?></span>
                                            <?php elseif ($deposit['status'] == 'approved'): ?>
                                                <span class='badge badge-success'><?= lang('Admin.approved') ?></span>
                                            <?php elseif ($deposit['status'] == 'rejected'): ?>
                                                <span class='badge badge-danger'><?= lang('Admin.rejected') ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/deposit-requests/details/'.$deposit['id']) ?>" class="btn btn-info btn-sm">
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
