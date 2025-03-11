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
                   


                    <div class="tab-content">
                       
                        <div role="tabpanel" class="tab-pane active" >
                            <div class="section">
                                <div class="clearfix">
                                    <i data-feather="check-circle" height="2.5rem" width="2.5rem" stroke-width="3" class='status mr10'></i><span class="pull-left"  style="line-height: 50px;">Looks like you have already installed LINKON-ULTIMATE SOCIAL MEDIA</span>  
                                </div>

                                <div style="margin: 15px 0 15px 55px; color: #d73b3b;">
                                    
                                    Please Delete the <b>install</b> directory!
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
    const onFormSubmit = ($form) => {
        const submitButton = $form.find('[type="submit"]');
        submitButton.attr('disabled', 'disabled').find(".loader").removeClass("hide");
        submitButton.find(".button-text").addClass("hide");
        $("#alert-container").html("");
    };

    const onSubmitSuccess = ($form) => {
        const submitButton = $form.find('[type="submit"]');
        submitButton.removeAttr('disabled').find(".loader").addClass("hide");
        submitButton.find(".button-text").removeClass("hide");
    };

    feather.replace();

    $(document).ready(() => {
        const $preInstallationTab = $("#pre-installation-tab");
        const $configurationTab = $("#configuration-tab");

        $(".form-next").click(() => {
            if ($preInstallationTab.hasClass("active")) {
                $preInstallationTab.removeClass("active");
                $configurationTab.addClass("active");
                $("#pre-installation").find("svg").remove();
                $("#pre-installation").prepend('<i data-feather="check-circle" class="icon"></i>');
                feather.replace();
                $("#configuration").addClass("active");
                $("#host").focus();
            }
        });

        $("#config-form").submit(function () {
            const $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: (result) => {
                    onSubmitSuccess($form);
                    if (result.success) {
                        $configurationTab.removeClass("active");
                        $("#configuration").find("svg").remove();
                        $("#configuration").prepend('<i data-feather="check-circle" class="icon"></i>');
                        $("#finished").find("svg").remove();
                        $("#finished").prepend('<i data-feather="check-circle" class="icon"></i>');
                        feather.replace();
                        $("#finished").addClass("active");
                        $("#finished-tab").addClass("active");
                    } else {
                        $("#alert-container").html(`<div class="alert alert-danger" role="alert">${result.message}</div>`);
                    }
                }
            });
            return false; // Prevent the default form submission.
        });

        $('#dbprefix').on('keyup', () => {
            const $dbPrefix = $('#dbprefix');
            const replacedValue = $dbPrefix.val().replace(/[^a-z_]/g, '');
            $dbPrefix.val(replacedValue);
        }).on('blur', () => {
            let dbPrefixValue = $('#dbprefix').val().substring(0, 20); // Allow only 20 characters for prefix.
            dbPrefixValue += dbPrefixValue.endsWith("_") ? '' : '_'; // Add underscore if not exists.
            $('#dbprefix').val(dbPrefixValue);
        });
    });
</script>
