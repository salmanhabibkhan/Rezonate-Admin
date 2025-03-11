<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <!-- User Welcome Section -->
        <div class="row">
        <div class="col-lg-3 connectedSortable">
            <div class="card illustration d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between p-3">
                    <!-- Dashboard Title with Site Name -->
                    <h4 class="illustration-text mb-3"><?= get_setting('site_name'); ?> <?= lang('Admin.dashboard') ?></h4>
                    
                    <!-- Welcome Section with Avatar -->
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <p class="mb-0"><?= lang('Admin.welcome_back') ?>, <strong><?= $user_data['username'] ?></strong></p>
                        </div>
                        <div>
                            <img src="<?= $user_data['avatar'] ?>" alt="User Avatar" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                        </div>
                    </div>
                </div>

                <!-- Card Footer with Icons (Edit Profile, Change Password, Logout) -->
                <div class="card-footer border-top bg-transparent d-flex justify-content-between pt-2">

                    <a href="<?= site_url('admin/users/edit/'.$user_data['id']) ?>" title="<?= lang('Admin.edit_profile') ?>">

                        <i class="fas fa-user-edit fa-lg"></i>
                    </a>
                    <a href="<?= site_url('admin/change-password') ?>" title="<?= lang('Admin.change_password') ?>">
                        <i class="fas fa-key fa-lg"></i>
                    </a>
                    <a href="<?= site_url('logout') ?>" title="<?= lang('Admin.logout') ?>">
                        <i class="fas fa-sign-out-alt fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>


            <!-- Small Boxes Section -->
            <div class="col-lg-9 connectedSortable">
                <?= $this->include('admin/_partials/small-box/small-box') ?>
            </div>
        </div>

        <!-- Withdraw and Deposit Requests Section -->
        <div class="row">
            <!-- Latest Withdraw Requests -->
            <div class="col-lg-6">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title"><?= lang('Admin.latest_wthdraw_requeest') ?></h5>
                    </div>
                    <?php if (!empty($withdraw_requests)): ?>
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell"><?= lang('Admin.sr') ?></th>
                                    <th><?= lang('Admin.name') ?></th>
                                    <th class="d-none d-xl-table-cell"><?= lang('Admin.request_amount') ?></th>
                                    <th><?= lang('Admin.status') ?></th>
                                    <th class="d-none d-md-table-cell"><?= lang('Admin.request_date') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $statusArray = [
                                    '1' => "<span class='badge bg-warning'>" . lang('Admin.in_progress') . "</span>",
                                    '2' => "<span class='badge bg-success'>" . lang('Admin.completed') . "</span>",
                                    '3' => "<span class='badge bg-danger'>" . lang('Admin.canceled') . "</span>"
                                ];
                                foreach ($withdraw_requests as $key => $withdraw_request): ?>
                                    <tr onclick="window.location.href = 'withdraw-requests/details/<?= $withdraw_request['id'] ?>';" style="cursor: pointer;">
                                        <td class="d-none d-md-table-cell"><?= ++$key ?></td>
                                        <td><?= $withdraw_request['username'] ?></td>
                                        <td class="d-none d-md-table-cell"><?= number_format($withdraw_request['amount'], 2, '.', '') ?></td>
                                        <td><?= $statusArray[$withdraw_request['status']] ?></td>
                                        <td class="d-none d-xl-table-cell"><?= date("d/M/Y", strtotime($withdraw_request['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="my-5 py-5 text-center">
                            <i class="fas fa-arrow-circle-down fa-3x text-muted"></i>
                            <h6 class="mt-2 mb-3 text-muted"><?= lang('Admin.no_withdraw_found') ?></h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Latest Deposit Requests -->
            <div class="col-lg-6">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title"><?= lang('Admin.latest_deposit_requeest') ?></h5>
                    </div>
                    <?php if (!empty($deposite_requests)): ?>
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th class="d-none d-xl-table-cell"><?= lang('Admin.sr') ?></th>
                                    <th><?= lang('Admin.name') ?></th>
                                    <th class="d-none d-xl-table-cell"><?= lang('Admin.request_amount') ?></th>
                                    <th><?= lang('Admin.status') ?></th>
                                    <th class="d-none d-md-table-cell"><?= lang('Admin.request_date') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $deposite_status = [
                                    'pending' => "<span class='badge bg-warning'>" . lang('Admin.in_progress') . "</span>",
                                    'approved' => "<span class='badge bg-success'>" . lang('Admin.completed') . "</span>",
                                    'rejected' => "<span class='badge bg-danger'>" . lang('Admin.canceled') . "</span>"
                                ];
                                foreach ($deposite_requests as $key => $deposite_request): ?>
                                    <tr onclick="window.location.href = 'deposit-requests/details/<?= $deposite_request['id'] ?>';" style="cursor: pointer;">
                                        <td class="d-none d-md-table-cell"><?= ++$key ?></td>
                                        <td><?= $deposite_request['username'] ?></td>
                                        <td class="d-none d-md-table-cell"><?= $deposite_request['amount'] ?></td>
                                        <td><?= $deposite_status[$deposite_request['status']] ?></td>
                                        <td class="d-none d-xl-table-cell"><?= date("d/M/Y", strtotime($deposite_request['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="my-5 py-5 text-center">
                            <i class="fas fa-wallet fa-3x text-muted"></i>
                            <h6 class="mt-2 mb-3 text-muted"><?= lang('Admin.no_deposit_found') ?></h6>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
    <?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
