<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

    <!-- 1st row starts from here -->
    <?php if(count($product_media)): ?>
        
        <div class="row">
            <div class="col-md-12">
                <h4><?= lang('Admin.product_images') ?></h4>
            </div>
        </div>
        <div class="row">
           
            <?php foreach ($product_media as $singleProduct) : ?>
                <div class="col-md-3">
                    <img src="<?= getMedia($singleProduct['image']) ?>" alt="<?= lang('Admin.product_image_alt') ?>" width="100%">
                </div>
            <?php endforeach ?>

            
        </div>
    <?php endif; ?>
    <div class="row mt-4">
        
        <div class="col-md-6">
            <h3><?= lang('Admin.user_details') ?></h3>
            <table class="table border-0">
                <tr class="">
                    <th><?= lang('Admin.username') ?></th>
                    <td><?= $product_user['username'] ?></td>
                </tr>
                <tr>
                    <th><?= lang('Admin.email') ?></th>
                    <td><?= $product_user['email'] ?></td>
                </tr>
                <tr>
                    <th><?= lang('Admin.user_profile') ?></th>
                    <td><img src="<?= $product_user['avatar'] ?>" alt="<?= lang('Admin.user_avatar_alt') ?>" width="100px"></td>
                </tr>
                <tr>
                    <th><?= lang('Admin.cover') ?></th>
                    <td><img src="<?= $product_user['cover'] ?>" alt="<?= lang('Admin.user_cover_alt') ?>" width="100px"></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h3><?= lang('Admin.product_details') ?></h3>
            <table class="table border-0">
                <tr class="">
                    <th><?= lang('Admin.product_name') ?></th>
                    <td><?= $product['product_name'] ?></td>
                </tr>
                <tr>
                    <th><?= lang('Admin.category') ?></th>
                    <td><?= PRODUCT_CATEGORIES[$product['category']] ?></td>
                </tr>
                <tr class="">
                    <th><?= lang('Admin.amount') ?></th>
                    <td><?= $product['price'] ?></td>
                </tr>
                <tr>
                    <th><?= lang('Admin.currency') ?></th>
                    <td><?= $product['currency'] ?></td>
                </tr>
                <tr>
                    <th><?= lang('Admin.condition') ?></th>
                    <td><?= ($product['type'] == 1) ? lang('Admin.new') : lang('Admin.used') ?></td>
                </tr>
                <tr>
                    <th><?= lang('Admin.location') ?></th>
                    <td><?= $product['location'] ?></td>
                </tr>
                <tr>
                    <th><?= lang('Admin.units') ?></th>
                    <td><?= $product['units'] ?></td>
                </tr>
            </table>
        </div>
        
    </div>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
