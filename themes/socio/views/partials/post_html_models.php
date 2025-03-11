<div class="modal fade" id="share_post_modal" tabindex="-1" aria-labelledby="shareActionLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareActionLabel"><i class="bi bi-share"></i> <?= lang('Web.share_post_on') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('Web.close') ?>"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="sharepostform">
                    <div class="share_modal_opts_icons">
                        <h6><?= lang('Web.share_post_on') ?></h6>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="share_type_select" id="share_type_select_timeline" value="timeline" checked onclick="getdata()">
                                <label class="form-check-label" for="share_type_select_timeline">
                                    <?= lang('Web.my_timeline') ?>
                                </label>
                            </div>
                            <div id="timeline_div">
                                <input type="hidden" name="group_id" value="0">
                                <input type="hidden" name="page_id" value="0">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="share_type_select" onclick="getdata('page')">
                                <label class="form-check-label" for="share_type_select_timeline">
                                    <?= lang('Web.page') ?>
                                </label>
                            </div>
                            <div id="page_div" style="display:none;" class="mt-2 mb-2">
                                <select name="page_id" id="user_pages" class="form-control"></select>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="share_type_select" onclick="getdata('group')">
                                <label class="form-check-label" for="share_type_select_timeline">
                                    <?= lang('Web.group') ?>
                                </label>
                            </div>
                            <div id="group_div" style="display:none;" class="mt-2 mb-2">
                                <select name="group_id" id="user_groups" class="form-control"></select>
                            </div>
                        </div>
                    </div>

                    <div class="wow_form_fields">
                        <input type="hidden" name="post_id" id="share_post_id">
                        <textarea placeholder="<?= lang('Web.whats_going_on') ?>" dir="auto" rows="4" name="shared_text" id="share_post_text" class="form-control"></textarea>
                    </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal"><?= lang('Web.cancel') ?></button>
                <button type="submit" class="btn btn-success-soft"><?= lang('Web.post') ?></button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editpostModel" tabindex="-1" aria-labelledby="editpostModel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editpostModel"><?= lang('Web.edit_post') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('Web.close') ?>"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" id="edit_post_id">
                <label><?= lang('Web.post_text') ?></label>
                <textarea class="form-control" placeholder="<?= lang('Web.post_text') ?>" id="edit_post_text"></textarea>
            </div>
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="update_post"><?= lang('Web.update') ?></button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('Web.close') ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="donationModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= lang('Web.donate_amount') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('Web.close') ?>"></button>
      </div>
      <form method="post" id="donatefundForm">
        <div class="modal-body">
          <label for=""><?= lang('Web.amount') ?></label>
          <input type="number" class="form-control" name="amount" min="0" required>
          <input type="hidden" name="fund_id" id="fund_id">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><?= lang('Web.save_changes') ?></button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('Web.close') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="emojiModal" tabindex="-1" aria-labelledby="emojiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="emojiModalLabel">Post Reaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body with Tabs -->
            <div class="modal-body">
                <!-- Tabs Navigation with Emojis -->
                <ul class="nav nav-tabs nav-fill" id="emojiTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="like-tab" data-bs-toggle="tab" data-bs-target="#like" type="button" role="tab" aria-controls="like" aria-selected="true">
                            👍
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="love-tab" data-bs-toggle="tab" data-bs-target="#love" type="button" role="tab" aria-controls="love" aria-selected="false">
                            ❤️
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="haha-tab" data-bs-toggle="tab" data-bs-target="#haha" type="button" role="tab" aria-controls="haha" aria-selected="false">
                            😆
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="wow-tab" data-bs-toggle="tab" data-bs-target="#wow" type="button" role="tab" aria-controls="wow" aria-selected="false">
                            😮
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sad-tab" data-bs-toggle="tab" data-bs-target="#sad" type="button" role="tab" aria-controls="sad" aria-selected="false">
                            😢
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="angry-tab" data-bs-toggle="tab" data-bs-target="#angry" type="button" role="tab" aria-controls="angry" aria-selected="false">
                            😡
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="emojiTabContent">
                    <div class="tab-pane fade show active" id="like" role="tabpanel" aria-labelledby="like-tab">
                        
                        <div id="likeContent">No data found for this reaction.</div>
                    </div>
                    <div class="tab-pane fade" id="love" role="tabpanel" aria-labelledby="love-tab">
                        
                        <div id="loveContent">No data found for this reaction.</div>
                    </div>
                    <div class="tab-pane fade" id="haha" role="tabpanel" aria-labelledby="haha-tab">
                        
                        <div id="hahaContent">No data found for this reaction.</div>
                    </div>
                    <div class="tab-pane fade" id="wow" role="tabpanel" aria-labelledby="wow-tab">
                    
                        <div id="wowContent">No data found for this reaction.</div>
                    </div>
                    <div class="tab-pane fade" id="sad" role="tabpanel" aria-labelledby="sad-tab">
                        
                        <div id="sadContent">No data found for this reaction.</div>
                    </div>
                    <div class="tab-pane fade" id="angry" role="tabpanel" aria-labelledby="angry-tab">
            
                        <div id="angryContent">No data found for this reaction.</div>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="shareuserModel" tabindex="-1" aria-labelledby="emojiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="postshareusers">Post ShareUser</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body with Tabs -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="postshareusers"></div>    

                    </div>
                </div>                
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url('public'); ?>/assets/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sharepostform').validate({
            ignore: [], // Remove ignore for hidden fields
            rules: {
                shared_text: {
                    required: true,
                },
            },
            messages: {
                shared_text: {
                    required: "<?= lang('Web.required_share_post_text') ?>",
                },
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
        });

        $('#sharepostform').submit(function(event) {
            event.preventDefault();

            if ($(this).valid()) { // Check if the form is valid
                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    type: "POST",
                    url: site_url + "/web_api/share-post",
                    data: formData,
                    success: function(response) {
                        if (response.code == 400) {
                    
                            Swal.fire({
                                icon: 'warning',
                                text: response.message,
                            });
                        
                        }
                        if (response.code == 200) {

                            let timerInterval;
                            Swal.fire({
                                icon: 'success',
                                html: response.message,
                                timer: 4000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent =
                                            `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                },
                                didClose: () => {
                                    Swal.update({
                                        html: '<i class="fas fa-check-circle"></i> Success!',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        showCloseButton: false,
                                    });
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */

                            });

                            setTimeout(() => {
                                window.location = site_url;
                            }, 4000);

                            // 
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                        // Handle error response
                    }
                    });
                }
        });

        // Your getdata function remains unchanged

    });
    

   
function getdata(data="")
{
    if(data=="page")
    {
        $.ajax({
            type: 'post',
            url: site_url+"/web_api/get-my-pages",
            success: function (response) {
                if (response.code=="200") {
                    $('#page_div').show();
                    var pagesSelect = $('#user_pages');
                        pagesSelect.show();
                        $('#timeline_div').hide();
                        $('#user_groups').hide();
                        pagesSelect.empty(); // Clear existing options
                    $.each(response.data, function(key, value) {
                        pagesSelect.append($('<option></option>').attr('value', value.id).text(value.page_title));
                    });
                } else {
                    $('#share_type_select_timeline').prop('checked', true);
                    alert("You are not the owner of any page")
                    $('#timeline_div').show();
                    $('#group_div').hide();
                    $('#page_div').hide();
                }
            }
          });
    }
    else if(data=="group"){
        $.ajax({
            type: 'post',
            url: site_url+"/web_api/get-my-group",
            success: function (response) {
                
                if (response.code=="200") {
                        $('#group_div').show();
                        var groupSelect = $('#user_groups');
                            $('#timeline_div').hide();
                            groupSelect.show();
                            $('#page_div').hide();
                            groupSelect.empty(); // Clear existing options
                        $.each(response.data, function(key, value) {
                            groupSelect.append($('<option></option>').attr('value', value.id).text(value.group_title));
                        });
                    } else {
                        $('#share_type_select_timeline').prop('checked', true);
                        alert("You are not currently a member of any group or the owner of any group")
                        $('#timeline_div').show();
                        $('#group_div').hide();
                        $('#page_div').hide();
                    }
            }
          });
    }
    else
    {
        $('#group_div').hide();
        $('#page_div').hide();
        $('#timeline_div').show();
        
    }

}
   
         



</script>