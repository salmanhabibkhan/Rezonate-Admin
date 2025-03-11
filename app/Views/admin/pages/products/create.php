<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">


    <!-- 1st row starts from here -->
        <div class="row">
          
            <div class="col-md-6 offset-md-3">
           
                <div class="card card-primary">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        <form action="<?= base_url('admin/gifts/store')?>" method="post" id="create_gift" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="">Gift Name</label>
                                    <input type="text" class="form-control" name="name"  value="<?= old('name') ?>" placeholder="Gift Name ">
                                    <?php  $validation = \Config\Services::validation();
                                        echo  !empty($validation->getError('name'))?"<span class='text-danger'>".$validation->getError('name')."</span> ":'';
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="">Gift Image</label>
                                    <input type="file" class="form-control" name="image"  value="<?= old('image') ?>" placeholder="Image ">
                                    <?php  $validation = \Config\Services::validation();
                                        echo  !empty($validation->getError('image'))?"<span class='text-danger'>".$validation->getError('image')."</span> ":''; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="">Gift price</label>
                                    <input type="number" class="form-control" name="price"  value="<?= old('price') ?>" placeholder="Gift Price "  step="0.01">
                                    <?php  $validation = \Config\Services::validation();
                                        echo  !empty($validation->getError('price'))?"<span class='text-danger'>".$validation->getError('Gift Price')."</span> ":'';
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary"> Submit</button>
                                        <a href="<?= base_url('admin/gifts')?>" class="btn btn-danger"> Cancel </a>
                                </div>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('script') ?>


<!-- Include jQuery Validation Plugin -->

<script  >
$(document).ready(function () {
        $("#create_gift").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                name: {
                    required: true
                },
                image: {
                    required: true,
                },
                price: {
                    required: true
                }
            },
           
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>