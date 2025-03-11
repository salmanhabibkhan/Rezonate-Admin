
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <?php if(isset($page_title)){ ?>
        <title><?=$page_title." ".get_setting('site_name');?></title>
    <?php }else{ ?>
        <title><?=get_setting('site_name');?> - Admin</title>
    <?php } ?>

    <link rel="stylesheet" href="<?=base_url('public');?>/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url('public');?>/assets/css/adminlte.min.css">
    <link rel="stylesheet" href="<?=base_url('public');?>/assets/css/datatables.min.css">
    <link rel="stylesheet" href="<?=base_url('public');?>/assets/css/custom_admin.css">
    <link rel="stylesheet" href="<?=base_url('public');?>/plugins/toastr/css/toastr.min.css">
    <link rel="icon" type="image/x-icon" href="<?= getMedia(get_setting('favicon')) ?>">
   
    <?= isset($css_files) ? load_css($css_files) : '' ?>
    
    <script type="text/javascript">
        var site_url = "<?=site_url();?>";
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?= $this->include('admin/_layouts/_partials/navbar') ?>
        <?= $this->include('admin/_layouts/_partials/sidebar') ?>
        <div class="content-wrapper p-3">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
        <?= $this->include('admin/_layouts/_partials/footer') ?>
    </div>


    

    <script src="<?=base_url('public');?>/assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?=base_url('public');?>/plugins/toastr/js/toastr.min.js"></script>
    <script src="<?=base_url('public');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?=base_url('public');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url('public');?>/assets/js/adminlte.js"></script>
    <?= isset($js_files) ? load_js($js_files) : '' ?>
    <script src="<?=base_url('public');?>/assets/js/custom_admin.js"></script>

    <?php if (session()->has('success')): ?>
    <script>
        toastr.success("<?= session('success') ?>");
    </script>
<?php elseif(session()->has('error')): ?>
    <script>
        toastr.error("<?= session()->get('error') ?>");
    </script>
<?php endif; ?>
    <?= $this->renderSection('script') ?>
</body>

</html>

