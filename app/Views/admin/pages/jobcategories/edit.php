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
                        <form action="<?= base_url('admin/job-categories/update/'.$category['id'])?>" method="post" id="create_package">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for=""><?= lang('Admin.categoryname') ?></label>
                                    <input type="text" class="form-control" name="name" placeholder="<?= lang('Admin.package_name_placeholder') ?>" value="<?= $category['name'] ?>">
                                    <?php  $validation = \Config\Services::validation(); ?>
                                    <?= !empty($validation->getError('name')) ? "<span class='text-danger'>" . $validation->getError('name') . "</span>" : '' ?>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button class="btn btn-success" >  <?= lang('Admin.update') ?></button>
                                    <a href="<?= base_url('admin/job-categories')?>" class="btn btn-danger" >  <?= lang('Admin.cancel') ?></a>
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script  >
$(document).ready(function () {
        $("#create_package").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 6
                },
                like_amount: {
                    required: true
                },
                share_amount: {
                    required: true,
                    min: 0
                },
                comment_amount: {
                    required: true,
                    min: 0
                },
                po_comment_amount: {
                    required: true,
                    min: 0
                },
                po_share_amount: {
                    required: true,
                    min: 0
                },
                po_like_amount: {
                    required: true,
                    min: 0
                },
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>