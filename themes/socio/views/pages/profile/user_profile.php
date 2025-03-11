<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/post_html_models') ?>
<div class="row g-4">

	<!-- Main content START -->
	<div class="col-lg-8 vstack gap-4">
		<div class="card">
			<?php if(empty($user['cover'])): ?>
				<div class="h-200px rounded-top" style=" background: linear-gradient(90deg, #cf5f5f, #2f4e6e)  "></div>
			<?php else: ?>
				<a href="<?= $user['cover'] ?>"><div class="h-200px rounded-top" style="background-image:url(<?= $user['cover'] ?>);)  "></div></a>
			<?php endif; ?>

			<div class="card-body py-0"> 
				<div class="d-sm-flex align-items-start text-center text-sm-start">
					<div>
						<!-- Avatar -->
						<div class="avatar avatar-xxl mt-n5 mb-0">
							<a href="<?= $user['avatar'] ?>"><img class="avatar-img rounded-circle border border-white border-3" src="<?= $user['avatar'] ?>" alt=""></a>
						</div>
					</div>
					<div class="ms-sm-4 mt-sm-3">
						<!-- Info -->
						<h1 class="mb-0 h5" title="<?= $user['username']; ?>"><?= $user['first_name'] . ' ' . $user['last_name'] ?> <?=($user['level']>1)?'<i class="bi bi-patch-check-fill text-success small"></i>':'' ;?></h1>
						<p>
							<?php
							$badgeClass = '';
							$iconClass = '';
							switch ($package['id']) {
								case '1':
									$iconClass = 'bi bi-star';
									break;
								case '2':
									$iconClass = 'bi bi-gem';
									break;
								case '3':
									$iconClass = 'bi bi-diamond';
									break;
								case '4':
									$iconClass = 'bi bi-trophy';
									break;
								default:
									$iconClass = 'bi bi-award';
									break;
							}
							?>
							<small class="badge bg-primary p-1 fs-6"><i class="<?= $iconClass ?> pe-1 "></i> <b><?= $package['name'] ;?> </b>  </small>
						</p>
					</div>
					
					<!-- Button -->
					<div class="d-flex mt-3 justify-content-center ms-sm-auto">
						<?php
						$privacy_friends = $user['privacy_friends'];
						$is_mutual = $user['details']['mutualFriendCount'] > 0;

						if ($user['id'] == $user_data['id']) { ?>
							<a href="<?= site_url('settings/general-settings'); ?>" class="btn btn-danger-soft me-2"> <i class="bi bi-pencil-fill pe-1"></i> <?= lang('Web.edit_profile') ?> </a>
						<?php } else { 
							if ($isFriend) { ?>
								<a href="#" class="btn btn-danger-soft me-2 unfrienduser" data-user_id="<?=$user_id ;?>" > <i class="bi bi-person-x-fill pe-1"></i> <?= lang('Web.unfriend') ?> </a>
							<?php } else if ($isPending) { ?>
								<a href="#" class="btn btn-warning-soft me-2 send_req" data-user_id="<?=$user_id ;?>"> <i class="bi bi-hourglass-split pe-1"></i> <?= lang('Web.request_sent') ?> </a>
							<?php } else {
								if ($privacy_friends == 0) { 
									echo '<a href="#" class="btn btn-success-soft me-2 send_req" data-user_id="'.$user_id.'"> <i class="bi bi-person-plus-fill pe-1"></i> ' . lang('Web.add_friend') . ' </a>';
								} elseif ($privacy_friends == 2 && $user['details']['mutualFriendCount'] > 0) {
									echo '<a href="#" class="btn btn-success-soft me-2 send_req" data-user_id="'.$user_id.'"> <i class="bi bi-person-plus-fill pe-1"></i> ' . lang('Web.add_friend') . ' </a>';
								}
							}
						} ?>
						<?php if ($user['id'] != $user_data['id']) { ?>
							<?php if($user['privacy_message']!=2 || ($user['privacy_message']!=2) || ($user['privacy_message']==1 && $isFriend==1)):?>
								<a href="#" class="btn btn-success-soft me-2  toast-btn" data-target="chatToast" data-id="<?=$user_id ;?>" > <i class="bi bi-chat-left-dotsbi-person-x-fill pe-1"></i><i class="bi bi-chat-text"></i> <?= lang('Web.message') ?> </a>
							<?php endif;?>
						<?php } ?>
					</div>
				</div>
				<!-- List profile -->
				<ul class="list-inline mb-0 text-center text-sm-start mt-3 mt-sm-0">
					<li class="list-inline-item"><i class="bi bi-calendar2-plus me-1"></i> <?= lang('Web.joined_on') ?> <?= date("M d, Y", strtotime($user['created_at'])) ?></li>
				</ul>
			</div>

			<!-- Card footer -->
			<div class="card-footer mt-3 pt-2 pb-0">
				<!-- Nav profile pages -->
				<ul class="nav nav-bottom-line align-items-center justify-content-center justify-content-md-start mb-0 border-0">
					<?php if ($user['privacy_private_account'] == '0' || $user['id'] == getCurrentUser()['id'] || $isFriend == '1') : ?>
						<li class="nav-item"> <a class="nav-link <?= $section == 'posts' ? 'active' : '' ?>" href="<?= site_url($user['username']); ?>"><?= lang('Web.posts') ?></a> </li>
						<li class="nav-item"> <a class="nav-link <?= $section == 'about' ? 'active' : '' ?>" href="<?= site_url($user['username']); ?>/about"><?= lang('Web.about') ?></a> </li>
						<?php if ($user['privacy_see_friend'] == 0 || ($user['privacy_see_friend'] == 1 && $isFriend == '1') || ($user['id'] == $loggedInUser)) : ?>
							<li class="nav-item"> <a class="nav-link <?= $section == 'friends' ? 'active' : '' ?>" href="<?= site_url($user['username']); ?>/friends"><?= lang('Web.friends') ?> <span class="badge bg-success bg-opacity-10 text-success small count_friend"> <?= $friendscount ?></span></a> </li>
						<?php endif; ?>
						<li class="nav-item"> <a class="nav-link <?= $section == 'photos' ? 'active' : '' ?>" href="<?= site_url($user['username']); ?>/photos"><?= lang('Web.photos') ?></a> </li>
						<li class="nav-item"> <a class="nav-link <?= $section == 'videos' ? 'active' : '' ?>" href="<?= site_url($user['username']); ?>/videos"><?= lang('Web.videos') ?></a> </li>
					<?php else: ?>
						<li class="nav-item"> <a class="nav-link"><?= lang('Web.this_account_is_private') ?></a> </li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<?php if($user['privacy_private_account']=='0' || $user['id']==getCurrentUser()['id'] || $isFriend=='1'){ ?>
		<?php if ($section == 'posts' || $section == '') { 
			if( $user['id']==$loggedInUser){
				echo $this->include('partials/create_post');
			}?>

			<!-- Share feed END -->
			<div id="post_holder" data-post_type="personal" data-post_tid="<?= $user['id'] ?>"></div>

		<?php } ?>

		<?php if ($section == 'about') { ?>
			<?= $this->include('pages/profile/about') ?>
		<?php } ?>

		<?php if ($section == 'photos') { ?>
			<?= $this->include('pages/profile/photos') ?>
		<?php } ?>

		<?php if ($section == 'videos') { ?>
			<?= $this->include('pages/profile/videos') ?>
		<?php } ?>
		<?php if($user['privacy_see_friend']==0 || ($user['privacy_see_friend']==1 && $isFriend=='1') || ($user['id']==$loggedInUser)) {
			if ($section == 'friends') { ?>
			<?= $this->include('pages/profile/friends') ?>
		<?php } } } ?>
	</div>

	<!-- Main content END -->

	<!-- Right sidebar START -->
	
	<div class="col-lg-4">
		<?php if($user['privacy_private_account']=='0' || $user['id']==getCurrentUser()['id'] || $isFriend=='1'){ ?>
		<div class="row g-4">

			<!-- About Card START -->
			<div class="col-md-6 col-lg-12">
				<div class="card">
					<div class="card-header d-flex justify-content-between border-0">
						<h5 class="card-title py-2 my-0"><?= lang('Web.about') ?></h5>
					</div>
					<div class="card-body position-relative pt-0">
						<p><?= $user['about_you'] ?></p>
						<ul class="d-flex justify-content-between p-0">
							<li class="list-group-item">
								<?php
								if ($user['gender'] == 'Male' || $user['gender'] == 'male') {
									$genderIconClass = 'bi bi-gender-male';
								}else{
									$genderIconClass = 'bi bi-gender-female';
								}
								?>
								<i class="<?= $genderIconClass ?> fa-fw pe-1"></i>
								<?= ucfirst($user['gender']) ?>
							</li>
							<li class="list-group-item">
								<i class="bi bi-person-circle fa-fw pe-1"></i>
								<?= lang('Web.posts') ?> <span class="badge bg-danger total_post_count"><?= $user['total_post_count'] ?></span>
							</li>
						</ul>
						<ul class="list-unstyled mt-3 mb-0">
							<?php if($user['privacy_birthday']==0 || ($user['privacy_birthday']==1 && $isFriend==1) || ($user['id']==$loggedInUser)) :?>
							<li class="mb-2"><i class="bi bi-calendar-date fa-fw pe-1"></i><?= lang('Web.dob') ?>: <strong><?= date("M d, Y", strtotime($user['date_of_birth'])) ?></strong></li>
							<?php endif; ?>
							<li class="mb-2"><i class="bi bi-heart fa-fw pe-1"></i><?= lang('Web.status') ?>: <strong>
								<?php
								$relationStatuses = [
									0 => lang('Web.none'),
									1 => lang('Web.single'),
									2 => lang('Web.in_a_relationship'),
									3 => lang('Web.married'),
									4 => lang('Web.engaged'),
								];
								echo isset($relationStatuses[$user['relation_id']]) ? $relationStatuses[$user['relation_id']] : lang('Web.unknown');
								?>
							</strong></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- About Card END -->

			<!-- Social Links Card START -->
			<div class="col-md-6 col-lg-12">
				<div class="card">
					<div class="card-header d-flex justify-content-between border-0">
						<h5 class="card-title py-2 my-0"><?= lang('Web.social_links') ?></h5>
					</div>
					<div class="card-body position-relative pt-0 d-flex justify-content-between border-0 text-center">
						<!-- Social Media Links -->
						<?php if (empty($user['facebook'])|| $user['facebook']!='#' ) : ?>
							<div class="col">
								<div class="input-group">
									<a href="<?= !empty($user['facebook']) ? $user['facebook'] : '#'; ?>">
										<span class="input-group-text border-0"> <i class="bi bi-facebook text-facebook"></i> </span>
									</a>
								</div>
							</div>
						<?php endif ?>
						<?php if (empty($user['twitter'])|| $user['twitter']!='#' ) : ?>

						<div class="col">
							<div class="input-group">
								<a href="<?= !empty($user['twitter']) ? $user['twitter'] : '#'; ?>">
									<span class="input-group-text border-0"> <i class="bi bi-twitter text-twitter"></i> </span>
								</a>
							</div>
						</div>
						<?php endif ?>
						<?php if (empty($user['instagram'])|| $user['instagram']!='#' ) : ?>
						<div class="col">
							<div class="input-group">
								<a href="<?= !empty($user['instagram']) ? $user['instagram'] : '#'; ?>">
									<span class="input-group-text border-0"> <i class="bi bi-instagram text-instagram"></i> </span>
								</a>
							</div>
						</div>
						<?php endif ?>
						<?php if (empty($user['linkedin'])|| $user['linkedin']!='#' ) : ?>
						<div class="col">
							<div class="input-group">
								<a href="<?= !empty($user['linkedin']) ? $user['linkedin'] : '#'; ?>">
									<span class="input-group-text border-0"> <i class="bi bi-linkedin text-linkedin"></i> </span>
								</a>
							</div>
						</div>
						<?php endif ?>
						<?php if (empty($user['youtube'])|| $user['youtube']!='#' ) : ?>
						<div class="col">
							<div class="input-group">
								<a href="<?= !empty($user['youtube']) ? $user['youtube'] : '#'; ?>">
									<span class="input-group-text border-0"> <i class="bi bi-youtube text-youtube"></i> </span>
								</a>
							</div>
						</div>
						<?php endif ?>
						
					</div>
				</div>
			</div>
			<!-- Social Links Card END -->

			<!-- Photos Card START -->
			<div class="col-md-6 col-lg-12">
				<div class="card">
					<div class="card-header d-sm-flex justify-content-between border-0">
						<h5 class="card-title py-2 my-0"><?= lang('Web.photos') ?></h5>
						<a class="btn btn-primary-soft btn-sm" href="<?= site_url($user['username']); ?>/photos"><?= lang('Web.see_all_photos') ?></a>
					</div>
					<div class="card-body pt-0">
						<div class="row g-2">
							<?php if (count($userphotos)) : ?>
								<?php foreach ($userphotos as $userphoto) : ?>
									<div class="col-6">
										<a href="<?= getMedia($userphoto['media_path']); ?>">
											<img class="rounded img-fluid" src="<?= getMedia($userphoto['media_path']); ?>" alt="<?= getMedia($userphoto['media_path']); ?>">
										</a>
									</div>
								<?php endforeach ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<!-- Photos Card END -->

			<!-- Friends Card START -->
			<?php if($user['privacy_see_friend'] == 0 || ($user['privacy_see_friend'] == 1 && $isFriend == 1) || ($user['id'] == $loggedInUser)) {?>
			<div class="col-md-6 col-lg-12">
				<div class="card">
					<div class="card-header d-sm-flex justify-content-between align-items-center border-0">
						<h5 class="card-title py-2 my-0"><?= lang('Web.friends') ?> <span class="badge bg-danger bg-opacity-10 text-danger count_friend"><?= count($friends) ?></span></h5>
						<a class="btn btn-primary-soft btn-sm" href="<?= site_url($user['username']); ?>/friends"><?= lang('Web.see_all_friends') ?></a>
					</div>
					<div class="card-body position-relative pt-0">
						<div class="row g-3">
							<?php if (count($friends)) { ?>
								<?php foreach ($friends as $friend) : ?>
									<div class="col-6">
										<div class="card shadow-none text-center h-100">
											<div class="card-body p-2 pb-0">
												<div class="avatar avatar-xl">
													<a href="<?=site_url($friend['username'])?>"><img class="avatar-img rounded-circle" src="<?= getMedia($friend['avatar']) ?>" alt=""></a>
												</div>
												<h6 class="card-title mb-1 mt-3"><a href="<?=site_url($friend['username'])?>"><?= $friend['first_name'] . " " . $friend['last_name'] ?></a></h6>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php } else { ?>
								<div class="row">
									<div class="my-sm-5 py-sm-5 text-center">
										<i class="display-1 text-body-secondary bi bi-people"></i>
										<h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_friends') ?></h4>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<!-- Friends Card END -->

		</div>
		<?php } ?>
	</div>

	
	<!-- Right sidebar END -->

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('Web.report_user') ?></h5>
                <button type="button" class="close border-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="reportForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="report_user_id" value="<?= $user['id'] ?>">
                            <label for=""><?= lang('Web.reason') ?></label>
                            <textarea name="reason" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger close" data-dismiss="modal">&times; <?= lang('Web.close') ?></button>
                    <button type="submit" class="btn btn-primary"> <i class="bi bi-ban"></i> <?= lang('Web.submit_report') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Row END -->
<script src="<?=base_url('public');?>/assets/js/jquery.validate.min.js"></script>

<script>

function translate(key) {
    // This object should map translation keys to their corresponding translated text
    var translations = {
        'are_you_sure_unfriend': '<?= lang('Web.are_you_sure_unfriend') ?>',
        'send_request': '<?= lang('Web.send_request') ?>',
		'sending_request': '<?= lang('Web.sending_request') ?>',
        'add_friend': '<?= lang('Web.add_friend') ?>',
        'cancel_request': '<?= lang('Web.cancel_request') ?>',
        'friend_request_status': '<?= lang('Web.friend_request_status') ?>',
        'error_message': '<?= lang('Web.error_message') ?>',
		'reason_required': '<?= lang('Web.reason_required') ?>',
        'reason_minlength': '<?= lang('Web.reason_minlength') ?>',
        'reason_maxlength': '<?= lang('Web.reason_maxlength') ?>',
        'report_status': '<?= lang('Web.report_status') ?>',
		'block_status': '<?= lang('Web.block_status') ?>',
    };

    // Return the translated text if found, otherwise return the key itself
    return translations[key] || key;
}
// Function to show the modal by its ID
function showModal() {
    $('#exampleModal').modal('show'); // Show the modal
}

// Event listener for the close button (hides the modal)
$(document).on('click', '.close', function() {
    $('#exampleModal').modal('hide'); // Hide the modal
});

// Event listener for a button click to show the modal
$(document).on('click', '#modelbtn', function() {
    showModal(); // Call the function to show the modal
});

// Event listener for the unfriend action
$(document).on('click', ".unfrienduser", function() {
    var that = $(this); // Store the reference to the clicked button

    // Use the translate function for the confirmation message
    var confirmation = confirm(translate('are_you_sure_unfriend')); 
    if (confirmation == true) {
        var user_id = that.data('user_id'); // Get the user ID from the data attribute
        $.ajax({
            type: "post", // Set the request type
            url: site_url + "web_api/unfriend", // URL for the unfriend action
            dataType: "json", // Expect JSON response
            data: {
                user_id: user_id // Send the user ID to the server
            },
            success: function(response) {
                console.log(response); // Log the response for debugging
                // Redirect to the friends page of the user
                window.location = site_url + "<?=$user['username']?>/friends";
            },
            error: function() {
                // Handle error case - show 'Send Request' button text with a translation
                that.html(translate('send_request')); // Replace the button text
            }
        });
    }
});
var offset = 0;
var limit = 10; // Adjust as needed
var isLoading = false; // Flag to track whether an Ajax request is in progress
var userId = <?php echo $user['id']; ?>
// Load initial set of images
loadImages();

// Infinite scroll event
$(window).scroll(function() {
	if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
		// Load more images when the user is near the bottom, and no request is in progress
		if (!isLoading) {
			offset += limit;
			loadImages();
		}
	}
});

function loadImages() {
	isLoading = true;
	$.ajax({
		url: site_url + '/load-image',
		type: 'GET',
		data: {
			offset: offset,
			limit: limit,
			user_id: userId
		},
		complete: function() {
			isLoading = false; // Reset the flag after the request is complete
		}
	});
}
$(document).on('click', ".send_req", function () {
    var that = $(this);
    that.html(translate('sending_request')); // Display "Sending request" while the request is being processed
    
    var user_id = that.data('user_id'); // Get the user ID from the data attribute
    
    $.ajax({
        type: "POST",
        url: site_url + "web_api/make-friend", // URL for sending friend request
        dataType: "json",
        data: { friend_two: user_id }, // Send user ID in the request
        success: function (response) {
            if (response.ispending === 0 && response.friend_status === 'Not Friends') {
                // Handle case where the friend request was not successful
                showAlert(response.message, translate('friend_request_status'), "warning");
                
                // Update button classes and text for a failed request
                that.removeClass('btn-warning-soft');
                that.addClass('btn-success');
                that.html("<i class='bi bi-person-plus'></i> " + translate('add_friend'));
                
            } else {
                // Successful friend request
                showAlert(response.message, translate('friend_request_status'), "success");
                
                // Change button to 'Cancel Request' after sending a friend request
                that.html(translate('cancel_request'));
                that.removeClass('btn-primary-soft').addClass('btn-warning-soft');
            }
        },
        error: function () {
            // Handle error case
            that.html('<i class="bi bi-person-plus-fill pe-1"></i> ' + translate('add_friend')); // Reset the button text
            showAlert(translate('error_message'), "Error", "danger");
        }
    });
});
$(document).on('click', ".poke-user", function () {
    var that = $(this);
    var user_id = that.data('user_id'); // Get the user ID from the data attribute
    
    $.ajax({
        type: "POST",
        url: site_url + "web_api/poke-user", // API endpoint to poke the user
        dataType: "json",
        data: { user_id: user_id }, // Send user ID in the request
        success: function (response) {
            if (response.code == 200) {
                // On success, show the success alert with the translated message
                showAlert(response.message, translate('poke_status'), "success");
            } else {
                // On failure, show the error alert with a translated message
                showAlert(translate('user') + response.message, translate('poke_status'), "error");
            }
        },
        error: function () {
            // Handle error case (such as a failed network request)
            that.html('<i class="bi bi-person-plus-fill pe-1"></i> ' + translate('add_friend'));
            showAlert(translate('error_message'), translate('poke_status'), "danger");
        }
    });
});



    $(document).ready(function() {
        var form = $('#reportForm');

        form.validate({
            rules: {
                // Validation rules
                reason: {
                    required: true,
                    minlength: 5,
                    maxlength: 50
                }
                // Other fields...
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            messages: {
                // Validation messages
                // Similar to the previous example...
            },
            submitHandler: function(form) {
                var formData = new FormData(form);


                $.ajax({
                    type: 'POST',
                    url: site_url+'web_api/report-user',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response.message);
						
                    },
                    error: function() {
                        // Handle error
                        alert("An error occurred.");
                    }
                });
            }
        });
    });
	function blockUser() {
    $.ajax({
        type: 'POST',
        url: site_url + "web_api/block-user",
        data: { user_id: "<?= $user['id'] ?>" }, // Send user ID dynamically from PHP
        success: function(response) {
            if (response.success) {
                // Display success message
                showAlert(response.message, translate('block_status'), 'success');
                // Redirect to home or the appropriate page
                window.location = site_url;
            } else {
                // Handle the case where blocking fails (server-side validation, etc.)
                showAlert(response.message, translate('block_status'), 'warning');
            }
        },
        error: function() {
            // Handle any AJAX errors
            showAlert(translate('error_message'), translate('block_status'), 'danger');
        }
    });
}
</script>

<?= $this->endSection() ?>