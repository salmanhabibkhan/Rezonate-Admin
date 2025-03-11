<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>
<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>


<section class="content">
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.edit_filter') ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/filters/update/'.$filter['id']) ?>" method="post" enctype="multipart/form-data" id="edit_filter_form">

                            <div class="mb-3">
                                <label for="title" class="form-label"><?= lang('Admin.name') ?></label>
                                <input type="text" class="form-control" name="name" placeholder="<?= lang('Admin.enter_name') ?>" value="<?= $filter['name'] ?>">
                                <?php $validation = \Config\Services::validation(); ?>
                                <?php echo !empty($validation->getError('name')) ? "<span class='text-danger'>" . $validation->getError('name') . "</span> " : ''; ?>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label"><?= lang('Admin.link') ?></label>
                                <input type="text" class="form-control" name="link" placeholder="<?= lang('Admin.enter_link') ?>" value="<?= $filter['link'] ?>">
                                <?php echo !empty($validation->getError('link')) ? "<span class='text-danger'>" . $validation->getError('link') . "</span> " : ''; ?>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label"><?= lang('Admin.image') ?></label>
                                <input type="file" class="form-control" name="image" >
                                <?php echo !empty($validation->getError('image')) ? "<span class='text-danger'>" . $validation->getError('image') . "</span> " : ''; ?>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit') ?></button>
                                    <a href="<?= base_url('admin/filters') ?>" class="btn btn-secondary"><?= lang('Admin.cancel') ?></a>
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

    $(document).ready(function() {
        // Your existing form validation script
        $("#edit_filter_form").validate({
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                name: {
                    required: true,
                    minlength: 3, // Minimum length for the title
                    maxlength: 255 // Maximum length for the title
                },
                link: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "<?= lang('Admin.name_required') ?>",
                    minlength: "<?= lang('Admin.name_minlength') ?>",
                    maxlength: "<?= lang('Admin.name_maxlength') ?>"
                },
                link: {
                    required: "<?= lang('Admin.link_required') ?>"
                },
            }
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
