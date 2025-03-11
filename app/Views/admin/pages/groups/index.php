<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>
<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>
<section class="content">
    <div class="container-fluid">
        <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary table-card">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        <!-- <a href="<?= base_url('admin/groups/create') ?>" class="btn btn-success btn-sm mb-3 float-right "><?= lang('Admin.create_new_group') ?></a> -->
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h1 class="table_title"><?= $page_title ?></h1>
                                    <!-- <a href="<?= base_url('admin/groupss/create') ?>" class="btn btn-success btn-sm mb-3 float-right "><i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.create_new_group') ?></a> -->
                                </div>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.group_title') ?></th>
                                        <th><?= lang('Admin.group_category') ?></th>
                                        <th><?= lang('Admin.group_description') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($groups as $key => $group) : ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td><?= $group['group_title'] ?></td>
                                            <td><?= GROUP_CATEGORIES[$group['category']] ?></td>
                                            <td><?= substr($group['about_group'], 0, 20) ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-warning text-light" href="<?= base_url('admin/groups/members/' . $group['id']) ?>"><i class="fa fa-users mr-2 text-light"></i><?= lang('Admin.users') ?></a>
                                                <a href="<?= base_url('admin/groups/edit/' . $group['id']) ?>"><button class="btn btn-sm btn-primary btn-wave">
                                                        <i class="fa fa-pen mr-2 text-light"></i><?= lang('Admin.edit') ?>
                                                    </button></a>
                                                <a href="<?= base_url('admin/groups/delete/' . $group['id']) ?>" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')"><button class="btn btn-sm btn-danger btn-wave">
                                                        <i class="fa fa-trash mr-2 text-light"></i><?= lang('Admin.delete') ?>
                                                    </button></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($pager->getPageCount() > 1) {
                            echo $pager->links();
                        }
                        ?>
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
