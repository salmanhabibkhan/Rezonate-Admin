<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <a href="<?= base_url('admin/gifts/create') ?>" class="btn btn-success btn-sm mb-3 float-right"> 
                            <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.add_new_gift') ?>
                        </a>
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped text-center">
                                <thead>
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.gift_name') ?></th>
                                        <th><?= lang('Admin.gift_price') ?></th>
                                        <th><?= lang('Admin.gift_image') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($gifts as $key => $gift): ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td><?= $gift['name'] ?></td>
                                            <td><?= $gift['price'] ?></td>
                                            <td><img src="<?= getMedia($gift['image']) ?>" alt="" height="50px" width="50px"></td>
                                            <td>
                                                <a href="<?= base_url('admin/gifts/edit/' . $gift['id']) ?>" class="btn btn-sm btn-primary btn-wave">
                                                    <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                                </a>
                                                <a href="<?= base_url('admin/gifts/delete/' . $gift['id']) ?>" class="btn btn-sm btn-danger btn-wave" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')">
                                                    <i class="fa fa-trash mr-2 text-light"></i> <?= lang('Admin.delete') ?>
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
