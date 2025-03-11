<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-3">
        <?= $this->include('partials/settings_sidebar') ?>
    </div>

    <div class="col-lg-6 vstack gap-4">
        <div class="py-0 mb-0">
            <div class="card mb-4">
                <div class="card-header border-0 border-bottom">
                    <h1 class="h5 card-title"><?= lang('Web.update_profile') ?></h1>
                </div>
                <div class="card-body">
                    <form class="row g-3" id="userProfileForm" method="post" enctype="multipart/form-data">

                        <!-- Avatar Upload -->
                        <div class="col-12">
                            <label class="form-label"><?= lang('Web.profile_avatar') ?></label>
                            <input type="file" class="form-control" id="avatar" name="avatar" onchange="previewImage('avatar', 'avatarPreview')">
                            <img id="avatarPreview" src="<?= esc($userdata['avatar']) ?>" alt="<?= lang('Web.avatar_preview') ?>" style="max-width: 100px; max-height: 100px;">
                        </div>

                        <!-- Cover Upload -->
                        <?php if (get_setting('chck-profile_back') != '0') : ?>
                            <div class="col-12">
                                <label class="form-label"><?= lang('Web.profile_cover') ?></label>
                                <input type="file" class="form-control" id="cover" name="cover" onchange="previewImage('cover', 'coverPreview')">
                                <img id="coverPreview" src="<?= esc($userdata['cover']) ?>" alt="<?= lang('Web.cover_preview') ?>" style="max-width: 300px; max-height: 100px;">
                            </div>
                        <?php endif; ?>

                        <!-- First name -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.first_name') ?></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="<?= lang('Web.first_name') ?>" value="<?= esc($userdata['first_name']) ?>">
                        </div>
                        <!-- Last name -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.last_name') ?></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="<?= lang('Web.last_name') ?>" value="<?= esc($userdata['last_name']) ?>">
                        </div>
                        <!-- About You -->
                        <div class="col-12">
                            <label class="form-label"><?= lang('Web.about_you') ?></label>
                            <textarea class="form-control" id="about_you" name="about_you" rows="3" placeholder="<?= lang('Web.about_you') ?>"><?= esc($userdata['about_you']) ?></textarea>
                        </div>
                        <!-- Gender -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.gender') ?></label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="Male" <?= $userdata['gender'] == 'Male' ? 'selected' : '' ?>><?= lang('Web.male') ?></option>
                                <option value="Female" <?= $userdata['gender'] == 'Female' ? 'selected' : '' ?>><?= lang('Web.female') ?></option>
                                <option value="Other" <?= $userdata['gender'] == 'Other' ? 'selected' : '' ?>><?= lang('Web.other') ?></option>
                            </select>
                        </div>
                        <!-- Address -->
                        <div class="col-12">
                            <label class="form-label"><?= lang('Web.address') ?></label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="<?= lang('Web.address') ?>"><?= esc($userdata['address']) ?></textarea>
                        </div>
                        <!-- Phone -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.phone') ?></label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="<?= lang('Web.phone') ?>" value="<?= esc($userdata['phone']) ?>">
                        </div>
                        <!-- City -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.city') ?></label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="<?= lang('Web.city') ?>" value="<?= esc($userdata['city']) ?>">
                        </div>
                        <!-- Email -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.email') ?></label>
                            <input type="email" readonly="true" class="form-control" id="email" name="email" placeholder="<?= lang('Web.email') ?>" value="<?= esc($userdata['email']) ?>">
                        </div>
                        <!-- Relationship Status -->
                        <div class="col-sm-6">
                            <label class="form-label"><?= lang('Web.relationship_status') ?></label>
                            <select class="form-select" id="relation_id" name="relation_id">
                                <option value="0" <?= $userdata['relation_id'] == 0 ? 'selected' : '' ?>><?= lang('Web.none') ?></option>
                                <option value="1" <?= $userdata['relation_id'] == 1 ? 'selected' : '' ?>><?= lang('Web.single') ?></option>
                                <option value="2" <?= $userdata['relation_id'] == 2 ? 'selected' : '' ?>><?= lang('Web.in_a_relationship') ?></option>
                                <option value="3" <?= $userdata['relation_id'] == 3 ? 'selected' : '' ?>><?= lang('Web.married') ?></option>
                                <option value="4" <?= $userdata['relation_id'] == 4 ? 'selected' : '' ?>><?= lang('Web.engaged') ?></option>
                            </select>
                        </div>
                        <!-- Working -->
                        <div class="col-12">
                            <label class="form-label"><?= lang('Web.working') ?></label>
                            <input type="text" class="form-control" id="working" name="working" placeholder="<?= lang('Web.occupation') ?>" value="<?= esc($userdata['working']) ?>">
                        </div>

                        <!-- Save Changes Button -->
                        <div class="col-12 text-end">
                            <button type="button" id="saveProfileBtn" class="btn btn-primary mb-0"><?= lang('Web.save_changes') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#userProfileForm').validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                last_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                about_you: {
                    maxlength: 300
                },
                gender: {
                    required: true
                },
                relation_id: {
                    required: true
                }
            },
            messages: {
                first_name: {
                    required: translate('first_name_required'),
                    minlength: translate('first_name_minlength'),
                    maxlength: translate('first_name_maxlength')
                },
                last_name: {
                    required: translate('last_name_required'),
                    minlength: translate('last_name_minlength'),
                    maxlength: translate('last_name_maxlength')
                },
                about_you: {
                    maxlength: translate('about_you_maxlength')
                },
                gender: {
                    required: translate('gender_required')
                },
                relation_id: {
                    required: translate('relation_required')
                }
            },
            submitHandler: function (form) {
                var formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('web_api/settings/update-user-profile') ?>',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            confirmButtonText:"<?=lang('Web.ok')?>"
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'danger',
                            text: response.message,
                            confirmButtonText:"<?=lang('Web.ok')?>"
                        });
                    }
                });
            }
        });

        $('#saveProfileBtn').click(function () {
            $('#userProfileForm').submit();
        });

        function previewImage(inputId, previewId) {
            var file = $('#' + inputId).get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function () {
                    $('#' + previewId).attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }

        function translate(key) {
            var translations = {
                'first_name_required': '<?= lang('Web.first_name_required') ?>',
                'first_name_minlength': '<?= lang('Web.first_name_minlength') ?>',
                'first_name_maxlength': '<?= lang('Web.first_name_maxlength') ?>',
                'last_name_required': '<?= lang('Web.last_name_required') ?>',
                'last_name_minlength': '<?= lang('Web.last_name_minlength') ?>',
                'last_name_maxlength': '<?= lang('Web.last_name_maxlength') ?>',
                'about_you_maxlength': '<?= lang('Web.about_you_maxlength') ?>',
                'gender_required': '<?= lang('Web.gender_required') ?>',
                'relation_required': '<?= lang('Web.relation_required') ?>',
                'profile_updated_success': '<?= lang('Web.profile_updated_success') ?>',
                'error_message_update': '<?= lang('Web.error_message_update') ?>',
                'update_status': '<?= lang('Web.update_status') ?>'
            };

            return translations[key] || key;
        }

       
        
    });
</script>

<?= $this->endSection() ?>
