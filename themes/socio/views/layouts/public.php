<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <title><?= get_setting('website_name'); ?></title>
  <link rel="stylesheet" href="<?= load_asset() ?>css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?=base_url('public');?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= load_asset() ?>css/login.css" />
  <link rel="icon" type="image/x-icon" href="<?= getMedia(get_setting('favicon')) ?>">
</head>

<body>
  <div class="www-layout">
    <section>
      <div class="gap no-gap signin whitish medium-opacity">
        <div class="container">

          <div class="top_section">
            <div class="container d-flex align-items-center justify-content-between">
              <a class="logo" href="<?=site_url();?>">
              <?php
               $site_logo = get_setting('site_logo');
			
               if(!empty($site_logo)){
                 $site_logo = getMedia($site_logo);
               }else{
                 $site_logo = load_asset().'images/logo.png';
               }
              ?>
                <img class="logo logo-img" src="<?=$site_logo ?>" alt="" />
              </a>
              
            
            </div>
          </div>
          
          <div class="row mt-5 gy-4 justify-content-between align-items-center">
          
         

            <?= $this->renderSection('content') ?>


          </div>
        </div>
        <div class="footer">
          <div class="welcome-footer container">
            <div class="row">
              <div class="col-md-6 text-start"> © <?= date("Y"); ?> <a href="<?= site_url(); ?>"><?= get_setting('site_name'); ?></a> - <?= get_setting('footer_text'); ?></div>
              <div class="col-md-6 d-flex justify-content-end">
                <ul>
                  <li><a href="<?= site_url('page/about'); ?>">About</a></li>
                  <li><a href="<?= site_url('page/terms-and-conditions'); ?>">Terms</a></li>
                  <li><a href="<?= site_url('page/privacy-policy'); ?>">Privacy</a></li>
                  <li><a href="<?= site_url('listings/people/a'); ?>">People</a></li>
                  <li><a href="<?= site_url('listings/pages/a'); ?>">Page</a></li>

                </ul>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script src="<?= load_asset('js/login.js') ?>"></script>


</body>

</html>