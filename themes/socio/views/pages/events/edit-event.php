<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h1 class="h4 card-title mb-0"><?= lang('Web.edit_event') ?></h1>
            </div>

            <div class="card-body">
                <form id="editEventForm" class="row g-3" method="post" enctype="multipart/form-data">
                    <!-- Event name -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.event_name') ?></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="<?= lang('Web.event_name_placeholder') ?>" value="<?= esc($event['name']) ?>">
                    </div>
                    
                    <!-- Event ID -->
                    <input type="hidden" name="event_id" value="<?= esc($event['id']) ?>">
                    
                    <!-- Location -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.location') ?></label>
                        <input type="text" class="form-control" id="location" name="location"
                            placeholder="<?= lang('Web.location_placeholder') ?>" value="<?= esc($event['location']) ?>">
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.description') ?></label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= esc($event['description']) ?></textarea>
                    </div>

                    <!-- Start date and time -->
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Web.start_date') ?></label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="<?= esc($event['start_date']) ?>" min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Web.start_time') ?></label>
                        <input type="time" class="form-control" id="start_time" name="start_time"
                            value="<?= esc($event['start_time']) ?>">
                    </div>

                    <!-- End date and time -->
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Web.end_date') ?></label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="<?= esc($event['end_date']) ?>" min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Web.end_time') ?></label>
                        <input type="time" class="form-control" id="end_time" name="end_time"
                            value="<?= esc($event['end_time']) ?>">
                    </div>

                    <!-- Cover Image -->
                    <div class="col-12">
                        <label class="form-label"><?= lang('Web.cover_image') ?></label>
                        <input type="file" class="form-control" id="cover" name="cover">
                        <small><?= lang('Web.current_cover') ?>: <a href="<?= getMedia($event['cover']) ?>" target="_blank"><?= lang('Web.view_current_cover') ?></a></small>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                    <?php 
                        $currentTime = new DateTime();
                        $date = $currentTime->format('Y-m-d');
                        $time = $currentTime->format('H:i:s');
                        if ($date > $event['start_date']) {
                            echo '<div class="alert alert-danger text-center">' . lang('Web.past_event_error') . '</div>';
                            $i = 1;
                        } elseif ($date == $event['start_date']) {
                            if ($event['start_time'] < $time) {
                                echo '<div class="alert alert-danger text-center">' . lang('Web.ongoing_event_error') . '</div>';
                                $i = 1;
                            }
                        }
                    ?>
                        <button type="submit" class="btn btn-primary mb-0" <?= isset($i) && $i == 1 ? 'disabled' : '' ?>><?= lang('Web.update_event') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('public'); ?>/assets/js/jquery.validate.min.js"></script>
<script>
    function convertDateTimeStringToDateTimeObject(dateString, timeString) {
        const [year, month, day] = dateString.split('-');
        const [hours, minutes] = timeString.split(':');
        return new Date(year, month - 1, day, hours, minutes);
    }
    $(document).ready(function() {
        $('#editEventForm').validate({
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
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                var startTime = $('#start_time').val();
                var endTime = $('#end_time').val();

                // Convert to Date objects for validation
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
                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/events/update-event',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            html: response.message,
                            timer: 2000,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href = site_url+'/events/my-events';
                            }
                        });
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>
