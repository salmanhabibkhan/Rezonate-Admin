<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="col-lg-6 p-4 p-sm-5 bg-primary bg-opacity-10 rounded">
    <h4><?= lang('Web.create_new_account') ?></h4>
    <hr>
    
    <!-- Validation Messages -->
    <?php $validation = \Config\Services::validation(); ?>
    <?php if (session()->get('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->get('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->get('danger')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->get('danger'); ?>
            <?= session()->get('resetlink') ?? '' ?>
        </div>
    <?php endif; ?>

    <!-- Registration Form START -->
    <?php if (get_setting('chck-user_registration') == 1 ) : ?>

        <form action="register" class="register_form" method="post">
            <!-- First Name -->
            <div class="form-group mb-3">
                <label for="first_name"><?= lang('Web.first_name') ?></label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?= lang('Web.first_name') ?>" value="<?= set_value('first_name') ?>">
                <?= $validation->getError('first_name') ? "<div class='text-danger mt-2'>{$validation->getError('first_name')}</div>" : '' ?>
            </div>

            <!-- Last Name -->
            <div class="form-group mb-3">
                <label for="last_name"><?= lang('Web.last_name') ?></label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?= lang('Web.last_name') ?>" value="<?= set_value('last_name') ?>">
                <?= $validation->getError('last_name') ? "<div class='text-danger mt-2'>{$validation->getError('last_name')}</div>" : '' ?>
            </div>

            <!-- Email Address -->
            <div class="form-group mb-3">
                <label for="email"><?= lang('Web.email_address') ?></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="<?= lang('Web.email_address') ?>" value="<?= set_value('email') ?>">
                <?= $validation->getError('email') ? "<div class='text-danger mt-2'>{$validation->getError('email')}</div>" : '' ?>
            </div>

            <!-- Password -->
            <?php $password_system = get_setting('chck-password_complexity_system'); ?>
            <div class="form-group mb-3">
                <label for="password"><?= lang('Web.password') ?></label>
                <input type="password" class="form-control password" name="password" id="<?= ($password_system == 1) ? 'psw-input' : ''; ?>" placeholder="<?= lang('Web.password') ?>">
                <?= $validation->getError('password') ? "<div class='text-danger mt-2'>{$validation->getError('password')}</div>" : '' ?>
            </div>

            <!-- Password Complexity Checker -->
            <?php if ($password_system == 1) : ?>
                <div class="d-flex align-items-center mb-3">
                    <div id="pswmeter-message" class="rounded"></div>
                    <div class="ms-auto">
                        <i class="bi bi-info-circle ps-1" data-bs-toggle="popover" data-bs-content="<?= lang('Web.password_complexity_info') ?>"></i>
                    </div>
                </div>
                <div id="pswmeter" class="mb-3"></div>
            <?php endif; ?>

            <!-- Confirm Password -->
            <div class="form-group mb-3">
                <label for="password_confirm"><?= lang('Web.confirm_password') ?></label>
                <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="<?= lang('Web.confirm_password') ?>">
                <?= $validation->getError('password_confirm') ? "<div class='text-danger mt-2'>{$validation->getError('password_confirm')}</div>" : '' ?>
            </div>

            <!-- Date of Birth -->
            <div class="form-group mb-3">
                <label for="date_of_birth"><?= lang('Web.date_of_birth') ?></label>
                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="<?= lang('Web.date_of_birth') ?>">
                <?= $validation->getError('date_of_birth') ? "<div class='text-danger mt-2'>{$validation->getError('date_of_birth')}</div>" : '' ?>
            </div>

            <!-- Gender -->
            <div class="form-group mb-3">
                <label for="gender"><?= lang('Web.gender') ?></label>
                <select name="gender" id="gender" class="form-control">
                    <option value="male"><?= lang('Web.male') ?></option>
                    <option value="female"><?= lang('Web.female') ?></option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="row align-items-center mt-4">
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-success"><?= lang('Web.register') ?></button>
                </div>
            </div>
        </form>

    <?php else : ?>
        <p class="alert alert-primary mt-1"><?= lang('Web.no_registration') ?></p>
    <?php endif; ?>

    <hr>
    <!-- Already Have an Account -->
    <span><?= lang('Web.already_have_account') ?>
        <a class="we-account underline" href="<?= site_url('login'); ?>"><?= lang('Web.login_now') ?></a>
    </span>
    <hr>

    <!-- Social Login Options -->
    <div class="text-center">
        <?php if (get_setting('chck-googleLogin') == 1 || get_setting('chck-facebookLogin') == 1) : ?>
            <p><?= lang('Web.sign_in_quick_access') ?></p>
        <?php endif; ?>
        <ul class="list-unstyled d-sm-flex mt-3 justify-content-center">
            <?php if (get_setting('chck-facebookLogin') == 1) : ?>
                <li class="mx-2">
                    <a href="#" class="btn bg-facebook social_buttons d-inline-block">
                        <i class="fab fa-facebook-f me-2"></i> <?= lang('Web.sign_in_with_facebook') ?>
                    </a>
                </li>
            <?php endif;
            if (get_setting('chck-googleLogin') == 1) : ?>
                <li class="mx-2">
                    <a href="#" class="btn bg-google social_buttons d-inline-block">
                        <i class="fab fa-google me-2"></i> <?= lang('Web.sign_in_with_google') ?>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<!-- Date Restriction Script -->
<script>
    var currentDate = new Date();
    var fifteenYearsAgo = new Date(currentDate.getFullYear() - 15, currentDate.getMonth(), currentDate.getDate());
    document.getElementById('date_of_birth').setAttribute('max', fifteenYearsAgo.toISOString().split('T')[0]);
</script>

<?= $this->endSection() ?>
