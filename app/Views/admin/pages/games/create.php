<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <form action="<?= base_url('admin/games/store') ?>" method="post" id="create_game" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name"><?= lang('Admin.game_title') ?></label>
                                        <input type="text" class="form-control" name="name" value="<?= old('name') ?>" placeholder="<?= lang('Admin.game_title') ?>">
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?= !empty($validation->getError('name')) ? "<span class='text-danger'>" . $validation->getError('name') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description"><?= lang('Admin.game_description') ?></label>
                                        <textarea name="description" class="form-control" rows="1" placeholder="<?= lang('Admin.game_description') ?>"><?= old('description') ?></textarea>
                                        <?= !empty($validation->getError('description')) ? "<span class='text-danger'>" . $validation->getError('description') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="url"><?= lang('Admin.url') ?></label>
                                        <input type="text" class="form-control" name="url" placeholder="<?= lang('Admin.url') ?>" value="<?= old('url') ?>">
                                        <?= !empty($validation->getError('url')) ? "<span class='text-danger'>" . $validation->getError('url') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image"><?= lang('Admin.image') ?></label>
                                        <input type="file" class="form-control" name="image" placeholder="<?= lang('Admin.image') ?>">
                                        <?= !empty($validation->getError('image')) ? "<span class='text-danger'>" . $validation->getError('image') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit') ?></button>
                                    <a href="<?= base_url('admin/games') ?>" class="btn btn-danger"><?= lang('Admin.cancel') ?></a>
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
        $("#create_game").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid',
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 6
                },
                image: {
                    required: true
                },
                url: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "<?= lang('Admin.validation_name_required') ?>"
                },
                description: {
                    required: "<?= lang('Admin.validation_description_required') ?>",
                    minlength: "<?= lang('Admin.validation_description_minlength') ?>"
                },
                image: {
                    required: "<?= lang('Admin.validation_image_required') ?>"
                },
                url: {
                    required: "<?= lang('Admin.validation_url_required') ?>"
                }
            }
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
