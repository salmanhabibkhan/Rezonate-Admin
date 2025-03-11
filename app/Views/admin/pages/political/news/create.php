<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-primary">
                    <div class="card-body">
                        <form action="<?=base_url('admin/political-news/store')?>" method="post" enctype="multipart/form-data" id="create_news">
                            <div class="form-group">
                                <label for="title">News Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="News Title" required>
                                <?php  $validation = \Config\Services::validation();
                                        echo  !empty($validation->getError('title'))?"<span class='text-danger'>".$validation->getError('title')."</span> ":'';
                                    ?>
                            </div>
                            <div class="form-group">
                                <label for="attachment">Attachment</label>
                                <input type="file" class="form-control" name="attachment" id="attachment">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->include('admin/script') ?>
<?= $this->section('script') ?>
<?= $this->endSection() ?>
