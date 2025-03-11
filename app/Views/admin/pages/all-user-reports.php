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
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <h1 class="table_title"><?= $page_title ?></h1>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.from_user') ?></th>
                                        <th><?= lang('Admin.reported_user') ?></th>
                                        <th><?= lang('Admin.reason') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($report_users as $key => $report): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $report['from_user']['username'] ?></td>
                                        <td><?= $report['report_user']['username'] ?></td>
                                        <td><?= $report['reason'] ?></td>
                                        <td>
                                            <form action="<?= site_url('admin/report/user-action') ?>" method="post">
                                                <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                                                <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check-circle"></i> <?= lang('Admin.approve') ?>
                                                </button>
                                                <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> <?= lang('Admin.reject') ?>
                                                </button>
                                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-outline btn-sm">
                                                    <i class="fa fa-trash"></i> <?= lang('Admin.delete') ?>
                                                </button>
                                            </form>
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
