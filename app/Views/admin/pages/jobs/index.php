<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h1 class="table_title"><?= $page_title ?></h1>
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <thead>
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.username') ?></th>
                                        <th><?= lang('Admin.job_title') ?></th>
                                        <th><?= lang('Admin.job_description') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($jobs as $key => $job): ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td><?= $job['username'] ?></td>
                                            <td><?= $job['job_title'] ?></td>
                                            <td><?= $job['job_description'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/jobs/applicants/' . $job['id']) ?>">
                                                    <i class='fa fa-users text-warning'></i>
                                                </a>
                                                <a href="<?= base_url('admin/jobs/edit/' . $job['id']) ?>">
                                                    <button class="btn btn-sm btn-primary btn-wave">
                                                        <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                                    </button>
                                                </a>
                                                <a href="<?= base_url('admin/jobs/delete/' . $job['id']) ?>" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')">
                                                    <button class="btn btn-sm btn-danger btn-wave">
                                                        <i class="fa fa-trash mr-2 text-light"></i> <?= lang('Admin.delete') ?>
                                                    </button>
                                                </a>
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
