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
                                <h1 class="total">$<?= sprintf("%.2f", floor($user_balance * 100) / 100)?></h1>
                            </div>

                        </div>
                        <!-- * Balance -->
                    </div>
                </div>

                <!-- Withdraw History -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header border-0 border-bottom">
                        <div class="row g-2">
                            <div class="col-lg-12">
                                <h1 class="h4 card-title mb-lg-0"><?= lang('Web.withdraw_history') ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-0 border-bottom">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <?php  if(count($withdrawrequests)>0): ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?= lang('Web.sr') ?></th>
                                                <th><?= lang('Web.request_via') ?></th>
                                                <th><?= lang('Web.amount') ?></th>
                                                <th><?= lang('Web.status') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($withdrawrequests as $key => $request): ?>
                                                <tr>
                                                    <td><?= ++$key ?></td>
                                                    <td><?= $request['type'] ?></td>
                                                    <td><?= $request['amount'] ?></td>
                                                    <td>
                                                        <?php if($request['status']==1): ?>
                                                            <span class="badge bg-info"><?= lang('Web.pending') ?> </span>
                                                        <?php elseif($request['status']==2): ?>
                                                            <span class="badge bg-success"><?= lang('Web.approved') ?> </span>
                                                        <?php elseif($request['status']==3): ?>
                                                            <span class="badge bg-danger"><?= lang('Web.rejected') ?> </span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php  endforeach; ?>
                                        </tbody>
                                    </table>    
                                <?php  else: ?>
                                    <p class="text-center text-danger"><?= lang('Web.no_withdraw_requests') ?></p>
                                <?php  endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>


<?= $this->endSection() ?>
