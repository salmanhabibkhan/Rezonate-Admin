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
                                <div class="form-group">
                                    <label for=""><?= lang('Admin.user_name') ?></label>
                                    <input type="text" value="<?= $user['username'] ?>" class="form-control" readonly disabled>
                                </div>
                                <div class="form-group">
                                    <label for=""><?= lang('Admin.email') ?></label>
                                    <input type="text" class="form-control" value="<?= $user['email'] ?>" readonly disabled>
                                </div>
                                <form class="row g-3" id="changepassword" method="post">
							<!-- Current password -->
                                    <div class="col-12">
                                        <label class="form-label"><?= lang('Admin.current_password') ?></label>
                                        <input type="password" name="old_password" class="form-control" placeholder="<?= lang('Admin.enter_old_password') ?>">
                                    </div>
                                    <!-- New password -->
                                    <div class="col-12">
                                        <label class="form-label"><?= lang('Admin.new_password') ?></label>
                                        <!-- Input group -->
                                        <div class="input-group">
                                            <input class="form-control" type="password" id="new_password" name="new_password" placeholder="<?= lang('Admin.enter_new_password') ?>">
                                        </div>
                                        <!-- Pswmeter -->
                                        <div id="pswmeter" class="mt-2"></div>
                                        <div id="pswmeter-message" class="rounded mt-1"></div>
                                    </div>
                                    <!-- Confirm password -->
                                    <div class="col-12">
                                        <label class="form-label"><?= lang('Admin.confirm_password') ?></label>
                                        <input type="password" name="confirm_password" class="form-control" placeholder="<?= lang('Admin.confirm_new_password') ?>">
                                    </div>
                                    <!-- Button  -->
                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn btn-primary mb-0"><?= lang('Admin.update_password') ?></button>
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

// Add validation rules using jQuery Validate for visible fields only
$('#changepassword').validate({
    ignore: ":hidden",  // Ignore hidden fields during validation
    rules: {
        old_password: {
            required: true,
        },
        new_password: {
            required: true,
        },
        confirm_password: {
            required: true,
            equalTo: '#new_password'
        }
    },
    messages: {
        old_password: {
            required: translate('old_password_required')
        },
        new_password: {
            required: translate('new_password_required')
        },
        confirm_password: {
            required: translate('confirm_password_required'),
            equalTo: translate('password_mismatch')
        }
    },
    errorElement: 'div',
    errorClass: 'invalid-feedback',
    highlight: function (element) {
        $(element).closest('.form-control').addClass('is-invalid');
    },
    unhighlight: function (element) {
        $(element).closest('.form-control').removeClass('is-invalid');
    },

});

$('#changepassword').submit(function (event) {
    event.preventDefault();
    if ($('#changepassword').valid()) {
        // Use $(this).serialize() to get the form data
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '<?= site_url('web_api/change-password') ?>', // Define site_url with the appropriate base URL
            data: formData,
            contentType: 'application/x-www-form-urlencoded',
            processData: true,
            success: function (response) {
                console.log(response);
                let timerInterval;
                if(response.code==200)
                {
                    toastr.success(response.message);

                }
                else
                {
                    toastr.error(response.message);
                }
            },
           
        });
    }
});
});
function translate(key) {
	var translations = {
		'success_title': '<?= lang('Admin.success_title') ?>',
		'error_title': '<?= lang('Admin.error_title') ?>',
		'update_password_error': '<?= lang('Admin.update_password_error') ?>',
		'old_password_required': '<?= lang('Admin.old_password_required') ?>',
		'new_password_required': '<?= lang('Admin.new_password_required') ?>',
		'confirm_password_required': '<?= lang('Admin.confirm_password_required') ?>',
		'password_mismatch': '<?= lang('Admin.password_mismatch') ?>',
	};
	return translations[key] || key;
}

</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
