
<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="col-lg-6 p-4 p-sm-5 bg-primary bg-opacity-10 rounded">
  <h2>Rest Password</h2>

  <hr>
  <p>Enter your email address to reset your password</p>
        <?php $validation = \Config\Services::validation(); ?>
        <?php if (session()->get('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->get('success'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->get('danger')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->get('danger'); ?>
            </div>
        <?php endif; ?>
        
        <form class="forgot_form" action="<?=site_url('forgotpassword');?>" method="post">
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>">
                <?php if ($validation->getError('email')) { ?>
                    <div class='alert text-danger mt-2'>
                        <?= $error = $validation->getError('email'); ?>
                    </div>
                <?php } ?>
            </div>

            <div class="row mt-2">
                <div class="col-12 col-sm-4">
                    <button type="submit" class="btn btn-primary" id="btnfetch">Reset</button>
                </div>

            </div>
        </form>
  <hr>
  <span>Don't have an account?
    <a class="we-account underline" href="<?= site_url('register'); ?>" title="">Create an Account</a></span>
  <!-- Form END -->
  <hr>

</div>

<?= $this->endSection() ?>