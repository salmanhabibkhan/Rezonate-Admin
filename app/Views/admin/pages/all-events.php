<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary table-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h1 class="table_title"><?= $page_title ?></h1>
                                    <!-- <a href="<?= base_url('admin/events/create')?>" class="btn btn-success btn-sm mb-3 float-right"> <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.create_new_event') ?></a> -->
                                </div>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.username') ?></th>
                                        <th><?= lang('Admin.event_name') ?></th>
                                        <th><?= lang('Admin.event_location') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $key => $event): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $event['username'] ?></td>
                                        <td><?= $event['name'] ?></td>
                                        <td><?= $event['location'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/events/details/'.$event['id']) ?>" class="btn btn-warning btn-sm text-light"><i class='fa fa-eye '></i><?= lang('Admin.view_details'); ?></a>
                                            <a href="<?= base_url('admin/events/edit/'.$event['id']) ?>"><button class="btn btn-sm btn-primary btn-wave">
                                                <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                            </button></a>
                                            <a href="<?= base_url('admin/events/delete/'.$event['id']) ?>" class="btn btn-sm btn-danger btn-wave" onclick="return confirm('<?= lang('Admin.confirm_delete_event') ?>')">
                                                <i class="fa fa-trash mr-2 text-light"></i> <?= lang('Admin.delete') ?>
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
