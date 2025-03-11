<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <?php
  if (isset($title)) { ?>
    <title><?= $title . '-' . get_setting('website_name'); ?></title>
  <?php } else { ?>
    <title><?= get_setting('website_name'); ?></title>
  <?php } ?>

  <link rel="stylesheet" href="<?= load_asset() ?>css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url('public'); ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= load_asset() ?>css/login.css" />
</head>

<body>
  <div class="www-layout">
    <section>
      <div class="gap no-gap signin whitish medium-opacity">
        <div class="top_section bg-white">
          <div class="container d-flex align-items-center justify-content-between">
            <a class="logo" href="<?= site_url(); ?>">
              <?php
              $site_logo = get_setting('site_logo');

              if (!empty($site_logo)) {
                $site_logo = getMedia($site_logo);
              } else {
                $site_logo = load_asset() . 'images/logo.png';
              }
              ?>
              <img class="logo logo-img" src="<?= $site_logo ?>" alt="" />
            </a>
            <?php if (get_setting('chck-user_registration') == 1) : ?>
              <a class="btn btn-main btn-mat" href="<?= site_url('register'); ?>">Register</a>
            <?php endif; ?>
          </div>
        </div>

        <div class="container">



          <div class="row mt-3 justify-content-between align-items-center">



            <?= $this->renderSection('content') ?>


          </div>
        </div>
        <div class="footer mb-3">
          <div class="welcome-footer container">
            <div class="row">
              <div class="col-6"> © <?= date("Y"); ?> <?= get_setting('site_name'); ?> - <?= get_setting('footer_text'); ?></div>
              <div class="col-6">
                <ul>
                  <li><a href="<?= site_url(); ?>">Home</a></li>
                  <li><a href="<?= site_url('page/about'); ?>">Contact</a></li>
                  <li><a href="<?= site_url('page/terms-and-conditions'); ?>">Terms</a></li>
                  <li><a href="<?= site_url('page/privacy-policy'); ?>">Privacy</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?= base_url('public'); ?>/assets/js/jquery.validate.min.js"></script>
  <script src="<?= load_asset('js/login.js') ?>"></script>


</body>

</html>