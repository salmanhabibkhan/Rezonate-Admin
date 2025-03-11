<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <div class="row">
                    <div class="col-md-6 offset-md-3" style="text-align: center;">
                        <img src="<?= site_url('uploads/placeholder/blood.png') ?>" alt="">
                    </div>
                </div>
            </div>
            <form id="bloodrequest" method="post">
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-3">
                        <h3><?= lang('Web.become_donor') ?></h3>
                        <div class="form-group">
                            <label for="blood_group"><?= lang('Web.blood_group') ?></label>
                            <select name="blood_group" class="form-control">
                                <option value=""><?= lang('Web.blood_group') ?></option>
                                <option value="A+" <?= ($userdata['blood_group'] == 'A+') ? 'selected' : '' ?>>A+</option>
                                <option value="B+" <?= ($userdata['blood_group'] == 'B+') ? 'selected' : '' ?>>B+</option>
                                <option value="AB+" <?= ($userdata['blood_group'] == 'AB+') ? 'selected' : '' ?>>AB+</option>
                                <option value="O+" <?= ($userdata['blood_group'] == 'O+') ? 'selected' : '' ?>>O+</option>
                                <option value="A-" <?= ($userdata['blood_group'] == 'A-') ? 'selected' : '' ?>>A-</option>
                                <option value="B-" <?= ($userdata['blood_group'] == 'B-') ? 'selected' : '' ?>>B-</option>
                                <option value="AB-" <?= ($userdata['blood_group'] == 'AB-') ? 'selected' : '' ?>>AB-</option>
                                <option value="O-" <?= ($userdata['blood_group'] == 'O-') ? 'selected' : '' ?>>O-</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="location"><?= lang('Web.location') ?></label>
                            <input type="text" name="address" value="<?= $userdata['address'] ?>" class="form-control">                            
                        </div>                               
                        <div class="form-group mt-2">
                            <label for="phone"><?= lang('Web.phone') ?></label>
                            <input type="text" name="phone" value="<?= $userdata['phone'] ?>" class="form-control">                            
                        </div>
                        <div class="form-group mt-2">
                            <label for="donation_date"><?= lang('Web.donation_date') ?></label>
                            <input type="date" name="donation_date" value="<?= $userdata['donation_date'] ?>" max="<?= date('Y-m-d') ?>" class="form-control">                            
                        </div>
                        <div class="form-group mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="donation_available" name="donation_available" <?= ($userdata['donation_available'] == 1) ? "checked" : "" ?> value="1" >
                                <label class="form-check-label" for="donation_available"><?= lang('Web.donation_available') ?></label>
                            </div>
                        </div>
                        <div class="form-group mt-3 mb-3">
                            <button class="btn btn-success btn-sm"><?= lang('Web.submit') ?></button> 
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('public'); ?>/assets/js/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    $('#bloodrequest').validate({
        rules: {
            blood_group: { required: true },
            address: { required: true },
            phone: { required: true },
            donation_date: { required: true, date: true }
        },
        messages: {
            blood_group: { required: "<?= lang('Web.required_blood_group') ?>" },
            address: { required: "<?= lang('Web.required_location') ?>" },
            phone: { required: "<?= lang('Web.required_phone') ?>" },
            donation_date: { 
                required: "<?= lang('Web.required_donation_date') ?>", 
                date: "<?= lang('Web.valid_donation_date') ?>"
            }
        },
        submitHandler: function(form) {
            var donationAvailableCheckbox = $('#donation_available');
            if (!donationAvailableCheckbox.is(':checked')) {
                $('<input />').attr('type', 'hidden')
                            .attr('name', 'donation_available')
                            .attr('value', '0')
                            .appendTo(form);
            }
            $.ajax({
                type: 'POST',
                url: site_url + 'web_api/settings/update-user-profile',
                data: $(form).serialize(),
                success: function(response) {
                    if (response.code == 200) {
                        alert("<?= lang('Web.update_success') ?>");
                        window.location.reload();
                    }
                },
                error: function() {
                    alert("<?= lang('Web.update_error') ?>");
                }
            });
        }
    });
});
</script>

<?= $this->endSection() ?>
