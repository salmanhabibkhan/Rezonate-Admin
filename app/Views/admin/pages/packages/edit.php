<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <form action="<?= base_url('admin/packages/update/'.$package['id'])?>" method="post" id="create_package">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.package_name') ?></label>
                                    <input type="text" class="form-control" name="name" placeholder="<?= lang('Admin.package_name_placeholder') ?>" value="<?= $package['name'] ?>">
                                    <?php  $validation = \Config\Services::validation(); ?>
                                    <?= !empty($validation->getError('name')) ? "<span class='text-danger'>" . $validation->getError('name') . "</span>" : '' ?>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.package_color') ?></label>
                                    <input type="color" name="color" class="form-control" value="<?= $package['color'] ?>">
                                    <?= !empty($validation->getError('color')) ? "<span class='text-danger'>" . $validation->getError('color') . "</span>" : '' ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.like_amount') ?></label>
                                    <input type="number" class="form-control" name="like_amount" placeholder="<?= lang('Admin.like_amount_placeholder') ?>" value="<?= $package['like_amount'] ?>">
                                    <?= !empty($validation->getError('like_amount')) ? "<span class='text-danger'>" . $validation->getError('like_amount') . "</span>" : '' ?>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.po_like_amount') ?></label>
                                    <input type="number" min="0" max="1" class="form-control" step="0.01" name="po_like_amount" placeholder="<?= lang('Admin.po_like_amount_placeholder') ?>" value="<?= $package['po_like_amount'] ?>">
                                    <?= !empty($validation->getError('po_like_amount')) ? "<span class='text-danger'>" . $validation->getError('po_like_amount') . "</span>" : '' ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.comment_amount') ?></label>
                                    <input type="number" class="form-control" name="comment_amount" placeholder="<?= lang('Admin.comment_amount_placeholder') ?>" value="<?= $package['comment_amount'] ?>">
                                    <?= !empty($validation->getError('comment_amount')) ? "<span class='text-danger'>" . $validation->getError('comment_amount') . "</span>" : '' ?>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.po_comment_amount') ?></label>
                                    <input type="number" min="0" max="1" class="form-control" name="po_comment_amount" step="0.001" placeholder="<?= lang('Admin.po_comment_amount_placeholder') ?>" value="<?= $package['po_comment_amount'] ?>">
                                    <?= !empty($validation->getError('po_comment_amount')) ? "<span class='text-danger'>" . $validation->getError('po_comment_amount') . "</span>" : '' ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.share_amount') ?></label>
                                    <input type="number" class="form-control" name="share_amount" placeholder="<?= lang('Admin.share_amount_placeholder') ?>" value="<?= $package['share_amount'] ?>">
                                    <?= !empty($validation->getError('share_amount')) ? "<span class='text-danger'>" . $validation->getError('share_amount') . "</span>" : '' ?>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.po_share_amount') ?></label>
                                    <input type="number" class="form-control" name="po_share_amount" placeholder="<?= lang('Admin.po_share_amount_placeholder') ?>" value="<?= $package['po_share_amount'] ?>">
                                    <?= !empty($validation->getError('po_share_amount')) ? "<span class='text-danger'>" . $validation->getError('po_share_amount') . "</span>" : '' ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.package_price') ?></label>
                                    <input type="number" class="form-control" name="package_price" placeholder="<?= lang('Admin.package_price_placeholder') ?>" value="<?= $package['package_price'] ?>">
                                    <?= !empty($validation->getError('package_price')) ? "<span class='text-danger'>" . $validation->getError('package_price') . "</span>" : '' ?>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.point_spendable') ?></label>
                                    <input type="number" class="form-control" name="point_spendable" placeholder="<?= lang('Admin.point_spendable_placeholder') ?>" value="<?= $package['point_spendable'] ?>">
                                    <?= !empty($validation->getError('point_spendable')) ? "<span class='text-danger'>" . $validation->getError('point_spendable') . "</span>" : '' ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.duration') ?></label>
                                    <select name="duration" id="" class="form-control">
                                        <option value="day" <?= $package['duration'] == 'day' ? 'selected' : '' ?>><?= lang('Admin.day') ?></option>
                                        <option value="week" <?= $package['duration'] == 'week' ? 'selected' : '' ?>><?= lang('Admin.week') ?></option>
                                        <option value="month" <?= $package['duration'] == 'month' ? 'selected' : '' ?>><?= lang('Admin.month') ?></option>
                                        <option value="year" <?= $package['duration'] == 'year' ? 'selected' : '' ?>><?= lang('Admin.year') ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.package_description') ?></label>
                                    <textarea name="description" rows="1" class="form-control"><?= $package['description'] ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.video_size') ?></label>
                                    <input type="number" class="form-control" name="video_upload_size" min="0" value="<?= $package['video_upload_size'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for=""><?= lang('Admin.longer_post') ?></label>
                                    <input type="number" class="form-control" name="longer_post" min="0" value="<?= $package['longer_post'] ?>">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-5">
                                    <strong><i class="fas fa-star mr-1"></i> <?= lang('Admin.featured_members') ?></strong>
                                </div>
                                <div class="col-sm-1">
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="featured_member" <?= $package['featured_member'] == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-5">
                                    <strong><i class="fas fa-bullhorn"></i> <?= lang('Admin.post_promotion') ?></strong>
                                </div>
                                <div class="col-sm-1">
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="post_promo" <?= $package['post_promo'] == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-5">
                                    <strong><i class="fas fa-pen mr-1"></i> <?= lang('Admin.edit_post') ?></strong>
                                </div>
                                <div class="col-sm-1">
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="edit_post" <?= $package['edit_post'] == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-5">
                                    <strong><i class="fas fa-trophy  mr-1"></i> <?= lang('Admin.page_promotion') ?></strong>
                                </div>
                                <div class="col-sm-1">
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="page_promo" <?= $package['page_promo'] == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-5">
                                    <strong><i class="fas fa-check-square mr-1"></i> <?= lang('Admin.verified_badge') ?></strong>
                                </div>
                                <div class="col-sm-1">
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="verified_badge" <?= $package['verified_badge'] == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-5">
                                    <strong><i class="fas fa-exclamation-circle mr-1"></i> <?= lang('Admin.status') ?></strong>
                                </div>
                                <div class="col-sm-1">
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status" <?= $package['status'] == 'active' ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit') ?></button>
                                    <a href="<?= base_url('admin/packages') ?>" class="btn btn-danger"><?= lang('Admin.cancel') ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>



<!-- Include jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script  >
$(document).ready(function () {
        $("#create_package").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 6
                },
                like_amount: {
                    required: true
                },
                share_amount: {
                    required: true,
                    min: 0
                },
                comment_amount: {
                    required: true,
                    min: 0
                },
                po_comment_amount: {
                    required: true,
                    min: 0
                },
                po_share_amount: {
                    required: true,
                    min: 0
                },
                po_like_amount: {
                    required: true,
                    min: 0
                },
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>