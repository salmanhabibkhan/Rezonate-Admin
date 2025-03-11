<?= $this->extend('emails/template') ?>
<?= $this->section('email_content') ?>
<row class="header" style="background:#6C6C6C">
    <columns>
        <spacer size="16"></spacer>
    </columns>
</row>
<row>
    <?php 
        // $first_name = "Muhammad Saif ";
        // $last_name = "Rehman ";
        // $resetlink = "https://linkon.social//activate/86/ZGNkZmY1MzkyNjRkYWIxNGJmYjg1ODMyNWU1ZDlkMzE5NzcyMTZkMg==";
    ;?>
    <columns>
        <spacer size="32"></spacer>
        <spacer size="16"></spacer>
        <h1 class="text-center" style="color:#01252F;font-family:Lato,sans-serif;font-size:30pt;text-align:center">Activate Your Account</h1>
        <spacer size="16"></spacer>
        <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">Hi <?php echo $first_name. ' ' .$last_name; ?></p>
        <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">Click the link below to activate your account</p>
        <a href="<?= $resetlink ?>" style="text-align:center">
            <button class="large expand" href="#" style="font-family:Lato,sans-serif;height:50px;left:50%;margin:20px -100px;position:relative;top:50%;width:200px;text-align:center">ACTIVATE ACCOUNT</button>
        </a>
        <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">Or copy and paste : <span style="color:#FF0000"><?= $resetlink ?></span> into your browsers address bar.</p>
        <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">If you did not register an account please let us know</p>
        <p style="font-family:Lato,sans-serif"></p>
    </columns>
</row>
<?= $this->endSection() ?>