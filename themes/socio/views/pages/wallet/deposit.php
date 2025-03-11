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
                            <?php if(get_setting('stripe_public_key')!='' && get_setting('stripe_secret_key')!='' && get_setting('chck-stripe')==1):?>
                                <h5 class="card-title mb-3"><?= lang('Web.deposit_via_stripe') ?></h5>
                                <form id="checkout-form" method="post" action="<?= base_url('payment-checkout') ?>">
                                    <input type="hidden" name="stripeToken" id="stripe-token-id">
                                    <div class="form-group">
                                        <label for="card-element"><?= lang('Web.card_info') ?></label>
                                        <div id="card-element" class="form-control"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount"><?= lang('Web.amount') ?></label>
                                        <input type="number" required name="amount" class="form-control" min="<?= get_setting('minimum_deposit_limit') ?>" placeholder="<?= lang('Web.enter_deposit') ?>">
                                    </div>
                                    <button 
                                        id="pay-btn"
                                        class="btn btn-success mt-3"
                                        type="button"
                                        style="width: 100%; padding: 7px;"
                                        onclick="createToken()"><?= lang('Web.pay') ?>
                                    </button>
                                </form>
                                <?php else: ?>
                                 
                                    <b class="text-danger">   <?= lang('Web.stripe_not_activated') ?></b>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Statistics -->
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe("<?= get_setting('stripe_public_key') ?>");
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    function createToken() {
        document.getElementById("pay-btn").disabled = true;
        stripe.createToken(cardElement).then(function(result) {
            if(typeof result.error != 'undefined') {
                document.getElementById("pay-btn").disabled = false;
                alert(result.error.message);
            }

            // creating token success
            if(typeof result.token != 'undefined') {
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById('checkout-form').submit();
            }
        });
    }
</script>

<?= $this->endSection() ?>
