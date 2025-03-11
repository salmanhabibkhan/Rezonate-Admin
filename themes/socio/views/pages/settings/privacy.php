<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
    select{
        width: auto;
    }
</style>
<div class="row g-4">
    <div class="col-lg-3">
        <?= $this->include('partials/settings_sidebar') ?>
    </div>

    <div class="col-lg-6 vstack gap-4">
        <div class="py-0 mb-0">
            <div class="card">
                <div class="card-header border-0 border-bottom">
                    <h5 class="card-title"><?= lang('Web.privacy_settings') ?></h5>
                </div>
                <div class="card-body">
                    <form id="privacySettingsForm" class="form-horizontal">
                        <!-- Who can send friend request -->
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div class="me-2">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                <h6 class="mb-0 d-inline"><?= lang('Web.who_can_send_friend_request') ?></h6>
                                <p class="small mb-0"><?= lang('Web.friend_request_description') ?></p>
                            </div>
                            <div class="col-md-6">
                                <select id="privacy_friends" name="privacy_friends" class="form-control">
                                    <option value="0" <?= $userdata['privacy_friends'] == 0 ? 'selected' : '' ?>><?= lang('Web.everyone') ?></option>
                                    <option value="1" <?= $userdata['privacy_friends'] == 1 ? 'selected' : '' ?>><?= lang('Web.mutual_friends') ?></option>
                                    <option value="2" <?= $userdata['privacy_friends'] == 2 ? 'selected' : '' ?>><?= lang('Web.no_one') ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- Who can message me -->
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div class="me-2">
                                <i class="bi bi-envelope-fill me-2"></i>
                                <h6 class="mb-0 d-inline"><?= lang('Web.who_can_message_me') ?></h6>
                                <p class="small mb-0"><?= lang('Web.message_me_description') ?></p>
                            </div>
                            <div class="col-md-6">
                                <select id="privacy_message" name="privacy_message" class="form-control">
                                    <option value="0" <?= $userdata['privacy_message'] == 0 ? 'selected' : '' ?>><?= lang('Web.everyone') ?></option>
                                    <option value="1" <?= $userdata['privacy_message'] == 1 ? 'selected' : '' ?>><?= lang('Web.friends') ?></option>
                                    <option value="2" <?= $userdata['privacy_message'] == 2 ? 'selected' : '' ?>><?= lang('Web.no_one') ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- Who can view my email -->
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div class="me-2">
                                <i class="bi bi-envelope-at-fill me-2"></i>
                                <h6 class="mb-0 d-inline"><?= lang('Web.who_can_view_email') ?></h6>
                                <p class="small mb-0"><?= lang('Web.email_view_description') ?></p>
                            </div>
                            <div class="col-md-6">
                                <select id="privacy_view_email" name="privacy_view_email" class="form-control">
                                    <option value="0" <?= $userdata['privacy_view_email'] == 0 ? 'selected' : '' ?>><?= lang('Web.everyone') ?></option>
                                    <option value="1" <?= $userdata['privacy_view_email'] == 1 ? 'selected' : '' ?>><?= lang('Web.friends') ?></option>
                                    <option value="2" <?= $userdata['privacy_view_email'] == 2 ? 'selected' : '' ?>><?= lang('Web.no_one') ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- Who can view my phone -->
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div class="me-2">
                                <i class="bi bi-telephone-fill me-2"></i>
                                <h6 class="mb-0 d-inline"><?= lang('Web.who_can_view_phone') ?></h6>
                                <p class="small mb-0"><?= lang('Web.phone_view_description') ?></p>
                            </div>
                            <div class="col-md-6">
                                <select id="privacy_view_phone" name="privacy_view_phone" class="form-control">
                                    <option value="0" <?= $userdata['privacy_view_phone'] == 0 ? 'selected' : '' ?>><?= lang('Web.everyone') ?></option>
                                    <option value="1" <?= $userdata['privacy_view_phone'] == 1 ? 'selected' : '' ?>><?= lang('Web.friends') ?></option>
                                    <option value="2" <?= $userdata['privacy_view_phone'] == 2 ? 'selected' : '' ?>><?= lang('Web.no_one') ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- Who can see my friends -->
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div class="me-2">
                                <i class="bi bi-people-fill me-2"></i>
                                <h6 class="mb-0 d-inline"><?= lang('Web.who_can_see_friends') ?></h6>
                                <p class="small mb-0"><?= lang('Web.friends_view_description') ?></p>
                            </div>
                            <div class="col-md-6">
                                <select id="privacy_see_friend" name="privacy_see_friend" class="form-control">
                                    <option value="0" <?= $userdata['privacy_see_friend'] == 0 ? 'selected' : '' ?>><?= lang('Web.everyone') ?></option>
                                    <option value="1" <?= $userdata['privacy_see_friend'] == 1 ? 'selected' : '' ?>><?= lang('Web.friends') ?></option>
                                    <option value="2" <?= $userdata['privacy_see_friend'] == 2 ? 'selected' : '' ?>><?= lang('Web.no_one') ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- Who can see my birthday -->
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div class="me-2">
                                <i class="bi bi-gift-fill me-2"></i>
                                <h6 class="mb-0 d-inline"><?= lang('Web.who_can_see_birthday') ?></h6>
                                <p class="small mb-0"><?= lang('Web.birthday_view_description') ?></p>
                            </div>
                            <div class="col-md-6">
                                <select id="privacy_birthday" name="privacy_birthday" class="form-control">
                                    <option value="0" <?= $userdata['privacy_birthday'] == 0 ? 'selected' : '' ?>><?= lang('Web.everyone') ?></option>
                                    <option value="1" <?= $userdata['privacy_birthday'] == 1 ? 'selected' : '' ?>><?= lang('Web.friends') ?></option>
                                    <option value="2" <?= $userdata['privacy_birthday'] == 2 ? 'selected' : '' ?>><?= lang('Web.no_one') ?></option>
                                </select>
                            </div>
                        </div>

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

<script src="<?= base_url('public'); ?>/assets/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#privacySettingsForm').validate({
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/settings/update-user-profile', // Update to your API endpoint
                    data: $(form).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: translate('privacy_update_success'),
                            confirmButtonText:"<?=lang('Web.ok')?>",
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            text: translate('privacy_update_error')
                        });
                    }
                });
            }
        });

        function translate(key) {
            var translations = {
                'privacy_update_success': '<?= lang('Web.privacy_update_success') ?>',
                'privacy_update_error': '<?= lang('Web.privacy_update_error') ?>'
            };
            return translations[key] || key;
        }
    });
</script>

<?= $this->endSection() ?>
