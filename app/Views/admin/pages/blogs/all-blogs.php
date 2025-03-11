<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary table-card">
                    <div class="card-body">
                       
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h1 class="table_title"><?= lang('Admin.blog_list') ?></h1>
                                    <a href="<?= base_url('admin/blogs/create') ?>" class="btn btn-success btn-sm mb-3 float-right">
                                        <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.create_new_blog') ?>
                                    </a>
                                </div>
                                <thead>
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.title') ?></th>
                                        <th><?= lang('Admin.category') ?></th>
                                        <th><?= lang('Admin.actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($blogs as $key => $blog) : ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td><?= substr($blog['title'], 0, 20) . (strlen($blog['title']) > 20 ? '...' : '') ?></td>
                                            <td><?= BLOG_CATEGORIES[$blog['category']] ?></td>

                                            <td>
                                                <a href="<?= base_url('admin/blogs/edit/' . $blog['id']) ?>"><button class="btn btn-sm btn-primary btn-wave">
                                                        <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                                    </button></a>
                                                <a href="<?= base_url('admin/blogs/delete/' . $blog['id']) ?>" onclick="return confirm('<?= lang('Admin.are_you_sure') ?>')"><button class="btn btn-sm btn-danger btn-wave">
                                                        <i class="fa fa-trash mr-2 text-light"></i> <?= lang('Admin.delete') ?>
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
