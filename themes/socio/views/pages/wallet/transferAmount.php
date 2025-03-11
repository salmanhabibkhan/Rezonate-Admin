<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-3 mt-1">

    <!-- Include the necessary CSS and JS for Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-body">
                <div class="section wallet-card-section pt-1">
                    <div class="wallet-card">
                        <!-- Balance -->
                        <div class="balance">
                            <div class="left">
                                <span class="title"><?= lang('Web.total_balance') ?></span>
                                <h1 class="total">$<?= sprintf("%.2f", floor($user_balance * 100) / 100)?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transfer Amount Form -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header border-0 border-bottom">
                        <div class="row g-2">
                            <div class="col-lg-12">
                                <h1 class="h4 card-title mb-lg-0"><?= lang('Web.transfer_amount') ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-0 border-bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" id="transferAmount">
                                    <div class="form-group">
                                        <label for="user_select"><?= lang('Web.user_name') ?></label>
                                        <select name="user_id" id="user_select" class="form-control">
                                            <?php foreach ($users as $user) : ?>
                                                <option value="<?= $user['id'] ?>"><?= $user['first_name']." ".$user['last_name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="amount"><?= lang('Web.amount') ?></label>
                                        <input type="number" name="amount" class="form-control" placeholder="<?= lang('Web.transfer_amount') ?>"
                                            max="<?= sprintf("%.2f", floor($user_balance * 100) / 100) ?>" step="0.01">
                                    </div>
                                    <div class="form-group mt-3">
                                        <button class="btn btn-primary" type="submit"> <i class="bi bi-send"></i> <?= lang('Web.transfer') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for user selection
        $('#user_select').select2();
       
        // Form validation rules using jQuery Validate
        $('#transferAmount').validate({
            ignore: ":hidden",  // Ignore hidden fields during validation
            rules: {
                amount: {
                    required: true,
                    number: true
                },
                user_id: {
                    required: true,
                    number: true
                }
            },
            messages: {
                amount: {
                    required: "<?= lang('Web.please_enter_amount') ?>",
                    number: "<?= lang('Web.enter_valid_number') ?>"
                },
                user_id: {
                    required: "<?= lang('Web.please_select_user') ?>",
                    number: "<?= lang('Web.select_valid_user') ?>"
                }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-group').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('is-invalid');
            },
        });

        // AJAX form submission
        $('#transferAmount').submit(function(event) {
            event.preventDefault();
            if ($('#transferAmount').valid()) {
                var formData = $(this).serialize();
                
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('web_api/transfer-amount') ?>', 
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: "<?= lang('Web.success') ?>",
                            icon: "success",
                            html: response.message,
                            timer: 4000,
                            timerProgressBar: true
                        }).then((result) => {
                            window.location.href = "<?= site_url('wallet') ?>";
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: "<?= lang('Web.error') ?>",
                            icon: "error",
                            text: "<?= lang('Web.error_occurred') ?>",
                        });
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
