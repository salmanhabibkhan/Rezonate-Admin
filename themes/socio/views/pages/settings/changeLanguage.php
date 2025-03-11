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
                    <h1 class="h5 card-title"><?= lang('Web.change_language') ?></h1>
                </div>
                <div class="card-body">
                    <form method="post" id="changelanguage">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for=""><?= lang('Web.select_language') ?></label>
                                <select name="lang" id="" class="form-control">
                                    <?php foreach ($languages as $language) : ?>
                                    <option value="<?=$language?>"<?=($user_language==$language)?'selected':''?>> <?=$language?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 form-group">
                                <button class="btn btn-success btn-sm"> <?= lang('Web.update') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
    var form = $('#changelanguage');

    form.validate({
        rules: {
            lang: {
                required: true
            },
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
            lang: {
                required: "<?= lang('Web.language_required') ?>",
            },
        },
        submitHandler: function(form) {
            // Show confirmation dialog
            Swal.fire({
                title: '<?= lang('Web.confirm_language_change_title') ?>',
                text: '<?= lang('Web.confirm_language_change_text') ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?= lang('Web.yes_confirm') ?>'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(form);
                    $.ajax({
                        type: 'POST',
                        url: site_url + 'web_api/settings/update-user-profile', // Adjust this to your controller's path
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            let timerInterval;
                            Swal.fire({
                                title: "<?= lang('Web.success') ?>",
                                icon: "success",
                                html: response.message,
                                timer: 4000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                },
                            }).then((result) => {
                                window.location = site_url ;
                            });
                        },
                        error: function() {
                            alert("<?= lang('Web.error_occurred') ?>");
                        }
                    });
                }
            });
        }
    });
});

</script>

<?= $this->endSection() ?>
