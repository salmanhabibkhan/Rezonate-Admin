<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 col-lg-6 vstack gap-4">
      <div class="content-tabs bg-dark shadow-sm clearfix">
        <ul class="clearfix m-0 p-1">
            <li class=""> <a href="<?= site_url('pages'); ?>">Suggested Pages</a></li>
            <li class="active"> <a href="<?= site_url('my-pages'); ?>">My Pages</a></li> 
        </ul>
      </div>
      <!-- Card START -->
      <div class="card">
          <!-- Card header START -->
          <div class="card-header border-0 border-bottom">
              <div class="row g-2">
                <div class="col-lg-2">
                  <!-- Card title -->
                  <h1 class="h4 card-title mb-lg-0">My Pages</h1>
                </div>
                <div class="col-sm-6 col-lg-3 ms-lg-auto">
                  <!-- Select Groups -->
                
                </div>
                  <div class="col-sm-6 col-lg-3">
                  <!-- Button modal -->
                  <a class="btn btn-primary-soft ms-auto w-100" href="<?=site_url('create-page');?>"> <i class="fa-solid fa-plus pe-1"></i> Create page</a>
                </div>
              </div>
          </div>
          <!-- Card header START -->
          <!-- Card body START -->
          <div class="card-body">
            
                <?php
                if(!empty($pages)){ ?>
                  <div class="row g-4">
                  
                    <?php
                    
                    foreach ($pages as $page) { 
                      ?>

                      <div class="col-sm-6 col-lg-4">
                        <!-- Card START -->
                        <div class="card">
                          <div class="h-80px rounded-top" style="background-image:url(<?=getMedia('cover')?>); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                            <!-- Card body START -->
                            <div class="card-body text-center pt-0">
                              <!-- Avatar -->
                              <div class="avatar avatar-lg mt-n5 mb-3">
                                  <a href="<?= site_url('pages/'.$page['page_username']) ;?>"><img class="avatar-img rounded-circle border border-white border-3 bg-white" src="<?=$page['avatar']?>" alt=""></a>
                              </div>
                              <!-- Info -->
                              <h5 class="mb-0"><a href="<?= site_url('pages/'.$page['page_username']) ;?>"><?=substr($page['page_title'],0,26)?></a></h5>
                              <?php if(!empty( $page['page_category'])){ ?>
                              <small><?=$page['page_category'] ?? 'Unknown' ?></small>
                              <?php } ?>
                              <!-- Group stat START -->
                              <div class="hstack gap-2 gap-xl-3 justify-content-center mt-3">
                                <!-- Group stat item -->
                                <div>
                                  <h6 class="mb-0"><?=$page['likes_count']?></h6>
                                  <small>Likes</small>
                                </div>
                                <!-- Divider -->
                                <div class="vr"></div>
                                <!-- Group stat item -->
                                <div>
                                  <h6 class="mb-0"><?= $page['post_count'] ;?></h6>
                                  <small>Posts</small>
                                </div>
                              </div>
                              <!-- Group stat END -->
                              
                          </div>
                          <!-- Card body END -->
                          <!-- Card Footer START -->
                          <div class="card-footer text-center">
                            <a class="btn btn-info-soft btn-sm" href="<?=site_url('update-page/'.$page['id']);?>"><i class="bi bi-pencil-fill"></i>  Edit Page </a>
                              <button class="btn btn-danger-soft btn-sm delete_page" data-page_id="<?= $page['id'] ?>"> <i class="bi bi-trash-fill"></i> Delete</button>
                          </div>
                          <!-- Card Footer END -->
                        </div>
                        <!-- Card END -->
                      </div>  
                    <?php }?>
                  </div>
                  <div class="row mt-2">
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <nav aria-label="Event Pagination border-top mt-2">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item mx-2 <?= ($i == $currentPage) ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= site_url('my-pages?page=' . $i) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                  </div>
                  <!-- Friends' groups tab END -->
                <?php }else{ ?>
                
                  <!-- More suggestions START -->
                <div class="tab-pane fade" id="tab-4">
                    <!-- Add group -->
                  <div class="my-sm-5 py-sm-5 text-center">
                    <i class="display-1 text-body-secondary bi bi-people"> </i>
                    <h4 class="mt-2 mb-3 text-body">No Page Found</h4>
                    <button class="btn btn-primary-soft btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateGroup">Click here to add </button>
                  </div>
                </div>
                <!-- More suggestions END -->

                <?php
                }
                ?>

          </div>
          
          <!-- Card body END -->
      </div>
      <!-- Card END -->
      




    </div>
    <!-- Main content END -->

</div> 
<script>
$(document).on("click", '.delete_page', function () {
    var that = $(this);
    

    var page_id = that.data('page_id');
    var request_action = 'accept';

    Swal.fire({
        title: "Are you sure to delete this page?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!"
    }).then((result) => {
        if (result.isConfirmed) {
            that.html("Sending request");
            $.ajax({
                type: "post",
                url: site_url + "web_api/delete-page", // Corrected the URL
                dataType: "json",
                data: {
                    page_id: page_id, // Pass the page_id to the server
                    request_action: request_action // Pass other data if needed
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
                                window.location = "<?= site_url('my-pages') ?>";
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



