<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="content-tabs card rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li class="active"> <a href="<?= site_url('events') ?>"><?= lang('Web.events') ?></a></li>
                <li> <a href="<?= site_url('events/my-events') ?>"><?= lang('Web.my_events') ?></a></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-2">
                        <h1 class="h4 card-title mb-lg-0 mt-1"><?= lang('Web.events') ?></h1>
                    </div>
                    <div class="col-sm-6 col-lg-10">
                        <a class="btn btn-primary-soft ms-auto float-end" href="<?= site_url('events/create-event') ?>">
                            <i class="fa-solid fa-plus pe-1"></i> <?= lang('Web.create_event') ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($events)) { ?>
                <div class="row g-3">
                    <?php foreach ($events as $event) { ?>
                    <div class="col-sm-6 col-xl-4">
                        <div class="card h-100">
                            <div class="card-body position-relative p-0" style="text-align:center; margin:0 auto">
                                <div class="position-relative" style="min-height: 200px;overflow: hidden;background-color:#d8d8d8;">
                                    <a href="<?= site_url('events/event-details/' . $event['id']) ?>">
                                        <img class="img-fluid rounded-top" src="<?= $event['cover'] ?>" style="min-height: 200px; max-height:200px;">
                                    </a>
                                </div>
                                <h6 class="mt-3">
                                    <a href="<?= site_url('events/event-details/' . $event['id']) ?>">
                                        <?= $event['name'] ?>
                                    </a>
                                </h6>
                                <p class="mb-0 "><b><?= lang('Web.start_date') ?>:</b> <?= (new \DateTime($event['start_date']))->format('d-M-Y') ?></p>
                                <p><b><?= lang('Web.start_time') ?>:</b> <?= (new \DateTime($event['start_time']))->format('h:i a') ?></p>
                                <p class="mb-0 "><b><?= lang('Web.end_date') ?>:</b> <?= (new \DateTime($event['end_date']))->format('d-M-Y') ?></p>
                                <p><b><?= lang('Web.end_time') ?>:</b> <?= (new \DateTime($event['end_time']))->format('h:i a') ?></p>
                            </div>
                            <div class="card-footer p-0">
                                <div class="d-flex m-2 justify-content-between">
                                    <button onclick="markeventgoing('<?= $event['id'] ?>')"
                                        class="btn btn-sm w-50 <?= $event['is_going'] ? 'btn-outline-danger' : 'btn-outline-primary' ?> m-1">
                                        <?= $event['is_going'] ? " <i class='bi bi-x-circle-fill '></i> " . lang('Web.not_going') : "<i class='bi bi-check-circle-fill'></i> " . lang('Web.going') ?>
                                    </button>
                                    <button onclick="markinterested('<?= $event['id'] ?>')"
                                        class="btn btn-sm w-50 <?= $event['is_interested'] ? 'btn-outline-danger' : 'btn-outline-success' ?> m-1">
                                        <?= $event['is_interested'] ? " <i class='bi bi-hand-thumbs-down-fill'></i> " . lang('Web.not_interested') : "<i class='bi bi-hand-thumbs-up m-1'></i> " . lang('Web.interested') ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="row">
                    <div class="my-sm-5 py-sm-5 text-center">
                        <i class="display-1 text-body-secondary bi bi-calendar-event"></i>
                        <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_events_found') ?></h4>
                        <a href="<?= site_url('events/create-event') ?>" class="btn btn-primary-soft btn-sm"><?= lang('Web.create_event') ?></a>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="card-footer">
                <?= $pager_links ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".btn-outline-primary, .btn-outline-success").click(function() {
            var $this = $(this);
            if ($this.hasClass('btn-outline-primary')) {
                $this.toggleClass('btn-primary btn-outline-primary');
            } else if ($this.hasClass('btn-outline-success')) {
                $this.toggleClass('btn-success btn-outline-success');
            }
        });
    });

    function markeventgoing(event_id) {
        Swal.fire({
            title: "<?= lang('Web.are_you_sure') ?>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "<?= lang('Web.yes') ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('web_api/events/gotoevent') ?>",
                    data: { event_id: event_id },
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                html: response.message,
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location = "<?= site_url('events') ?>";
                            });
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                    }
                });
            }
        });
    }

    function markinterested(event_id) {
        Swal.fire({
            title: "<?= lang('Web.are_you_sure') ?>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "<?= lang('Web.yes') ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('web_api/events/createinterest') ?>",
                    data: { event_id: event_id },
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                html: response.message,
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location = "<?= site_url('events') ?>";
                            });
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                    }
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>
