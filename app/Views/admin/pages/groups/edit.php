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
                        <form action="<?= base_url('admin/groups/update/' . $group['id']) ?>" method="post" enctype="multipart/form-data" id="update_group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="group_title"><?= lang('Admin.group_title') ?></label>
                                        <input type="text" class="form-control" name="group_title" placeholder="<?= lang('Admin.title_placeholder') ?>" value="<?= $group['group_title']; ?>">
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?php echo !empty($validation->getError('group_title')) ? "<span class='text-danger'>" . $validation->getError('group_title') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="group_name"><?= lang('Admin.group_name') ?></label>
                                        <input type="text" class="form-control" name="group_name" placeholder="<?= lang('Admin.name_placeholder') ?>" value="<?= $group['group_name']; ?>" disabled>
                                        <?php echo !empty($validation->getError('group_namee')) ? "<span class='text-danger'>" . $validation->getError('group_namee') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cover"><?= lang('Admin.group_cover') ?></label>
                                        <input type="file" class="form-control" name="cover">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="avatar"><?= lang('Admin.group_avatar') ?></label>
                                        <input type="file" class="form-control" name="avatar">
                                        <?php echo !empty($validation->getError('avatar')) ? "<span class='text-danger'>" . $validation->getError('avatar') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="category"><?= lang('Admin.group_category') ?></label>
                                    <select name="category" class="form-control">
                                        <option value=""><?= lang('Admin.select_category') ?></option>
                                        <?php foreach(GROUP_CATEGORIES as $key=> $category): ?>
                                            <option value="<?= $key ?>" <?php if ($group['category'] == $key) { echo "selected"; } ?> ><?= $category?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="group_privacy"><?= lang('Admin.privacy') ?></label>
                                    <select name="privacy" class="form-control">
                                        <option value="1" <?= ($group['privacy'] == 1) ? "selected" : "" ?>><?= lang('Admin.public') ?></option>
                                        <option value="2" <?= ($group['privacy'] == 2) ? "selected" : "" ?>><?= lang('Admin.private') ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="about_group"><?= lang('Admin.group_description') ?></label>
                                        <textarea name="about_group" id="about_group" rows="5" class="form-control"><?= $group['about_group']; ?></textarea>
                                        <?php echo !empty($validation->getError('about_group')) ? "<span class='text-danger'>" . $validation->getError('about_group') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit') ?></button>
                                    <a href="<?= base_url('admin/groups') ?>" class="btn btn-danger"><?= lang('Admin.cancel') ?></a>
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

<script>
    $(document).ready(function() {
        $("#update_group").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid',
            rules: {
                group_title: {
                    required: true
                },
                about_group: {
                    required: true,
                    minlength: 6
                },
                privacy: {
                    required: true,
                    minlength: 0
                },
                category: {
                    required: true,
                    minlength: 0
                },
                // Add more rules for additional fields as needed
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>