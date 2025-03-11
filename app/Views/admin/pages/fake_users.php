<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">


    <!-- 1st row starts from here -->
        <div class="row">

            <!-- 1st row 1st column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Fake User Generator</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    
                    <form action="<?= site_url('admin/manage-fake-users') ?>" method="post">
                        <div class="form-group">
                            <label for="user_links_limit">Number of user want to create</label>
                            <input type="number" name="user_limit" class="form-control" required min="10" max="500">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Password</label>
                            <input type="password" id="pasword" class="form-control"  placeholder="***********">
                        </div>


                        <label for="avatar">Create Random Avatar?</label>

                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="avatar" id="avatar-enabled" value="1">
                                <label class="form-check-label" for="avatar-enabled">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="avatar" id="avatar-disabled" value="0" checked="">
                                <label class="form-check-label" for="avatar-disabled">No</label>
                            </div>
                        </div>
                        
                        <button type="submit" name="action" value="generate" class="btn btn-danger">Generate Fake Users</button>
                        <button type="submit" name="action" value="delete" class="btn btn-success">Delete Fake Users</button>
                    </form>
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