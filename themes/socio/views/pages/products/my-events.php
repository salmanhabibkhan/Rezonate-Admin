<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="content-tabs bg-white rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li class=""> <a href="<?=site_url('events');?>">Events</a></li>
                <li class="active"> <a href="<?=site_url('events/my-events');?>">My Events</a></li> 
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-2">
                        <h1 class="h4 card-title mb-lg-0">My Events</h1>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="btn btn-primary-soft ms-auto w-100" href="<?= site_url('events/create-event'); ?>"><i class="fa-solid fa-plus pe-1"></i> Create Event</a>
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
                                        <div class="position-relative" style="max-height: 200px;overflow: hidden;">
                                            <img class="img-fluid rounded-top" src="<?= $event['cover'] ?>" alt="">
                                            <!-- <div class="badge bg-danger text-white mt-2 me-2 position-absolute top-0 end-0">Online</div> -->
                                        </div>
                                        <h6 class="mt-3"><a href="event-details.html"><?= $event['name'] ?></a></h6>
                                        <p class="mb-0 small"><i class="bi bi-calendar-check pe-1"></i> <?= $event['start_date'] . " " . $event['start_time'] ?> to <?= $event['end_date'] . " " . $event['end_time'] ?></p>
                                        <p class="small"><i class="bi bi-geo-alt pe-1"></i> <?= $event['location'] ?></p>
                                    </div>
                                    <div class="card-footer p-0">
                                      
                                        
                                            <?php if($event['user_id'] == $user_data['id']) { ?>
                                                <div class="d-flex m-1 justify-content-between">
                                                    <a href="<?= site_url('events/event-detials/' . $event['id']); ?>" class="btn btn-sm btn-primary  m-1"><i class="bi bi-pencil-square me-1"></i>Details</a>
                                                    <a href="<?= site_url('events/edit-event/' . $event['id']); ?>" class="btn btn-info btn-sm m-1"> <i class="bi bi-pencil-fill" ></i> Edit</a>                                                   
                                                    <button class="btn btn-sm btn-danger  m-1" onclick="deleteEvent(<?= $event['id'] ?>)" ><i class="bi bi-trash me-1"></i>Delete</button>
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
                            <h4 class="mt-2 mb-3 text-body">No events found</h4>
                            <a href="<?= site_url('events/create-event'); ?>" class="btn btn-primary-soft btn-sm">Create Event</a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="card-footer">
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <nav aria-label="Event Pagination border-top mt-2">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item mx-2 <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= site_url('events?page=' . $i) ?>"><?= $i ?></a>
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
function deleteEvent(event_id)
{
   
    Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "POST", // You can change this to 'GET' if needed
            url: "<?= site_url('web_api/events/delete-event') ?>", // Specify the URL where you want to send the data
            data:{ event_id:  event_id} ,
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

                    let timerInterval;
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        html: response.message,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector(
                            "b");
                            timerInterval = setInterval(() => {
                                timer.textContent =
                                    `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                       
                    });
                    setTimeout(() => {
                        window.location = "<?= site_url('events') ?>";
                    }, 4000);

                    // 
                }
            },
            error: function(error) {
                // Handle the error response here
                console.error("Error:", error);
            }
        });
    }
    });
}
</script>

<?= $this->endSection() ?>
