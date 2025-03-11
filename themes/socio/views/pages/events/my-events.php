<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="content-tabs card rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li class=""> <a href="<?=site_url('events');?>"><?= lang('Web.events') ?></a></li>
                <li class="active"> <a href="<?=site_url('events/my-events');?>"><?= lang('Web.my_events') ?></a></li> 
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-2">
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.my_events') ?></h1>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="btn btn-primary-soft ms-auto w-100" href="<?= site_url('events/create-event'); ?>">
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
                                        <div class="position-relative" style="min-height: 200px;max-height: 200px;overflow: hidden;background-color:#d8d8d8;">
                                            <img class="img-fluid rounded-top" src="<?= getMedia($event['cover']) ?>" alt="" style="min-height: 200px; max-height:200px;">
                                        </div>
                                        <h6 class="mt-3"><a href="<?= site_url('events/event-details/'.$event['id']) ?>"><?= esc($event['name']) ?></a></h6>
                                        <p class="mb-0 small"><i class="bi bi-calendar-check pe-1"></i> <?= $event['start_date'] . " " . $event['start_time'] ?> to <?= $event['end_date'] . " " . $event['end_time'] ?></p>
                                        <p class="small"><i class="bi bi-geo-alt pe-1"></i> <?= esc($event['location']) ?></p>
                                    </div>
                                    <div class="card-footer p-0">
                                        <?php if($event['user_id'] == $user_data['id']) { ?>
                                            <div class="d-flex m-1 justify-content-between">
                                                <a href="<?= site_url('events/event-details/' . $event['id']); ?>" class="btn btn-sm btn-primary m-1"><i class="bi bi-pencil-square me-1"></i><?= lang('Web.details') ?></a>
                                                <a href="<?= site_url('events/edit-event/' . $event['id']); ?>" class="btn btn-info btn-sm m-1"><i class="bi bi-pencil-fill"></i> <?= lang('Web.edit') ?></a>
                                                <button class="btn btn-sm btn-danger m-1" onclick="deleteEvent(<?= $event['id'] ?>)"><i class="bi bi-trash me-1"></i><?= lang('Web.delete') ?></button>
                                            </div>
                                        <?php } ?>
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
                            <a href="<?= site_url('events/create-event'); ?>" class="btn btn-primary-soft btn-sm"><?= lang('Web.create_event') ?></a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="card-footer">
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <nav aria-label="<?= lang('Web.event_pagination') ?>" class="border-top mt-2">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item mx-2 <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= site_url('events/my-events?page=' . $i) ?>"><?= $i ?></a>
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

function deleteEvent(event_id) {
    Swal.fire({
        title: "<?= lang('Web.are_you_sure') ?>",
        text: "<?= lang('Web.cannot_revert') ?>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "<?= lang('Web.yes_delete') ?>"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "<?= site_url('web_api/events/delete-event') ?>",
                data: { event_id: event_id },
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            title: "<?= lang('Web.success') ?>",
                            icon: "success",
                            html: response.message,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: () => { Swal.showLoading(); },
                            willClose: () => { window.location = "<?= site_url('events/my-events') ?>"; }
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
