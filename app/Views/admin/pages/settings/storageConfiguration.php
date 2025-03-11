<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

    <!-- 1st row starts from here -->
        <div class="row">

            <!-- 1st row 1st column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">    
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="mt-2"><?= lang('Admin.local_storage') ?></h4>
                            </div>
                            <div class="col-md-2">
                                <label class="switch">
                                    <input type="checkbox" class="storage_setting" <?= get_setting('active_storage') == 'local' ? 'checked="checked" disabled' : ''; ?> data-key="active_storage" value="local">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="mt-2"><?= lang('Admin.aws') ?></h4>
                            </div>
                            <div class="col-md-2">
                                <label class="switch">
                                    <input type="checkbox" data-storage="chck-awsStorage" class="storage_setting" <?= get_setting('active_storage') == 'aws' ? 'checked="checked" disabled' : ''; ?> data-key="active_storage" value="aws">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <form action="<?= base_url('admin/settings/update-aws-storage') ?>" method="post">
                            <?php $amazones3setting  = json_decode(get_setting('amazone_s3_settings')); ?>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.aws_bucket_name') ?></label>
                                        <input type="text" name="bucket_name" id="aws_bucket_name" class="form-control" value="<?=$amazones3setting->bucket_name ?? ''?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.aws_s3_key') ?></label>
                                        <input type="text" name="amazone_s3_key" id="amazone_s3_key" class="form-control" value="<?=$amazones3setting->amazone_s3_key ?? ''?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.aws_s3_secret_key') ?></label>
                                        <input type="text" name="amazone_s3_s_key" id="amazone_s3_s_key"  class="form-control" value="<?=$amazones3setting->amazone_s3_s_key ?? ''?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.aws_bucket_region') ?></label>
                                        <select name="region" class="form-control" id="aws_bucket_region">
                                            <?php
                                            $aws_regions = [
                                                'us-east-1' => 'US East (N. Virginia) - us-east-1',
                                                'us-east-2' => 'US East (Ohio) - us-east-2',
                                                'us-west-1' => 'US West (N. California) - us-west-1',
                                                'us-west-2' => 'US West (Oregon) - us-west-2',
                                                'af-south-1' => 'Africa (Cape Town) - af-south-1',
                                                'ap-east-1' => 'Asia Pacific (Hong Kong) - ap-east-1',
                                                'ap-south-2' => 'Asia Pacific (Hyderabad) - ap-south-2',
                                                'ap-southeast-3' => 'Asia Pacific (Jakarta) - ap-southeast-3',
                                                'ap-southeast-4' => 'Asia Pacific (Melbourne) - ap-southeast-4',
                                                'ap-south-1' => 'Asia Pacific (Mumbai) - ap-south-1',
                                                'ap-northeast-3' => 'Asia Pacific (Osaka) - ap-northeast-3',
                                                'ap-northeast-2' => 'Asia Pacific (Seoul) - ap-northeast-2',
                                                'ap-southeast-1' => 'Asia Pacific (Singapore) - ap-southeast-1',
                                                'ap-southeast-2' => 'Asia Pacific (Sydney) - ap-southeast-2',
                                                'ap-northeast-1' => 'Asia Pacific (Tokyo) - ap-northeast-1',
                                                'ca-central-1' => 'Canada (Central) - ca-central-1',
                                                'cn-north-1' => 'China (Beijing) - cn-north-1',
                                                'cn-northwest-1' => 'China (Ningxia) - cn-northwest-1',
                                                'eu-central-1' => 'Europe (Frankfurt) - eu-central-1',
                                                'eu-west-1' => 'Europe (Ireland) - eu-west-1',
                                                'eu-west-2' => 'Europe (London) - eu-west-2',
                                                'eu-south-1' => 'Europe (Milan) - eu-south-1',
                                                'eu-west-3' => 'Europe (Paris) - eu-west-3',
                                                'eu-south-2' => 'Europe (Spain) - eu-south-2',
                                                'eu-north-1' => 'Europe (Stockholm) - eu-north-1',
                                                'eu-central-2' => 'Europe (Zurich) - eu-central-2',
                                                'me-south-1' => 'Middle East (Bahrain) - me-south-1',
                                                'me-central-1' => 'Middle East (UAE) - me-central-1',
                                                'sa-east-1' => 'South America (São Paulo) - sa-east-1'
                                            ];                                            

                                            foreach ($aws_regions as $value => $label): ?>
                                                <option value="<?php echo $value; ?>" <?= (isset($amazones3setting->region) && $amazones3setting->region == $value) ? 'selected' : '' ?> ><?php echo $label; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm"><?= lang('Admin.update_aws_storage') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
               
                <!-- Wasabi Storage -->
                <div class="card card-primary">
                    <div class="card-body">    
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="mt-2"><?= lang('Admin.wasabi_storage') ?></h4>
                            </div>
                            <div class="col-md-2">
                                <label class="switch">
                                    <input type="checkbox" class="storage_setting" data-storage="chck-wasabiStorage" <?= get_setting('active_storage') == 'wasabi' ? 'checked="checked" disabled' : ''; ?> data-key="active_storage" value="wasabi">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <?php $wasabi_setting  = json_decode(get_setting('wasabi_settings')); ?>                    
                        <form action="<?= base_url('admin/settings/update-wasabi-storage') ?>" method="post">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.wasabi_bucket_name') ?></label>
                                        <input type="text" name="wasabi_bucket_name" id="wasabi_bucket_name" class="form-control" value="<?= $wasabi_setting->wasabi_bucket_name ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.wasabi_access_key') ?></label>
                                        <input type="text" name="wasabi_access_key" id="wasabi_access_key" class="form-control" value="<?= $wasabi_setting->wasabi_access_key ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.wasabi_secret_key') ?></label>
                                        <input type="text" name="wasabi_secret_key" id="wasabi_secret_key" class="form-control" value="<?= $wasabi_setting->wasabi_secret_key ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.wasabi_bucket_region') ?></label>
                                        <input type="text" name="wasabi_bucket_region" id="wasabi_bucket_region"  class="form-control" value="<?= $wasabi_setting->wasabi_bucket_region ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <button class="btn btn-success btn-sm" type="submit"><?= lang('Admin.update_wasabi_storage') ?></button>
                                </div>
                            </div>
                        </form>    
                    </div>
                </div>  

                <!-- FTP Storage -->
               
            </div>
            <div class="col-md-6">
            <div class="card card-primary">
                    <div class="card-body">
                        <?php $ftp_settings  = json_decode(get_setting('ftp_settings')); ?>  
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="mt-2"><?= lang('Admin.ftp_storage') ?></h4>
                            </div>
                            <div class="col-md-2">
                                <label class="switch">
                                    <input type="checkbox" class="storage_setting" data-storage="chck-ftpStorage" <?= get_setting('active_storage') == 'ftp' ? 'checked="checked" disabled' : ''; ?> data-key="active_storage" value="ftp">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <form action="<?= base_url('admin/settings/update-ftp-storage') ?>" method="post">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.ftp_hostname') ?></label>
                                        <input type="text" name="ftp_host" id="ftp_host" class="form-control" value="<?= $ftp_settings->ftp_host ?? '' ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.ftp_username') ?></label>
                                        <input type="text" name="ftp_username" id="ftp_username" class="form-control" value="<?= $ftp_settings->ftp_username ?? '' ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.ftp_password') ?></label>
                                        <input type="password" name="ftp_password" id="ftp_password" class="form-control" value="<?= $ftp_settings->ftp_password ?? '' ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.ftp_port') ?></label>
                                        <input type="text" name="ftp_port" class="form-control" id="ftp_port"  value="<?= $ftp_settings->ftp_port ?? '' ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.ftp_endpoint') ?></label>
                                        <input type="text" name="ftp_path" id="ftp_path"class="form-control" value="<?= $ftp_settings->ftp_path ?? '' ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <button type="submit" class="btn btn-success btn-sm"><?= lang('Admin.update_ftp_settings') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Digital Ocean Storage -->
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="mt-2"><?= lang('Admin.digital_ocean_storage') ?></h4>
                            </div>
                            <div class="col-md-2">
                                <label class="switch">
                                    <input type="checkbox" class="storage_setting" data-storage="chck-digitaloceanStorage" <?= get_setting('active_storage') == 'digital_ocean' ? 'checked="checked" disabled' : ''; ?> data-key="active_storage" value="digital_ocean">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <?php $space_settings  = json_decode(get_setting('space_settings')); ?> 
                        <form action="<?= base_url('admin/settings/update-space-storage') ?>" method="post">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.space_key') ?></label>
                                        <input type="text" name="space_key" id="space_key" class="form-control" value="<?= $space_settings->space_key ?? ''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.space_secret_key') ?></label>
                                        <input type="text" name="spaces_secret" id="space_secret" class="form-control" value="<?= $space_settings->spaces_secret ?? ''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.space_name') ?></label>
                                        <input type="text" name="space_name" id="space_name" class="form-control" value="<?= $space_settings->space_name ?? ''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group text-black">
                                        <label><?= lang('Admin.space_region') ?></label>
                                        <input type="text" name="space_region" id="space_region"   class="form-control" value="<?= $space_settings->space_region ?? ''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <button type="submit" class="btn btn-success btn-sm"><?= lang('Admin.update_digital_ocean_storage') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
