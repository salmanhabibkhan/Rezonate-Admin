<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                                    <thead>
                                        <tr>
                                            <th><?= lang('Admin.id') ?></th>
                                            <th><?= lang('Admin.from_user') ?></th>
                                            <th><?= lang('Admin.ad_title') ?></th>
                                            <th><?= lang('Admin.image') ?></th>
                                            <th><?= lang('Admin.status') ?></th>
                                            <!-- <th><?= lang('Admin.action') ?></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($postadvertisements)>0) : ?>
                                            <?php foreach ($postadvertisements as $key=> $advertisement) : ?>
                                                <tr>
                                                    <td><?= ++$key?></td>
                                                    <td><?= $advertisement['from_user']['username'] ?></td>
                                                    <td><?= $advertisement['title'] ?></td>
                                                    <td><img src="<?= getMedia($advertisement['title']) ?>" alt="<?= lang('Admin.ad_image') ?>" style="width:100px"></td>
                                             
                                                    <td>
                                                        <?php if ($advertisement['status']==1) : ?>
                                                            <span class="badge badge-primary"><?= lang('Admin.pending') ?></span>
                                                        <?php elseif($advertisement['status']==2): ?>
                                                            <span class="badge badge-success"><?= lang('Admin.approved') ?></span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger"><?= lang('Admin.rejected') ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <!-- <td>
                                                        <a href="<?= base_url('admin/post-advertisement/delete/' . $advertisement['id']) ?>" class="btn btn-sm btn-danger btn-wave">
                                                            <i class="fa fa-trash text-light"></i>
                                                            <?= lang('Admin.delete') ?>
                                                        </a>
                                                    </td> -->
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6"> <span class="text-center text-danger" style="text-align: center;"><?= lang('Admin.no_advertisement_found') ?></span></td>
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
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
