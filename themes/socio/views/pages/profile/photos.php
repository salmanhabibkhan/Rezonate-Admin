<div class="card">
              <!-- Card header START -->
    <div class="card-header d-sm-flex align-items-center justify-content-between border-0 pb-0">
      <h5 class="card-title"> User Photos</h5>
    </div>
    <!-- Card header END -->
    <!-- Card body START -->
    <div class="card-body">
      <!-- Photos of you tab START -->
      <div class="row g-3 " id="imageContainer">

        <?php if(count($userallphotos)){ ?>
          <?php foreach($userallphotos as $userphoto):?>
            <div class="col-sm-6 col-md-4 col-lg-3">
          <!-- Photo -->
          <a href="<?= getMedia($userphoto['media_path']) ?>" data-gallery="image-popup" data-glightbox="description: .custom-desc2; descPosition: left;">
            <img class="rounded img-fluid" src="<?= getMedia($userphoto['media_path']) ?>" alt="" style="min-height: 200px;max-height:200px; over-flow:hidden;">
          </a>
       
        </div>  
          <?php endforeach ;?>
        <?php } else{ ?>
          <div class="row">
									<div class="my-sm-5 py-sm-5 text-center">
										<i class="display-1 text-body-secondary bi bi-camera"></i>
										<h4 class="mt-2 mb-3 text-body">No Photos</h4>
										
									</div>
								</div>
        <?php
        }
          ?>

       
      </div>
      <!-- Photos of you tab END -->
    </div>
              <!-- Card body END -->
</div>