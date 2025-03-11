<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row g-2">
                    <div class="col-lg-3">
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.advertisements') ?></h1>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th><?= lang('Web.user_name') ?></th>
                                    <td><?= $userdata['username'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Web.email') ?></th>
                                    <td><a href="mailto:<?= $userdata['email'] ?>"><?= $userdata['email'] ?></a></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Web.post_details') ?></th>
                                    <td><a href="<?= $post_link ?>"><?= lang('Web.view_post') ?></a></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Web.ad_image') ?></th>
                                    <td><a href="<?= getMedia($ad['image']) ?>"><img src="<?= getMedia($ad['image']) ?>" alt=""></a></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Web.ad_link') ?></th>
                                    <td><a href="<?= $ad['link'] ?>"><?= lang('Web.ad_link') ?></a></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Web.ad_title') ?></th>
                                    <td><?= $ad['title'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Web.ad_body') ?></th>
                                    <td><?= $ad['body'] ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('Web.status') ?></th>
                                    <td>
                                        <?php if ($ad['status'] == 1): ?>
                                            <span class="badge bg-secondary"><i class="bi bi-hourglass-split"></i> <?= lang('Web.pending') ?></span>
                                        <?php elseif ($ad['status'] == 2): ?>
                                            <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> <?= lang('Web.approved') ?></span>
                                        <?php elseif ($ad['status'] == 3): ?>
                                            <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> <?= lang('Web.rejected') ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <?php if ($ad['status'] == 1): ?>
                    <button type="button" class="btn btn-success-soft btn-sm m-1 float-end" onclick="adaction(<?= $ad['id'] ?>, 'approve', '<?= lang('Web.confirm_approve') ?>')" title="<?= lang('Web.approve') ?>">
                        <i class="bi bi-check-circle-fill"></i> <?= lang('Web.approve') ?>
                    </button>
                    <button type="button" class="btn btn-danger-soft btn-sm m-1 float-end" onclick="adaction(<?= $ad['id'] ?>, 'reject', '<?= lang('Web.confirm_reject') ?>')" title="<?= lang('Web.reject') ?>">
                        <i class="bi bi-x-circle-fill"></i> <?= lang('Web.reject') ?>
                    </button>
                <?php endif; ?>
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
            confirmButtonText: '<?= lang('Web.yes') ?> ',
            cancelButtonText: '<?= lang('Web.cancel') ?> '
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
                            window.location.href = '<?= site_url('post-ads') ?>';
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
