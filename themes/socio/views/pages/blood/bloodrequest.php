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
                    <div class="col-md-3">
                        <a href="<?= site_url('add-blood-request') ?>" class="float-end btn btn-success btn-xs" title="<?= lang('Web.become_donor') ?>">
                            <i class="bi bi-plus-circle"></i> 
                        </a> 
                    </div>
                   

                </div>
            </div>
            <?php if(count($blood_requests)>0):?>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table ">
                        <thead>
                            <tr>
                                <th><?= lang('Web.user_name') ?></th>
                                <th><?= lang('Web.phone') ?></th>
                                <th><?= lang('Web.location') ?></th>
                                <th><?= lang('Web.blood_group') ?></th>
                                <th><?= lang('Web.urgent_need') ?></th>
                                <th><?= lang('Web.action') ?></th>
                            </tr>
                        </thead>

                            <tbody>
                               <?php foreach ($blood_requests as $blood_request) : ?>
                                <tr>
                                    <td><?= $blood_request['user']['username'] ?></td>
                                    <td><?= $blood_request['phone'] ?></td>
                                    <td><?= $blood_request['location'] ?></td>
                                    <td><?= $blood_request['blood_group'] ?></td>
                                    <td>
                                        <?php if ($blood_request['is_urgent_need']==1) : ?>
                                            <span class="badge bg-success"><?= lang('Web.yes') ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?= lang('Web.no') ?></span>
                                           
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($blood_request['user_id']==$user_data['id']) : ?>
                                            <button class="btn btn-danger deletebloodrequest btn-sm" data-request_id="<?= $blood_request['id'] ?>"> <i class="bi bi-trash"></i> <?= lang('Web.delete') ?> </button>
                                        <?php else:?>
                                            <a href="#" class="btn btn-success me-2 btn-sm toast-btn" data-target="chatToast" data-id="<?=$blood_request['user_id'] ;?>" > <i class="bi bi-chat-left-dotsbi-person-x-fill pe-1"></i><i class="bi bi-chat-text"></i> <?= lang('Web.message') ?> </a>

                                        <?php endif ?>
                                    </td>
                                </tr>
                               <?php endforeach ?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    $('.deletebloodrequest').click(function() {
        var that = $(this);
        var request_id = that.data('request_id');
        console.log(request_id);
        Swal.fire({
        title: "Delete Blood Request ",
        text:'Do you want to delete this blood request',
        showDenyButton: true,
       
        confirmButtonText: "Confirm",
        denyButtonText: `Cancel`
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/delete-bloodrequest',
                    data: {request_id:request_id},
                    success: function(response) {
                        Swal.fire({
                            title: "Blood Request Delete",
                            text: "Blood Request is deleted",
                            icon: "success",
                            timer: 3000,
                            timerProgressBar: true,
                            }).then(() => {
                            location.reload(); // Reloads the page after the alert is closed
                        });
                    },
                    error: function() {
                        alert("An error occurred while updating privacy settings.");
                    }
                });
        } 
        });
        
    });
});

</script>
<?= $this->endSection() ?>