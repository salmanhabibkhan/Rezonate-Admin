
<?= $this->extend('emails/template') ?>
<?= $this->section('email_content') ?>
    <row class="header" style="background:#6C6C6C">
        <columns>
            <spacer size="16"></spacer>
        </columns>
    </row>
    <row>
        <columns>
            <spacer size="32"></spacer>

            <spacer size="16"></spacer>
            <h1 class="text-center" style="color:#01252F;font-family:Lato,sans-serif;font-size:20pt;text-align:center">Forgot Your Password?</h1>
            <spacer size="16"></spacer>
            <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">Hi </p>
            <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">Click the link below to reset your password.</p>
            <a href="<?= $resetlink ?>">
                <button class="large expand" href="#" style="font-family:Lato,sans-serif;height:50px;left:50%;margin:20px -100px;position:relative;top:50%;width:200px">RESET PASSWORD</button>
            </a>
            <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">Or copy and paste following link into your browsers address bar.</p>
            <p class="textcenter" style="    background: #f6f6f6;
    font-family: Lato, sans-serif;
    text-align: center;
    border: 1px solid #e5e5e5;
    padding: 10px;"><span style="color:#FF0000"><?= $resetlink ?></span> </p>
            <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">If you did not request your password, please ignore it, the request will reset in 1 hour</p>
            <p style="font-family:Lato,sans-serif"></p>
        </columns>
    </row>
<?= $this->endSection() ?>