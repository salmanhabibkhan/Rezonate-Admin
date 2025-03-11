<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="col-lg-6 p-4 p-sm-5 bg-primary bg-opacity-10 rounded">
  <h4><?= lang('Web.login_account') ?></h4>
  <hr>
  <?php $validation = \Config\Services::validation(); ?>
  <?php if (session()->get('success')) : ?>
    <div class="alert alert-success" role="alert">
      <?= session()->get('success'); ?>
    </div>
  <?php endif; ?>
  <?php if (session()->get('danger')) : ?>
    <div class="alert alert-danger" role="alert">
      <?= session()->get('danger'); ?>
      <?php if (session()->get('resetlink')) {
        echo session()->get('resetlink');
      } ?>
    </div>
  <?php endif; ?>

  <!-- Form START -->
  <form class="login_form" action="<?= base_url(); ?>login" method="post">
    <div class="form-group mb-3">
      <label for="email" class="form-label"><?= lang('Web.email_address') ?></label>
      <input type="text" class="form-control" placeholder="<?= lang('Web.email_address') ?>" name="email" id="email" value="<?= set_value('email') ?>">
      <?php if ($validation->getError('email')) { ?>
        <div class='alert text-danger m-0 p-0'>
          <?= $error = $validation->getError('email'); ?>
        </div>
      <?php } ?>
    </div>
        
    <div class="form-group mt-2 mb-3">
      <label for="password" class="form-label"><?= lang('Web.password') ?></label>
      <input type="password" class="form-control" placeholder="<?= lang('Web.password') ?>" name="password" id="password" value="">
      <?php if ($validation->getError('password')) { ?>
        <div class='alert text-danger m-0 p-0'>
          <?= $error = $validation->getError('password'); ?>
        </div>
      <?php } ?>
    </div>

    <div class="form-check mb-3">
      <input type="checkbox" class="form-check-input" id="rememberme" name="rememberme" value="1">
      <label class="form-check-label" for="rememberme"><?= lang('Web.remember_me') ?></label>
    </div>

    <?php if(get_setting('chck-reCaptcha')=='1'): ?>
      <div class="mb-3">
        <div class="g-recaptcha" data-sitekey="<?=get_setting('recaptcha_sitekey')?>"></div>
      </div>
    <?php endif ;?>

    <div class="row align-items-center">
      <div class="col-sm-4">
        <button type="submit" class="btn btn-primary"><?= lang('Web.login') ?></button>
      </div>
       <div class="col-sm-8 text-sm-end">
        <span><a href="<?= site_url('forgotpassword'); ?>"><u>Forgot Password</u></a></span>
      </div>
    </div>
  </form>
  <hr>
  
  <?php if(get_setting('chck-user_registration') == 1 && !IS_DEMO): ?>
    <span><?= lang('Web.dont_have_account') ?>
      <a class="we-account underline" href="<?= site_url('register'); ?>" title=""><?= lang('Web.create_account') ?></a></span>
    <hr>
  <?php endif; ?>
  
  <!-- Social-media btn -->
  <div class="text-center">
    <?php if((get_setting('chck-googleLogin') == 1 || get_setting('chck-facebookLogin') == 1) && !IS_DEMO): ?>
      <p><?= lang('Web.quick_access') ?></p>
    
      <ul class="list-unstyled d-sm-flex mt-3 justify-content-center">
        <?php if( get_setting('chck-facebookLogin') == 1): ?>
          <li class="mx-2 my-2">
            <a href="<?= site_url('social_login/facebook'); ?>" class="btn bg-facebook social_buttons d-inline-block">
              <i class="fab fa-facebook-f me-2"></i> <?= lang('Web.sign_in_with_facebook') ?>
            </a>
          </li>
        <?php endif; ?>
        <?php if(get_setting('chck-googleLogin') == 1): ?>
          <li class="mx-2  my-2">
            <a href="<?= site_url('social_login/google'); ?>" class="btn bg-google social_buttons d-inline-block">
              <i class="fab fa-google me-2"></i> <?= lang('Web.sign_in_with_google') ?>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>

<?php if(IS_DEMO): ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#role').change(function() {
        var selectedRole = $(this).val(); 
        var emailValue = ''; 
        var passwordValue = ''; 

        if (selectedRole === 'admin') {
          emailValue = '<?= lang('Web.admin_email') ?>';
          passwordValue = '<?= lang('Web.admin_password') ?>';
        } else if (selectedRole === 'user') {
          emailValue = '<?= lang('Web.user_email') ?>';
          passwordValue = '<?= lang('Web.user_password') ?>';
        }

        $('#email').val(emailValue);
        $('#password').val(passwordValue);
      });
    });
  </script>
<?php endif; ?>

<?= $this->endSection() ?>
