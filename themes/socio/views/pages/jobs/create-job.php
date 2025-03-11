<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">

    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 col-lg-6 vstack gap-4">
        <!-- Card START -->
        <div class="card">
            <!-- Title START -->
            <div class="card-header border-0 pb-0">
                <h1 class="h4 card-title mb-0"><?= lang('Web.create_job') ?></h1>
            </div>
            <!-- Title END -->
            <!-- Create a Job form START -->
            <div class="card-body">
                <form id="createJobForm" class="row g-3" method="post" enctype="multipart/form-data">
                    <!-- Job Title -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.job_title') ?></label>
                        <input type="text" class="form-control" id="job_title" name="job_title" placeholder="<?= lang('Web.job_title_required') ?>">
                    </div>

                    <!-- Job Description -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.job_description') ?></label>
                        <textarea class="form-control" id="job_description" name="job_description" rows="3" placeholder="<?= lang('Web.job_description_required') ?>"></textarea>
                    </div>

                    <!-- Job Location -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.job_location') ?></label>
                        <input type="text" class="form-control" id="job_location" name="job_location" placeholder="<?= lang('Web.job_location_required') ?>">
                    </div>

                    <!-- Salary Information -->
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.salary_date') ?></label>
                        <select name="salary_date" class="form-control">
                            <option value="month"><?= lang('Web.month') ?></option>
                            <option value="week"><?= lang('Web.week') ?></option>
                            <option value="hour"><?= lang('Web.hour') ?></option>
                            <option value="year"><?= lang('Web.year') ?></option>
                            <option value="day"><?= lang('Web.day') ?></option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.currency') ?></label>
                        <select class="form-control" id="currency" name="currency">
                            <?php foreach (CURRECY_ARRAY as $currency) : ?>
                               <option value="<?=$currency?>"><?=$currency?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.minimum_salary') ?></label>
                        <input type="number" class="form-control" id="minimum_salary" name="minimum_salary" placeholder="<?= lang('Web.minimum_salary') ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.maximum_salary') ?></label>
                        <input type="number" class="form-control" id="maximum_salary" name="maximum_salary" placeholder="<?= lang('Web.maximum_salary') ?>">
                    </div>

                    <!-- Job Type -->
                    <div class="col-12">
                        <label for="job_type" class="form-label"><?= lang('Web.job_type') ?></label>
                        <select class="form-select" id="job_type" name="job_type" required>
                            <option value="" selected><?= lang('Web.select_job_type') ?></option>
                            <option value="fulltime"><?= lang('Web.full_time') ?></option>
                            <option value="parttime"><?= lang('Web.part_time') ?></option>
                            <option value="internship"><?= lang('Web.internship') ?></option>
                            <option value="volunteer"><?= lang('Web.volunteer') ?></option>
                            <option value="contract"><?= lang('Web.contract') ?></option>
                        </select>
                    </div>

                    <!-- Job Category -->
                    <div class="col-12">
                        <label for="category" class="form-label"><?= lang('Web.category') ?></label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="" selected><?= lang('Web.select_category') ?></option>
                            <?php foreach ($categories as $key => $category) : ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback"><?= lang('Web.validation_category_required') ?></div>
                    </div>

                    <!-- Company Name -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.company_name') ?></label>
                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="<?= lang('Web.company_name') ?>">
                    </div>

                    <!-- Urgent Hiring -->
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_urgent_hiring" name="is_urgent_hiring">
                            <label class="form-check-label" for="is_urgent_hiring"><?= lang('Web.urgent_hiring') ?></label>
                        </div>
                    </div>

                    <!-- Experience Years -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.experience_years') ?></label>
                        <input type="number" class="form-control" id="experience_years" name="experience_years" placeholder="<?= lang('Web.experience_years_placeholder') ?>" maxlength="2">
                    </div>

                    <!-- Active Checkbox -->
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active"><?= lang('Web.active') ?></label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary mb-0"><?= lang('Web.create_job_button') ?></button>
                    </div>
                </form>
            </div>
            <!-- Create a Job form END -->
        </div>
        <!-- Card END -->
    </div>
    <!-- Main content END -->
</div> <!-- Row END -->

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        var form = $('#createJobForm');

        form.validate({
            rules: {
                job_title: {
                    required: true,
                    minlength: 5,
                    maxlength: 50
                },
                job_description: {
                    required: true
                },
                job_location: {
                    required: true
                },
                salary_date: {
                    required: true
                },
                currency: {
                    required: true
                },
                minimum_salary: {
                    required: true,
                    number: true
                },
                maximum_salary: {
                    required: true,
                    number: true
                },
                job_type: {
                    required: true
                },
                category: {
                    required: true
                },
                company_name: {
                    required: true
                },
                experience_years: {
                    required: true,
                    number: true,
                    maxlength: 2
                }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            messages: {
                job_title: {
                    required: "<?= lang('Web.validation_job_title_required') ?>",
                    minlength: "<?= lang('Web.validation_job_title_minlength') ?>",
                    maxlength: "<?= lang('Web.validation_job_title_maxlength') ?>"
                },
                job_description: "<?= lang('Web.validation_job_description_required') ?>",
                job_location: "<?= lang('Web.validation_job_location_required') ?>",
                salary_date: "<?= lang('Web.validation_salary_date_required') ?>",
                currency: "<?= lang('Web.validation_currency_required') ?>",
                minimum_salary: "<?= lang('Web.validation_minimum_salary_required') ?>",
                maximum_salary: "<?= lang('Web.validation_maximum_salary_required') ?>",
                job_type: "<?= lang('Web.validation_job_type_required') ?>",
                category: "<?= lang('Web.validation_category_required') ?>",
                company_name: "<?= lang('Web.validation_company_name_required') ?>",
                experience_years: {
                    required: "<?= lang('Web.validation_experience_years_required') ?>",
                    number: "<?= lang('Web.validation_experience_years_number') ?>",
                    maxlength: "<?= lang('Web.validation_experience_years_maxlength') ?>"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('web_api/store-job') ?>', 
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert("<?= lang('Web.job_created_successfully') ?>");
                        setTimeout(() => {
                            window.location.href = '<?= site_url('jobs/my-jobs') ?>';
                        }, 3000);
                    },
                    error: function() {
                        alert("<?= lang('Web.job_creation_error') ?>");
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
