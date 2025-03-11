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
                    <div class="card-header">
                        <h3 class="card-title">Social Login Settings</h3>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Facebook Login</strong>
                                <p class="text-muted">
                               <small> By enabling developer mode, error reporting will be enabled,
                                it's not recommended to enable this mode without the help of a developer,
                                this may occur some issues in your website.</small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-facebookLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-facebookLogin">
                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Vkontakte Login</strong>
                                <p class="text-muted">
                               <small> By enabling developer mode, error reporting will be enabled,
                                it's not recommended to enable this mode without the help of a developer,
                                this may occur some issues in your website.</small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-VkontakteLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-VkontakteLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Google Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-googleLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-googleLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Twitter Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-twitterLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-twitterLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Linked Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-linkedinLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-linkedinLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Instagram Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-instagramLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-instagramLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>QQ Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-qqLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-qqLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>WeChat Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-WeChatLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-WeChatLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Discord Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-DiscordLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-DiscordLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Mailru Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-MailruLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-MailruLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>OK Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-OkLogin']==1?'checked="checked"':'';?>
                                  data-key="chck-OkLogin">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Tiktok Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-tiktok_login']==1?'checked="checked"':'';?>
                                  data-key="chck-tiktok_login">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <strong><i class="fas fa-book mr-1"></i>Wordpress Login</strong>
                                <p class="text-muted">
                                <small>Turn the whole site under Maintenance.
                                You can get the site back by visiting /admincp or /admin-cp

                                </small>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <label class="switch">
                                  
                                  <input type="checkbox"
                                  class="settings_checkbox" 
                                  <?=$setttings['chck-wordpress_login']==1?'checked="checked"':'';?>
                                  data-key="chck-wordpress_login">

                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

               
                    </div>

                </div>

            </div>


            <!-- 1st row 2nd column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Setup Social Login API Keys</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    
                        <div class="form-group">
                            <label for="user_links_limit">Facebook Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Twitter Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Google Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">LinkedIn Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Vkontakte Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Instagram Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">QQ Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">WeChat Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Discord Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Mailru Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">ok.ru Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">TikTok Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Wordpress Configuration</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_links_limit" class="form-control" value="Application Secret Key">
                        </div>

                    </div>
                    </div>

                    
                </div>

            </div>


        </div>



    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>