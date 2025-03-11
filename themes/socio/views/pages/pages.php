<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 col-lg-6 vstack gap-4">
      <div class="content-tabs bg-white rounded shadow-sm clearfix">
        <ul class="clearfix m-0 p-1">
            <li class="active"> <a href="<?= site_url('pages'); ?>">Suggessted Pages</a></li>
            <li > <a href="<?= site_url('my-pages'); ?>">My Pages</a></li> 
        </ul>
      </div>
      <!-- Card START -->
      <div class="card">
          <!-- Card header START -->
          <div class="card-header border-0 border-bottom">
              <div class="row g-2">
                <div class="col-lg-2">
                  <!-- Card title -->
                  <h1 class="h4 card-title mb-lg-0">All Pages</h1>
                </div>
                <div class="col-sm-6 col-lg-3 ms-lg-auto">
                  <!-- Select Groups -->
                  <form action="<?= site_url('pages'); ?>" id="myForm">
                    <select class="form-select  choice-select-text-none" id="selectBox"  name="choice" data-search-enabled="false">
                      <option value="">Newest </option>  
                      <option value="alpha" <?= ($choice=="alpha")?'selected':'' ?>>Alphabetical</option>                      
                    </select>
                  </form>
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
                if(!empty($pages)){
                ?>
                  <div class="row g-4">
                  
                    <?php
                    
                    foreach ($pages as $single_page) { 
                      if(is_array($single_page)){
                      ?>

                      <div class="col-sm-6 col-lg-4">
                        <!-- Card START -->
                        <div class="card">
                          <div class="h-80px rounded-top" style="background-image:url(<?=getMedia('cover')?>); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                            <!-- Card body START -->
                            <div class="card-body text-center pt-0">
                              <!-- Avatar -->
                              <div class="avatar avatar-lg mt-n5 mb-3">
                                  <a href="<?= site_url('pages/'.$single_page['page_username']) ;?>"><img class="avatar-img rounded-circle border border-white border-3 bg-white" src="<?=$single_page['avatar']?>" alt=""></a>
                              </div> 
                           
                              <!-- Info -->
                              <h5 class="mb-0"><a href="<?= site_url('pages/'.$single_page['page_username']) ;?>"><?= substr($single_page['page_title'], 0, 20) ?></a></h5>
                              <?php if(!empty( $single_page['page_category'])){ ?>
                              <small><?=$single_page['page_category'] ?? 'Unknown' ?></small>
                              <?php } ?>
                              <!-- Group stat START -->
                              <div class="hstack gap-2 gap-xl-3 justify-content-center mt-3">
                                <!-- Group stat item -->
                                <div>
                                  <h6 class="mb-0">
                                  <a class=" likepage_btn" data-page_id="<?php echo $single_page['id'] ;?>" data-is_liked="<?php echo $single_page['is_liked'] ;?>"  href="#" ><?php if($single_page['is_liked']==1):?> <i class="bi bi-hand-thumbs-up-fill text-primary "></i> <?php else:?> <i class="bi bi-hand-thumbs-up "></i><?php endif ;?> </a>
                                  </h6>
                                  <small id="likes_count<?php echo $single_page['id'] ;?>"><?=$single_page['likes_count']?> Likes</small>
                                </div>
                                <!-- Divider -->
                                <div class="vr"></div>
                                <!-- Group stat item -->
                                <div>
                                  <h6 class="mb-1 mt-1"><?= $single_page['post_count'] ;?></h6>
                                  <small>Posts</small>
                                </div>
                              </div>
                              <!-- Group stat END -->
                              
                          </div>
                          <!-- Card body END -->
                          <!-- Card Footer START -->
                          <!-- <div class="card-footer text-center">

                              
                            <a class="btn btn-success-soft btn-sm" href="<?=site_url('page/'.$single_page['page_username']);?>"> Visit </a>
                          </div> -->
                          <!-- Card Footer END -->
                        </div>
                        <!-- Card END -->
                      </div>  
                    <?php 
                      }
                    }?>
                   <div class="row">
                      <div class="col-12">
                      
                      </div>
                    </div>
                    


                  </div>
                  <!-- Friends' groups tab END -->

                <?php }else{ ?>
                
                  <!-- More suggestions START -->
                <div class="tab-pane fade" id="tab-4">
                    <!-- Add group -->
                  <div class="my-sm-5 py-sm-5 text-center">
                    <i class="display-1 text-body-secondary bi bi-people"> </i>
                    <h4 class="mt-2 mb-3 text-body">No pages founds</h4>
                    <button class="btn btn-primary-soft btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateGroup"> Click here to add </button>
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
 <!-- Row END -->
<script>
$(document).on('click', '.likepage_btn', function (event) {
        let that = $(this);
        let is_liked = that.data('is_liked');
        let page_id = that.data('page_id');
        let confirmationMessage = is_liked == 1 ? "Are you sure you want to unlike this page?" : "Are you sure you want to like this page?";
         Swal.fire({
            title: "Are you sure?",
            text: confirmationMessage,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST", // You can change this to 'GET' if needed
                    url: "<?= site_url('web_api/like-page') ?>", // Specify the URL where you want to send the data
                    data:{page_id:page_id} ,
                    success: function(response) {
                        if(response.data==1)
                        {
                            that.html('<i class="bi bi-hand-thumbs-up-fill text-primary "></i> ');
                        }
                        else{
                            that.html('<i class="bi bi-hand-thumbs-up"></i>');
                        }
                        that.data('is_liked', is_liked == 1 ? 0 : 1);
                        $('#likes_count'+page_id).html(response.likes_count+" Likes")
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
                                Swal.icon = 'success';
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            },
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                
                            });
                            setTimeout(() => {
                                
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
           
        });
        $(document).ready(function(){
          $('#selectBox').change(function(){
            $('#myForm').submit();
            });
        });
        

</script>
<?= $this->endSection() ?>



