<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-8">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h1 class="h4 card-title mb-0"><?= esc(lang('Web.add_product')) ?></h1> <!-- Translate "Add a Product" -->
            </div>
            <div class="card-body">
                <form id="addProductForm" method="post" enctype="multipart/form-data" action="<?= base_url('products/save') ?>">
                    <!-- Product name -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_name" class="form-label"><?= esc(lang('Web.product_name')) ?></label> <!-- Translate "Product Name" -->
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="<?= esc(lang('Web.product_name_placeholder')) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label"><?= esc(lang('Web.location')) ?></label> <!-- Translate "Location" -->
                                <input type="text" class="form-control" id="location" name="location" placeholder="<?= esc(lang('Web.location_placeholder')) ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="mb-3">
                        <label for="product_description" class="form-label"><?= esc(lang('Web.product_description')) ?></label> <!-- Translate "Product Description" -->
                        <textarea class="form-control" id="product_description" name="product_description" rows="3" placeholder="<?= esc(lang('Web.product_description_placeholder')) ?>"></textarea>
                    </div>

                    <!-- Category and Product Images -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="images" class="form-label"><?= esc(lang('Web.product_images')) ?><sub class="text-danger"><small><?= esc(lang('Web.multiple_select')) ?></small></sub></label> <!-- Translate "Product Images" -->
                            <input type="file" class="form-control" name="images[]" id="images" accept="image/jpeg, image/png" required multiple>
                        </div>
                        <div class="col">
                            <label for="category" class="form-label"><?= esc(lang('Web.category')) ?></label> <!-- Translate "Category" -->
                            <select name="category" class="form-control">
                                <option value=""><?= esc(lang('Web.select_category')) ?></option> <!-- Translate "Select Product Category" -->
                                <?php foreach ($categories as $key => $category) : ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <!-- Price and Currency (side by side) -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="price" class="form-label"><?= esc(lang('Web.price')) ?></label> <!-- Translate "Price" -->
                            <input type="number" class="form-control" id="price" name="price" placeholder="<?= esc(lang('Web.price_placeholder')) ?>" required>
                        </div>
                        <div class="col">
                            <label for="currency" class="form-label"><?= esc(lang('Web.currency')) ?></label> <!-- Translate "Currency" -->
                            <select name="currency" id="currency" class="form-control">
                                <option value=""><?= esc(lang('Web.select_currency')) ?></option> <!-- Translate "Select Currency" -->
                                <?php foreach (CURRECY_ARRAY as $currency) : ?>
                                    <option value="<?= $currency ?>"><?= $currency ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <!-- Units -->
                    <div class="mb-3">
                        <label for="units" class="form-label"><?= esc(lang('Web.units')) ?></label> <!-- Translate "Units" -->
                        <input type="number" class="form-control" id="units" name="units" placeholder="<?= esc(lang('Web.units_placeholder')) ?>" required min="0">
                    </div>

                    <!-- Type (New/Used) -->
                    <div class="mb-3">
                        <label for="type" class="form-label"><?= esc(lang('Web.type')) ?></label> <!-- Translate "Type" -->
                        <select class="form-select" id="type" name="type" required>
                            <option value="1"><?= esc(lang('Web.new')) ?></option> <!-- Translate "New" -->
                            <option value="0"><?= esc(lang('Web.used')) ?></option> <!-- Translate "Used" -->
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-primary"><?= esc(lang('Web.add_product')) ?></button> <!-- Translate "Add Product" -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('#addProductForm').validate({
            // Validation rules for product form fields
            rules: {
                product_name: {
                    required: true
                },
                location: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                units: {
                    required: true,
                    number: true
                },
                images: {
                    required: true,
                    accept: "image/jpeg,image/png"
                }
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
                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/add-product',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        let timerInterval;
                        Swal.fire({
                            title: "<?= esc(lang('Web.success')) ?>",
                            icon: "success",
                            html: response.message,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.icon = 'success';
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            },
                        }).then((result) => {
                            window.location.href = "<?= site_url('products/my-products') ?>";
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: "<?= esc(lang('Web.error')) ?>",
                            icon: "error",
                            text: "<?= esc(lang('Web.error_message')) ?>",
                        });
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
