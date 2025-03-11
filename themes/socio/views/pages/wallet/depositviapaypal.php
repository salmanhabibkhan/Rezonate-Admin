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
                        <!-- * Balance -->
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-3 offset-md-3">
                            <?php if(get_setting('paypal_public_key')!='' && get_setting('paypal_secret_key')!='' && get_setting('chck-paypal')==1):?>
                                <h5 class="card-title mb-3"><?= lang('Web.deposit_via_paypal') ?></h5>
                                <form id="" method="post" action="<?= site_url('paypal/create') ?>">
                                    <div class="form-group">
                                        <label for="amount"><?= lang('Web.amount') ?></label>
                                        <input type="number" required name="amount" class="form-control" min="<?= get_setting('minimum_deposit_limit') ?>" placeholder="<?= lang('Web.enter_deposit') ?>">
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="bi bi-paypal"></i> <?= lang('Web.deposit_via_paypal') ?>
                                        </button>
                                    </div>
                                </form>
                                <?php else:?>
                                   <b class="text-danger"> <?= lang('Web.paypal_not_activated') ?></b>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
