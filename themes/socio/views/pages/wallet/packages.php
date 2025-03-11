<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>
    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card pricing">
            <div class="card-header border-bottom">
                <h4 class="h4 "><?= esc(lang('Web.pick_your_plan')) ?></h4> <!-- Use translation for "Pick your Plan" -->
                <p>
                    <?= esc(lang('Web.pro_features_description')) ?> <!-- Use translation for "Pro features..." -->
                </p>
            </div>
            <div class="card-body">

                <div class="row">
                    <?php foreach($packages as $package):?>
                    <div class="col-lg-4">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body"> 
                                <h5 class="card-title text-uppercase text-center"><?= $package['name'] ;?></h5>
                                <h6 class="card-price text-center">$<?= $package['package_price'] ;?><span class="period">/<?= $package['duration'] ;?></span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li>
                                        <span class="fa-li"><?php if($package['featured_member']==1):?><i class="fas fa-check text-success"></i><?php else:?><i class="fas fa-close text-danger"></i><?php endif ;?></span><?= esc(lang('Web.featured_member')) ?> <!-- Translate "Feature Members" -->
                                    </li>
                                    <li>
                                        <span class="fa-li"><?php if($package['verified_badge']==1):?><i class="fas fa-check text-success"></i><?php else:?><i class="fas fa-close text-danger"></i><?php endif ;?></span><?= esc(lang('Web.verified_badge')) ?> <!-- Translate "Verified Badge" -->
                                    </li>
                                    <li>
                                        <span class="fa-li"><?php if($package['page_promo']==1):?><i class="fas fa-check text-success"></i><?php else:?><i class="fas fa-close text-danger"></i><?php endif ;?></span><?= esc(lang('Web.page_promotion')) ?> <!-- Translate "Page Promotion" -->
                                    </li>
                                    <li>
                                        <span class="fa-li"><?php if($package['post_promo']==1):?><i class="fas fa-check text-success"></i><?php else:?><i class="fas fa-close text-danger"></i><?php endif ;?></span><?= esc(lang('Web.post_promotion')) ?> <!-- Translate "Post Promotion" -->
                                    </li>
                                    <li>
                                        <span class="fa-li"><?php if($package['edit_post']==1):?><i class="fas fa-check text-success"></i><?php else:?><i class="fas fa-close text-danger"></i><?php endif ;?></span><?= esc(lang('Web.edit_post')) ?> <!-- Translate "Edit Post" -->
                                    </li>
                                    <li>
                                        <span class="fa-li"><i class="fas fa-check text-success"></i></span><?= $package['point_spendable'] ;?> <?= esc(lang('Web.point_spendable')) ?> <!-- Translate "Point Spendable" -->
                                    </li>
                                </ul>
                                <div class="d-grid">
                                    <?php if(get_setting('chck-upgrade_to_pro_system')==1):
                                        if( $user['level']== $package['id']):?>
                                            <a href="#" class="btn btn-success-soft text-uppercase"> <i class="bi bi-check-circle"></i> <?= esc(lang('Web.selected')) ?> <!-- Translate "Selected" --></a>
                                        <?php else:?>
                                            <button class="btn btn-primary-soft text-uppercase purchase_package" data-package_id="<?= $package['id'] ;?>"> <?= esc(lang('Web.select')) ?> <!-- Translate "Select" --></button>
                                        <?php endif;
                                    endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click', ".purchase_package", function () {
    Swal.fire({
        title: "<?= esc(lang('Web.confirmation_title')) ?>", // Translate "Are you sure?"
        text: "<?= esc(lang('Web.confirmation_text')) ?>", // Translate "Are you sure to purchase this package?"
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "<?= esc(lang('Web.yes')) ?>", // Translate "Yes"
    }).then((result) => {
        if(result.isConfirmed) {
            var that = $(this);
            that.html("<?= esc(lang('Web.sending_request')) ?>"); // Translate "Sending request"
            that.removeClass('send_req');
            var package_id = that.data('package_id');
            $.ajax({
                type: "post",
                url: site_url + "web_api/upgrade-to-pro",
                dataType: "json",
                data: { package_id: package_id },
                success: function (response) {
                    Swal.fire({
                        title: "<?= esc(lang('Web.success')) ?>", // Translate "Success"
                        icon: "success",
                        html: response.message,
                        timer: 4000,
                        timerProgressBar: true
                    }).then((result) => {
                        window.location = site_url + "packages";
                    });
                },
                error: function () {
                    that.html("<?= esc(lang('Web.send_request')) ?>"); // Translate "Send Request"
                }
            });
        }
    });
});
</script>

<?= $this->endSection() ?>
