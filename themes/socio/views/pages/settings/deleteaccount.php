<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-lg-3">
        <?= $this->include('partials/settings_sidebar') ?>
    </div>
    <div class="col-lg-6 vstack gap-4">
        <div class="py-0 mb-0">
            <div class="card mb-4">
                <div class="card-header border-0 border-bottom">
                <h1 class="h5 card-title"><?= lang('Web.delete_account_permanently') ?></h1>
                </div>
                <form method="post" id="deleteaccount">
                    <div class="card-body">
                        <div class="form-group">
                        <label for="Password"><?= lang('Web.password') ?></label>
                        <input type="password" name="password" class="form-control mt-2" placeholder="<?= lang('Web.enter_password') ?>">
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-danger btn-soft"><i class="bi bi-trash-fill"></i> <?= lang('Web.delete_account') ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        var form = $('#deleteaccount');

        form.validate({
            rules: {
                // Validation rules           
                password: {
                    required: true
                },
                // Other fields...
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            messages: {
                // Validation messages
                // Similar to the previous example...
            },
            submitHandler: function(form) {
                // Show confirmation dialog
                Swal.fire({
                    title: '<?= lang('Web.delete_account_confirm_title') ?>',
                    text: '<?= lang('Web.delete_account_confirm_text') ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?= lang('Web.delete_account_confirm_button') ?>'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData(form);
                        $.ajax({
                            type: 'POST',
                            url: site_url + 'web_api/deleteaccount', // Adjust this to your controller's path
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                let timerInterval;
                                Swal.fire({
                                    title: "Success",
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
                                    
                                    window.location = site_url+"login";
                                });
                            },
                            error: function() {
                                // Handle error
                                alert("An error occurred.");
                            }
                        });
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>