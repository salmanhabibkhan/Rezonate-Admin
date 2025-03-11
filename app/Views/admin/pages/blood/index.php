<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <!-- <a href="<?= base_url('admin/packages/create')?>" class="btn btn-success btn-sm mb-3 float-right ">Create New Package</a> -->
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <h1 class="table_title"><?= $page_title ?></h1>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.user_name') ?></th>
                                        <th><?= lang('Admin.blood_group') ?></th>
                                        <th><?= lang('Admin.phone') ?></th>
                                        <th><?= lang('Admin.location') ?></th>
                                        <th><?= lang('Admin.urgently_needed') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($blood_requests as $key => $blood_request) : ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $blood_request['user']['username'] ?></td>
                                        <td><?= $blood_request['blood_group'] ?></td>
                                        <td><?= $blood_request['phone'] ?></td>
                                        <td><?= $blood_request['location'] ?></td>
                                        <td>
                                            <?php if ($blood_request['is_urgent_need'] == 1): ?>
                                                <span class='badge badge-success'><?= lang('Admin.yes') ?></span>
                                            <?php else: ?>
                                                <span class='badge badge-danger'><?= lang('Admin.no') ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/blood-requests/delete/'.$blood_request['id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>');">
                                                <i class='fa fa-trash ml-2'></i> <?= lang('Admin.delete') ?>
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
