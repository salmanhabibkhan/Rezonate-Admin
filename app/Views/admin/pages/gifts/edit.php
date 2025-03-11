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
                        <form action="<?= base_url('admin/gifts/update/' . $gift['id']) ?>" method="post" id="edit_gift" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="name"><?= lang('Admin.gift_name') ?></label>
                                    <input type="text" class="form-control" name="name" value="<?= $gift['name'] ?>" placeholder="<?= lang('Admin.gift_name_placeholder') ?>">
                                    <?php $validation = \Config\Services::validation();
                                        echo !empty($validation->getError('name')) ? "<span class='text-danger'>" . $validation->getError('name') . "</span> " : ''; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="image"><?= lang('Admin.gift_image') ?></label>
                                    <input type="file" class="form-control" name="image" value="<?= old('image') ?>" placeholder="<?= lang('Admin.gift_image_placeholder') ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="price"><?= lang('Admin.gift_price') ?></label>
                                    <input type="number" class="form-control" name="price" placeholder="<?= lang('Admin.gift_price_placeholder') ?>" value="<?= $gift['price'] ?>" step="0.01">
                                    <?php echo !empty($validation->getError('price')) ? "<span class='text-danger'>" . $validation->getError('price') . "</span> " : ''; ?>
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


<!-- Include jQuery Validation Plugin -->

<script  >
$(document).ready(function () {
        $("#edit_gift").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                name: {
                    required: true
                },
              
                price: {
                    required: true
                }
            },
           
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>