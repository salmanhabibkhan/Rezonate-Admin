<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Bootstrap Tabs -->
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="spacedetail-tab" data-toggle="tab" href="#spacedetail"><?= lang('Admin.space_detail') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="members-tab" data-toggle="tab" href="#members"><?= lang('Admin.space_members') ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- Tab Pane for Space Details -->
            <div class="tab-pane fade show active" id="spacedetail">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h3><?= lang('Admin.user_details') ?></h3>
                                <table class="table border-0">
                                    <tr class="">
                                        <th><?= lang('Admin.username') ?></th>
                                        <td><?= $space_owner['username'] ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.email') ?></th>
                                        <td><?= $space_owner['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.user_profile') ?></th>
                                        <td><img src="<?= getMedia($space_owner['avatar']) ?>" alt="<?= lang('Admin.profile_image') ?>" width="100px"></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.cover') ?></th>
                                        <td><img src="<?= getMedia($space_owner['cover']) ?>" alt="<?= lang('Admin.cover_image') ?>" width="100px"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h3><?= lang('Admin.space_details') ?></h3>
                                <table class="table border-0">
                                    <tr class="">
                                        <th><?= lang('Admin.space_title') ?></th>
                                        <td><?= $space['title'] ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.paid_free') ?></th>
                                        <td><?= ($space['is_paid'] == 1) ? lang('Admin.paid') : lang('Admin.free') ?></td>
                                    </tr>
                                    <?php if ($space['is_paid'] == 1) : ?>
                                        <tr>
                                            <th><?= lang('Admin.amount') ?></th>
                                            <td><?= $space['amount'] ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <tr class="">
                                        <th><?= lang('Admin.status') ?></th>
                                        <td><?= ($space['status'] == 1) ? lang('Admin.continue') : lang('Admin.completed') ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.privacy') ?></th>
                                        <td><?= ($space['privacy'] == 0) ? lang('Admin.public') : lang('Admin.friend') ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= lang('Admin.description') ?></th>
                                        <td><?= $space['description'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Pane for Space Members -->
            <div class="tab-pane fade" id="members">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-hover table-bordered">
                                        <h1 class="table_title"><?= $page_title ?></h1>
                                        <thead class="">
                                            <tr>
                                                <th><?= lang('Admin.sr_no') ?></th>
                                                <th><?= lang('Admin.username') ?></th>
                                                <th><?= lang('Admin.gender') ?></th>
                                                <th><?= lang('Admin.user_image') ?></th>
                                                <th><?= lang('Admin.user_role') ?></th>
                                                <th><?= lang('Admin.can_speak') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($members) > 0): ?>
                                                <?php foreach ($members as $key => $member) : ?>
                                                    <tr>
                                                        <td><?= ++$key ?></td>
                                                        <td><?= $member['username'] ?></td>
                                                        <td><?= $member['gender'] ?></td>
                                                        <td><img src="<?= base_url($member['avatar']) ?>" alt="" width="50px" height="50px"></td>
                                                        <td>
                                                            <?php
                                                            if ($member['is_host'] == 1)
                                                                echo lang('Admin.space_host');
                                                            elseif ($member['is_cohost'] == 1)
                                                                echo lang('Admin.space_cohost');
                                                            else
                                                                echo lang('Admin.listener');
                                                            ?>
                                                        </td>
                                                        <td><?= ($member['is_speaking_allowed'] == 1) ? "<span class='badge bg-success'>" . lang('Admin.yes') . "</span>" : "<span class='badge bg-danger'>" . lang('Admin.no') . "</span>" ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-danger"><?= lang('Admin.no_user_in_space') ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
    <!-- Include Bootstrap JS and other scripts if needed -->
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
