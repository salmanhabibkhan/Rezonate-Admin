<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="fairsketch">
        <link rel="icon" href="assets/images/favicon.png" />
        <title>LINKON-ULTIMATE SOCIAL MEDIA SCRIPT Installation</title>
        <link rel='stylesheet' type='text/css' href='assets/bootstrap/css/bootstrap.min.css' />

        <link rel='stylesheet' type='text/css' href='assets/css/install.css' />

        <script type='text/javascript'  src='assets/js/jquery-3.5.1.min.js'></script>
        <script type='text/javascript'  src='assets/js/feather-icons/feather.min.js'></script>
        <script type='text/javascript'  src='assets/js/jquery-validation/jquery.validate.min.js'></script>
        <script type='text/javascript'  src='assets/js/jquery-validation/jquery.form.js'></script>

    </head>
    <body>
        <div class="install-box">

            <div class="card card-install">
                <div class="card-header text-center">                    
                    <img src="assets/logo.png" class="text-center w-50">
                    <h5>ULTIMATE SOCIAL MEDIA SCRIPT Installation</h5>
                </div>
                <div class="card-body no-padding">
                    <div class="tab-container clearfix">
                        <div class="container">
                            <div class="row tab-title-bg">
                                <div id="pre-installation" class="tab-title col-sm-3 active"><i data-feather="circle" class="icon"></i><strong>1-Pre-Installation</strong></span></div>
                                <div id="verifypurchasecode" class="tab-title col-sm-3"><i data-feather="circle" class="icon"></i><strong>2-Verify Purchase Code</strong></div>
                                <div id="configuration" class="tab-title col-sm-3"><i data-feather="circle" class="icon"></i><strong>3-Configuration</strong></div>
                                
                                <div id="finished" class="tab-title col-sm-3"><i data-feather="circle" class="icon"></i><strong>3-Finished</strong></div>
                            </div>
                        </div>
                    </div>
                    <div id="alert-container">

                    </div>


                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="pre-installation-tab">
                            <div class="section">
                                <p>1. Please configure your PHP settings to match following requirements:</p>
                                <?php 
                                    $domain = $_SERVER['HTTP_HOST'].str_replace('/install/index.php', '',$_SERVER['SCRIPT_NAME']);
                                    
                                    // Add 'https://' or 'http://' based on the presence of HTTPS
                                    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
                                    
                                ?>
                                <hr />
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">PHP Settings</th>
                                                <th width="27%">Current Version</th>
                                                <th>Required Version</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PHP Version</td>
                                                <td><?php echo $current_php_version; ?></td>
                                                <td><?php echo $php_version_required; ?></td>
                                                <td class="text-center">
                                                    <?php if ($php_version_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="section">
                                <p>2. Please make sure the extensions/settings listed below are installed/enabled:</p>
                                <hr />
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">Extension/settings</th>
                                                <th width="27%">Current Settings</th>
                                                <th>Required Settings</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>MySQLi</td>
                                                <td> <?php if ($mysql_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mysql_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>GD</td>
                                                <td> <?php if ($gd_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($gd_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>cURL</td>
                                                <td> <?php if ($curl_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($curl_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>mbstring</td>
                                                <td> <?php if ($mbstring_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mbstring_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>intl</td>
                                                <td> <?php if ($intl_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($intl_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>json</td>
                                                <td> <?php if ($json_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($json_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>mysqlnd</td>
                                                <td> <?php if ($mysqlnd_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mysqlnd_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>xml</td>
                                                <td> <?php if ($xml_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($xml_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>zlib.output_compression</td>
                                                <td> <?php if ($zlib_success) { ?>
                                                        Off
                                                    <?php } else { ?>
                                                        On
                                                    <?php } ?>
                                                </td>
                                                <td>Off</td>
                                                <td class="text-center">
                                                    <?php if ($zlib_success) { ?>
                                                        <i data-feather="check-circle" class="status-icon"></i>
                                                    <?php } else { ?>
                                                        <i data-feather="x-circle" class="status-icon"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="section">
                                <p>3. Please make sure you have set the <strong>writable</strong> permission on the following folders/files:</p>
                                <hr />
                                <div>
                                    <table>
                                        <tbody>
                                            <?php
                                            foreach ($writeable_directories as $value) {
                                                ?>
                                                <tr>
                                                    <td style="width:87%;"><?php echo $value; ?></td>  
                                                    <td class="text-center">
                                                        <?php if (is_writeable(".." . $value)) { ?>
                                                            <i data-feather="check-circle" class="status-icon"></i>
                                                            <?php
                                                        } else {
                                                            $all_requirement_success = false;
                                                            ?>
                                                            <i data-feather="x-circle" class="status-icon"></i>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button <?php
                                if (!$all_requirement_success) {
                                    echo "disabled=disabled";
                                }
                                ?> class="btn btn-info verifypurchasecode text-white"><i data-feather="chevron-right" class='icon'></i> Next</button>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane " id="purchasecode-tab">
                            <form name="purchasecode-form" id="purchasecode-form"  method="post" action="https://verify.linkon.social/index.php">

                                <div class="section clearfix">
                                    <p>4. Please enter your item purchase code..</p>
                                    <hr />
                                    <div>
                                    <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="verify_email" class=" col-md-3">Domain</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" readonly id="domain_name" name="domain_name" value="<?= $scheme.$domain; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="product" value="53692029">
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="verify_email" class=" col-md-3">Email</label>
                                                <div class="col-md-9">
                                                    <input type="email" id="verify_email" name="verify_email" class="form-control" placeholder="Your email" required/>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                              
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="purchase_code" class=" col-md-3">Purchase Code</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="purchase_code" name="purchase_code" class="form-control" placeholder="Your purchase code" required/>
                                                    <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">How to find your purchase code?</a>
                                                </div>

                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info ">
                                        <span class="loader text-white hide"><span> Please wait...</span></span>
                                        <span class="button-text text-white"><i data-feather="chevron-right" class='icon'></i> Next</span> 
                                    </button>
                                </div>

                            </form>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="configuration-tab">
                            <form name="config-form" id="config-form" action="do_install.php" method="post">

                                <div class="section clearfix">
                                    <p>1. Please enter your database connection details.</p>
                                    <hr />
                                    <div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="host" class=" col-md-3">Database Host</label>
                                                <div class="col-md-9">
                                                    <input type="text" value="" id="host"  name="host" class="form-control" placeholder="Database Host (usually localhost)" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="dbuser" class=" col-md-3">Database User</label>
                                                <div class=" col-md-9">
                                                    <input id="dbuser" type="text" value="" name="dbuser" class="form-control" autocomplete="off" placeholder="Database user name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="dbpassword" class=" col-md-3">Password</label>
                                                <div class=" col-md-9">
                                                    <input id="dbpassword" type="password" value="" name="dbpassword" class="form-control" autocomplete="off" placeholder="Database user password" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="dbname" class=" col-md-3">Database Name</label>
                                                <div class=" col-md-9">
                                                    <input id="dbname" type="text" value="" name="dbname" class="form-control" placeholder="Database Name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="dbprefix" class=" col-md-3">Database Prefix</label>
                                                <div class=" col-md-9">
                                                    <input id="dbprefix" type="text" value="lon<?=rand(10,99)?>_" name="dbprefix" class="form-control" placeholder="Database Prefix" maxlength="21" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section clearfix">
                                    <p>2. Please write your information.</p>
                                    <hr />
                                    <div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="first_name" class=" col-md-3">First Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" value=""  id="first_name"  name="first_name" class="form-control"  placeholder="Your first name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="last_name" class=" col-md-3">Last Name</label>
                                                <div class=" col-md-9">
                                                    <input type="text" value="" id="last_name"  name="last_name" class="form-control"  placeholder="Your last name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="email" class=" col-md-3">Email</label>
                                                <div class=" col-md-9">
                                                    <input id="email" type="text" value="" name="email" class="form-control" placeholder="Your email" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="email" class=" col-md-3">Purchase Code</label>
                                                <div class=" col-md-9">
                                                    <input id="purchasecode" readonly type="text" value="" name="purchasecode" class="form-control" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="section clearfix">
                                    <p>3. Please enter your item purchase code.</p>
                                    <hr />
                                    <div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="purchase_code" class=" col-md-3">Item purchase code</label>
                                                <div class="col-md-9">
                                                    <input type="text" value=""  id="purchase_code"  name="purchase_code" class="form-control"  placeholder="Find in codecanyon item download section" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info form-next">
                                        <span class="loader text-white hide"><span> Please wait...</span></span>
                                        <span class="button-text text-white"><i data-feather="chevron-right" class='icon'></i> Finish</span> 
                                    </button>
                                </div>

                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="finished-tab">
                            <div class="section">
                                <div class="clearfix">
                                    <i data-feather="check-circle" height="2.5rem" width="2.5rem" stroke-width="3" class='status mr10'></i><span class="pull-left"  style="line-height: 50px;">Congratulation! You have successfully installed LINKON-ULTIMATE SOCIAL MEDIA SCRIPT</span>  
                                </div>

                                <div style="margin: 15px 0 15px 55px; color: #d73b3b;">
                                    Don't forget to delete the <b>install</b> directory!
                                </div>
                                <a class="go-to-login-page" href="<?php echo $dashboard_url; ?>">
                                    <div class="text-center">
                                        <div style="font-size: 100px;"><i data-feather="monitor" height="7rem" width="7rem" class="mb-2"></i></div>
                                        <div>GO TO YOUR LOGIN PAGE</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    function toggleSubmitButton($form, disable) {
        var $submitButton = $form.find('[type="submit"]');
        if (disable) {
            $submitButton.attr('disabled', true);
            $submitButton.find(".loader").removeClass("hide");
            $submitButton.find(".button-text").addClass("hide");
        } else {
            $submitButton.removeAttr('disabled');
            $submitButton.find(".loader").addClass("hide");
            $submitButton.find(".button-text").removeClass("hide");
        }
        $("#alert-container").empty();
    }

    $(document).ready(function () {
        $(".form-next").click(function () {
            if ($("#pre-installation-tab").hasClass("active")) {
                $("#pre-installation-tab").removeClass("active");
                $("#configuration-tab").addClass("active");
                $("#pre-installation").find("svg").remove();
                $("#pre-installation").prepend('<i data-feather="check-circle" class="icon"></i>');
                feather.replace();
                $("#configuration").addClass("active");
                $("#host").focus();
            }
        });

        $(".verifypurchasecode").click(function () {
            if ($("#pre-installation-tab").hasClass("active")) {
                $("#pre-installation-tab").removeClass("active");
                $("#purchasecode-tab").addClass("active");
                $("#pre-installation").find("svg").remove();
                $("#pre-installation").prepend('<i data-feather="check-circle" class="icon"></i>');
                feather.replace();
                $("#verifypurchasecode").addClass("active");
                $("#host").focus();
            }
        });

        $("#config-form").submit(function (e) {
            e.preventDefault();
            var $form = $(this);
            toggleSubmitButton($form, true);
            
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    toggleSubmitButton($form, false);
                    if (result.success) {
                        $("#configuration-tab").removeClass("active");
                        $("#configuration").find("svg").remove();
                        $("#configuration").prepend('<i data-feather="check-circle" class="icon"></i>');
                        $("#finished").find("svg").remove();
                        $("#finished").prepend('<i data-feather="check-circle" class="icon"></i>');
                        feather.replace();
                        $("#finished").addClass("active");
                        $("#finished-tab").addClass("active");
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                },
                error: function (xhr) {
                    $("#alert-container").html('<div class="alert alert-danger" role="alert">An error occurred: ' + xhr.responseText + '</div>');
                    toggleSubmitButton($form, false);
                }
            });
        });

        $("#purchasecode-form").submit(function (e) {
            e.preventDefault();
            var $form = $(this);
            toggleSubmitButton($form, true);

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    toggleSubmitButton($form, false);
                    if (response.status === 'success') {
                        $("#configuration").addClass("active");
                        $("#verifypurchasecode").find("svg").remove();
                        $("#verifypurchasecode").prepend('<i data-feather="check-circle" class="icon"></i>');
                        feather.replace();
                        $("#configuration-tab").addClass('active');
                        $("#purchasecode-tab").removeClass('active');
                        $("#purchasecode").val($('#purchase_code').val());
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    $("#alert-container").html('<div class="alert alert-danger" role="alert">An error occurred: ' + xhr.responseText + '</div>');
                    toggleSubmitButton($form, false);
                }
            });
        });

        $('#dbprefix').on('keyup', function () {
            var sanitizedValue = $(this).val().replace(/[^a-z_]/g, '');
            $(this).val(sanitizedValue);
        }).on('blur', function () {
            var dbPrefixValue = $(this).val().substring(0, 20);
            if (!dbPrefixValue.endsWith("_")) {
                dbPrefixValue += '_';
            }
            $(this).val(dbPrefixValue);
        });
    });
</script>
