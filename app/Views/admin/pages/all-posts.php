<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary table-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h1 class="table_title"><?= $page_title ?></h1>
                                    <!-- <a href="<?= base_url('admin/groups/create')?>" class="btn btn-success btn-sm mb-3 float-right "> <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.create_new_post') ?></a> -->
                                </div>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.username') ?></th>
                                        <th><?= lang('Admin.post_text') ?></th>
                                        <th><?= lang('Admin.post_type') ?></th>
                                        <th><?= lang('Admin.shared_post') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($posts as $key => $post): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $post['username'] ?></td>
                                        <td><?= $post['post_text'] ?></td>
                                        <td><?= $post['post_type'] ?></td>
                                        <td>
                                            <?php if ($post['parent_id'] != 0): ?>
                                                <span class='badge badge-success'><?= lang('Admin.yes') ?></span>
                                            <?php else: ?>
                                                <span class='badge badge-danger'><?= lang('Admin.no') ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- <a href="<?= base_url('admin/posts/edit/'.$post['id']) ?>"><button class="btn btn-sm btn-primary btn-wave">
                                                        <i class="fa fa-pen mr-2 text-light"></i>
                                                        <?= lang('Admin.edit') ?>
                                                    </button></a> -->
                                            <a href="<?= base_url('admin/posts/delete/'.$post['id']) ?>" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')"><button class="btn btn-sm btn-danger btn-wave">
                                                <i class="fa fa-trash mr-2 text-light"></i>
                                                <?= lang('Admin.delete') ?>
                                            </button></a>
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
