<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Bootstrap Tabs -->
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="going-to-tab" data-toggle="tab" href="#going-to"><?= lang('Admin.going_user') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="interested-tab" data-toggle="tab" href="#interested"><?= lang('Admin.interested_user') ?></a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Tab Pane for Going to Events -->
            <div class="tab-pane fade show active" id="going-to">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-hover table-bordered">
                                        <h1 class="table_title"><?= $page_title ?></h1>
                                        <thead class="">
                                            <tr>
                                                <th><?= lang('Admin.id') ?></th>
                                                <th><?= lang('Admin.user_name') ?></th>
                                                <th><?= lang('Admin.email') ?></th>
                                                <th><?= lang('Admin.gender') ?></th>
                                                <th><?= lang('Admin.profile') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($goingusers) > 0): ?>
                                                <?php foreach ($goingusers as $key => $user): ?>
                                                    <tr>
                                                        <td><?= ++$key ?></td>
                                                        <td><?= $user['username'] ?></td>
                                                        <td><?= $user['email'] ?></td>
                                                        <td><?= $user['gender'] ?></td>
                                                        <td><img src="<?= getMedia($user['avatar']) ?>" alt="<?= $user['username'] ?>" width="50px" height="50px"></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-danger"><?= lang('Admin.no_user_going') ?></td>
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

            <!-- Tab Pane for Interested Events -->
            <div class="tab-pane fade" id="interested">
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
                                                <th><?= lang('Admin.user_name') ?></th>
                                                <th><?= lang('Admin.email') ?></th>
                                                <th><?= lang('Admin.gender') ?></th>
                                                <th><?= lang('Admin.profile') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($interestedusers) > 0): ?>
                                                <?php foreach ($interestedusers as $key => $user): ?>
                                                    <tr>
                                                        <td><?= ++$key ?></td>
                                                        <td><?= $user['username'] ?></td>
                                                        <td><?= $user['email'] ?></td>
                                                        <td><?= $user['gender'] ?></td>
                                                        <td><img src="<?= base_url($user['avatar']) ?>" alt="" width="50px" height="50px"></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-danger"><?= lang('Admin.no_user_interested') ?></td>
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
<?= $this->endSection() ?>
