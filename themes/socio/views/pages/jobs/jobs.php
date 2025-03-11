<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php echo $this->include('partials/banner_jobs.php') ?>

<div class="container">
    <div class="row g-3 mt-1">
        <?php echo $this->include('partials/sidebar_jobs') ?>
        <div class="col-md-8 col-lg-6 vstack gap-3">

            <div class="content-tabs card rounded shadow-sm clearfix">
                <ul class="clearfix m-0 p-1">
                    <li class="active"> <a href="<?= site_url('jobs'); ?>"><?= lang('Web.jobs') ?></a></li>
                    <li> <a href="<?= site_url('jobs/my-jobs'); ?>"><?= lang('Web.my_jobs') ?></a></li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header border-0 border-bottom">
                    <div class="row g-2">
                        <div class="col-lg-7">
                            <h1 class="h4 card-title mb-lg-0"><?= lang('Web.jobs') ?></h1>
                        </div>
                        <div class="col-lg-5">
                            <!-- Sorting Dropdown -->
                            <div class="float-end">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-bars fa-fw"></i> <?= lang('Web.sort') ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="sortingDropdown">
                                        <li><a class="dropdown-item" href="?sort=latest"><?= lang('Web.latest') ?></a></li>
                                        <li><a class="dropdown-item" href="?sort=salary-high"><?= lang('Web.salary_high_to_low') ?></a></li>
                                        <li><a class="dropdown-item" href="?sort=salary-low"><?= lang('Web.salary_low_to_high') ?></a></li>
                                    </ul>
                                </div>
                            </div>

                        
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <!-- Jobs Listing -->
                    <div class="row">
                        <?php if (!empty($jobs)) : ?>
                            <?php foreach ($jobs as $job) : ?>
                                <div class="job-item p-4 border-bottom">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                            <div class="text-start ps-4">
                                                <h5 class="mb-3"><a href="<?= site_url('jobs/detail/' . $job['id']) ?>"><?= $job['job_title'] ?></a></h5>
                                                <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?= $job['job_location'] ?></span>
                                                <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?= ucfirst($job['job_type']) ?></span>
                                                <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i> <?= $job['minimum_salary'] ?> - <?= $job['maximum_salary'] ?> / <?= $job['currency'] ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                            <div class="d-flex mb-3">
                                                <?php if ($job['is_applied']) : ?>
                                                    <button class="btn btn-primary" data-toggle="modal">
                                                        <i class="bi bi-check mr5"></i><?= lang('Web.applied') ?>
                                                    </button>
                                                <?php else : ?>
                                                    <a class="btn btn-sm btn-info js_job-apply" data-toggle="modal" href="<?= site_url('jobs/apply/' . $job['id']) ?>">
                                                        <i class="fa fa-user-tie mr5"></i><?= lang('Web.apply_now') ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i><?= lang('Web.created_at') ?>: <?= $job['created_at'] ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="row">
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-briefcase"></i>
                                    <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_jobs_found') ?></h4>
                                    <!-- <a href="<?= site_url('jobs'); ?>" title=""><?= lang('Web.list_all_jobs') ?></a> -->
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                        <nav aria-label="<?= lang('Web.job_pagination') ?> border-top mt-2">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item mx-2 <?= ($i == $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= site_url('jobs?page=' . $i) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
