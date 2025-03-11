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
                        <h3 class="card-title">hhh</h3>
                    </div> -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">

                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.page_name') ?></th>
                                        <th><?= lang('Admin.page_title') ?></th>
                                        <th><?= lang('Admin.page_description') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pages as $key => $page) : ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td><?= $page['page_username'] ?></td>
                                            <td><?= $page['page_title'] ?></td>
                                            <td><?= strlen($page['page_description']) > 20 ? substr($page['page_description'], 0, 30) . '...' : $page['page_description']; ?></td>

                                            <td>
                                                <a href="<?= base_url('admin/pages/edit/' . $page['id']) ?>"><button class="btn btn-sm btn-primary btn-wave">
                                                        <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                                    </button></a>
                                                <a href="<?= base_url('admin/pages/delete/' . $page['id']) ?>" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')"><button class="btn btn-sm btn-danger btn-wave">
                                                        <i class="fa fa-trash mr-2 text-light"></i> <?= lang('Admin.delete') ?>
                                                    </button></a>

                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                        <?php if ($pager->getPageCount() > 1){
                                echo  $pager->links();
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
