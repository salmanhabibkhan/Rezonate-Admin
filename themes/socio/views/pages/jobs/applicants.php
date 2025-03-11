<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="pt-5 pb-0 position-relative"
    style="background-image: url(<?= load_asset('images/jobs.jpg') ?>); background-repeat: no-repeat; background-size: cover; background-position: top center;">
    <div class="bg-overlay bg-dark opacity-8"></div>
    <!-- Container START -->
    <div class="container">
        <div class="py-5">
            <div class="row position-relative">
                <div class="col-lg-9 mx-auto">
                    <div class="text-center">
                        <!-- Title -->
                        <h1 class="text-white"><?= lang('Web.jobs') ?></h1>
                        <p class="text-white"><?= lang('Web.discover_jobs') ?></p>
                    </div>
                    <div class="mx-auto bg-mode shadow rounded p-4 mt-5">
                        <!-- Form START -->
                        <form class="row align-items-end g-4" action="<?= site_url('jobs') ?>">

                            <!-- Search -->
                            <div class="col-sm-6 col-lg-10">
                                <input type="text" autocomplete="off" name="search" placeholder="<?= lang('Web.search_jobs') ?>"
                                    class="form-control" value="">
                            </div>
                            <!-- Search Button -->
                            <div class="col-sm-6 col-lg-2">
                                <a class="btn btn-primary w-100" href="#"><?= lang('Web.search') ?></a>
                            </div>
                        </form>
                        <!-- Form END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row g-3 mt-1">
    <?php echo $this->include('partials/sidebar_jobs'); ?>
    <div class="col-md-8 col-lg-6 vstack gap-3">

        <div class="content-tabs bg-white rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li> <a href="<?= site_url('jobs') ?>"><?= lang('Web.jobs') ?></a></li>
                <li class="active"> <a href="<?= site_url('jobs/my-jobs') ?>"><?= lang('Web.my_jobs') ?></a></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-7">
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.job_applicants') ?></h1>
                    </div>
                    <div class="col-lg-5">
                        <!-- Sorting Dropdown -->
                        <div class="float-end">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bars fa-fw"></i> <?= lang('Web.sort') ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sortingDropdown">
                                    <li><a class="dropdown-item" href="?sort=latest"><?= lang('Web.sort_latest') ?></a></li>
                                    <li><a class="dropdown-item" href="?sort=salary-high"><?= lang('Web.salary_high_to_low') ?></a></li>
                                    <li><a class="dropdown-item" href="?sort=salary-low"><?= lang('Web.salary_low_to_high') ?></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Location Filter Dropdown -->
                        <div class="float-end me-2">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-map-marker-alt mr5"></i> <?= lang('Web.location') ?>
                                </button>
                                <div class="dropdown-menu p-3">
                                    <form method="get" action="?">
                                        <div class="mb-3">
                                            <label for="distance" class="form-label"><?= lang('Web.distance_km') ?></label>
                                            <input type="range" class="form-range" id="distance" name="distance"
                                                min="1" max="5000" value="5000">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100"><?= lang('Web.filter') ?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <!-- Jobs Listing -->
                <div class="row">
                    <div class="col-md-12">
                        <?php if (!empty($applicants)) : ?>
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><?= lang('Web.name') ?></th>
                                        <th><?= lang('Web.email') ?></th>
                                        <th><?= lang('Web.phone') ?></th>
                                        <th><?= lang('Web.address') ?></th>
                                        <th><?= lang('Web.cv') ?></th>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($applicants as $applicant) : ?>
                                    <tr>
                                        <td><?php echo $applicant['username']; ?></td>
                                        <td><?php echo $applicant['email']; ?></td>
                                        <td><?php echo $applicant['phone']; ?></td>
                                        <td><?php echo $applicant['location']; ?></td>
                                        <td>  
                                            <?php if($applicant['cv_file']): ?>
                                                <a href="<?= getMedia($applicant['cv_file'])?>" download=""><?= lang('Web.download') ?></a>
                                            <?php else: ?>
                                                <?= lang('Web.cv_not_exist') ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                        <?php else : ?>
                            <div class="row">
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-briefcase"></i>
                                    <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_applicants_found') ?></h4>
                                    <a href="<?= site_url('jobs') ?>" title=""><?= lang('Web.list_all_jobs') ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <?php if (isset($totalPages) && $totalPages > 1) : ?>
                <nav aria-label="Pagination border-top mt-2">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item mx-2 <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="<?= site_url('movies?page=' . $i) ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

</div>
