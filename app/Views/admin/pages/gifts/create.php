<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-primary">
                    <div class="card-body">
                        <form action="<?= base_url('admin/gifts/store') ?>" method="post" id="create_gift" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="name"><?= lang('Admin.gift_name') ?></label>
                                    <input type="text" class="form-control" name="name" value="<?= old('name') ?>" placeholder="<?= lang('Admin.gift_name_placeholder') ?>">
                                    <?php 
                                        $validation = \Config\Services::validation();
                                        echo !empty($validation->getError('name')) ? "<span class='text-danger'>" . lang('Admin.validation_name_required') . "</span> " : ''; 
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="image"><?= lang('Admin.gift_image') ?></label>
                                    <input type="file" class="form-control" name="image" value="<?= old('image') ?>" placeholder="<?= lang('Admin.gift_image_placeholder') ?>">
                                    <?php 
                                        echo !empty($validation->getError('image')) ? "<span class='text-danger'>" . lang('Admin.validation_image_required') . "</span> " : ''; 
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="price"><?= lang('Admin.gift_price') ?></label>
                                    <input type="number" class="form-control" name="price" value="<?= old('price') ?>" placeholder="<?= lang('Admin.gift_price_placeholder') ?>" step="0.01">
                                    <?php 
                                        echo !empty($validation->getError('price')) ? "<span class='text-danger'>" . lang('Admin.validation_price_required') . "</span> " : ''; 
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit') ?></button>
                                    <a href="<?= base_url('admin/gifts') ?>" class="btn btn-danger"><?= lang('Admin.cancel') ?></a>
                                </div>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$(document).ready(function () {
    $("#create_gift").validate({
        ignore: ':hidden:not(:checkbox)',
        errorElement: 'label',
        errorClass: 'is-invalid text-danger',
        validClass: 'is-valid',
        rules: {
            name: {
                required: true
            },
            image: {
                required: true,
            },
            price: {
                required: true
            }
        },
        messages: {
            name: {
                required: "<?= lang('Admin.validation_name_required') ?>"
            },
            image: {
                required: "<?= lang('Admin.validation_image_required') ?>"
            },
            price: {
                required: "<?= lang('Admin.validation_price_required') ?>"
            }
        }
    });
});
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
