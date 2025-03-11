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
                        <form action="<?= base_url('admin/groups/store') ?>" method="post" id="create_group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="group_title">Group Title</label>
                                        <input type="text" class="form-control" name="group_title" value="<?= old('group_title') ?>" placeholder="Group Title">
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?= !empty($validation->getError('group_title')) ? "<span class='text-danger'>" . $validation->getError('group_title') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_group">Group Description</label>
                                        <textarea name="about_group" class="form-control" rows="1" placeholder="Group Description"><?= old('about_group') ?></textarea>
                                        <?php echo !empty($validation->getError('about_group')) ? "<span class='text-danger'>" . $validation->getError('about_group') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" name="category" placeholder="Category" value="<?= old('category') ?>">
                                        <?php echo !empty($validation->getError('category')) ? "<span class='text-danger'>" . $validation->getError('category') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="privacy">Privacy</label>
                                        <input type="text" class="form-control" name="privacy" placeholder="Privacy" value="<?= old('privacy') ?>">
                                        <?php echo !empty($validation->getError('privacy')) ? "<span class='text-danger'>" . $validation->getError('privacy') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"> Submit</button>
                                    <a href="<?= base_url('admin/events') ?>" class="btn btn-danger"> Cancel </a>
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
        $("#create_group").validate({
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