<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <a href="<?= site_url('become-donor') ?>" class="float-end btn btn-success btn-xs" title="<?= lang('Web.become_donor') ?>">
                    <i class="bi bi-plus-circle"></i> 
                </a>
                <div class="row">
                    <div class="col-md-12" style="text-align: center;">
                        <img src="<?= site_url('uploads/placeholder/blood.png') ?>" alt="<?= lang('Web.blood_image_alt') ?>">
                    </div>
                </div>
            </div>
           <div class="row mt-4">
                <div class="col-md-10 offset-md-1" >
                   <a href="<?= site_url('find-donors') ?>">
                   <div class="card">
                        <div class="card-body">
                            <i class="bi bi-droplet"></i> <?= lang('Web.find_donor') ?>      
                        </div>
                    </div>
                   </a>
                </div>
           </div>
           <div class="row my-3">
                <div class="col-md-10 offset-md-1" >
                   <a href="<?= site_url('blood-request') ?>">
                   <div class="card">
                        <div class="card-body">
                            <i class="bi bi-droplet-fill"></i> <?= lang('Web.blood_request') ?>         
                        </div>
                    </div>
                   </a>
                </div>
           </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
