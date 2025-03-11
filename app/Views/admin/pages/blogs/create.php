<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>
<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <section class="content">
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.create_blog') ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/blogs/store') ?>" method="post" enctype="multipart/form-data" id="create_blog_form">

                            <div class="mb-3">
                                <label for="title" class="form-label"><?= lang('Admin.title') ?></label>
                                <input type="text" class="form-control" name="title" placeholder="<?= lang('Admin.enter_title') ?>" value="<?= old('title'); ?>">
                                <?php $validation = \Config\Services::validation(); ?>
                                <?= !empty($validation->getError('title')) ? "<span class='text-danger'>" . $validation->getError('title') . "</span> " : '' ?>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label"><?= lang('Admin.category') ?></label>
                                <select name="category" class="form-control">
                                    <option value=""><?= lang('Admin.select_category') ?></option>
                                    <?php foreach (BLOG_CATEGORIES as $key => $category) : ?>
                                        <option value="<?= $key ?>"><?= $category ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?= !empty($validation->getError('category')) ? "<span class='text-danger'>" . $validation->getError('category') . "</span> " : '' ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="thumbnail" class="form-label"><?= lang('Admin.image') ?></label>
                                    <input type="file" name="thumbnail" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="active" class="form-label"><?= lang('Admin.status') ?></label>
                                    <select name="active" class="form-control">
                                        <option value="1"><?= lang('Admin.active') ?></option>
                                        <option value="0"><?= lang('Admin.inactive') ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label"><?= lang('Admin.content') ?></label>
                                <textarea name="content" id="content" rows="5" class="form-control"><?= old('content'); ?></textarea>
                                <?= !empty($validation->getError('content')) ? "<span class='text-danger'>" . $validation->getError('content') . "</span> " : '' ?>
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label"><?= lang('Admin.tags') ?></label>
                                <input type="text" name="tags" id="tags" class="form-control" placeholder="<?= lang('Admin.enter_tags') ?>">
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit') ?></button>
                                    <a href="<?= base_url('admin/blogs') ?>" class="btn btn-secondary"><?= lang('Admin.cancel') ?></a>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
     $('#content').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    $(document).ready(function() {
        // Your existing form validation script
        $("#create_blog_form").validate({
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                title: {
                    required: true,
                    minlength: 3, // Minimum length for the title
                    maxlength: 255 // Maximum length for the title
                },
                category: {
                    required: true
                },
                thumbnail: {
                    required: true // Add any additional rules for the file if needed
                },
                active: {
                    required: true
                },
                content: {
                    required: true,
                    minlength: 10 // Minimum length for the content
                },
                description: {
                    required: true,
                    minlength: 10 // Minimum length for the description
                },
                tags: {
                    required: true,
                    minlength: 3 // Minimum length for each tag
                }
            },
            messages: {
                title: {
                    required: "Please enter the title",
                    minlength: "Title must be at least 3 characters",
                    maxlength: "Title cannot exceed 255 characters"
                },
                category: {
                    required: "Please select the category"
                },
                thumbnail: {
                    required: "Please upload a thumbnail"
                },
                active: {
                    required: "Please select the status"
                },
                content: {
                    required: "Please enter the content",
                    minlength: "Content must be at least 10 characters"
                },
                description: {
                    required: "Please enter the description",
                    minlength: "Description must be at least 10 characters"
                },
                tags: {
                    required: "Please enter at least one tag",
                    minlength: "Each tag must be at least 3 characters"
                }
            }
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
