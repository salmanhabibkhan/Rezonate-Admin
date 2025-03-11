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
                        <form action="<?= base_url('admin/users/store') ?>" method="post" id="user_form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name"><?= lang('Admin.first_name') ?></label>
                                        <input type="text" class="form-control" name="first_name" >
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?php echo !empty($validation->getError('first_name')) ? "<span class='text-danger'>" . $validation->getError('first_name') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name"><?= lang('Admin.last_name') ?></label>
                                        <input type="text" class="form-control" name="last_name" >
                                        <?php echo !empty($validation->getError('last_name')) ? "<span class='text-danger'>" . $validation->getError('last_name') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name"><?= lang('Admin.email') ?></label>
                                        <input type="email" class="form-control" name="email" >
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?php echo !empty($validation->getError('email')) ? "<span class='text-danger'>" . $validation->getError('email') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name"><?= lang('Admin.password') ?></label>
                                        <input type="password" class="form-control" name="password" >
                                        <?php echo !empty($validation->getError('password')) ? "<span class='text-danger'>" . $validation->getError('password') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="avatar"><?= lang('Admin.avatar') ?></label>
                                        <input type="file" class="form-control" name="avatar" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cover"><?= lang('Admin.cover') ?></label>
                                        <input type="file" class="form-control" name="cover" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password"><?= lang('Admin.address') ?></label>
                                        <input type="text" class="form-control" name="address" >
                                        <?php echo !empty($validation->getError('address')) ? "<span class='text-danger'>" . $validation->getError('address') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status"><?= lang('Admin.status') ?></label>
                                        <select class="form-control" name="status">
                                            <option value="1" ><?= lang('Admin.active') ?></option>
                                            <option value="0" ><?= lang('Admin.inactive') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender"><?= lang('Admin.gender') ?></label>
                                        <select class="form-control" name="gender">
                                            <option value="Male"><?= lang('Admin.male') ?></option>
                                            <option value="Female" ><?= lang('Admin.female') ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone"><?= lang('Admin.phone') ?></label>
                                        <input type="text" class="form-control" name="phone" >
                                        <?php echo !empty($validation->getError('phone')) ? "<span class='text-danger'>" . $validation->getError('phone') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_of_birth"><?= lang('Admin.date_of_birth') ?></label>
                                        <input type="date" class="form-control" name="date_of_birth" " max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="working"><?= lang('Admin.working') ?></label>
                                        <input type="text" class="form-control" name="working" >
                                    </div>
                                </div>
                            </div>
                           

                            <button type="submit" class="btn btn-primary"><?= lang('Admin.add_new_admin') ?></button>
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
        $("#user_form").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid',
            rules: {
                first_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true // Added email validation here

                },
                last_name: {
                    required: true
                },
                address: {
                    required: true
                },
                phone: {
                    required: true
                },
                working: {
                    required: true
                },
            },
            messages: {
                first_name: {
                    required: "<?= lang('Admin.first_name_required') ?>"
                },
                email: {
                    required: "<?= lang('Admin.email_required') ?>",
                    email: "<?= lang('Admin.email_invalid') ?>"
                },
                last_name: {
                    required: "<?= lang('Admin.last_name_required') ?>"
                },
                address: {
                    required: "<?= lang('Admin.address_required') ?>"
                },
                phone: {
                    required: "<?= lang('Admin.phone_required') ?>"
                },
                working: {
                    required: "<?= lang('Admin.working_required') ?>"
                },
            },
        });
    });
</script>


<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
