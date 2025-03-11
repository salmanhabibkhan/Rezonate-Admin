<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
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
                                    <small></small>
                                    <a href="<?= base_url('admin/movies/create')?>" class="btn btn-success btn-sm mb-3 float-right">
                                        <i class="fa fa-plus mr-2 text-light"></i> <?= lang('Admin.create_new_movie') ?>
                                    </a>
                                </div>
                                <thead class="">
                                    <tr>
                                        <th><?= lang('Admin.id') ?></th>
                                        <th><?= lang('Admin.name') ?></th>
                                        <th><?= lang('Admin.type') ?></th>
                                        <th><?= lang('Admin.stars') ?></th>
                                        <th><?= lang('Admin.producer') ?></th>
                                        <th><?= lang('Admin.duration') ?></th>
                                        <th><?= lang('Admin.actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($movies as $key => $movie): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $movie['movie_name'] ?></td>
                                        <td><?= $movie['genre'] ?></td>
                                        <td><?= $movie['stars'] ?></td>
                                        <td><?= $movie['producer'] ?></td>
                                        <td><?= $movie['duration'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/movies/edit/'.$movie['id'])?>">
                                                <button class="btn btn-sm btn-primary btn-wave">
                                                    <i class="fa fa-pen mr-2 text-light"></i> <?= lang('Admin.edit') ?>
                                                </button>
                                            </a>
                                            <a href="<?= base_url('admin/movies/delete/'.$movie['id'])?>" onclick="return confirm('<?= lang('Admin.confirm_delete') ?>')">
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
