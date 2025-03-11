<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

    <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        <form action="<?= base_url('admin/pages/update/'. $page['id'])?>" method="post" enctype="multipart/form-data" id="edit_page">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.page_title') ?></label>
                                    <input type="text" class="form-control" name="page_title" placeholder="<?= lang('Admin.title_placeholder') ?>" value="<?= $page['page_title']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.page_username') ?></label>
                                    <input type="text" class="form-control" name="page_username" placeholder="<?= lang('Admin.username_placeholder') ?>" value="<?= $page['page_username']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.website') ?></label>
                                    <input type="text" class="form-control" name="website" placeholder="<?= lang('Admin.website_placeholder') ?>" value="<?= $page['google']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.company') ?></label>
                                    <input type="text" class="form-control" name="company" placeholder="<?= lang('Admin.company_placeholder') ?>" value="<?= $page['company']; ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.page_cover') ?></label>
                                    <input type="file" class="form-control" name="cover">
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.page_avatar') ?></label>
                                    <input type="file" class="form-control" name="avatar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.page_category') ?></label>
                                    <select name="page_category" class="form-control">
                                        <option value=""><?= lang('Admin.select_category') ?></option>
                                        <?php foreach (PAGE_CATEGORIES as $key => $category): ?>
                                            <option value="<?= $key ?>" <?php if ($page['page_category'] == $key) { echo "selected"; } ?>>
                                                <?= $category ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.page_description') ?></label>
                                    <textarea name="page_description" rows="1" class="form-control"><?= $page['page_description']; ?></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit') ?></button>
                                    <a href="<?= base_url('admin/pages')?>" class="btn btn-danger"><?= lang('Admin.cancel') ?></a>
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

<script  >
$(document).ready(function () {
        $("#edit_page").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                page_title: {
                    required: true
                },
                page_username: {
                    required: true,
                    minlength: 6
                },
                page_category: {
                    required: true
                },
               
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>