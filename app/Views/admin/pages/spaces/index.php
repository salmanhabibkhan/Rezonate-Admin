<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

    <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <h1 class="table_title"><?= $page_title ?></h1>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.username') ?></th>
                                        <th><?= lang('Admin.space_title') ?></th>
                                        <th><?= lang('Admin.paid_or_free') ?></th>
                                        <th><?= lang('Admin.ongoing_space') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($spaces as $key => $space): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $space['user']['username'] ?></td>
                                        <td><?= $space['title'] ?></td>
                                        <td><?= ($space['is_paid'] == 1) ? lang('Admin.paid') : lang('Admin.free') ?></td>
                                        <td>
                                            <?= ($space['status'] == 1) ? "<span class='badge badge-success'>" . lang('Admin.yes') . "</span>" : "<span class='badge badge-danger'>" . lang('Admin.no') . "</span>" ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/spaces/details/' . $space['id']) ?>" class="btn btn-sm btn-warning btn-wave text-light"><i class='fa fa-eye'></i> <?= lang('Admin.view') ?></a>
                                            <a href="<?= base_url('admin/spaces/delete/' . $space['id']) ?>" class="btn btn-sm btn-danger btn-wave" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')"><i class="fa fa-trash mr-2 text-light"></i><?= lang('Admin.delete') ?></a>
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
