<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

    <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary table-card">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                               <h1 class="table_title"><?= $page_title ?></h1>
                                <a href="<?= base_url('admin/games/create')?>" class="btn btn-success btn-sm mb-3 float-right">
                                    <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.create_new_game') ?>
                                </a>
                               </div>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.name') ?></th>
                                        <th><?= lang('Admin.description') ?></th>
                                        <th><?= lang('Admin.link') ?></th>
                                        <th><?= lang('Admin.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($games as $key => $game): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $game['name'] ?></td>
                                        <td title="<?=$game['description']?>"><?= (strlen($game['description']) > 30) ? substr($game['description'], 0, 30) . '...' : $game['description']; ?>
                                        </td>
                                        <td><?= $game['link'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/games/edit/'.$game['id'])?>" ">
                                                <button class="btn btn-sm btn-primary btn-wave">
                                                    <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                                </button>
                                            </a>
                                            <a href="<?= base_url('admin/games/delete/'.$game['id'])?>" onclick="return confirm('<?= lang('Admin.confirm_delete_game') ?>')">
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
