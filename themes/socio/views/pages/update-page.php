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
                <h1 class="h4 card-title mb-0">Update page</h1>
            </div>
            <!-- Title END -->
            <!-- Create a page form START -->
            <div class="card-body">
                
                <form id="updatePageForm" class="row g-3" method="post" enctype="multipart/form-data">
                    <!-- Page name -->
                    <div class="col-12">
                        <label class="form-label">Page name</label>
                        <input type="text" class="form-control" id="page_title" name="page_title" placeholder="Page name (Required)"  value="<?= $pageData['page_title'] ?>">
                        
                    </div>
                    
                    <!-- Display name -->
                    <!-- <div class="col-sm-6 col-lg-4">
                        <label class="form-label">Display name</label>
                        <input type="text" class="form-control" id="page_username" name="page_username" placeholder="Display name (Required)">
                    </div> -->
                
                    <!-- Category -->
                    <div class="col-sm-6 col-lg-6">
                        <label for="category" class="form-label">Category (required)</label>
                        <input type="hidden" name="page_id" value="<?= esc($pageData['id']) ?>">

                        <select class="form-select" id="category" name="page_category" required>
                            <option value="" selected>Select Category</option>
                            <?php foreach (PAGE_CATEGORIES as $key => $value): ?>
                                
                                <option value="<?= esc($key) ?>" <?= $key == $pageData['page_category'] ? 'selected' : '' ?>><?= esc($value) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select a category.</div>
                    </div>
                    
                    <!-- Website URL -->
                    <div class="col-sm-6 col-lg-6">
                        <label class="form-label">Website URL</label>
                        <input type="url" class="form-control" id="website" name="website" placeholder="https://www.example.com/" value="<?= $pageData['website'] ?>">
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <label class="form-label">Avatar</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" >
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <label class="form-label">Cover</label>
                        <input type="file" class="form-control" id="cover" name="cover" >
                    </div>

                    <!-- About page -->
                    <div class="col-12">
                        <label class="form-label">About page</label>
                        <textarea class="form-control" id="page_description" name="page_description" rows="3" placeholder="Description (Required)"><?= $pageData['page_description'] ?></textarea>
                        <small>Character limit: 500</small>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary mb-0">Update page</button>
                    </div>
                </form>

            </div>
            <!-- Create a page form END -->
        </div>
        <!-- Card END -->
    </div>
    <!-- Main content END -->
</div> <!-- Row END -->

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
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
                    required: true
                },
                // Other fields...
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
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    type: 'POST',
                    url: site_url+'web_api/update-page', // Adjust this to your controller's path
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle success
                        showAlert(response.message,'Page Create Status','success');

                        setTimeout(() => {
                            window.location.href = site_url+'my-pages';
                        }, 3000);
                    },
                    error: function() {
                        // Handle error
                        alert("An error occurred.");
                    }
                });
            }
        });
    });
</script>


<?= $this->endSection() ?>