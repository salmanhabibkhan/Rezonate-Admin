<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
    
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped text-center">
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.product_name') ?></th>
                                        <th><?= lang('Admin.category') ?></th>
                                        <th><?= lang('Admin.currency') ?></th>
                                        <th><?= lang('Admin.price') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (count($products) > 0): ?>
                                <?php foreach ($products as $key => $product): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $product['product_name'] ?></td>
                                        <td><?= PRODUCT_CATEGORIES[$product['category']] ?></td>
                                        <td><?= $product['currency'] ?></td>
                                        <td><?= $product['price'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/products/view/'.$product['id'])?>" class="btn btn-sm btn-primary btn-wave">
                                                <i class="fa fa-eye mr-1 text-light"></i><?= lang('Admin.view') ?>
                                            </a>
                                            <a href="<?= base_url('admin/products/delete/'.$product['id'])?>" class="btn btn-sm btn-danger btn-wave" onclick="return confirm('<?= lang('Admin.confirm_delete_product') ?>')">
                                                <i class="fa fa-trash mr-2 text-light"></i><?= lang('Admin.delete') ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-danger"><?= lang('Admin.no_products_found') ?></td>
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
