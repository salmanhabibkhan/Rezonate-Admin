<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
        <!-- 1st row starts from here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <form action="<?= base_url('admin/jobs/update/' . $job['id']) ?>" method="post" id="edit_job" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_title"><?= lang('Admin.job_title') ?></label>
                                        <input type="text" class="form-control" name="job_title" value="<?= $job['job_title'] ?>" placeholder="<?= lang('Admin.job_title') ?>">
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?= !empty($validation->getError('job_title')) ? "<span class='text-danger'>" . $validation->getError('job_title') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_description"><?= lang('Admin.job_description') ?></label>
                                        <textarea name="job_description" class="form-control" rows="1" placeholder="<?= lang('Admin.job_description') ?>"><?= $job['job_description'] ?></textarea>
                                        <?= !empty($validation->getError('job_description')) ? "<span class='text-danger'>" . $validation->getError('job_description') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_location"><?= lang('Admin.job_location') ?></label>
                                        <input type="text" class="form-control" name="job_location" placeholder="<?= lang('Admin.job_location') ?>" value="<?= $job['job_location'] ?>">
                                        <?= !empty($validation->getError('job_location')) ? "<span class='text-danger'>" . $validation->getError('job_location') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category"><?= lang('Admin.job_category') ?></label>
                                        <select name="category" class="form-control">
                                            <option value=""><?= lang('Admin.select_job_category') ?></option>
                                            <?php foreach(JOB_CATEGORIES as $key=> $category): ?>
                                                <option value="<?= $key ?>" <?php if ($job['category'] == $key) { echo "selected"; } ?>><?= $category?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= !empty($validation->getError('category')) ? "<span class='text-danger'>" . $validation->getError('category') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="minimum_salary"><?= lang('Admin.minimum_salary') ?></label>
                                        <input type="text" class="form-control" name="minimum_salary" placeholder="<?= lang('Admin.minimum_salary') ?>" value="<?= $job['minimum_salary'] ?>">
                                        <?= !empty($validation->getError('minimum_salary')) ? "<span class='text-danger'>" . $validation->getError('minimum_salary') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maximum_salary"><?= lang('Admin.maximum_salary') ?></label>
                                        <input type="text" class="form-control" name="maximum_salary" placeholder="<?= lang('Admin.maximum_salary') ?>" value="<?= $job['maximum_salary'] ?>">
                                        <?= !empty($validation->getError('maximum_salary')) ? "<span class='text-danger'>" . $validation->getError('maximum_salary') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="salary_date"><?= lang('Admin.salary_date') ?></label>
                                        <input type="text" class="form-control" name="salary_date" placeholder="<?= lang('Admin.salary_date') ?>" value="<?= $job['salary_date'] ?>">
                                        <?= !empty($validation->getError('salary_date')) ? "<span class='text-danger'>" . $validation->getError('salary_date') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="currency"><?= lang('Admin.currency') ?></label>
                                        <select name="currency" class="form-control">
                                            <option value=""><?= lang('Admin.select_currency') ?></option>
                                            <?php foreach (CURRECY_ARRAY as $key => $currency): ?>
                                                <option value="<?= $currency ?>" <?php if ($currency == $job['currency']) { echo "selected"; } ?>>
                                                    <?= $currency ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= !empty($validation->getError('currency')) ? "<span class='text-danger'>" . $validation->getError('currency') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_urgent_hiring"><?= lang('Admin.is_urgent_hiring') ?></label>
                                        <select name="is_urgent_hiring" class="form-control">
                                            <option value="0"><?= lang('Admin.no') ?></option>
                                            <option value="1"><?= lang('Admin.yes') ?></option>
                                        </select>
                                        <?= !empty($validation->getError('is_urgent_hiring')) ? "<span class='text-danger'>" . $validation->getError('is_urgent_hiring') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="experience_years"><?= lang('Admin.experience_years') ?></label>
                                        <input type="text" class="form-control" name="experience_years" placeholder="<?= lang('Admin.experience_years') ?>" value="<?= $job['experience_years'] ?>">
                                        <?= !empty($validation->getError('experience_years')) ? "<span class='text-danger'>" . $validation->getError('experience_years') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name"><?= lang('Admin.company_name') ?></label>
                                        <input type="text" class="form-control" name="company_name" placeholder="<?= lang('Admin.company_name') ?>" value="<?= $job['company_name'] ?>">
                                        <?= !empty($validation->getError('company_name')) ? "<span class='text-danger'>" . $validation->getError('company_name') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_type"><?= lang('Admin.job_type') ?></label>
                                        <input type="text" class="form-control" name="job_type" placeholder="<?= lang('Admin.job_type') ?>" value="<?= $job['job_type'] ?>" disabled>
                                        <?= !empty($validation->getError('job_type')) ? "<span class='text-danger'>" . $validation->getError('job_type') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry_date"><?= lang('Admin.expiry_date') ?></label>
                                        <input type="date" class="form-control" name="expiry_date" placeholder="<?= lang('Admin.expiry_date') ?>" value="<?= $job['expiry_date'] ?>">
                                        <?= !empty($validation->getError('expiry_date')) ? "<span class='text-danger'>" . $validation->getError('expiry_date') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit') ?></button>
                                    <a href="<?= base_url('admin/jobs') ?>" class="btn btn-danger"><?= lang('Admin.cancel') ?></a>
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