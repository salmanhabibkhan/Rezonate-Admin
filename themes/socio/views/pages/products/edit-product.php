<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h1 class="h4 card-title mb-0"><?= esc(lang('Web.edit_product')) ?></h1>
            </div>
            <div class="card-body">
                <form id="editProductForm" method="post" enctype="multipart/form-data">
                    <!-- Product name -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_name" class="form-label"><?= esc(lang('Web.product_name')) ?></label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="<?= esc(lang('Web.product_name_placeholder')) ?>" required value="<?=$product['product_name'] ?>">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label"><?= esc(lang('Web.location')) ?></label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="<?= esc(lang('Web.location_placeholder')) ?>" required value="<?=$product['location'] ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="mb-3">
                        <label for="product_description" class="form-label"><?= esc(lang('Web.product_description')) ?></label>
                        <textarea class="form-control" id="product_description" name="product_description" rows="3" placeholder="<?= esc(lang('Web.product_description_placeholder')) ?>"><?=$product['product_description'] ?></textarea>
                    </div>

                    <!-- Category and Product Images -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="images" class="form-label"><?= esc(lang('Web.product_images')) ?> <sub class="text-danger"><small><?= esc(lang('Web.multiple_select')) ?></small></sub></label>
                            <input type="file" class="form-control" name="images[]" id="images" accept="image/jpeg, image/png" multiple>
                        </div>
                        <div class="col">
                            <label for="category" class="form-label"><?= esc(lang('Web.category')) ?></label>
                            <select name="category" id="category" class="form-control">
                                <option value=""><?= esc(lang('Web.select_category')) ?></option>
                                <?php foreach ($categories as $key => $category) : ?>
                                    <option value="<?=$key?>"  
                                    <?php if($category['id'] == $product['category']): ?>
                                        selected
                                    <?php endif; ?>
                                    ><?=$category['name']?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <!-- Price and Currency -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="price" class="form-label"><?= esc(lang('Web.price')) ?></label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="<?= esc(lang('Web.price_placeholder')) ?>" required value="<?=$product['price'] ?>">
                        </div>
                        <div class="col">
                            <label for="currency" class="form-label"><?= esc(lang('Web.currency')) ?></label>
                            <select name="currency" id="currency" class="form-control">
                                <option value=""><?= esc(lang('Web.select_currency')) ?></option>
                                <?php foreach (CURRECY_ARRAY as $currency) : ?>
                                    <option value="<?= $currency ?>" <?= ($currency == $product['currency']) ? 'selected' : '' ?>><?= $currency ?></option>
                                <?php endforeach ?>
                            </select>
                            <input type="hidden" id="removedImageIds" name="deleted_image_ids" value="">
                        </div>
                    </div>

                    <!-- Units -->
                    <div class="mb-3">
                        <label for="units" class="form-label"><?= esc(lang('Web.units')) ?></label>
                        <input type="number" class="form-control" id="units" name="units" placeholder="<?= esc(lang('Web.units_placeholder')) ?>" required min="0" value="<?=$product['units'] ?>">
                    </div>

                    <!-- Type (New/Used) -->
                    <div class="mb-3">
                        <label for="type" class="form-label"><?= esc(lang('Web.type')) ?></label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="1" <?= ($product['type'] == 1) ? 'selected' : '' ?>><?= esc(lang('Web.new')) ?></option>
                            <option value="0" <?= ($product['type'] == 0) ? 'selected' : '' ?>><?= esc(lang('Web.used')) ?></option>
                        </select>
                    </div>

                    <!-- Existing Images -->
                    <div class="mb-3 row">
                        <?php foreach ($images as $key => $image) : ?>
                            <div class="col">
                                <div class="position-relative">
                                    <img src="<?= getMedia($image['image']) ?>" class="img-fluid" alt="<?= esc(lang('Web.your_image')) ?>">
                                    <span class="position-absolute top-0 end-0 remove-image" data-image-id="<?= $image['id'] ?>">
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-primary"><?= esc(lang('Web.update_product')) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    var validationMessages = {
        required: "<?= esc(lang('Web.validation_required')) ?>",
        number: "<?= esc(lang('Web.validation_number')) ?>",
        accept: "<?= esc(lang('Web.validation_image_accept')) ?>"
    };

    $(document).ready(function () {
        var removedImageIds = [];

        $('#editProductForm').validate({
            rules: {
                product_name: { required: true },
                location: { required: true },
                price: { required: true, number: true },
                units: { required: true, number: true },
                images: { accept: "image/jpeg,image/png" }
            },
            messages: {
                product_name: { required: validationMessages.required },
                location: { required: validationMessages.required },
                price: { required: validationMessages.required, number: validationMessages.number },
                units: { required: validationMessages.required, number: validationMessages.number },
                images: { accept: validationMessages.accept }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function (element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            submitHandler: function (form) {
                var formData = new FormData(form);
                formData.append('deleted_image_ids', removedImageIds.join(','));

                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/update-product',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            title: "<?= esc(lang('Web.success')) ?>",
                            icon: "success",
                            html: response.message,
                            timer: 4000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = "<?= site_url('products/my-products') ?>";
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: "<?= esc(lang('Web.error')) ?>",
                            icon: "error",
                            text: "<?= esc(lang('Web.error_message')) ?>"
                        });
                    }
                });
            }
        });

        $('.remove-image').click(function () {
            var imageId = $(this).data('image-id');
            var confirmation = confirm('<?= esc(lang('Web.confirm_remove_image')) ?>');
            let totalImage = <?= count($images) ?>;

            if (confirmation && removedImageIds.length < totalImage) {
                $(this).closest('.col').remove();
                removedImageIds.push(imageId);
            } else {
                alert('<?= esc(lang('Web.cannot_delete_all_images')) ?>');
            }
        });
    });
</script>

<?= $this->endSection() ?>
