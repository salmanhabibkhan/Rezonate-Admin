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
                        <form action="<?= base_url('admin/pages/store')?>" method="post" enctype="multipart/form-data" id="create_page">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Page Title</label>
                                    <input type="text" class="form-control" name="page_title" placeholder="Page Title ">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Page User Name</label>
                                    <input type="text" class="form-control" name="page_username" placeholder="Page User Name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" placeholder="Facebook Link">
                                </div>
                                <div class="col-md-6">
                                    <label for=""> Website </label>
                                    <input type="text" class="form-control" name="website" placeholder="Website Link">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Page Cover</label>
                                    <input type="file" class="form-control" name="cover" >
                                </div>
                                <div class="col-md-6">
                                    <label for=""> Page Avatar</label>
                                    <input type="file" class="form-control" name="avatar" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Page Background</label>
                                    <input type="file" class="form-control" name="page_background" >
                                </div>
                                <div class="col-md-6">
                                    <label for="">Page Categories</label>
                                    <select name="page_category" class="form-control">
                                        <option value=""> Select page category</option>
                                        <?php foreach(PAGE_CATEGORIES as $key=> $category): ?>
                                            <option value="<?= ++$key ?>"><?= $category?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Company</label>
                                    <input type="text" class="form-control" name="company"  placeholder="Enter Company Email Address">
                                </div>
                                <div class="col-md-6">
                                    <label for=""> Page Descripiton</label>
                                    <textarea name="page_description" rows="1 " class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                            <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"> Submit</button>
                                    <a href="<?= base_url('admin/pages')?>" class="btn btn-danger"> Cancel </a>
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
        $("#create_page").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                page_title: {
                    required: true
                },
                page_username: {
                    required: true,
                    minlength: 6
                },
                page_category: {
                    required: true
                },
               
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>