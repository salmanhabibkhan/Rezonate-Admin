<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 col-lg-6 vstack gap-4">
        <!-- Card START -->
        <div class="card">
            <!-- Title START -->
            <div class="card-header border-0 border-bottom">
                <h1 class="h4 card-title mb-0"><?= lang('Web.edit_group_title') ?></h1>
            </div>
            <!-- Title END -->
            <!-- Edit a group form START -->
            <div class="card-body">
                <form id="editGroupForm" class="row g-3" method="post" enctype="multipart/form-data">
                    <!-- Group name -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.group_title') ?></label>
                        <input type="text" class="form-control" id="group_title" name="group_title" placeholder="<?= lang('Web.group_name_placeholder') ?>" value="<?= $group['group_title'] ?>">
                        <small><?= lang('Web.group_name_description') ?></small>
                    </div>
                   
                    <!-- Group Category -->
                    <div class="col-sm-6 col-lg-6">
                        <label for="category" class="form-label"><?= lang('Web.category') ?> (<?= lang('Web.required') ?>)</label>
                        <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                        <select class="form-select" id="category" name="category" required>
                            <?php foreach ($categories as $key => $category): ?>
                                <option value="<?= esc($key) ?>" 
                                <?php if($category['id'] == $group['category']): ?>
                                        selected
                                    <?php endif; ?>
                                ><?= esc($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= lang('Web.select_category') ?></div>
                    </div>

                    <!-- Group Privacy -->
                    <div class="col-sm-6 col-lg-6">
                        <label for="privacy" class="form-label"><?= lang('Web.privacy') ?></label>
                        <select class="form-select" id="privacy" name="privacy" required>
                            <option value="Public"><?= lang('Web.public') ?></option>
                            <option value="Private"  
                                <?php if($group['privacy'] == 'Private'): ?>
                                    selected
                                <?php endif; ?>
                            ><?= lang('Web.private') ?></option>
                        </select>
                        <div class="invalid-feedback"><?= lang('Web.select_privacy') ?></div>
                    </div>

                    <!-- Group Profile -->
                    <div class="col-sm-6 col-lg-6">
                        <label for="avatar" class="form-label"><?= lang('Web.group_profile') ?></label>
                        <input type="file" name="avatar" class="form-control" id="avatar" accept="image/*">
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <label for="cover" class="form-label"><?= lang('Web.group_cover') ?></label>
                        <input type="file" name="cover" class="form-control" id="cover" accept="image/*">
                    </div>

                    <!-- Group Description -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.about_group') ?></label>
                        <textarea class="form-control" id="about_group" name="about_group" rows="3" placeholder="<?= lang('Web.description_placeholder') ?>"><?= $group['about_group'] ?></textarea>
                        <small><?= lang('Web.character_limit') ?></small>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <a href="<?=site_url('my-groups')?>" class="btn btn-danger"><?=lang('Web.cancel') ?></a>
                        <button type="submit" class="btn btn-primary mb-0"><?= lang('Web.update_group_button') ?></button>
                    </div>
                </form>
            </div>
            <!-- Edit a group form END -->
        </div>
        <!-- Card END -->
    </div>
    <!-- Main content END -->
</div> <!-- Row END -->

<script src="<?= base_url('public/assets/js/jquery.validate.min.js') ?>"></script>
<script>
$(document).ready(function() {
    function validateImageFile(fileInput, allowedExtensions) {
        fileInput.addEventListener('change', function() {
            var selectedFile = fileInput.files[0];
            if (selectedFile) {
                var fileExtension = selectedFile.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(fileExtension)) {
                    alert('<?= lang('Web.invalid_file_extension') ?> ' + allowedExtensions.join(', '));
                    fileInput.value = '';
                }
            }
        });
    }

    var avatarInput = document.getElementById('avatar');
    var coverInput = document.getElementById('cover');
    var allowedExtensions = ['jpg', 'png', 'gif', 'jpeg'];

    validateImageFile(avatarInput, allowedExtensions);
    validateImageFile(coverInput, allowedExtensions);
});

$(document).ready(function() {
    var form = $('#editGroupForm');

    form.validate({
        rules: {
            group_title: {
                required: true,
                maxlength: 50
            },
            category: {
                required: true
            },
            privacy: {
                required: true
            },
            about_group: {
                required: true,
                maxlength: 300
            }
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
            group_title: {
                required: "<?= lang('Web.group_title_required') ?>",
                maxlength: "<?= lang('Web.group_title_max') ?>"
            },
            category: "<?= lang('Web.category_required') ?>",
            privacy: "<?= lang('Web.privacy_required') ?>",
            about_group: "<?= lang('Web.description_required') ?>"
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= site_url('web_api/update-group') ?>',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        title: "<?= lang('Web.success') ?>",
                        icon: "success",
                        html: response.message,
                        timer: 4000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = "<?= site_url('my-groups') ?>";
                    });
                },
                error: function() {
                    Swal.fire({
                        title: "<?= lang('Web.error') ?>",
                        icon: "error",
                        text: "<?= lang('Web.error_update_group_message') ?>",
                    });
                }
            });
        }
    });
});
</script>

<?= $this->endSection() ?>
