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
                        <form action="<?= base_url('admin/jobs/update/' . $job['id']) ?>" method="post" id="edit_job" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_title">Job Title</label>
                                        <input type="text" class="form-control" name="job_title" value="<?= $job['job_title'] ?>" placeholder="Job Title" >
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?= !empty($validation->getError('job_title')) ? "<span class='text-danger'>" . $validation->getError('job_title') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_description">Job Description</label>
                                        <textarea name="job_description" class="form-control" rows="1" placeholder="Job Description" ><?= $job['job_description'] ?></textarea>
                                        <?php echo !empty($validation->getError('job_description')) ? "<span class='text-danger'>" . $validation->getError('job_description') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_location">Job Location</label>
                                        <input type="text" class="form-control" name="job_location" placeholder="Job Location" value="<?= $job['job_location'] ?>" >
                                        <?php echo !empty($validation->getError('job_location')) ? "<span class='text-danger'>" . $validation->getError('job_location') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Job  Category</label>
                                   
                                        <select name="category" class="form-control">
                                            <option value=""> Select page category</option>
                                            <?php foreach(JOB_CATEGORIES as $key=> $category): ?>
                                                <option value="<?= $key ?>" <?php if ($job['category'] == $key) { echo "selected"; } ?>><?= $category?></option>
                                            <?php endforeach; ?>

                                        </select>
                                        <?php echo !empty($validation->getError('category')) ? "<span class='text-danger'>" . $validation->getError('category') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="minimum_salary">Minimum Salary</label>
                                        <input type="text" class="form-control" name="minimum_salary" placeholder="Minimum Salary" value="<?= $job['minimum_salary'] ?>" >
                                        <?php echo !empty($validation->getError('minimum_salary')) ? "<span class='text-danger'>" . $validation->getError('minimum_salary') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maximum_salary">Maximum Salary</label>
                                        <input type="text" class="form-control" name="maximum_salary" placeholder="Maximum Salary" value="<?= $job['maximum_salary'] ?>" >
                                        <?php echo !empty($validation->getError('maximum_salary')) ? "<span class='text-danger'>" . $validation->getError('maximum_salary') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary_date">Salary Date</label>
                                        <input type="text" class="form-control" name="salary_date" placeholder="Salary Date" value="<?= $job['salary_date'] ?>" >
                                        <?php echo !empty($validation->getError('salary_date')) ? "<span class='text-danger'>" . $validation->getError('salary_date') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="currency">Currency</label>
                                        <select name="currency" class="form-control">
                                            <option value="">Select page category</option>
                                            <?php foreach (CURRECY_ARRAY as $key => $currency): ?>
                                                <option value="<?= $currency ?>" <?php if ($currency == $job['currency']) { echo "selected"; } ?>>
                                                    <?= $currency ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo !empty($validation->getError('currency')) ? "<span class='text-danger'>" . $validation->getError('currency') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_urgent_hiring">Is Urgent Hiring</label>
                                        <select name="is_urgent_hiring" id="" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>

                                        </select>
                                        <?php echo !empty($validation->getError('is_urgent_hiring')) ? "<span class='text-danger'>" . $validation->getError('is_urgent_hiring') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="experience_years">Experience Years</label>
                                        <input type="text" class="form-control" name="experience_years" placeholder="Experience Years" value="<?= $job['experience_years'] ?>" >
                                        <?php echo !empty($validation->getError('experience_years')) ? "<span class='text-danger'>" . $validation->getError('experience_years') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="<?= $job['company_name'] ?>" >
                                        <?php echo !empty($validation->getError('company_name')) ? "<span class='text-danger'>" . $validation->getError('company_name') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_type">Job Type</label>
                                        <input type="text" class="form-control" name="job_type" placeholder="Job Type" value="<?= $job['job_type'] ?>" disabled>
                                        <?php echo !empty($validation->getError('job_type')) ? "<span class='text-danger'>" . $validation->getError('job_type') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="date" class="form-control" name="expiry_date" placeholder="Expiry Date" value="<?= $job['expiry_date'] ?>" >
                                        <?php echo !empty($validation->getError('expiry_date')) ? "<span class='text-danger'>" . $validation->getError('expiry_date') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="<?= base_url('your_controller/job_list') ?>" class="btn btn-danger">Cancel</a>
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
<script>
    $(document).ready(function() {
        $("#edit_job").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid',
            rules: {
                job_title: {
                   required : true
                },
                job_description: {
                   required : true
                },
                job_location: {
                   required : true
                },
                category: {
                   required : true
                },
                minimum_salary: {
                   required : true
                },
                maximum_salary: {
                   required : true
                },
                lon: {
                   required : true
                },
                salary_date: {
                   required : true
                },
                currency: {
                   required : true
                },
                lat: {
                   required : true
                },
                is_urgent_hiring: {
                   required : true
                },
                experience_years: {
                   required : true
                },
                company_name: {
                   required : true
                },
                job_type: {
                   required : true
                },
               
                // Add more rules for additional fields as needed
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>


<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>