<div class="card">
  <div class="card-header border-0 pb-0">
    <h5 class="card-title"></h5>
    <h5>Page Followers</h5>
 
  </div>
  <div class="card-body">
    <div class="rounded border px-3 py-2 mb-3">   
      <div class="row g-4">
        <div class="col-12">
        <?php if(count($getallusermembers)>0): ?>
          <ul style="list-style-type: none;">
        <?php foreach ($getallusermembers as $user) : ?>
          <li class=""><a href="<?= site_url('/' . $user['id']) ?>"
                           >
                            <div
                                class="rounded   d-sm-flex border-0 mb-1 p-3 position-relative">


                                <div class="avatar text-center">
                                    <img class="avatar-img rounded-circle"
                                        src="<?= getMedia($user['avatar']) ?>" alt="">
                                </div>
                                <!-- Info -->
                                <div class="mx-sm-3 my-2 my-sm-0">
                                    <p class="small"><b> <a
                                                href="<?= site_url($user['username']) ?>"><?= $user['first_name'] . ' ' . $user['last_name'] ?></a>
                                        </b><br><a href="<?= site_url($user['username']) ?>"
                                            style="color:inherit;">@<?=$user['username'] ?> </a></p>
                                </div>
                                <!-- Action -->
                                <div class="d-flex ms-auto">
                                    <p class="small me-5 text-nowrap"></p>
                                    <!-- Notification action START -->
                                    <?php if(getCurrentUser()['id']==$page['user_id']): ?>
                                    <div class="dropdown position-absolute end-0 top-0 mt-3 me-3">
                                        <a href="#"
                                            class="z-index-1 text-secondary btn position-relative py-0 px-2"
                                            id="cardNotiAction2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <!-- Card share action dropdown menu -->
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardNotiAction2">
                                            <li ><a class="dropdown-item  delete_page_user" href="#"
                                                    data-user_id="<?= $user['id'] ?>"> <i
                                                        class="bi bi-person-x-fill fa-fw pe-2"
                                                        ></i>Remove</a>
                                            </li>
                                            <!-- <li><a class="dropdown-item" href="#"> <i class="bi bi-bell-slash fa-fw pe-2"></i>Turn off </a></li>
                                        <li><a class="dropdown-item" href="#"> <i class="bi bi-volume-mute fa-fw fs-5 pe-2"></i>Mute Judy Nguyen </a></li> -->
                                        </ul>
                                    </div>
                                    <?php endif ;?>
                                    <!-- Notification action END -->
                                </div>
                            </div>
                        </a>
                    </li>
          </li>
         <?php endforeach ?>
         </ul>
          <?php else: ?>
              <div class="row">
              <div class="my-sm-5 py-sm-5 text-center">
                  <i class="display-1 text-body-secondary bi bi-briefcase"></i>
                  <h4 class="mt-2 mb-3 text-body">No User Liked this page </h4>
                  
              </div>
          </div>
          <?php endif; ?>
        </div>
        <!-- Add more group details as needed -->
      </div>
    </div>
  </div>
</div>
