<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <!-- <a href="<?= base_url('admin/packages/create')?>" class="btn btn-success btn-sm mb-3 float-right ">Create New Package</a> -->
                        <div class="table-responsive">
                            <table id="example1" class=" table table-hover table-bordered admin-side-tables table-striped">
                                <h1 class="table_title"><?= $page_title ?></h1>
                                <thead>
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.user_name') ?></th>
                                        <th><?= lang('Admin.email') ?></th>
                                        <th><?= lang('Admin.phone') ?></th>
                                        <th><?= lang('Admin.gender') ?></th>
                                        <th><?= lang('Admin.blood_group') ?></th>
                                        <th><?= lang('Admin.location') ?></th>
                                        <th><?= lang('Admin.donation_available') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($blood_donors as $key => $blood_donor) : ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $blood_donor['username'] ?></td>
                                        <td><?= $blood_donor['email'] ?></td>
                                        <td><?= $blood_donor['phone'] ?></td>
                                        <td><?= $blood_donor['gender'] ?></td>
                                        <td><?= $blood_donor['blood_group'] ?></td>
                                        <td><?= $blood_donor['address'] ?></td>
                                        <td>
                                            <?php if ($blood_donor['donation_available'] == 1): ?>
                                                <span class='badge badge-success'><?= lang('Admin.yes') ?></span>
                                            <?php else: ?>
                                                <span class='badge badge-danger'><?= lang('Admin.no') ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
