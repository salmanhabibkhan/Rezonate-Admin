<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card card-primary table-card">
                    <div class="card-body">
                        <div class="table-responsive">

                            <form method="post" action="<?= base_url('admin/custom-page/update/'.$custompage['id']) ?>" id="create-custompage">
                                <?php $validation = \Config\Services::validation(); ?>
                                
                                <div class="form-group">
                                    <label for="page_title"><?= lang('Admin.page_title') ?></label>
                                    <input type="text" class="form-control" id="page_title" name="page_title" required value="<?= $custompage['page_name'] ?>">
                                    <?= !empty($validation->getError('page_title')) ? "<span class='text-danger'>" . $validation->getError('page_title') . "</span> " : '' ?>
                                </div>

                                <div class="form-group">
                                    <label for="meta_title"><?= lang('Admin.meta_title') ?></label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title" value="<?= $custompage['meta_title'] ?>">
                                    <?= !empty($validation->getError('meta_title')) ? "<span class='text-danger'>" . $validation->getError('meta_title') . "</span> " : '' ?>
                                </div>

                                <div class="form-group">
                                    <label for="meta_description"><?= lang('Admin.meta_description') ?></label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="10"><?= $custompage['meta_description'] ?></textarea>
                                    <?= !empty($validation->getError('meta_description')) ? "<span class='text-danger'>" . $validation->getError('meta_description') . "</span> " : '' ?>
                                </div>

                                <div class="form-group">
                                    <label for="page_content"><?= lang('Admin.page_content') ?></label>
                                    <textarea class="form-control" id="page_content" name="page_content"><?= $custompage['page_content'] ?></textarea>
                                </div>
                               
                                <button type="submit" class="btn btn-success"><?= lang('Admin.update') ?></button>
                                <a href="<?= base_url('admin/custom-page') ?>" class="btn btn-danger"><?= lang('Admin.cancel') ?></a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>



<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
   $(document).ready(function() {
        $('#page_content').summernote(
            {
                height: 300,
            }
        );
        $("#create-custompage").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
               
                page_title: {
                    required: true,
                    
                },
                page_content: {
                    required: true
                },
                meta_title: {
                    maxlength:65
                },
                meta_description: {
                    maxlength:165
                },
              
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>