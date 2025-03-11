<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <!-- Main content START -->
    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <!-- Card header START -->
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-8">
                        <!-- Card title -->
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.notifications') ?></h1>
                    </div>

                    <div class="col-4">
                        <?php if($is_seen == 1): ?>
                        <a class="btn btn-success-soft ms-auto btn-sm markread" href="#">
                            <i class="fa-solid fa-check pe-1"></i> <?= lang('Web.mark_all_read') ?>
                        </a>
                        <?php endif; if(!empty($notifications)): ?>
                        <a class="btn btn-danger-soft ms-auto btn-sm float-end deleteallnotification" href="#">
                            <i class="fa-solid fa-trash pe-1"></i> <?= lang('Web.delete_all') ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <?php if (!empty($notifications)) { ?>
                <ul class="list-unstyled">
                    <?php foreach ($notifications as $notification): ?>
                    <li class="notification_row">
                        <a href="<?= site_url('notification/' . $notification['id']) ?>">
                            <div class="rounded <?= $notification['seen'] == 0 ? 'badge-unread' : '' ?> notification_item d-sm-flex border-0 mb-1 p-3 position-relative">
                                <div class="avatar text-center">
                                    <img class="avatar-img rounded-circle" src="<?= $notification['notifier']['avatar'] ?>" alt="">
                                </div>
                                <!-- Info -->
                                <div class="mx-sm-3 my-2 my-sm-0">
                                    <p class="small <?= $notification['type'] == 'sent_request' ? 'mb-2' : '' ?>"><b>
                                        <a href="<?= site_url($notification['notifier']['username']) ?>"><?= $notification['notifier']['first_name'] . ' ' . $notification['notifier']['last_name'] ?></a>
                                        </b> <a href="<?= site_url('notification/' . $notification['id']) ?>" style="color:inherit;">
                                            <?= $notification['text'] ?> </a></p>

                                    <?php if($notification['type'] == 'Like-page'): ?>
                                    <a href="<?= site_url('notification/' . $notification['id']) ?>"><?= lang('Web.view_page') ?></a>
                                    <?php endif; ?>
                                    <?php if($notification['type'] == 'Join-group'): ?>
                                    <a href="<?= site_url('notification/' . $notification['id']) ?>"><?= lang('Web.view_group') ?></a>
                                    <?php endif; ?>
                                    <?php if($notification['type'] == 'Comment' || $notification['type'] == 'post-reaction' || $notification['type'] == 'share-post' || $notification['type2'] > 0): ?>
                                    <a href="<?= site_url('notification/' . $notification['id']) ?>"><?= lang('Web.view_post') ?></a>
                                    <?php endif; ?>
                                    <?php if($notification['type'] == 'sent_request'): ?>
                                    <?php if ($notification['is_reacted'] == 0): ?>
                                    <div class="notificationbtn">
                                        <button class="btn btn-sm py-1 btn-primary me-2 accept_req"
                                            data-notification_id="<?= $notification['id'] ?>"
                                            data-user_id="<?= $notification['from_user_id'] ?>"><?= lang('Web.accept') ?></button>
                                        <button class="btn btn-sm py-1 btn-danger-soft delete_req"
                                            data-notification_id="<?= $notification['id'] ?>"
                                            data-user_id="<?= $notification['from_user_id'] ?>"><?= lang('Web.delete') ?></button>
                                    </div>
                                    <?php endif ?>
                                    <?php endif; ?>
                                </div>
                                <!-- Action -->
                                <div class="d-flex ms-auto">
                                    <p class="small me-5 text-nowrap"><?= HumanTime($notification['created_at']) ?></p>
                                    <!-- Notification action START -->
                                    <div class="dropdown position-absolute end-0 top-0 mt-3 me-3">
                                        <a href="#" class="z-index-1 text-secondary btn position-relative py-0 px-2"
                                            id="cardNotiAction2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </a>
                                        <!-- Card share action dropdown menu -->
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardNotiAction2">
                                            <li><a class="dropdown-item delete_notification" href="#"
                                                    data-notification_id="<?= $notification['id'] ?>"> <i
                                                        class="bi bi-trash fa-fw pe-2"
                                                        data-notification_id="<?= $notification['id'] ?>"></i><?= lang('Web.delete') ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Notification action END -->
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php } else { ?>
                <!-- No Notifications Found START -->
                <div class="my-sm-5 py-sm-5 text-center">
                    <i class="display-1 text-body-secondary bi bi-bell"></i>
                    <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_notifications') ?></h4>
                </div>
                <!-- No Notifications Found END -->
                <?php } ?>
                <div class="my-sm-5 py-sm-5 text-center no_notification d-none">
                    <i class="display-1 text-body-secondary bi bi-bell"></i>
                    <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_notifications') ?></h4>
                </div>
            </div>
            <!-- Card body END -->
        </div>
        <!-- Card END -->
    </div>
    <!-- Main content END -->
</div>

<script>
    $(document).on("click", ".accept_req", function() {
        let that = $(this);
        let notification_id = that.data('notification_id');
        let user_id = that.data('user_id');

        $.ajax({
            type: "post",
            url: site_url + "web_api/friend-request-action",
            data: {
                user_id: user_id,
                request_action: 'accept',
                notification_id: notification_id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.code == 200) {
                    that.closest(".badge-unread").removeClass("badge-unread");
                    that.closest(".notificationbtn").remove();
                }
            },
        });
    });
    $(document).on("click", ".delete_req", function() {
        let that = $(this);
        let notification_id = that.data('notification_id');
        let user_id = that.data('user_id');
        $.ajax({
            type: "post",
            url: site_url + "web_api/friend-request-action",
            data: {
                user_id: user_id,
                request_action: 'decline',
                notification_id: notification_id
            },
            dataType: "json",
            success: function(response) {
                if (response.code == 200) {
                    that.closest(".badge-unread").removeClass("badge-unread");
                    that.closest(".notificationbtn").remove();

                }
            },
        });
    });
    $(document).on("click", ".delete_notification", function() {
        let that = $(this);
        let notification_id = that.data('notification_id');

        $.ajax({
            type: "post",
            url: site_url + "web_api/notifications/delete",
            data: {
                notification_id: notification_id
            },
            dataType: "json",
            success: function(response) {
                if (response.code == 200) {
                    if (response.count_notification === 0) {
                        $('.deleteallnotification').remove();
                        $('.markread').remove();
                        $('.no_notification').removeClass('d-none');
                    }

                    that.closest(".notification_row").remove();

                }
            },
        });
    });
    $(document).on("click", ".markread", function() {
        let that = $(this);


        $.ajax({
            type: "post",
            url: site_url + "web_api/notifications/mark-all-as-read",
            data: {},
            dataType: "json",
            success: function(response) {
                if (response.code == 200) {
                    alert(response.message);

                    window.location = site_url + 'notifications';

                }
            },
        });
    });
</script>
<?= $this->endSection() ?>
