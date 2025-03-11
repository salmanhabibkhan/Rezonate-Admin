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
                            <a href="<?= base_url('admin/custom-page/create') ?>" class="btn btn-primary float-right mb-3">
                                <i class="fa fa-plus-circle"></i> <?= lang('Admin.create_new_page') ?>
                            </a>

                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <div class="d-flex align-items-center justify-content-between mb-2"></div>

                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.page_name') ?></th>
                                        <th><?= lang('Admin.page_title') ?></th>
                                        <th><?= lang('Admin.meta_title') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($custompages) > 0): ?>
                                        <?php foreach($custompages as $key => $custompage): ?>
                                            <tr>
                                                <td><?= ++$key ?></td>
                                                <td><?= $custompage['page_name'] ?></td>
                                                <td><?= $custompage['page_title'] ?></td>
                                                <td><?= $custompage['meta_title'] ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/custom-page/edit/'.$custompage['id']) ?>" class="btn btn-primary">
                                                        <i class="fa fa-pen"></i> <?= lang('Admin.edit') ?>
                                                    </a>
                                                    <a href="<?= base_url('admin/custom-page/delete/'.$custompage['id']) ?>" class="btn btn-danger" onclick="return confirm('<?= lang('Admin.are_you_sure') ?>')">
                                                        <i class="fa fa-trash"></i> <?= lang('Admin.delete') ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?> 
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center"><?= lang('Admin.no_custom_page_found') ?></td>
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
