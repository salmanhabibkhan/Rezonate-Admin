<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <!-- Trigger modal button -->
                        <button class="btn btn-info btn-sm mb-3 float-right" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.add_new_category') ?>
                        </button>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.categoryname') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $key => $category): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $category['name'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/product-categories/edit/'.$category['id']) ?>" class="btn btn-sm btn-primary btn-wave">
                                                <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                            </a>
                                            <?php if($category['id'] > 10): ?>
                                                <a href="<?= base_url('admin/product-categories/delete/'.$category['id']) ?>" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')" class="btn btn-sm btn-danger btn-wave">
                                                    <i class="fa fa-trash mr-2 text-light"></i> <?= lang('Admin.delete') ?>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bootstrap Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?= lang('Admin.add_new_category') ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('admin/product-categories/store') ?>" method="POST">
                                            <div class="form-group">
                                                <label for="categoryName"><?= lang('Admin.categoryname') ?></label>
                                                <input type="text" class="form-control"name="name" placeholder="<?= lang('Admin.enter_category_name') ?>" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('Admin.close') ?></button>
                                                <button type="submit" class="btn btn-primary"><?= lang('Admin.save_changes') ?></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Modal -->
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
