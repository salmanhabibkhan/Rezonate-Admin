<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="pt-5 pb-0 position-relative" style="background-image: url(<?= load_asset('images/jobs.jpg'); ?>); background-repeat: no-repeat; background-size: cover; background-position: top center;">
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
                        <form class="row align-items-end g-4" action="<?= site_url('jobs'); ?>">

                            <!-- Search -->
                            <div class="col-sm-6 col-lg-10">
                                <input type="text" autocomplete="off" name="search" placeholder="<?= lang('Web.search_placeholder') ?>" class="form-control" value="">
                            </div>
                            <!-- Search button -->
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
    <?php echo $this->include('partials/sidebar_jobs') ?>
    <div class="col-md-8 col-lg-6 vstack gap-3">

        <div class="content-tabs  rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li class=""> <a href="<?= site_url('jobs'); ?>"><?= lang('Web.jobs') ?></a></li>
                <li class="active"> <a href="<?= site_url('jobs/my-jobs'); ?>"><?= lang('Web.my_jobs') ?></a></li>
                
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-10">
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.my_jobs') ?></h1>
                    </div>
                    <div class="col-lg-2">
                        <a href="<?= site_url('jobs/create') ?>" class="btn btn-primary-soft"> <i class="fa fa-plus"></i> <?= lang('Web.create_job') ?></a>
                    </div>
                 
                </div>
            </div>

            <div class="card-body">

                <!-- Jobs Listing -->
                <div class="row">
                    <?php if (!empty($jobs)) : ?>
                        <?php foreach ($jobs as $job) : ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card product">
                                    <div class="product-image">
                                        <div class="product-price">
                                            <?= lang('Web.salary_range', ['min_salary' => $job['minimum_salary'], 'max_salary' => $job['maximum_salary'], 'salary_date' => $job['salary_date']]) ?>
                                        </div>
                                        <img src="<?= getMedia($job['job_image']) ?>" alt="<?= $job['job_title'] ?>">
                                        <div class="product-overlay">
                                            <a class="btn btn-sm btn-info rounded-pill js_job-apply" data-toggle="modal" href="<?= site_url('jobs/applicants/' . $job['id']) ?>">
                                                <i class="fa fa-user-tie mr5"></i> <?= lang('Web.view_applicants') ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-meta title">
                                            <a href="<?= site_url('jobs/detail/' . $job['id']) ?>" class="title"><?= $job['job_title'] ?></a>
                                        </div>
                                        <div class="product-meta">
                                            <i class="fa fa-briefcase fa-fw mr5" style="color: #2bb431;"></i><?= ucfirst($job['job_type']) ?>
                                        </div>
                                        <div class="product-meta">
                                            <i class="fa fa-map-marker fa-fw mr5" style="color: #1f9cff;"></i><?= $job['job_location'] ?>
                                        </div>
                                        <div class="product-actions">
                                            <a class="btn btn-sm btn-outline-primary rounded-pill float-center" href="<?= site_url('jobs/update/' . $job['id']) ?>">
                                                <i class="bi bi-pencil"></i> <?= lang('Web.edit_job') ?>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger rounded-pill float-center delete_job" data-job_id="<?= $job['id'] ?>">
                                                <i class="bi bi-trash"></i> <?= lang('Web.delete_job') ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="row">
                            <div class="my-sm-5 py-sm-5 text-center">
                                <i class="display-1 text-body-secondary bi bi-briefcase"></i>
                                <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_jobs_found') ?></h4>
                                <a href="<?= site_url('jobs'); ?>" title=""><?= lang('Web.list_all_jobs') ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-footer">
                <?php if (isset($totalPages) && $totalPages > 1) : ?>
                    <nav aria-label="Pagination border-top mt-2">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item mx-2 <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= site_url('jobs/my-jobs?page=' . $i) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on("click", '.delete_job', function () {

    var that = $(this);
    var job_id = that.data('job_id');
    Swal.fire({
        title: "<?= lang('Web.delete_job_confirm') ?>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "<?= lang('Web.yes') ?>"
    }).then((result) => {
        if (result.isConfirmed) {
            that.html("Sending request");
            $.ajax({
                type: "post",
                url: site_url + "web_api/delete-job",
                dataType: "json",
                data: {
                    job_id: job_id,
                },
                success: function (response) {
                  let timerInterval;
                            Swal.fire({
                                icon: 'success',
                                html: response.message,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent =
                                            `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                },
                                didClose: () => {
                                    Swal.update({
                                        html: '<i class="fas fa-check-circle"></i> Success!',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        showCloseButton: false,
                                    });
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                            });
                            setTimeout(() => {
                                window.location = "<?= site_url('jobs/my-jobs') ?>";
                            }, 4000);
                },
                error: function () {
                    that.html("Send Request");
                }
            });
        }
    });
});
</script>

<?= $this->endSection() ?>
