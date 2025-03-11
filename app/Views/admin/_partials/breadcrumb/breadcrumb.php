<?php if(isset($breadcrumbs)){ ?>

 <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?=isset($page_title)?$page_title:get_setting('site_name');?></h1>
                <ol class="breadcrumb ">
                    <li class="mr-1"><i class="nav-icon fas fa-tachometer-alt"></i></li>
                     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <?php if(!empty($breadcrumb['url'])) {
                            echo '<li class="breadcrumb-item"><a class="" href="'.$breadcrumb["url"].'">'.$breadcrumb["name"].'</a></li>';
                        }else{
                            echo '<li class="breadcrumb-item active">'.$breadcrumb['name'].'</li>';
                        } ?>
                    <?php } ?>
                </ol>
            </div>
           
        </div>
    </div>
</div> 
<?php } ?>

