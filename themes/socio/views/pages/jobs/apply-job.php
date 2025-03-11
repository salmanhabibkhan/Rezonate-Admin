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
                        <p class=""><?= lang('Web.discover_jobs') ?></p>
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

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-7">
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.jobs') ?></h1>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Jobs Listing -->
                    <div class="row">

                        <form id="myForm" method="post" enctype="multipart/form-data">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Web.phone_number') ?> </label>
                                    <input type="text" class="form-control" name="phone" placeholder="<?= lang('Web.phone_number_placeholder') ?>"
                                        id="phone" required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Web.position') ?> </label>
                                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                    <input type="text" class="form-control" name="position" placeholder="<?= lang('Web.position_placeholder') ?>">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Web.company_name') ?></label>
                                    <input type="text" class="form-control" name="previous_work"
                                        placeholder="<?= lang('Web.company_name_placeholder') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Web.cv_file') ?> </label>
                                    <input type="file" class="form-control" id="file" name="cv_file" accept=".pdf, .doc, .docx">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Web.address') ?></label>
                                    <input type="text" class="form-control" name="location" placeholder="<?= lang('Web.address_placeholder') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Web.description') ?> </label>
                                    <textarea name="description" rows="1" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success "><?= lang('Web.submit') ?></button>
                                    <a href="" class="btn btn-danger"><?= lang('Web.cancel') ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-footer"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fileInput = document.getElementById('file');

            fileInput.addEventListener('change', function() {
                var selectedFile = fileInput.files[0];

                if (selectedFile) {
                    var fileExtension = selectedFile.name.split('.').pop().toLowerCase();
                    if (fileExtension !== 'pdf' && fileExtension !== 'doc' && fileExtension !== 'docx') {
                        alert('<?= lang('Web.file_extension_error') ?>');
                        fileInput.value = '';
                    }
                }
            });
        });

        $(document).ready(function() {
            $("#myForm").submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();
                console.log(formData);

                $.ajax({
                    type: "POST",
                    url: "<?= site_url('jobapply') ?>",
                    data: formData,
                    success: function(response) {
                        if (response.code == 400) {
                            $('#phone').focus();
                            Swal.fire({
                                icon: 'warning',
                                text: response.data.phone,
                            });
                            $('#phone').focus();
                        }
                        if (response.code == 200) {
                            Swal.fire({
                                title: "<?= lang('Web.success') ?>",
                                icon: "success",
                                html: response.message,
                                timer: 4000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                willClose: () => {}
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    console.log("Closed by timer");
                                }
                            });
                            setTimeout(() => {
                                window.location = "<?= site_url('jobs') ?>";
                            }, 4000);
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                    }
                });
            });
        });
    </script>

<?= $this->endSection() ?>
