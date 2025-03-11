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
                <h1 class="h4 card-title mb-0"><?= lang('Web.edit_job') ?></h1>
            </div>
            <!-- Title END -->
            <!-- Edit Job form START -->
            <div class="card-body">
                <form id="editJobForm" class="row g-3" method="post" enctype="multipart/form-data">
                    <!-- Add a hidden input for job ID -->
                    <input type="hidden" name="job_id" value="<?= esc($job['id']) ?>">

                    <!-- Job Title -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.job_title') ?></label>
                        <input type="text" class="form-control" id="job_title" name="job_title" placeholder="<?= lang('Web.job_title_required') ?>" value="<?= esc($job['job_title']) ?>">
                    </div>

                    <!-- Job Description -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.job_description') ?></label>
                        <textarea class="form-control" id="job_description" name="job_description" rows="3" placeholder="<?= lang('Web.job_description_required') ?>"><?= esc($job['job_description']) ?></textarea>
                    </div>

                    <!-- Job Location -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.job_location') ?></label>
                        <input type="text" class="form-control" id="job_location" name="job_location" placeholder="<?= lang('Web.job_location_required') ?>" value="<?= esc($job['job_location']) ?>">
                    </div>

                    <!-- Salary Information -->
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.salary_date') ?></label>
                        <select name="salary_date" id="" class="form-control">
                            <option value="month" <?= ($job['salary_date']=='month')?'selected':'' ?>><?= lang('Web.month') ?></option>
                            <option value="week" <?= ($job['salary_date']=='week')?'selected':'' ?>><?= lang('Web.week') ?></option>
                            <option value="hour" <?= ($job['salary_date']=='hour')?'selected':'' ?>><?= lang('Web.hour') ?></option>
                            <option value="year" <?= ($job['salary_date']=='year')?'selected':'' ?>><?= lang('Web.year') ?></option>
                            <option value="day" <?= ($job['salary_date']=='day')?'selected':'' ?>><?= lang('Web.day') ?></option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.currency') ?></label>
                        <select class="form-control" id="currency" name="currency">
                            <?php foreach (CURRECY_ARRAY as $currency) : ?>
                               <option value="<?=$currency?>" <?= ($currency==$job['currency']) ? 'selected':''?>><?=$currency?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.minimum_salary') ?></label>
                        <input type="number" class="form-control" id="minimum_salary" name="minimum_salary" placeholder="<?= lang('Web.minimum_salary') ?>" value="<?= esc($job['minimum_salary']) ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.maximum_salary') ?></label>
                        <input type="number" class="form-control" id="maximum_salary" name="maximum_salary" placeholder="<?= lang('Web.maximum_salary') ?>" value="<?= esc($job['maximum_salary']) ?>">
                    </div>

                    <!-- Job Type -->
                    <div class="col-12">
                        <label for="job_type" class="form-label"><?= lang('Web.job_type') ?></label>
                        <select class="form-select" id="job_type" name="job_type" required>
                            <option value="" selected><?= lang('Web.select_job_type') ?></option>
                            <option value="fulltime" <?= $job['job_type'] == 'fulltime' ? 'selected' : '' ?>><?= lang('Web.full_time') ?></option>
                            <option value="parttime" <?= $job['job_type'] == 'parttime' ? 'selected' : '' ?>><?= lang('Web.part_time') ?></option>
                            <option value="internship" <?= $job['job_type'] == 'internship' ? 'selected' : '' ?>><?= lang('Web.internship') ?></option>
                            <option value="volunteer" <?= $job['job_type'] == 'volunteer' ? 'selected' : '' ?>><?= lang('Web.volunteer') ?></option>
                            <option value="contract" <?= $job['job_type'] == 'contract' ? 'selected' : '' ?>><?= lang('Web.contract') ?></option>
                        </select>
                    </div>

                    <!-- Job Category -->
                    <div class="col-12">
                        <label for="category" class="form-label"><?= lang('Web.category') ?></label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="" selected><?= lang('Web.select_category') ?></option>
                            <?php foreach ($categories as $key => $category) : ?>
                                    <option value="<?= $category['id'] ?>" 
                                    <?php if($category['id'] == $job['category']): ?>
                                        selected
                                    <?php endif; ?>
                                    ><?= $category['name'] ?></option>
                                <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback"><?= lang('Web.validation_category_required') ?></div>
                    </div>

                    <!-- Company Name -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.company_name') ?></label>
                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="<?= lang('Web.company_name') ?>" value="<?= esc($job['company_name']) ?>">
                    </div>

                    <!-- Urgent Hiring -->
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_urgent_hiring" name="is_urgent_hiring" <?= $job['is_urgent_hiring'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_urgent_hiring">
                                <?= lang('Web.urgent_hiring') ?>
                            </label>
                        </div>
                    </div>

                    <!-- Experience Years -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.experience_years') ?></label>
                        <input type="number" class="form-control" id="experience_years" name="experience_years" placeholder="<?= lang('Web.experience_years_placeholder') ?>" value="<?= esc($job['experience_years']) ?>" maxlength="2">
                    </div>

                    <!-- Active Checkbox -->
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?= $job['is_active'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                <?= lang('Web.active') ?>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary mb-0"><?= lang('Web.update_job_button') ?></button>
                    </div>
                </form>
            </div>
            <!-- Edit Job form END -->
        </div>
        <!-- Card END -->
    </div>
    <!-- Main content END -->
</div> <!-- Row END -->

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        var form = $('#editJobForm');

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
                    number: true
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
                    number: "<?= lang('Web.validation_experience_years_number') ?>"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/update-job', 
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert("<?= lang('Web.job_updated_successfully') ?>");
                        setTimeout(() => {
                            window.location.href = site_url + 'jobs/my-jobs';
                        }, 3000);
                    },
                    error: function() {
                        alert("<?= lang('Web.job_update_error') ?>");
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
