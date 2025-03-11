<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-3">
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.advertisements') ?></h1>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                      
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($ads)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <th><?= lang('Web.sr_no') ?></th>
                                    <th><?= lang('Web.image') ?></th>
                                    <th><?= lang('Web.ad_link') ?></th>
                                    <th><?= lang('Web.ad_title') ?></th>
                                    <th><?= lang('Web.action') ?></th>
                                </thead>
                                <tbody>
                                    <?php foreach ($ads as $key => $ad) : ?>
                                        <tr>
                                            <td><?= ++$key ;?></td>
                                            <td> <a href="<?= getMedia($ad['image']) ;?>" ><img src="<?= getMedia($ad['image']) ;?>" style="width:50px;height:50px;"></a> </td>
                                            <td><?= $ad['email'] ;?></td>
                                            <td><?= $ad['title'] ;?></td>
                                            <td>
                                                <a class="btn btn-primary-soft btn-sm m-1 float-right" title="<?= lang('Web.view_post') ?>" href="<?= site_url('ad-details/'.$ad['id']) ?>" > <i class="bi bi-eye"></i> </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="my-sm-5 py-sm-5 text-center">
                            <i class="display-1 text-body-secondary bi bi-badge-ad"></i>
                            <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_ad_found') ?></h4>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="card-footer">
              
            </div>
        </div>
    </div>
</div>

<script>
    function adaction(ad_id, action, text) {
        Swal.fire({
            title: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= lang('Web.yes') ?> ' + action + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: site_url + "web_api/post/ad-action",
                    data: { action: action, ad_id: ad_id },
                    success: function(response) {
                        Swal.fire({
                            title: "<?= lang('Web.success_msg') ?>",
                            icon: "success",
                            html: response.message,
                            timer: 4000,
                            timerProgressBar: true,
                        });
                        setTimeout(() => {
                            window.location.href = '<?= site_url("post-ads") ?>';
                        }, 3000);
                    },
                    error: function() {
                        Swal.fire({
                            title: "<?= lang('Web.error_msg') ?>",
                            icon: "error",
                        });
                    }
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>
