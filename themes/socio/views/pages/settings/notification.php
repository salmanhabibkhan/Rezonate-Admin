<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-3">
        <?= $this->include('partials/settings_sidebar') ?>
    </div>

    <div class="col-lg-6 vstack gap-4">
        <div class="py-0 mb-0">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h5 class="card-title"><?= lang('Web.notification_settings') ?> </h5>
                </div>
                <div class="card-body">
                    <form id="notificationSettingsForm" class="row g-3">
                        <!-- Notification Types with Icons -->
                        <?php
                        $notifications = [
                            'notify_like' => ['liked_my_posts', 'liked_my_posts_description', 'bi-hand-thumbs-up'],
                            'notify_comment' => ['commented_on_my_posts', 'commented_on_my_posts_description', 'bi-chat-dots'],
                            'notify_share_post' => ['shared_my_posts', 'shared_my_posts_description', 'bi-share'],
                            'notify_accept_request' => ['accepted_request', 'accepted_request_description', 'bi-person-check'],
                            'notify_liked_page' => ['liked_my_pages', 'liked_my_pages_description', 'bi-hand-thumbs-up'],
                            'notify_joined_group' => ['joined_my_groups', 'joined_my_groups_description', 'bi-people'],
                            'notify_message' => ['received_message', 'received_message_description', 'bi-chat-fill'],
                            'notify_friends_newpost' => ['friends_new_post', 'friends_new_post_description', 'bi-gem'],
                            'notify_profile_visit' => ['profile_visit', 'profile_visit_description', 'bi-person-check'],
                        ];

                        foreach ($notifications as $key => [$titleKey, $descriptionKey, $icon]): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <div class="me-2">
                                    <i class="<?= esc($icon) ?> me-2"></i>
                                    <h6 class="mb-0 d-inline"><?= lang('Web.' . esc($titleKey)) ?></h6>
                                    <p class="small mb-0"><?= lang('Web.' . esc($descriptionKey)) ?></p>
                                </div>
                                <div class="form-check form-switch">
                                    <!-- Hidden field to send 0 when checkbox is unchecked -->
                                    <input type="hidden" name="<?= esc($key) ?>" value="0">
                                    <!-- Checkbox field -->
                                    <input class="form-check-input" type="checkbox" role="switch" id="<?= esc($key) ?>" name="<?= esc($key) ?>" value="1" <?= isset($userdata[$key]) && $userdata[$key] == '1' ? 'checked' : '' ?>>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- Submit Button -->
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary mb-0"><?= lang('Web.save_changes') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#notificationSettingsForm').validate({
            submitHandler: function(form) {
                var formData = {};
                $(form).find('input[type="checkbox"]').each(function() {
                    formData[this.name] = this.checked ? "1" : "0";
                });

                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/settings/update-user-profile',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            confirmButtonText:"<?=lang('Web.ok')?>"
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            confirmButtonText:"<?=lang('Web.ok')?>"
                        });
                    }
                });
            }
        });

        function translate(key) {
            var translations = {
                'notification_update_success': '<?= lang('Web.notification_update_success') ?>',
                'notification_update_error': '<?= lang('Web.notification_update_error') ?>'
            };
            return translations[key] || key;
        }
    });
</script>

<?= $this->endSection() ?>
