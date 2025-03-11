<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <title><?= get_setting('website_name'); ?></title>
  <link rel="stylesheet" href="<?= load_asset() ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('public'); ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= load_asset() ?>css/login.css">
  <link rel="icon" type="image/x-icon" href="<?= getMedia(get_setting('favicon')) ?>">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
  <div class="www-layout">
    <section>
      <div class="gap no-gap signin whitish medium-opacity">
        <!-- Top Section -->
        <div class="top_section">
          <div class="container d-flex align-items-center justify-content-between">
            <a class="logo" href="<?= site_url(); ?>">
              <?php
              $site_logo = get_setting('site_logo') ? getMedia(get_setting('site_logo')) : load_asset() . 'images/logo.png';
              ?>
              <img class="logo logo-img" src="<?= $site_logo ?>" alt="Site Logo" />
            </a>

            <?php if (get_setting('chck-user_registration') == 1) : ?>
              <a class="btn btn-sm btn-primary" href="<?= site_url('register'); ?>">Register</a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Main Content Section -->
        <div class="container">
          <div class="row px-2 mt-5 gy-4 justify-content-between align-items-center">
            <div class="col-lg-6 text-lg-start text-center body_login">
              <div class="banner-content wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="0.5s" style="visibility: visible; animation-duration: 0.5s; animation-delay: 0.3s; animation-name: fadeInUp;">
                <h2>
                  <?php 
                    $title = get_setting('login_page_title');
                    echo empty($title) ? "Welcome to " . get_setting('website_name') : $title;
                  ?>
                </h2>
                <p class="mt-3"><?= get_setting('login_page_text'); ?></p>
              </div>

              <!-- App Download Icons Section -->
              <div class="row mt-2 px-3 text-center">
                <?php if(get_setting('playstore_app_link')!=null || !empty(get_setting('playstore_app_link'))): ?>
                <div class="col-6">
                  <a href="<?=get_setting('playstore_app_link')?>" target="_blank" class="me-4">
                    <img class="w-100" src="<?= load_asset() . 'images/ios.png' ?>" alt="Download iOS" />
                  </a>
                </div>
                <?php endif; ?>
                <?php if(get_setting('appstore_app_link')!=null || !empty(get_setting('appstore_app_link'))): ?>
                  <div class="col-6">
                    <a href="<?= get_setting('appstore_app_link') ?>" target="_blank">
                      <img class="w-100" src="<?= load_asset() . 'images/android.png' ?>" alt="Download Android" />
                    </a>
                  </div>
                <?php endif; ?>
              </div>
              <!-- End of App Download Icons Section -->
            </div>

            <!-- Render Section Content -->
            <?= $this->renderSection('content') ?>
          </div>
        </div>

        <!-- Footer Section -->
        <footer class="w-100 position-relative mt-5 fr_welcome_bottom">
          <div class="container">
            <div class="row footer">
              <div class="col-sm-6 text-start p-2">
                <span>© <?= date("Y"); ?> <a href="<?= site_url(); ?>"><?= get_setting('site_name'); ?></a> - <?= get_setting('footer_text'); ?>. All rights reserved.</span>
                <a href="#" data-bs-toggle="modal" data-bs-target="#languageModal" class="ms-3">
                  <svg fill="currentColor" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px; vertical-align: middle;">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.93 6h-2.88c-.13-1.45-.5-2.81-1.07-4.07 1.84.45 3.41 1.57 4.61 3.07-.21.3-.44.59-.66.9zm-4.93-4.4c.5 1.05.83 2.15 1 3.4h-2c.17-1.25.5-2.35 1-3.4zm-3.93 4.4H4.07c.22-.31.45-.6.66-.9 1.19-1.5 2.77-2.62 4.61-3.07-.57 1.26-.94 2.62-1.07 4.07zM4.07 14h2.88c.13 1.45.5 2.81 1.07 4.07-1.84-.45-3.41-1.57-4.61-3.07.21-.3.44-.59.66-.9zM9 16.4c-.5-1.05-.83-2.15-1-3.4h2c-.17 1.25-.5 2.35-1 3.4zm3 3.17c-.5-1.26-.83-2.35-1-3.57h2c-.17 1.22-.5 2.31-1 3.57zm3.93-4.07h2.88c-.22.31-.45.6-.66.9-1.19 1.5-2.77 2.62-4.61 3.07.57-1.26.94-2.62 1.07-4.07zm0-2h-2.88c-.13-1.45-.5-2.81-1.07-4.07 1.84.45 3.41 1.57 4.61 3.07-.21.3-.44.59-.66.9z"></path>
                  </svg><?= lang('Web.select_language') ?>
                </a>
              </div>
              <div class="col-sm-6 text-end">
                <nav class="nav justify-content-end">
                  <a class="nav-link" href="<?= site_url(); ?>login">Log In</a>
                  <a class="nav-link" href="<?= site_url(); ?>register">Sign Up</a>
                  <a class="nav-link" href="<?= site_url('page/about'); ?>">About</a>
                  <a class="nav-link" href="<?= site_url('page/terms-and-conditions'); ?>">Terms</a>
                  <a class="nav-link" href="<?= site_url('page/privacy-policy'); ?>">Privacy</a>
                  <a class="nav-link" href="<?= site_url('page/data-deletion-request'); ?>">Data Deletion</a>
                </nav>
              </div>
            </div>
          </div>
        </footer>

        <!-- Language Selection Modal -->
        <div class="modal fade custom-language-modal" id="languageModal" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel" aria-hidden="true">
          <div class="modal-dialog custom-modal-dialog" role="document">
            <div class="modal-content custom-modal-content">
              <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="languageModalLabel"><?= lang('Web.select_language') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body custom-modal-body">
                <ul class="list-unstyled custom-language-list">
                  <?php foreach (get_available_languages() as $code => $name): ?>
                    <li>
                      <a class="dropdown-item text-center" href="<?= site_url('set-language/' . $code); ?>">
                        <?= $name; ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="modal-footer custom-modal-footer">
                <button type="button" class="btn btn-primary custom-btn-close" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?= load_asset() ?>/js/bootstrap.min.js"></script>
  <script src="<?= base_url('public'); ?>/assets/js/jquery.validate.min.js"></script>
  <script src="<?= load_asset('js/login.js') ?>"></script>

</body>
</html>
