<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h1 class="h4 card-title mb-0"><?= lang('Web.create_event') ?></h1>
            </div>
            <div class="card-body">
                <form id="addEventForm" class="row g-3" method="post" enctype="multipart/form-data">
                    <!-- Event name -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.event_name') ?></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="<?= lang('Web.event_name_placeholder') ?>">
                    </div>

                    <!-- Location -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.location') ?></label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="<?= lang('Web.location_placeholder') ?>">
                    </div>

                    <!-- Event Description -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.description') ?></label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="<?= lang('Web.description_placeholder') ?>"></textarea>
                    </div>

                    <!-- Start Date -->
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.start_date') ?></label>
                        <input type="date" class="form-control" id="start_date" name="start_date" min="<?=date('Y-m-d')?>">
                    </div>

                    <!-- Start Time -->
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.start_time') ?></label>
                        <input type="time" class="form-control" id="start_time" name="start_time">
                    </div>

                    <!-- End Date -->
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.end_date') ?></label>
                        <input type="date" class="form-control" id="end_date" name="end_date" min="<?=date('Y-m-d')?>">
                    </div>

                    <!-- End Time -->
                    <div class="col-sm-6">
                        <label class="form-label"><?= lang('Web.end_time') ?></label>
                        <input type="time" class="form-control" id="end_time" name="end_time">
                    </div>

                    <!-- Event Cover Image -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.cover_image') ?></label>
                        <input type="file" class="form-control" id="cover" name="cover">
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary mb-0"><?= lang('Web.create_event') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
    function convertDateTimeStringToDateTimeObject(dateString, timeString) {
        const [year, month, day] = dateString.split('-');
        const [hours, minutes] = timeString.split(':');
        return new Date(year, month - 1, day, hours, minutes);
    }

    $(document).ready(function () {
        $('#addEventForm').validate({
            rules: {
                name: {
                    required: true
                },
                location: {
                    required: true
                },
                start_date: {
                    required: true
                },
                start_time: {
                    required: true
                },
                end_date: {
                    required: true,
                },
                end_time: {
                    required: true,
                }
            },
            rules: {
            name: {
                required: true
            },
            location: {
                required: true
            },
            start_date: {
                required: true
            },
            start_time: {
                required: true
            },
            end_date: {
                required: true,
            },
            end_time: {
                required: true,
            }
        },
        messages: {
            name: {
                required: "<?= lang('Web.validation.name_required') ?>"
            },
            location: {
                required: "<?= lang('Web.validation.location_required') ?>"
            },
            start_date: {
                required: "<?= lang('Web.validation.start_date_required') ?>"
            },
            start_time: {
                required: "<?= lang('Web.validation.start_time_required') ?>"
            },
            end_date: {
                required: "<?= lang('Web.validation.end_date_required') ?>"
            },
            end_time: {
                required: "<?= lang('Web.validation.end_time_required') ?>"
            }
        },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function (element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            submitHandler: function (form) {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                var startTime = $('#start_time').val();
                var endTime = $('#end_time').val();

                var startDateObject = convertDateTimeStringToDateTimeObject(startDate, startTime);
                var endDateObject = convertDateTimeStringToDateTimeObject(endDate, endTime);
                var currentDate = new Date();

                // Check if start date/time is before current date/time
                if (startDateObject < currentDate) {
                    alert("<?= lang('Web.start_date_time_before_current') ?>");
                    return;
                }

                // Compare start date and end date
                if (endDateObject < startDateObject) {
                    alert("<?= lang('Web.end_date_time_before_start') ?>");
                    return;
                }

                // Compare start time and end time if dates are equal
                if (endDateObject.getTime() === startDateObject.getTime() && endTime <= startTime) {
                    alert("<?= lang('Web.end_time_before_or_equal_start') ?>");
                    return;
                }

                // Continue with form submission
                var formData = new FormData(form);
                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/events/add-event',
                    data: formData,
                    processData: false,
                    contentType: false,
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
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            },
                        }).then((result) => {
                            window.location = "<?= site_url('events/my-events') ?>";
                        });
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        // Handle the error response here
                        Swal.fire({
                            icon: 'error',
                            title: '<?= lang('Web.error') ?>',
                            text: '<?= lang('Web.error_occurred') ?>: ' + errorThrown,
                        });
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
