<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php echo $this->include('partials/banner_jobs.php') ?>
<div class="row g-3 mt-1">
    <?php echo $this->include('partials/sidebar_jobs') ?>
    <div class="col-md-8 col-lg-6 vstack gap-4">
    <div class="card">
                <div class="card-header">
                    <h2><?= $job['job_title'] ?></h2>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="<?= site_url('themes/socio/assets/images/talent-search.png') ?>" alt="<?= $job['job_title'] ?>" class="img-fluid mb-3">
                    </div>

                    <div class="d-flex text-center p-3 m-2 border rounded bg-light">
                        <!-- Location Details -->
                        <div class="col border-end">
                            <div class="title">
                                <i class="fa fa-map-marker fa-fw mr5" style="color: #1f9cff;"></i><?= lang('Web.location') ?>
                            </div>
                            <div class="description">
                                <?= $job['job_location'] ?>
                            </div>
                        </div>

                        <!-- Job Type Details -->
                        <div class="col border-end">
                            <div class="title">
                                <i class="fa fa-briefcase fa-fw mr5" style="color: #2bb431;"></i><?= lang('Web.type') ?>
                            </div>
                            <div class="description">
                                <?= ucfirst($job['job_type']) ?>
                            </div>
                        </div>

                        <!-- Job Status Details -->
                        <div class="col">
                            <div class="title">
                                <i class="fa fa-clock fa-fw mr5" style="color: #a038b2;"></i><?= lang('Web.status') ?>
                            </div>
                            <div class="description">
                                <span class="badge <?= ($job['is_active']) ? 'bg-success' : 'bg-danger' ?>">
                                    <?= ($job['is_active']) ? lang('Web.open') : lang('Web.closed') ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 m-2 border rounded bg-light">
                            <h5><?= lang('Web.description') ?></h5>
                            <p><?= $job['job_description'] ?></p>
                    </div>

                    <ul class="list-unstyled my-2 mx-2 border p-4 rounded">
                        <li class="d-flex justify-content-between pb-2 border-bottom">
                            <strong><?= lang('Web.job_type') ?>:</strong>
                            <span class="text-end"><?= ucfirst($job['job_type']) ?></span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <strong><?= lang('Web.salary') ?>:</strong>
                            <span class="text-end"><?= $job['minimum_salary'] ?> - <?= $job['maximum_salary'] ?> / <?= $job['salary_date'] ?></span>
                        </li>
                        
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <strong><?= lang('Web.experience_required') ?>:</strong>
                            <span class="text-end"><?= $job['experience_years'] ?></span>
                        </li>
                        <li class="d-flex justify-content-between pt-2">
                            <strong><?= lang('Web.application_deadline') ?>:</strong>
                            <span class="text-end"><?= date("F j, Y", strtotime($job['expiry_date'])) ?></span>
                        </li>
                    </ul>

                </div>
                <?php if($job['user_id'] != getCurrentUser()['id']): ?>
                
                    <div class="card-footer">
                        <?php if($job['is_applied']): ?>
                            <button class="btn btn-success"> <i class="bi bi-check-circle-fill"></i> <?= lang('Web.already_applied') ?></button>
                        <?php else: ?>
                            <a href="<?= site_url('jobs/apply/' . $job['id']) ?>" class="btn btn-primary"> <i class="fa fa-plus-circle"></i> <?= lang('Web.apply_now') ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
    </div>
</div>
<?= $this->endSection() ?>
