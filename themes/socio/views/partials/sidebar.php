<div class="col-lg-3 main_sidebar">

  <!-- Navbar START-->
  <nav class="navbar navbar-expand-lg mx-0 ">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSideNavbar">
      <!-- Offcanvas header -->
      <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <!-- Offcanvas body -->
      <div class="offcanvas-body d-block px-2 px-lg-0 left_sidebar">
        <!-- Card START -->
        <div class="card overflow-hidden">

          <!-- Card body START -->
          <div class="card-body">

            <div class="d-flex">
              <!-- Avatar -->
              <div class="avatar me-1">
                <a href="#!"><img class="avatar-img rounded border border-white border-3" src="<?= $user_data['avatar'] ?>" alt=""></a>
              </div>
              <div>

                <!-- Info -->
                <h6 class="mb-0"> <a href="<?= site_url($user_data['username']) ?>"><?= $user_data['first_name'] ?> <?= $user_data['last_name'] ?> </a> </h6>
                <small>@<?= $user_data['username'] ?></small>
              </div>
            </div>
            <hr />
            <!-- Side Nav START -->
            <ul class="nav nav-link-secondary flex-column fw-bold gap-2">


              <?php if($user_data['role'] == 2){ ?>
              <li class="nav-item">
                <a class="nav-link" href="<?=site_url('admin/dashboard');?>" title="">
                <span class="s-6"></span>
                  <span><?= lang('Web.admin_panel') ?></span>
                </a>
              </li>
              <?php } ?>

              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('home'); ?>" title="">
                  <span class="s-18"></span>
                  <span><?= lang('Web.news_feed') ?></span>
                </a>
              </li>
              <?php if(get_setting('chck-pages')==1):?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= site_url('pages'); ?>" title=""><span class="s-4"></span><span><?= lang('Web.pages') ?></span></a>
                </li>
              <?php endif ;
               if(get_setting('chck-groups')==1):?>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('groups'); ?>" title="">
                  <span class="s-15"></span><span><?= lang('Web.group') ?></span>
                </a>
              </li>
              <?php endif ;?>
         

            
              <?php if(get_setting('chck-movies')==1):?>

              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('movies'); ?>" title="">
                  <span class="s-40"></span><span><?= lang('Web.movies') ?></span>
                </a>
              </li>
              <?php endif ;
                if(get_setting('chck-events')==1):?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= site_url('events'); ?>" title="">
                    <span class="s-7"></span><span><?= lang('Web.events') ?></span>
                  </a>
                </li>
              <?php endif;
              if(get_setting('chck-job_system')==1):?>

              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('jobs'); ?>" title="">
                  <span class="s-23"></span><span><?= lang('Web.jobs') ?></span>
                </a>
              </li>
              <?php endif; ?>
              
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('video_timeline'); ?>" title="">
                  <span class="s-40"></span><span><?= lang('Web.videos') ?></span>
                </a>
              </li>
                <?php
                 if(get_setting('chck-games')==1):?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('games'); ?>" title="">
                      <span class="s-31"></span><span><?= lang('Web.games') ?></span>
                    </a>
                  </li>
                <?php endif ;
               if(get_setting('chck-wallet')==1):?>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('wallet'); ?>" title="">
                  <span class="s-10"></span><span><?= lang('Web.wallet') ?></span>
                </a>
              </li>
              <?php endif ;
               if(get_setting('is_friend_system')==1):?>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('friends'); ?>" title="">
                  <span class="s-102"></span><span><?= lang('Web.friends') ?></span>
                </a>
              </li>
              <?php endif ;
               if(get_setting('chck-point_level_system')==1):?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= site_url('packages'); ?>" title="">
                    <span class="s-31"></span><span><?= lang('Web.packages') ?></span>
                  </a>
                </li>
                <?php endif ;
                 if(get_setting('chck-blogs')==1):?>
                <li class="nav-item">
                <a class="nav-link" href="<?= site_url('blogs'); ?>" title="">
                  <span class="s-46"></span><span><?= lang('Web.blog_articles') ?></span>
                </a>
              </li>
              <?php endif ;
               if(get_setting('chck-product')==1):?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= site_url('products'); ?>" title="">
                    <span class="s-24"></span><span><?= lang('Web.marketplace') ?></span>
                  </a>
                </li>
              <?php endif ;
                if(get_setting('chck-blood')==1):?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('blood-bank'); ?>" title="">
                      <span class="s-24"></span><span><?= lang('Web.blood_bank') ?></span>
                    </a>
                  </li>
                <?php endif ;
               if(get_setting('chck-post_advertisement')==1):?>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('post-ads'); ?>" title="">
                  <span class="s-21"></span><span><?= lang('Web.post_ads_requests') ?></span>
                </a>
              </li>
              <?php endif ;?>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('saved-post'); ?>" title="">
                  <span class=""></span><span> <i class="bi bi-floppy-fill text-primary" style="font-size: 20px;"></i> <?= lang('Web.saved_posts') ?></span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?=site_url('search?term'); ?>" title="">
                <span class="s-37"></span><span><?= lang('Web.explore') ?></span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('logout'); ?>" title=""><i class="me-2 h-20px fa-fw fa-regular fa-solid fa-arrow-right-from-bracket"></i><span><?= lang('Web.logout') ?></span></a>
              </li>

            </ul>
            <!-- Side Nav END -->
          </div>
          <!-- Card body END -->


        </div>
        <!-- Card END -->
        <?= $this->include('partials/sidebar_bottom') ?>

        <!-- Copyright -->
        <p class="small text-center mt-1">©<?= date('Y'); ?> <a class="text-reset" target="_blank" href="<?= site_url(); ?>"> <?= get_setting('site_name') ?> </a></p>
      </div>
    </div>
  </nav>
  <!-- Navbar END-->

</div>
