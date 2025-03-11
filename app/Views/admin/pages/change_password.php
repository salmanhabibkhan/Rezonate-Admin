<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-6 offset-md-3">

                <div class=" card card-primary table-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3><?= lang('Admin.change_password') ?></h3>
                                <form action="<?= base_url('admin/users/update-password/'.$user['id']) ?>" method="post" id="change_password">
                                    <div class="form-group">
                                        <label for=""><?= lang('Admin.user_name') ?></label>
                                        <input type="text" value="<?= $user['username'] ?>" class="form-control" readonly disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?= lang('Admin.email') ?></label>
                                        <input type="text" class="form-control" value="<?= $user['email'] ?>" readonly disabled>
                                    </div>                      
                                    <div class="form-group">
                                        <label for=""><?= lang('Admin.new_password') ?></label>
                                        <input type="password" name="password" class="form-control" placeholder="<?= lang('Admin.password_placeholder') ?>" id="password">
                                        <?php  $validation = \Config\Services::validation();
                                        echo  !empty($validation->getError('password'))?"<span class='text-danger'>".$validation->getError('password')."</span> ":'';
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?= lang('Admin.confirm_password') ?></label>
                                        <input type="password" name="confirm_password" class="form-control" placeholder="<?= lang('Admin.confirm_password_placeholder') ?>">
                                        <?php  
                                        echo  !empty($validation->getError('confirm_password'))?"<span class='text-danger'>".$validation->getError('confirm_password')."</span> ":'';
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success"><?= lang('Admin.change_password_btn') ?></button>
                                        <a href="<?= base_url('admin/users') ?>" class="btn btn-danger"> <i class="fa fa-times"></i> <?= lang('Admin.cancel') ?></a>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    $(document).ready(function () {
        $("#change_password").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid',
            rules: {
                password: {
                    required: true,
                    minlength: 6,

                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password" // Ensure confirm_password matches the value of password
                }
            },
            messages: {
                password: {
                    required: "<?= lang('Admin.password_required') ?>",
                    minlength: "<?= lang('Admin.password_minlength') ?>"
                },
                confirm_password: {
                    required: "<?= lang('Admin.confirm_password_required') ?>",
                    minlength: "<?= lang('Admin.password_minlength') ?>",
                    equalTo: "<?= lang('Admin.confirm_password_equalto') ?>"
                }
            },
            // Add any additional settings or callbacks if needed
        });
    });

</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
