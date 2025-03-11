<div class="card">
          <!-- Card header START -->
          <div class="card-header border-0 pb-0">
            <h5 class="card-title">Videos</h5>
            <!-- Button modal -->
          </div>
          <!-- Card header END -->
          <!-- Card body START -->
          <div class="card-body">
            <!-- Video of you tab START -->
            <div class="row g-3">

              <!-- Add Video START -->
              <!-- <div class="col-sm-6 col-md-4">
                <div class="border border-2 py-5 border-dashed h-100 rounded text-center d-flex align-items-center justify-content-center position-relative">
                  <a class="stretched-link" href="#!">
                    <i class="fa-solid fa-camera-retro fs-1"></i>
                    <h6 class="mt-2">Add Video</h6>
                  </a>
                </div>
              </div> -->
              <!-- Add Video END -->

              <?php 
              if(!empty($videos)){
              foreach ($videos as  $video){ ?>
                <div class="col-sm-6 col-md-4">
                <!-- Video START -->
                <div class="card p-0 shadow-none border-0 position-relative">
                  <!-- Video image -->
                  <div class="position-relative">
                    
                   <a href="<?=site_url('posts/'.$video['id'])?>"><img class="rounded" src="<?=$video['video_thumbnail']?>" alt=""></a>
                    <div class="position-absolute bottom-0 start-0 p-3 d-flex w-100">
                      <span class="bg-dark bg-opacity-50 px-2 rounded text-white small"></span>
                    </div>
                  </div>
                  <!-- Video info -->
                 
                </div>
                <!-- Video END -->
              </div>
              <?php } }else{ ?>
                <div class="row">
                    <div class="my-sm-5 py-sm-5 text-center">
                        <i class="display-1 text-body-secondary bi-camera-video"></i>
                        <h4 class="mt-2 mb-3 text-body">No Videos found</h4>
                       
                    </div>
                </div>
              <?php } ?>

             
            </div>
            <!-- Video of you tab END -->
          </div>
          <!-- Card body END -->
          <!-- Card footer START -->
          <div class="card-footer border-0 pt-0">
          </div>
          <!-- Card footer END -->
        </div>