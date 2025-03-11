
<?= $this->extend('emails/template') ?>
<?= $this->section('email_content') ?>
    <row class="header" style="background:#6C6C6C">
        <columns>
            <spacer size="16"></spacer>
        </columns>
    </row>
    <row class="header" style="background:#6C6C6C">
            <columns>
                <spacer size="16"></spacer>
            </columns>
        </row>
        <row>
            <columns>                
                <h1 class="text-center" style="color:#01252F;font-family:Lato,sans-serif;font-size:30pt;text-align:center">View Profile</h1>
                <table style="border: 1px solid">

                    <tr >
                        <td rowspan="2"><img src="<?= $profile_image ?>" width="50px" height="50px"></td>

                          <td><b><?= $first_name ?> <?= $last_name ?> </b> <?= $notification_text ?> </td>  
                    </tr>
                   
                </table>
                
            </columns>
        </row>

<?= $this->endSection() ?>