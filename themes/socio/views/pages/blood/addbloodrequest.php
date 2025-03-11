<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <div class="row">
                                
                    <div class="col-md-6 offset-md-3" style="text-align: center;">

                        <img src="<?= site_url('uploads/placeholder/blood.png') ?>" style="text-align: center;" alt="">
                    </div>
                    <form id="addbloodrequest" method="post">
                        <div class="row mt-4">
                            <div class="col-md-6 offset-md-3">
                                <h3><?= lang('Web.add_blood_request') ?></h3>
                                <div class="form-group">
                                    <label for="blood_group"><?= lang('Web.blood_group') ?></label>
                                    <select name="blood_group" class="form-control">
                                        <option value=""><?= lang('Web.blood_group') ?></option>
                                        <option value="A+" >A+</option>
                                        <option value="B+" >B+</option>
                                        <option value="AB+" >AB+</option>
                                        <option value="O+" >O+</option>
                                        <option value="A-" >A-</option>
                                        <option value="B-" >B-</option>
                                        <option value="AB-" >AB-</option>
                                        <option value="O-" >O-</option>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="location"><?= lang('Web.location') ?></label>
                                    <input type="text" name="location"  class="form-control">                            
                                </div>                               
                                <div class="form-group mt-2">
                                    <label for="phone"><?= lang('Web.phone') ?></label>
                                    <input type="text" name="phone"  class="form-control">                            
                                </div>
                               
                                <div class="form-group mt-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="urgent_need" name="is_urgent_need" value="1" >
                                        <label class="form-check-label" for="urgent_need"><?= lang('Web.urgent_need') ?></label>
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
    </div>
</div>

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    $('#addbloodrequest').validate({
        rules: {
            blood_group: { required: true },
            location: { required: true },
            phone: { required: true },
            donation_date: { required: true, date: true }
        },
        messages: {
            blood_group: { required: "<?= lang('Web.required_blood_group') ?>" },
            location: { required: "<?= lang('Web.required_location') ?>" },
            phone: { required: "<?= lang('Web.required_phone') ?>" }
        },
        submitHandler: function(form) {
            console.log($(form).serialize());
            $.ajax({
                type: 'POST',
                url: site_url + 'web_api/add-bloodrequest',
                data: $(form).serialize(), // Serialize form data for sending
                success: function(response) {
                 
                    alert(response.message);
                    window.location = site_url+'blood-request';
                    // Success message (you can change this)
                },
                error: function() {
                     // Error message
                }
            });
        }
    });
});

</script>
<?= $this->endSection() ?>