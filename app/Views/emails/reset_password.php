
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
            <h1 class="text-center" style="color:#01252F;font-family:Lato,sans-serif;font-size:20pt;text-align:center">Reset Password</h1>
            <spacer size="16"></spacer>
            <p class="textcenter" style="font-family:Lato,sans-serif;text-align:center">Hi </p>
            <?=$emailMessage?>
        </columns>
    </row>
<?= $this->endSection() ?>