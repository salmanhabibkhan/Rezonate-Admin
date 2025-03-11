<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 col-lg-6 vstack gap-4">
        <!-- Card START -->
        <div class="content-tabs card rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li> <a href="<?= site_url('groups') ?>"><?= lang('Web.all_groups') ?></a></li>
                <li class="active"> <a href="<?= site_url('my-groups') ?>"><?= lang('Web.my_groups') ?></a></li>
            </ul>
        </div>
        <div class="card">
            <!-- Card header START -->
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-2">
                        <!-- Card title -->
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.my_groups') ?></h1>
                    </div>
                    <div class="col-sm-6 col-lg-3 ms-lg-auto">
                        <!-- Select Groups -->
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- Button modal -->
                        <a class="btn btn-primary-soft ms-auto w-100" href="<?= site_url('create-group'); ?>"> <i class="fa-solid fa-plus pe-1"></i> <?= lang('Web.create_group') ?></a>
                    </div>
                </div>
            </div>
            <!-- Card header END -->
            <!-- Card body START -->
            <div class="card-body">
                <?php if (!empty($groups)): ?>
                    <div class="row g-4">
                        <?php foreach ($groups as $group): ?>
                            <div class="col-sm-6 col-lg-4">
                                <!-- Card START -->
                                <div class="card">
                                    <div class="h-80px rounded-top" style="background-image:url(<?= getMedia('avatar', $group['avatar']) ?>); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                                    <!-- Card body START -->
                                    <div class="card-body text-center pt-0">
                                        <!-- Avatar -->
                                        <div class="avatar avatar-lg mt-n5 mb-3">
                                            <a href="<?= site_url('group/'.$group['group_name']) ?>"><img class="avatar-img rounded-circle border border-white border-3 bg-white" src="<?= $group['avatar'] ?>" alt=""></a>
                                        </div>
                                        <!-- Info -->
                                        <h5 class="mb-0"><a href="<?= site_url('group/'.$group['group_name']) ?>"><?= esc($group['group_title']) ?></a></h5>
                                        <small><?= $group['category'] ?? lang('Web.unknown') ?></small>
                                        <!-- Group stat START -->
                                        <div class="hstack gap-2 gap-xl-3 justify-content-center mt-3">
                                            <!-- Group stat item -->
                                            <div>
                                                <h6 class="mb-0"><?= esc($group['members_count']) ?></h6>
                                                <small><?= lang('Web.members') ?></small>
                                            </div>
                                            <!-- Divider -->
                                            <div class="vr"></div>
                                            <!-- Group stat item -->
                                            <div>
                                                <h6 class="mb-0"><?= $group['post_count'] ?></h6>
                                                <small><?= lang('Web.posts') ?></small>
                                            </div>
                                        </div>
                                        <!-- Group stat END -->
                                    </div>
                                    <!-- Card body END -->
                                    <!-- Card Footer START -->
                                    <div class="card-footer text-center">
                                        <a class="btn btn-info-soft btn-sm" href="<?= site_url('edit-group/' . $group['id']); ?>"> <i class="bi bi-pencil"></i> <?= lang('Web.edit') ?> </a>
                                        <a class="btn btn-danger-soft btn-sm delete_group" data-group_id="<?= $group['id'] ?>"> <i class="bi bi-trash"></i> <?= lang('Web.delete') ?> </a>
                                    </div>
                                    <!-- Card Footer END -->
                                </div>
                                <!-- Card END -->
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row mt-2">
                       <?= $pager_links ?>
                    </div>
                <?php else: ?>
                    <!-- No Groups Found START -->
                    <div class="my-sm-5 py-sm-5 text-center">
                        <i class="display-1 text-body-secondary bi bi-people"></i>
                        <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_groups_found') ?></h4>
                        <a class="btn btn-primary-soft btn-sm" href="<?= site_url('create-group'); ?>"><?= lang('Web.click_here_to_add') ?></a>
                    </div>
                    <!-- No Groups Found END -->
                <?php endif; ?>
            </div>
            <!-- Card body END -->
        </div>
        <!-- Card END -->
    </div>
    <!-- Main content END -->
</div>

<script>
$(document).on('click', '.delete_group', function (event) {
    let that = $(this);
    let group_id = that.data('group_id');
   
    Swal.fire({
        title: "<?= lang('Web.are_you_sure') ?>",
        text: "<?= lang('Web.confirm_delete_group') ?>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "<?= lang('Web.yes') ?>"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "<?= site_url('web_api/delete-group') ?>",
                data: {group_id: group_id},
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            title: "<?= lang('Web.success') ?>",
                            icon: "success",
                            html: response.message,
                            timer: 4000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location = "<?= site_url('/my-groups') ?>";
                        });
                    }
                },
                error: function(error) {
                    console.error("Error:", error);
                }
            });
        }
    });
});
</script>

<?= $this->endSection() ?>
