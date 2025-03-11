<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <a href="<?= base_url('admin/packages/create')?>" class="btn btn-success btn-sm mb-3 float-right">
                            <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.create_new_package') ?>
                        </a>
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.package_name') ?></th>
                                        <th><?= lang('Admin.package_description') ?></th>
                                        <th><?= lang('Admin.like_amount') ?></th>
                                        <th><?= lang('Admin.share_amount') ?></th>
                                        <th><?= lang('Admin.comment_amount') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($packages as $key => $package): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $package['name'] ?></td>
                                        <td><?= $package['description'] ?></td>
                                        <td><?= $package['like_amount'] ?></td>
                                        <td><?= $package['share_amount'] ?></td>
                                        <td><?= $package['comment_amount'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/packages/edit/'.$package['id'])?>" class="btn btn-sm btn-primary btn-wave">
                                                <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                            </a>
                                            <?php if($package['id'] > 3): ?>
                                                <a href="<?= base_url('admin/packages/delete/'.$package['id'])?>" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')" class="btn btn-sm btn-danger btn-wave">
                                                    <i class="fa fa-trash mr-2 text-light"></i> <?= lang('Admin.delete') ?>
                                                </a>
                                            <?php endif; ?>
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
