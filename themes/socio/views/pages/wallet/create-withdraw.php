<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-3 mt-1">
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
                                <h1 class="total">$<?= sprintf("%.2f", floor($user_balance * 100) / 100) ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Withdraw Form -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header border-0 border-bottom">
                        <div class="row g-2">
                            <div class="col-lg-12">
                                <h1 class="h4 card-title mb-lg-0"><?= lang('Web.withdraw_balance') ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-0 border-bottom">
                        <form method="post" id="create-withdraw">
                            <div class="row g-2">
                                <div class="col-lg-12">
                                    <label for="gatewaymethod"><?= lang('Web.withdraw_via') ?></label>
                                    <select name="type" id="gatewaymethod" class="form-control">
                                        <option value=""><?= lang('Web.select_withdrawal_method') ?></option>
                                        <option value="Paypal">Paypal</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="amount"><?= lang('Web.amount') ?></label>
                                    <input type="number" name="amount" class="form-control" placeholder="<?= lang('Web.withdrawal_amount') ?>" max="<?= sprintf("%.2f", floor($user_balance * 100) / 100) ?>" step="0.01">
                                </div>
                            </div>
                            <div id="paypal" class="d-none">
                                <div class="row g-2 mt-2">
                                    <div class="col-lg-12">
                                        <label for="paypal_email"><?= lang('Web.paypal_email') ?></label>
                                        <input type="email" name="paypal_email" class="form-control" placeholder="<?= lang('Web.enter_paypal_email') ?>">
                                    </div>
                                </div>
                            </div>
                            <div id="bank" class="d-none">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="full_name"><?= lang('Web.full_name') ?></label>
                                        <input type="text" name="full_name" class="form-control" placeholder="<?= lang('Web.enter_full_name') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address"><?= lang('Web.address') ?></label>
                                        <input type="text" name="address" class="form-control" placeholder="<?= lang('Web.enter_address') ?>">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="iban"><?= lang('Web.iban') ?></label>
                                        <input type="text" name="iban" class="form-control" placeholder="<?= lang('Web.enter_iban') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country"><?= lang('Web.country') ?></label>
                                        <input type="text" name="country" class="form-control" placeholder="<?= lang('Web.enter_country') ?>">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="swift_code"><?= lang('Web.swift_code') ?></label>
                                        <input type="text" name="swift_code" class="form-control" placeholder="<?= lang('Web.enter_swift_code') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mbl_no"><?= lang('Web.mobile_number') ?></label>
                                        <input type="text" name="mbl_no" class="form-control" placeholder="<?= lang('Web.enter_mobile_number') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success"><?= lang('Web.withdraw') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function(){
        $('#gatewaymethod').change(function(){  
            var selectedValue = $(this).val();
            $('#paypal, #bank').addClass('d-none');
            if (selectedValue === 'Paypal') {
                $('#paypal').removeClass('d-none');
            } else if (selectedValue === 'Bank') {
                $('#bank').removeClass('d-none');
            }
        });

        // Add validation rules and messages using lang keys for translation
        $('#create-withdraw').validate({
            ignore: ":hidden",
            rules: {
                amount: {
                    required: true,
                    number: true
                },
                type: {
                    required: true,
                },
                paypal_email: {
                    required: function() {
                        return $('#gatewaymethod').val() === 'Paypal';
                    },
                    email: true
                },
                full_name: {
                    required: function() {
                        return $('#gatewaymethod').val() === 'Bank';
                    }
                },
                iban: {
                    required: function() {
                        return $('#gatewaymethod').val() === 'Bank';
                    }
                },
                country: {
                    required: function() {
                        return $('#gatewaymethod').val() === 'Bank';
                    }
                },
                swift_code: {
                    required: function() {
                        return $('#gatewaymethod').val() === 'Bank';
                    }
                },
                address: {
                    required: function() {
                        return $('#gatewaymethod').val() === 'Bank';
                    }
                },
                mbl_no: {
                    required: function() {
                        return $('#gatewaymethod').val() === 'Bank';
                    }
                }
            },
            messages: {
                amount: {
                    required: "<?= lang('Web.amount_required') ?>",
                    number: "<?= lang('Web.valid_number') ?>"
                },
                type: {
                    required: "<?= lang('Web.withdrawal_method_required') ?>"
                },
                paypal_email: {
                    required: "<?= lang('Web.paypal_email_required') ?>",
                    email: "<?= lang('Web.valid_email') ?>"
                },
                full_name: {
                    required: "<?= lang('Web.full_name_required') ?>"
                },
                iban: {
                    required: "<?= lang('Web.iban_required') ?>"
                },
                country: {
                    required: "<?= lang('Web.country_required') ?>"
                },
                swift_code: {
                    required: "<?= lang('Web.swift_code_required') ?>"
                },
                address: {
                    required: "<?= lang('Web.address_required') ?>"
                },
                mbl_no: {
                    required: "<?= lang('Web.mobile_number_required') ?>"
                }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            }
        });

        $('#create-withdraw').submit(function (event) {
            event.preventDefault();
            if ($('#create-withdraw').valid()) {
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/create-withdraw',
                    data: formData,
                    success: function (response) {
                        if(response.status == 200) {
                            Swal.fire({
                                title: "<?= lang('Web.success') ?>",
                                icon: "success",
                                html: response.message,
                                timer: 4000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = "<?= site_url('wallet') ?>";
                            });
                        } else {
                            Swal.fire({
                                title: "<?= lang('Web.error_occurred') ?>",
                                icon: "error",
                                html: response.message,
                                timer: 4000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: "<?= lang('Web.error') ?>",
                            icon: "error",
                            text: "<?= lang('Web.error_occurred') ?>"
                        });
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
