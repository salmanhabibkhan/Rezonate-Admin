<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">
        <!-- 1st row -->
        <div class="row">
            <!-- 1st row 1st column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.general') ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="site_name"><?= lang('Admin.website_name') ?></label>
                                    <input type="text" class="form-control settings_text" id="site_name" name="site_name" placeholder="<?= lang('Admin.website_name') ?>" value="<?=$settings['site_name']?>">
                                    <small><?= lang('Admin.website_name_description') ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="site_title"><?= lang('Admin.website_title') ?></label>
                                    <input type="text" class="form-control settings_text" id="site_title" name="site_title" placeholder="<?= lang('Admin.website_title') ?>" value="<?=$settings['site_title']?>">
                                    <small><?= lang('Admin.website_title_description') ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="site_keywords"><?= lang('Admin.website_keyword') ?></label>
                                    <input type="text" class="form-control settings_text" id="site_keywords" name="site_keywords" placeholder="<?= lang('Admin.website_keyword') ?>" value="<?=$settings['site_keywords']?>">
                                    <small><?= lang('Admin.website_keyword_description') ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="site_description"><?= lang('Admin.website_description') ?></label>
                                    <textarea id="site_description" class="form-control settings_text" name="site_description" rows="1"><?=$settings['site_description']?></textarea>
                                    <small><?= lang('Admin.website_desc_details') ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="defualt_language"><?= lang('Admin.defualt_language') ?></label>
                                    <select class="form-control settings_text" id="defualt_language" name="defualt_language">
                                    <?php foreach ($languages as $lang): ?>
                                        <option value="<?= $lang ?>" <?= $settings['defualt_language'] == $lang ? 'selected' : '' ?>>
                                            <?= ucfirst($lang) ?>
                                        </option>
                                    <?php endforeach; ?>
                                    </select>
                                    <small><?= lang('Admin.defualt_language_description') ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="site_google_analytics"><?= lang('Admin.website_analytics') ?></label>
                                    <textarea type="text" id="site_google_analytics" name="site_google_analytics" class="form-control settings_text" rows="4"><?=$settings['site_google_analytics']?></textarea>
                                    <small><?= lang('Admin.website_analytics') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="max_upload_size"><?= lang('Admin.max_file_upload_size') ?></label>
                                    <input type="number" class="form-control settings_text" id="max_upload_size" name="max_upload_size" placeholder="<?= lang('Admin.max_file_upload_size') ?>" value="<?=$settings['max_upload_size']?>">
                                    <small><?= lang('Admin.max_file_upload_description') ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="general_og_title"><?= lang('Admin.og_title') ?></label>
                                    <input type="text" id="general_og_title" name="general_og_title" class="form-control settings_text" value="<?=$settings['general_og_title']?>">
                                    <small><?= lang('Admin.og_title_desc') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="general_og_description"><?= lang('Admin.og_description') ?></label>
                                    <textarea rows="5" class="form-control settings_text" id="general_og_description" name="general_og_description"><?=$settings['general_og_description']?></textarea>
                                    <small><?= lang('Admin.og_description_details') ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="login_page_text"><?=lang('Admin.login_page_title') ?></label>
                                    <input  class="form-control settings_text" id="login_page_title" name="login_page_title" value="<?=$settings['login_page_title']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="login_page_text"><?= lang('Admin.login_page_text') ?></label>
                                    <textarea rows="5" class="form-control settings_text" id="login_page_text" name="login_page_text"><?=$settings['login_page_text']?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1st row 2nd column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.logo_favicon') ?></h3>
                        <br>
                        <small><?= lang('Admin.logo_favicon_desc') ?></small>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" id="updatelogo">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="site_logo"><?= lang('Admin.website_logo') ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="file" name="site_logo" accept="image/*" id="site_logo">
                                </div>
                                <div class="col-md-2 offset-md-3 mt-2">
                                    <label for="site_logo"><?= lang('Admin.website_logo') ?></label>
                                </div>
                                <div class="col-md-1">
                                    <img src="<?= getMedia(get_setting('site_logo')) ?>" alt="text" height="50px" width="100%" class="img-circle" id="website_logo">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="favicon"><?= lang('Admin.favicon') ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="file" name="favicon" accept="image/*" id="faviconinput">
                                </div>
                                <div class="col-md-2 mt-2 offset-md-3">
                                    <label for="favicon"><?= lang('Admin.favicon') ?></label>
                                </div>
                                <div class="col-md-1">
                                    <img src="<?= getMedia(get_setting('favicon')) ?>" alt="text" height="50px" width="100%" class="img-circle" id="faviconImg">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.upload') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.post_advertisement') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-11">
                                <strong>
                                    <i class="fas fa-ad mr-1"></i> <?= lang('Admin.post_advertisement') ?>
                                </strong>
                                <p class="text-muted">
                                    <small><?= lang('Admin.post_adv_description') ?></small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                    <input type="checkbox" class="settings_checkbox" <?=$settings['chck-post_advertisement']==1?'checked="checked"':'';?> data-key="chck-post_advertisement">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ad-price"><?= lang('Admin.ads_price') ?></label>
                            <input type="number" class="form-control settings_text" id="ad-price" name="ad-price" placeholder="<?= lang('Admin.ads_price') ?>" value="<?=$settings['ad-price']?>">
                            <small><?= lang('Admin.ads_price_description') ?></small>
                        </div>
                        <div class="form-group">
                            <label for="ad-post_owner_share"><?= lang('Admin.post_owner_share') ?></label>
                            <input type="number" class="form-control" id="ad-post_owner_share" name="ad-post_owner_share" placeholder="<?= lang('Admin.post_owner_share') ?>" value="<?=$settings['ad-post_owner_share']?>">
                            <small><?= lang('Admin.post_owner_share_desc') ?></small>
                        </div>
                        <div class="form-group">
                            <label for="ad-admin_share"><?= lang('Admin.admin_share') ?></label>
                            <input type="number" class="form-control" id="ad-admin_share" name="ad-admin_share" placeholder="<?= lang('Admin.admin_share') ?>" value="<?=$settings['ad-admin_share']?>">
                            <small><?= lang('Admin.admin_share_desc') ?></small>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.google_advertisement') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="adid"><?= lang('Admin.google_advertisement_key') ?></label>
                            <input type="text" class="form-control settings_text" id="adid" name="adid" placeholder="<?= lang('Admin.google_advertisement_key') ?>" value="<?=$settings['adid']?>">
                            <small><?= lang('Admin.google_advertisement_desc') ?></small>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.app_links') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="playstore_app_link"><?= lang('Admin.playstore_app_link') ?></label>
                            <input type="text" class="form-control settings_text" id="playstore_app_link" name="playstore_app_link" placeholder="<?= lang('Admin.playstore_app_link') ?>" value="<?=$settings['playstore_app_link']?>">
                            <small><?= lang('Admin.playstore_app_link_desc') ?></small>
                        </div>
                        <div class="form-group">
                            <label for="appstore_app_link"><?= lang('Admin.playstore_app_link') ?></label>
                            <input type="text" class="form-control settings_text" id="appstore_app_link" name="appstore_app_link" placeholder="<?= lang('Admin.appstore_app_link') ?>" value="<?=$settings['appstore_app_link']?>">
                            <small><?= lang('Admin.appstore_app_link_desc') ?></small>
                        </div>
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
    $('#updatelogo').submit(function(e) {
        e.preventDefault(); // Prevent form submission
        var siteLogoFile = $('input[name="site_logo"]').prop('files')[0];
        var faviconFile = $('input[name="favicon"]').prop('files')[0];
        
        // Check if both file inputs are empty
        if (!siteLogoFile && !faviconFile) {
            // Show a message indicating that no file was selected
            alert('Please select a file to upload.');
            return; // Exit the function, preventing form submission
        }
        
     
        var formData = new FormData($(this)[0]); // Get form data
        $.ajax({
            url: '<?= base_url("uploadImage") ?>', // Ensure the URL is enclosed in quotes and correctly pointing to your backend script
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#faviconinput').val('');
                $('#site_logo').val('');
                $('#website_logo').attr('src', response.data.site_logo);
                $('#faviconImg').attr('src', response.data.favicon);
            }
           
        });
    });
});


        $(document).ready(function () {
        // Initial values
        var adminShareValue = parseInt($("#ad-admin_share").val()) || 0;
        var postOwnerShareValue = parseInt($("#ad-post_owner_share").val()) || 0;

        // Update other field when admin_share changes
        $("#ad-admin_share").on("input", function () {
            adminShareValue = parseInt($(this).val()) || 0;
            
            if (adminShareValue > 100) {
                alert("Admin Share can not be greater than 100%");
                return false;
            }
            updatePostOwnerShare();
        });

        // Update other field when post_owner_share changes
        $("#ad-post_owner_share").on("input", function () {
            postOwnerShareValue = parseInt($(this).val()) || 0;
   
            if (postOwnerShareValue > 100) {
                alert("Value cannot be more than 100");
            }
            updateAdminShare();
        });

        // Function to update post_owner_share based on admin_share
        function updatePostOwnerShare() {
            var remainingPercentage = 100 - adminShareValue;
            postOwnerShareValue = remainingPercentage;

            // Update the field
            $("#ad-post_owner_share").val(postOwnerShareValue);
            updatesetting(adminShareValue,postOwnerShareValue);

        }

        // Function to update admin_share based on post_owner_share
        function updateAdminShare() {
            var remainingPercentage = 100 - postOwnerShareValue;
            adminShareValue = remainingPercentage;

            // Update the field
            $("#ad-admin_share").val(adminShareValue);
            updatesetting(adminShareValue,postOwnerShareValue);
        }
        function updatesetting(admin_share,post_owner_share)
        {
            $.ajax({
                    type: "POST", // You can change this to 'GET' if needed
                    url: "<?= site_url('admin/change-ad-share') ?>", // Specify the URL where you want to send the data
                    data: {
                        admin_share: admin_share,
                        post_owner_share: post_owner_share,
                        
                    },
                    success: function(response) {
                       
                    }
                })
            
        }
        // Function to restrict a value to a specific range
      
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>-