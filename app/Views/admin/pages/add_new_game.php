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
                        <h3 class="card-title">Add New Game</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    
                        <div class="form-group">
                            <label for="user_links_limit">Game URL</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Game Image URL</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>
                        
                        <div class="form-group">
                            <label for="user_links_limit">Game Name</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>


                        <button class="btn btn-danger"> Submit</button>
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