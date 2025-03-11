<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="col-lg-6 p-4 p-sm-5 bg-primary bg-opacity-10 rounded">
    <div class="container">
        <h3><?= lang('Web.reset_password') ?></h3>
        <hr>

        <?php $validation = \Config\Services::validation(); ?>
        <?php if (session()->get('danger')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->get('danger'); ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->get('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->get('success'); ?>
            </div>
            
            <p><?= lang('Web.enter_new_password') ?></p>
            
            <form action="<?= site_url(); ?>updatepassword/<?= $id ?>" method="post">
                <div class="form-group mb-3">
                    <label for="password"><?= lang('Web.password') ?></label>
                    <input type="password" class="form-control" required name="password" id="password" value="">
                    <?php if ($validation->getError('password')) { ?>
                        <div class='alert alert-danger mt-2'>
                            <?= $validation->getError('password'); ?>
                        </div>
                    <?php } ?>
                </div>
                
                <div class="form-group mb-3">
                    <label for="password_confirm"><?= lang('Web.confirm_password') ?></label>
                    <input type="password" class="form-control" required name="password_confirm" id="password_confirm" value="">
                    <?php if ($validation->getError('password_confirm')) { ?>
                        <div class='alert alert-danger mt-2'>
                            <?= $validation->getError('password_confirm'); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-4">
                        <button type="submit" class="btn btn-primary"><?= lang('Web.reset') ?></button>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
