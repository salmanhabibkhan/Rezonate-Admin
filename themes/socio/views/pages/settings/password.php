<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
	<div class="col-lg-3">
		<?= $this->include('partials/settings_sidebar') ?>
	</div>

	<div class="col-lg-6 vstack gap-4">
		<div class="py-0 mb-0">

				<!-- Change your password START -->
				<div class="card">
					<!-- Title START -->
					<div class="card-header border-0 pb-0">
						<h5 class="card-title"><?= lang('Web.change_password') ?></h5>
						<p class="mb-0"></p>
					</div>
					<!-- Title END -->
					<div class="card-body">
						<!-- Settings START -->
						<form class="row g-3" id="changepassword" method="post">
							<!-- Current password -->
							<div class="col-12">
								<label class="form-label"><?= lang('Web.current_password') ?></label>
								<input type="password" name="old_password" class="form-control" placeholder="<?= lang('Web.enter_old_password') ?>">
							</div>
							<!-- New password -->
							<div class="col-12">
								<label class="form-label"><?= lang('Web.new_password') ?></label>
								<!-- Input group -->
								<div class="input-group">
									<input class="form-control" type="password" id="new_password" name="new_password" placeholder="<?= lang('Web.enter_new_password') ?>">
								</div>
								<!-- Pswmeter -->
								<div id="pswmeter" class="mt-2"></div>
								<div id="pswmeter-message" class="rounded mt-1"></div>
							</div>
							<!-- Confirm password -->
							<div class="col-12">
								<label class="form-label"><?= lang('Web.confirm_password') ?></label>
								<input type="password" name="confirm_password" class="form-control" placeholder="<?= lang('Web.confirm_new_password') ?>">
							</div>
							<!-- Button  -->
							<div class="col-12 text-end">
								<button type="submit" class="btn btn-primary mb-0"><?= lang('Web.update_password') ?></button>
							</div>
						</form>
						<!-- Settings END -->
					</div>
				</div>
		

		</div>
	</div>

</div> <!-- Row END -->

<script src="<?= base_url('public'); ?>/assets/js/jquery.validate.min.js"></script>

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
					let timerInterval;
					if(response.code==200)
					{
						Swal.fire({
							title: translate('success_title'),
							icon: "success",
							html: response.message,
							timer: 4000,
							timerProgressBar: true,
							didOpen: () => {
								Swal.icon = 'success';
								const timer = Swal.getPopup().querySelector("b");
								timerInterval = setInterval(() => {
									timer.textContent = `${Swal.getTimerLeft()}`;
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);
							},
						}).then((result) => {
							window.location.href = "<?= site_url('') ?>";
						});	
					}
					else
					{
						Swal.fire({
							title: translate('error_title'),
							icon: "error",
							html: response.message,
							timer: 4000,
							timerProgressBar: true,
							didOpen: () => {
								Swal.icon = 'error';
								const timer = Swal.getPopup().querySelector("b");
								timerInterval = setInterval(() => {
									timer.textContent = `${Swal.getTimerLeft()}`;
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);
							},
						});	
					}
				},
				error: function () {
					Swal.fire({
						title: translate('error_title'),
						icon: "error",
						text: translate('update_password_error'),
					});
				}
			});
		}
	});
});

function translate(key) {
	var translations = {
		'success_title': '<?= lang('Web.success_title') ?>',
		'error_title': '<?= lang('Web.error_title') ?>',
		'update_password_error': '<?= lang('Web.update_password_error') ?>',
		'old_password_required': '<?= lang('Web.old_password_required') ?>',
		'new_password_required': '<?= lang('Web.new_password_required') ?>',
		'confirm_password_required': '<?= lang('Web.confirm_password_required') ?>',
		'password_mismatch': '<?= lang('Web.password_mismatch') ?>',
	};
	return translations[key] || key;
}
</script>

<?= $this->endSection() ?>
