<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class=" card card-primary table-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h1 class="table_title"><?= lang('Admin.filter_list_title') ?></h1>
                                    <a href="<?= base_url('admin/filters/create') ?>" class="btn btn-success btn-sm mb-3 float-right">
                                        <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.create_new_filter') ?>
                                    </a>
                                </div>
                                <thead class="">
                                    <tr class="text-center">
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.title') ?></th>
                                        <th><?= lang('Admin.image') ?></th>
                                        <th><?= lang('Admin.actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($filters)) : ?>
                                        <?php foreach ($filters as $key => $filter) : ?>
                                            <tr class="text-center">
                                                <td><?= ++$key ?></td>
                                                <td><?= substr($filter['name'], 0, 20) . (strlen($filter['name']) > 20 ? '...' : '') ?></td>
                                                <td><img src="<?= getMedia($filter['image']) ?>" alt="" width="50px" height="50px"></td>
                                                <td>
                                                    <a href="<?= base_url('admin/filters/edit/' . $filter['id']) ?>">
                                                        <button class="btn btn-sm btn-primary btn-wave">
                                                            <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                                        </button>
                                                    </a>
                                                    <a href="<?= base_url('admin/filters/delete/' . $filter['id']) ?>" onclick="return confirm('<?= lang('Admin.are_you_sure') ?>')">
                                                        <button class="btn btn-sm btn-danger btn-wave">
                                                            <i class="fa fa-trash mr-2 text-light"></i> <?= lang('Admin.delete') ?>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" class="text-center"><span class="text-danger"><?= lang('Admin.no_data_found') ?></span></td>
                                        </tr>
                                    <?php endif; ?>
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
