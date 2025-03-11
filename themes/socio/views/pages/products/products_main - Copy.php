<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="content-tabs bg-white rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li class="active"> <a href="<?= site_url('products') ?>">Products</a></li>
                <li> <a href="<?= site_url('products/my-products') ?>">My Proudcts</a></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-2">
                        <h1 class="h4 card-title mb-lg-0 mt-1"></h1>
                    </div>
                    <div class="col-sm-6 col-lg-10">
                        <a class="btn btn-primary-soft ms-auto float-end" href="<?= site_url('products/create-product') ?>"><i
                                class="fa-solid fa-plus pe-1"></i> Create Product</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <?php if (count($products)>0) { ?>
                    <?php foreach ($products as $product) : ?>
                        
                        <div class="row py-2 border-bottom">
                            <div class="col-md-3 mt-1"><img class="img-fluid img-responsive rounded product-image" src="<?= $product['images'][0]['image'] ?>"></div>
                            <div class="col-md-6 mt-1">
                                <h5><?= $product['product_name'] ?></h5>
                                <p class="text-justify text-truncate para mb-0"><?= $product['product_description'] ;?><br><br></p>
                            </div>
                            <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                                <div class="d-flex flex-row align-items-center">
                                    <h4 class="mr-1"><?= $product['currency'] ;?> <?= $product['price'] ;?></h4> 
                                    <!-- <span class="strike-text">$</span> -->
                                </div>
                                <!-- <h6 class="text-success">Free shipping</h6> -->
                                <div class="d-flex flex-column mt-4"><a class="btn btn-primary btn-sm" href="<?= site_url('products/details/'.$product['id']) ?>">Details</a></div>
                            </div>

                        </div>
                        
                    <?php endforeach ?>

                <?php } else { ?>
                <div class="row">
                    <div class="my-sm-5 py-sm-5 text-center">
                        <i class="display-1 text-body-secondary bi bi-calendar-event"></i>
                        <h4 class="mt-2 mb-3 text-body">No Product found</h4>
                        
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="card-footer">
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav aria-label="Event Pagination border-top mt-2">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item mx-2 <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="<?= site_url('?page=' . $i) ?>"><?= $i ?></a>
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

    function markeventgoing(event_id) {
        Swal.fire({
            title: "Are you sure?",

            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST", // You can change this to 'GET' if needed
                    url: "<?= site_url('web_api/events/gotoevent') ?>", // Specify the URL where you want to send the data
                    data: {
                        event_id: event_id
                    },
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

    function markinterested(event_id) {

        Swal.fire({
            title: "Are you sure?",

            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ok?"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST", // You can change this to 'GET' if needed
                    url: "<?= site_url('web_api/events/createinterest') ?>", // Specify the URL where you want to send the data
                    data: {
                        event_id: event_id
                    },
                    success: function(response) {
                        console.log(response);
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
