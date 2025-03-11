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
                                <h5><?= lang('Web.total_balance') ?></h5>
                                <h1 class="total">$<?= sprintf("%.2f", floor($user_balance * 100) / 100) ?> </h1>
                            </div>
                            <?php if(get_setting('stripe_public_key')!='' && get_setting('stripe_secret_key')!='' && get_setting('chck-stripe')==1):?>
                            <div class="right">
                                <a href="<?= site_url('deposit-amount-via-stripe') ?>" class="button">
                                    <i class="bi bi-stripe" aria-label="add"></i>&nbsp;&nbsp;<?= lang('Web.stripe') ?>
                                </a>
                            </div>
                            <?php endif;?>
                            <?php if(get_setting('paypal_public_key')!='' && get_setting('paypal_secret_key')!='' && get_setting('chck-paypal')==1):?>
                            <div class="right">
                                <a href="<?= site_url('deposit-amount-via-paypal') ?>" class="button">
                                    <i class="bi bi-paypal" aria-label="add"></i>&nbsp;&nbsp;<?= lang('Web.paypal') ?>
                                </a>
                            </div>
                            <?php endif;?>
                            <?php if(get_setting('paystack_public_key')!='' && get_setting('paystack_secret_key')!='' && get_setting('chck-paystack')==1 ):?>

                            
                                <div class="right">
                                    <a href="<?= site_url('deposit-amount-via-paystack') ?>" class="button">
                                        <i class="bi bi-plus-circle" aria-label="add"></i>&nbsp;&nbsp;<?= lang('Web.paystack') ?>
                                    </a>
                                </div>
                                <?php endif ;?>
                        </div>
                        <!-- * Balance -->
                        <!-- Wallet Footer -->
                        <div class="wallet-footer">
                            <div class="item">
                                <a href="<?= site_url('create-withdraw') ?>">
                                    <div class="icon-wrapper bg-danger">
                                        <i class="bi bi-arrow-down-circle" aria-label="withdraw"></i>
                                    </div>
                                </a>
                                <strong ><?= lang('Web.withdraw') ?></strong>
                            </div>
                            <div class="item">
                                <a href="<?= site_url('withdraw-requests') ?>">
                                    <div class="icon-wrapper bg-warning">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </div>
                                </a>
                                <strong ><?= lang('Web.withdraw_requests') ?></strong>
                            </div>
                            <div class="item">
                                <a href="<?= site_url('transfer-amount') ?>">
                                    <div class="icon-wrapper bg-info">
                                        <i class="bi bi-send"></i>
                                    </div>
                                </a>
                                <strong><?= lang('Web.transfer') ?></strong>
                            </div>
                        </div>
                        <!-- * Wallet Footer -->
                    </div>
                </div>

                <!-- Earnings Breakdown -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header border-0 border-bottom">
                        <div class="row g-2">
                            <div class="col-lg-12">
                                <h1 class="h4 card-title mb-lg-0"><?= lang('Web.earning_breakdown') ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row g-3">
                            <?php if (isset($earnings['like_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.like_earnings') ?></div>
                                        <div class="fs-5 value text-success">$<?= number_format($earnings['like_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['comment_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.comment_earnings') ?></div>
                                        <div class="fs-5 value text-success">$<?= number_format($earnings['comment_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['share_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.share_earnings') ?></div>
                                        <div class="fs-5 value text-info">$<?= number_format($earnings['share_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['withdraw_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.withdraw_earnings') ?></div>
                                        <div class="fs-5 value text-warning">$<?= number_format($earnings['withdraw_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['deposit_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.deposit_earnings') ?></div>
                                        <div class="fs-5 value text-danger">$<?= number_format($earnings['deposit_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['package_subscription_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.package_subscription_earnings') ?></div>
                                        <div class="fs-5 value text-success">$<?= number_format($earnings['package_subscription_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['coffee_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.coffee_earnings') ?></div>
                                        <div class="fs-5 value text-error">$<?= number_format($earnings['coffee_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['great_job_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.great_job_earnings') ?></div>
                                        <div class="fs-5 value text-danger">$<?= number_format($earnings['great_job_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['withdraw_rejected_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <div class="title fs-6 "><?= lang('Web.withdraw_rejected_earnings') ?></div>
                                        <div class="fs-5 value text-info">$<?= number_format($earnings['withdraw_rejected_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($earnings['advertisement_earnings'])) : ?>
                                <div class="col-4">
                                    <div class="card stat-box">
                                        <div class="title fs-6 "><?= lang('Web.advertisement_earnings') ?></div>
                                        <div class="fs-5 value text-success">$<?= number_format($earnings['advertisement_earnings'], 3); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- End of Earnings Breakdown -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
