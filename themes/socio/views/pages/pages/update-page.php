<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 col-lg-6 vstack gap-4">
        <!-- Card START -->
        <div class="card">
            <!-- Title START -->
            <div class="card-header border-0 pb-0">
                <h1 class="h4 card-title mb-0"><?= lang('Web.update_page_title') ?></h1>
            </div>
            <!-- Title END -->
            <!-- Update page form START -->
            <div class="card-body">
                
                <form id="updatePageForm" class="row g-3" method="post" enctype="multipart/form-data">
                    <!-- Page name -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.page_name') ?></label>
                        <input type="text" class="form-control" id="page_title" name="page_title" placeholder="<?= lang('Web.page_name_placeholder') ?>" value="<?= esc($pageData['page_title']) ?>">
                    </div>
                    
                    <!-- Category -->
                    <div class="col-sm-6 col-lg-6">
                        <label for="category" class="form-label"><?= lang('Web.category') ?> (<?= lang('Web.required') ?>)</label>
                        <input type="hidden" name="page_id" value="<?= esc($pageData['id']) ?>">

                        <select class="form-select" id="category" name="page_category" required>
                            <option value="" selected><?= lang('Web.select_category') ?></option>
                            <?php foreach (PAGE_CATEGORIES as $key => $value): ?>
                                <option value="<?= esc($key) ?>" <?= $key == $pageData['page_category'] ? 'selected' : '' ?>><?= esc($value) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= lang('Web.category_required') ?></div>
                    </div>
                    
                    <!-- Website URL -->
                    <div class="col-sm-6 col-lg-6">
                        <label class="form-label"><?= lang('Web.website_url') ?></label>
                        <input type="url" class="form-control" id="website" name="website" placeholder="<?= lang('Web.website_placeholder') ?>" value="<?= esc($pageData['website']) ?>">
                    </div>

                    <!-- Avatar -->
                    <div class="col-sm-6 col-lg-6">
                        <label class="form-label"><?= lang('Web.avatar') ?></label>
                        <input type="file" class="form-control" id="avatar" name="avatar">
                    </div>

                    <!-- Cover -->
                    <div class="col-sm-6 col-lg-6">
                        <label class="form-label"><?= lang('Web.cover') ?></label>
                        <input type="file" class="form-control" id="cover" name="cover">
                    </div>

                    <!-- About page -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.about_page') ?></label>
                        <textarea class="form-control" id="page_description" name="page_description" rows="3" placeholder="<?= lang('Web.description_placeholder') ?>"><?= esc($pageData['page_description']) ?></textarea>
                        <small><?= lang('Web.character_limit') ?></small>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary mb-0"><?= lang('Web.update_page_button') ?></button>
                    </div>
                </form>

            </div>
            <!-- Update page form END -->
        </div>
        <!-- Card END -->
    </div>
    <!-- Main content END -->
</div> <!-- Row END -->

<script src="<?= base_url('public/assets/js/jquery.validate.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        var form = $('#updatePageForm');

        form.validate({
            rules: {
                // Validation rules
                page_title: {
                    required: true,
                    minlength: 5,
                    maxlength: 50
                },
                page_category: {
                    required: true
                },
                page_description: {
                    required: true,
                    maxlength: 500
                },
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            messages: {
                page_title: {
                    required: "<?= lang('Web.page_name_required') ?>",
                    minlength: "<?= lang('Web.page_name_min') ?>",
                    maxlength: "<?= lang('Web.page_name_max') ?>"
                },
                page_category: {
                    required: "<?= lang('Web.category_required') ?>"
                },
                page_description: {
                    required: "<?= lang('Web.description_required') ?>",
                    maxlength: "<?= lang('Web.description_max') ?>"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);

                // Optional file validation before sending to the server
                var avatarFile = $('#avatar')[0].files[0];
                var coverFile = $('#cover')[0].files[0];
                var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if (avatarFile && allowedTypes.indexOf(avatarFile.type) === -1) {
                    alert("<?= lang('Web.invalid_avatar') ?>");
                    return;
                }

                if (coverFile && allowedTypes.indexOf(coverFile.type) === -1) {
                    alert("<?= lang('Web.invalid_cover') ?>");
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('web_api/update-page') ?>', // Adjust to your controller path
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        showAlert(response.message, '<?= lang('Web.page_update_status') ?>', 'success');
                        setTimeout(function() {
                            window.location.href = '<?= site_url('my-pages') ?>';
                        }, 3000);
                    },
                    error: function() {
                        alert("<?= lang('Web.error_message') ?>");
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
