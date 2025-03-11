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
                <h1 class="h4 card-title mb-0"><?= lang('Web.create_group_title') ?></h1>
            </div>
            <!-- Title END -->
            <!-- Create a group form START -->
            <div class="card-body">
                <form id="createGroupForm" class="row g-3" method="post" enctype="multipart/form-data">
                    <!-- Group name -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.group_title') ?></label>
                        <input type="text" class="form-control" id="group_title" name="group_title" placeholder="<?= lang('Web.group_name_placeholder') ?>">
                        <small><?= lang('Web.group_name_description') ?></small>
                    </div>
                    
                    <!-- Group Category -->
                    <div class="col-sm-6 col-lg-6">
                        <label for="category" class="form-label"><?= lang('Web.category') ?> (<?= lang('Web.required') ?>)</label>
                        <select class="form-select" id="category" name="category" required>
                            <?php foreach ($categories as $key => $category) : ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback"><?= lang('Web.select_category') ?></div>
                    </div>

                    <!-- Group Privacy -->
                    <div class="col-sm-6 col-lg-6">
                        <label for="privacy" class="form-label"><?= lang('Web.privacy') ?></label>
                        <select class="form-select" id="privacy" name="privacy" required>
                            <option value="1"><?= lang('Web.public') ?></option>
                            <option value="2"><?= lang('Web.private') ?></option>
                        </select>
                        <div class="invalid-feedback"><?= lang('Web.select_privacy') ?></div>
                    </div>
                    
                    <!-- Group Profile -->
                    <div class="col-sm-6 col-lg-6">
                        <label for="avatar" class="form-label"><?= lang('Web.group_profile') ?></label>
                        <input type="file" name="avatar" class="form-control" id="avatar" accept="image/*" required>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <label for="cover" class="form-label"><?= lang('Web.group_cover') ?></label>
                        <input type="file" name="cover" class="form-control" id="cover" accept="image/*" >
                    </div>

                    <!-- Group Description -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.about_group') ?></label>
                        <textarea class="form-control" id="about_group" name="about_group" rows="3" placeholder="<?= lang('Web.description_placeholder') ?>"></textarea>
                        <small><?= lang('Web.character_limit') ?></small>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary mb-0"><?= lang('Web.create_group_button') ?></button>
                    </div>
                </form>
            </div>
            <!-- Create a group form END -->
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
    var form = $('#createGroupForm');

    form.validate({
        rules: {
            group_title: {
                required: true,
                minlength: 5,
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
                minlength: "<?= lang('Web.group_title_min') ?>",
                maxlength: "<?= lang('Web.group_title_max') ?>"
            },
            category: "<?= lang('Web.category_required') ?>",
            about_group: "<?= lang('Web.description_required') ?>"
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= site_url('web_api/add-group') ?>',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        title: "<?= lang('Web.success') ?>",
                        icon: "success",
                        html: response.message,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: () => {
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        },
                    }).then(() => {
                        window.location.href = "<?= site_url('my-groups') ?>";
                    });
                },
                error: function() {
                    Swal.fire({
                        title: "<?= lang('Web.error') ?>",
                        icon: "error",
                        text: "<?= lang('Web.error_message') ?>",
                    });
                }
            });
        }
    });
});
</script>

<?= $this->endSection() ?>
