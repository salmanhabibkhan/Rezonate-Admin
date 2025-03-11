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
                        <form action="<?= base_url('admin/events/store')?>" method="post" id="create_package">
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="">Event Name</label>
                                    <input type="text" class="form-control" name="name"  value="<?= old('name') ?>" placeholder="Page Title ">
                                    <?php  $validation = \Config\Services::validation();
                                        echo  !empty($validation->getError('name'))?"<span class='text-danger'>".$validation->getError('name')."</span> ":'';
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Event Description</label>
                                    <textarea name="description"  class="form-control" rows="1" placeholder="Event Description"></textarea>
                                    <?php
                                        echo  !empty($validation->getError('description'))?"<span class='text-danger'>".$validation->getError('description')."</span> ":'';
                                    ?>
                                </div>
                               
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="Location">
                                    <?php
                                        echo  !empty($validation->getError('location'))?"<span class='text-danger'>".$validation->getError('location')."</span> ":'';
                                    ?>

                                </div>
                                <div class="col-md-6">
                                    <label for=""> Url  </label>
                                    <input type="text" min="0" class="form-control" name="url" placeholder="Url ">
                                    <?php
                                        echo  !empty($validation->getError('url'))?"<span class='text-danger'>".$validation->getError('url')."</span> ":'';
                                    ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="">Start Date </label>
                                    <input type="date" class="form-control" name="start_date" placeholder="Start Date ">
                                    <?php
                                        echo  !empty($validation->getError('start_date'))?"<span class='text-danger'>".$validation->getError('start_date')."</span> ":'';
                                    ?>
                                </div>
                               
                                <div class="col-md-6">
                                    <label for=""> Start Time  </label>
                                    <input type="time" min="0" class="form-control" name="start_time" placeholder="Start Time ">
                                    <?php
                                        echo  !empty($validation->getError('start_time'))?"<span class='text-danger'>".$validation->getError('start_time')."</span> ":'';
                                    ?>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">End Date</label>
                                    <input type="date" class="form-control" name="end_date" placeholder="End Date">
                                    <?php
                                        echo  !empty($validation->getError('end_date'))?"<span class='text-danger'>".$validation->getError('end_date')."</span> ":'';
                                    ?>
                                </div>
                               
                                <div class="col-md-6">
                                    <label for="">End Time</label>
                                    <input type="time" class="form-control" name="end_time" placeholder="Share Amount">
                                    <?php
                                        echo  !empty($validation->getError('end_time'))?"<span class='text-danger'>".$validation->getError('end_time')."</span> ":'';
                                    ?>
                                </div>

                            </div>
                            <div class="row mt-2">
                            <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"> Submit</button>
                                    <a href="<?= base_url('admin/events')?>" class="btn btn-danger"> Cancel </a>
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script  >
$(document).ready(function () {
        $("#create_package").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 6
                },
                like_amount: {
                    required: true
                },
                share_amount: {
                    required: true,
                    min: 0
                },
                comment_amount: {
                    required: true,
                    min: 0
                },
                po_comment_amount: {
                    required: true,
                    min: 0
                },
                po_share_amount: {
                    required: true,
                    min: 0
                },
                po_like_amount: {
                    required: true,
                    min: 0
                },
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>