$(document).ready(function() {
    $("body").on('change', '.storage_setting', function(event) {
		event.preventDefault();
		var that = $(this);
		var key = that.data('key');
		var storage = that.data('storage');
        
        var isValid = validateStorageCredentials(storage);
        
        if (!isValid) {
            toastr.error("Please provide valid credentials before enabling this storage.");
            that.prop('checked', false);
            return;
        }
		var value = that.val();
        $('.storage_setting').prop('checked', false).prop('disabled', false); // Uncheck and enable all checkboxes
        $(this).prop('checked', true).prop('disabled', true); // Check and disable the clicked checkbox

		change_settings_value(key, value, function(res) {
				if(res.success){
                    toastr.success("Storage setting is set for uploading is "+value);
				}else{
					showError('Error', res.error);
				}
		});



	});
});
function validateStorageCredentials(key) {
    // Add your validation logic here based on the storage type
    console.log(key);
    switch (key) {
        case 'chck-wasabiStorage':
            var wasabi_bucket_region = $("#wasabi_bucket_region").val();
            var wasabi_secret_key = $('#wasabi_secret_key').val();
            var wasabi_access_key = $('#wasabi_access_key').val();
            var wasabi_bucket_name = $('#wasabi_bucket_name').val();
            // Validate that all required fields are not empty
            if (isEmpty(wasabi_bucket_region) || isEmpty(wasabi_secret_key) || isEmpty(wasabi_access_key) || isEmpty(wasabi_bucket_name)) {
                return false;
            }
            break;
            case 'chck-awsStorage':
                var aws_bucket_name = $("#aws_bucket_name").val();
                var amazone_s3_key = $('#amazone_s3_key').val();
                var amazone_s3_s_key = $('#amazone_s3_s_key').val();
                var aws_bucket_region = $('#aws_bucket_region').val();
                if (isEmpty(aws_bucket_name) || isEmpty(amazone_s3_key) || isEmpty(amazone_s3_s_key) || isEmpty(aws_bucket_region)) {
                    return false;
                }
            break;
            case 'chck-ftpStorage':
                var ftp_host = $("#ftp_host").val();
                var ftp_username = $('#ftp_username').val();
                var ftp_password = $('#ftp_password').val();
                var ftp_port = $('#ftp_port').val();
                var ftp_path = $('#ftp_path').val();
                
                if (isEmpty(ftp_host) || isEmpty(ftp_username) ||isEmpty(ftp_path) || isEmpty(ftp_password) || isEmpty(ftp_port) || isEmpty(ftp_path)) {
                    return false;
                }
            break;
            case 'chck-digitaloceanStorage':
                var space_key = $("#space_key").val();
                var space_secret = $('#space_secret').val();
                var space_name = $('#space_name').val();
                var space_region = $('#space_region').val();
             
                
                if (isEmpty(space_key) || isEmpty(space_secret)  || isEmpty(space_name) || isEmpty(space_region)) {
                    return false;
                }
            break;
            
                
        default:
            break;
    }
    return true;
}

function isEmpty(value) {
    
    return (value === undefined || value === null || value.trim() === '');
}

</script>


<?= $this->include('admin/script') ?>



<?= $this->endSection() ?>