
<?php
if(!empty($posts) && is_array($posts)) {
foreach($posts as $key => $post){  ?>
	<div class="card mb-2 post_card " data-pstid="<?=$post['id']?>">

	
	<div class="card-header border-0 py-2 border-bottom border-light">
		<div class="d-flex align-items-center justify-content-between">
			<div class="d-flex align-items-center">
				<!-- Avatar -->
				<div class="avatar me-2">
					<?php
						$avatar = $post['user']['avatar'];
						$link = site_url($post['user']['username']);
						$name = $post['user']['first_name'] . " " . $post['user']['last_name'];
					?>
					<a href="<?=$link?>"> <img class="avatar-img rounded-circle" src="<?=$avatar?>" alt=""> </a>
					<i class="bi bi-check-circle-fill verified_circle"></i>
				</div>
				<!-- Info -->
				<div>
					<div class="nav nav-divider">
						<h6 class="nav-item card-title mb-0">
							<a href="<?=$link;?>"><?=$name ?> </a>
							<?php if (!empty($post['tagged_users']) && count($post['tagged_users']) > 0) { ?>
								<?= lang('Web.with') ?><span class="ps-2">
								<?php foreach ($post['tagged_users'] as $key => $tag_user) : ?>
									<?php if ($tag_user['id'] != getCurrentUser()['id']) : ?>
										<a href="<?= site_url($tag_user['username']) ?>">
											<?= $tag_user['first_name'] . ' ' . $tag_user['last_name'] ?>
										</a>
										<?php if ($key < count($post['tagged_users']) - 2) : ?>
											, 
										<?php elseif ($key == count($post['tagged_users']) - 2) : ?>
											<?= lang('Web.and') ?>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
								</span>
							<?php } ?>
							<?php if (!empty($post['post_location'])) { ?>
								<span class="small">&nbsp;<?= lang('Web.is_in') ?>&nbsp;<strong><a target="_blank" href="https://www.google.com/maps/place/<?=$post['post_location']?>"><?=$post['post_location']?></a></strong></span>
							<?php } ?>
						</h6>
						<?php
						$genderMsg = $post['user']['gender'] == "Male" ? lang('Web.gender_male') : lang('Web.gender_female');

						if ($post['post_type'] == 'avatar') { ?>
							<span class="ps-2 small"><?= lang('Web.updated_profile_picture', ['gender' => $genderMsg]) ?></span>
						<?php } ?>
						<?php if ($post['post_type'] == 'cover') { ?>
							<span class="ps-2 small"><?= lang('Web.updated_cover_photo', ['gender' => $genderMsg]) ?></span>
						<?php } ?>

						<?php if ($post['parent_id'] != 0 && $post['parent_id'] != null) { ?>
							<span class="ps-2"><?= lang('Web.shared_post') ?></span>
						<?php } ?>

						<?php
						$page_group_link = '';
						$page_group_name = '';
						$arrow = '';
						if (!empty($post['page'])) {
							$page_group_link = site_url('pages/' . $post['page']['page_username']);
							$page_group_name = $post['page']['page_title'];
							$arrow = "<i class='bi bi-arrow-right'></i>";
						} elseif (!empty($post['group'])) {
							$page_group_link = site_url('group/' . $post['group']['group_name']);
							$page_group_name = $post['group']['group_title'];
							$arrow = "<i class='bi bi-arrow-right'></i>";
						}
						echo $arrow;
						?>
						<h6 class="nav-item card-title mb-0 text-info"> <a href="<?= $page_group_link ?>"> <?= $page_group_name ?></a></h6>
					</div>

					<div class="dropdown">
						<a class="mb-0 small text-muted" href="<?=$post['post_link']?>"><?=$post['created_human']?></a> -
						<a class="mb-0 small" href="<?=$post['post_link']?>" title="<?=$post['created_at']?>">
							<?php
							if ($post['privacy'] == 1) { echo '<i title="' . lang('Web.public_post') . '" class="bi bi-globe"></i>'; }
							if ($post['privacy'] == 2) { echo '<i title="' . lang('Web.friends') . '" class="bi bi-people-fill"></i>'; }
							if ($post['privacy'] == 3) { echo '<i title="' . lang('Web.only_me') . '" class="bi bi-person-fill"></i>'; }
							if ($post['privacy'] == 4) { echo '<i title="' . lang('Web.family') . '" class="bi bi-person-hearts"></i>'; }
							if ($post['privacy'] == 5) { echo '<i title="' . lang('Web.business') . '" class="bi bi-briefcase-fill"></i>'; }
							?>
						</a>
					</div>
				</div>
			</div>
			
			<!-- Card feed action dropdown START -->
			<div class="dropdown">
				<a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="bi bi-three-dots"></i>
				</a>
				<!-- Card feed action dropdown menu -->
				<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
					<?php if ($loggendInUserId != $post['user_id']){  ?>
					<li><a class="dropdown-item post_action" data-pst_action="save" href="#">
						<?php if ($post['is_saved']) { ?>
							<i class="bi bi-bookmark-fill fa-fw pe-2"></i><?= lang('Web.unsave_post') ?>
						<?php } else { ?>
							<i class="bi bi-bookmark fa-fw pe-2"></i><?= lang('Web.save_post') ?>
						<?php } ?>
					</a></li>
					<?php  } ?>
					<?php if ($loggendInUserId == $post['user_id']) { ?>
						<li><a class="dropdown-item post_action" data-pst_action="disablecomments" href="#">
							<?php if ($post['comments_status'] == 1) { ?>
								<i class="bi bi-chat-left-dots fa-fw pe-2"></i><?= lang('Web.disable_comments') ?>
							<?php } else { ?>
								<i class="bi bi-chat-left-dots-fill fa-fw pe-2"></i><?= lang('Web.enable_comments') ?>
							<?php } ?>
						</a></li>
						<?php if ($post['post_type'] != 'donation') { ?>
						<li><a class="dropdown-item edit_post" href="#" data-post_text="<?= $post['post_text'] ?>" data-post_id="<?=$post['id']?>" data-bs-toggle="modal" data-bs-target="#editpostModel">
							<i class="bi bi-pencil fa-fw pe-2"></i><?= lang('Web.edit_post') ?>
						</a></li>
						<?php } ?>
						<li><a class="dropdown-item post_action" data-pst_action="delete" href="#">
							<i class="bi bi-trash fa-fw pe-2"></i><?= lang('Web.delete_post') ?>
						</a></li>
					<?php } ?>

					<li><hr class="dropdown-divider"></li>

					<?php if ($loggendInUserId != $post['user_id']) { ?>
						<li><a class="dropdown-item post_action" data-pst_action="report" href="#">
							<i class="bi bi-flag fa-fw pe-2"></i><?= lang('Web.report_post') ?>
						</a></li>
					<?php } ?>

					<li><a class="dropdown-item" href="<?=$post['post_link']?>" target="__blank">
						<i class="bi bi-box-arrow-up-right fa-fw pe-2"></i><?= lang('Web.open_in_new_tab') ?>
					</a></li>
				</ul>
			</div>
			<!-- Card feed action dropdown END -->
		</div>
	</div>
	<div class="card-body">
		<?php if($post['product_id'] > 0) { ?>
			<img src="<?= $post['product']['images'][0]['image'] ?>" alt="">
			<div class="row mt-3">
				<div class="col-md-9">
					<p><?= $post['post_text'] ?></p>
					<h6><b><?= $post['product']['product_name'] ?></b></h6>
					<span><b><?= lang('Web.price') ?>: </b><?= $post['product']['price'] ?> (<?= $post['product']['currency'] ?>)</span>
					<br><span><b><?= lang('Web.category') ?>: </b><?= $post['product']['category'] ?></span>
					<br><span> <i class="bi bi-geo-alt-fill text-primary"></i> <?= $post['product']['location'] ?> </span>
				</div>
				<div class="col-md-3 mt-4">
					<?php if ($post['product']['user_id'] != getCurrentUser()['id']) : ?>
						<a href="<?= site_url('products/details/' . $post['product']['id']) ?>" class="btn btn-primary-hover btn-outline-primary rounded-pill"><?= lang('Web.buy_product') ?></a>
					<?php else : ?>
						<a href="<?= site_url('products/details/' . $post['product']['id']) ?>" class="btn btn-primary-hover btn-outline-primary rounded-pill"><?= lang('Web.edit_product') ?></a>
					<?php endif; ?>
				</div>
			</div>
		<?php } 

		elseif($post['post_type'] == 'donation' && $post['fund_id'] != 0) { ?>
			<div class="row">
				<div class="col-md-12">
					<img src="<?= $post['donation']['image'] ?>" alt="" class="w-100">
					<h5 class="text-center mt-3"><?= $post['donation']['title'] ?></h5>
					<p class="text-center mt-3 short-description" id="shortDescription<?= $post['id'] ?>" onclick="toggleDescription(<?= $post['id'] ?>)" style="cursor: pointer;">
						<?= substr($post['donation']['description'], 0, 160) ?>...
					</p>
					<p class="text-center mt-3 full-description" id="fullDescription<?= $post['id'] ?>" style="display: none;" onclick="toggleDescription(<?= $post['id'] ?>)" style="cursor: pointer;">
						<?= $post['donation']['description'] ?>
					</p>
					<div class="progress bg-primary bg-opacity-10 position-relative vote_the_option" style="height: 10px;">
					<?php
						$percentage = 100 * (int) $post['donation']['collected_amount'] / $post['donation']['amount'];
					?>
						<div class="progress-bar bg-primary bg-opacity-100" role="progressbar" style="width: <?= $percentage; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
						<span class="position-absolute pt-1 ps-3 fs-6 fw-normal text-truncate w-100"></span>
					</div>
		
					<span class="mt-1"><?= $post['donation']['collected_amount'] ?> <?= lang('Web.collected') ?></span>
					<button class="btn btn-primary btn-xs mt-1 float-end donationbtn" data-fund_id="<?= $post['donation']['id'] ?>"><?= lang('Web.donate') ?></button>
				</div>
			</div>
		<?php }
		
		elseif($post['event_id']>0)
		{?>
		 <div class="row">
        <div class="col-md-12">
            <p><?= $post['post_text'] ?></p>
            <img src="<?= $post['event']['cover'] ?>" alt="" class="w-100">
            <?php $start_date = new DateTime($post['event']['start_date']); ?>
            <a href="<?= site_url('events/event-details/' . $post['event']['id']) ?>">
                <button class="badge rounded-pill bg-primary mt-3">
                    <?= $start_date->format(lang('Web.date_format')) ?>
                </button>
                <h6 class="mt-2"><b><?= $post['event']['name'] ?></b></h6>
            </a>
        </div>
    </div>
		<?php 
		}
		elseif($post['parent_id']!=0)
		{
			//echo $this->include('partials/shared_post',['post'=>$post]);
			echo load_view('partials/shared_post.php', ['post'=>$post]);
		}
		elseif($post['post_type']=='poll'){ ?>
		<span class="ml-2"><?= $post['post_text'] ?></span>
		<div class="card card-body mt-4">

			<div class="d-sm-flex justify-content-sm-between align-items-center">
				<!-- You can add any other elements here if needed -->
			</div>

			<!-- Results -->
			<div class="vstack gap-4 gap-sm-3 mt-3">
				<!-- Option 1 result START -->
				<?php foreach ($post['poll']['poll_options'] as $options) : ?>
					<?php
						if ($post['poll']['poll_total_votes'] != 0) {
							$percentage = 100 * $options['no_of_votes'] / $post['poll']['poll_total_votes'];
						} else {
							$percentage = 0;
						}
					?>
					<div class="d-flex align-items-center justify-content-between">
						<!-- Progress bar -->
						<div class="overflow-hidden w-100 me-3">
							<div class="progress bg-primary bg-opacity-10 position-relative vote_the_option" style="height: 30px;" data-poll_option_id="<?=$options['id']?>" data-poll_id="<?=$post['poll']['id']?>" data-is_voted="<?= $post['poll']['is_voted'] ?>">
								<div class="progress-bar bg-primary bg-opacity-25" role="progressbar" style="width: <?= (int)$percentage ?>%" aria-valuenow="<?= (int)$percentage ?>" aria-valuemin="0" aria-valuemax="100">
								</div>
								<span class="position-absolute pt-1 ps-3 fs-6 fw-normal text-truncate w-100"><?= $options['option_text'] ?></span>
							</div>
						</div>
						<div class="flex-shrink-0"><?= (int)$percentage ?>%</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>



		<?php }
		else
		{
			$postColor = '';
				if($post['bg_color'] && $post['bg_color']!="_23jo"){
					$postColor = $post['bg_color'].' clr_pst';	
				}
				if($post['image_or_video'] != 0){
					$postColor = '';	
				}
			
			?>
				<div class="inner_post <?=$postColor?>">
			<?php
			
			// ===============[   Manage Text   ]===================
			if (!empty($post['post_text'])) {
				$maxLength = 100; // Max length of the text to show initially
				$truncatedText = (strlen($post['post_text']) > $maxLength) 
								? substr($post['post_text'], 0, $maxLength) . "..." 
								: $post['post_text'];

				// Displaying the truncated text
				$textcolor = '';
				if(empty($post['bg_color']) || $post['bg_color']=='_23jo')
				{
					$textcolor='text-dark ';
				}
				echo "<p class='short-text {$textcolor}' dir='auto'>{$truncatedText}</p>";

				// Full text will be hidden initially
				if (strlen($post['post_text']) > $maxLength) {
					echo "<p class='full-text'  dir='auto' style='display: none;'>{$post['post_text']}</p>";
					echo "<a href='javascript:void(0);' class='read-more'>Read More</a>";
				}
			}
			?>

				<div class="img-bunch">
					<div class="row">
					<?php
						if(is_array($post['images'])){
							$numImages = count($post['images']);
						}else{
							$numImages = 0;
						}
						if ($numImages > 0) {
							// Determine the column class based on the number of images
							$colClass = $numImages === 1 ? 'col-12' : 'col-lg-6 col-md-6 col-sm-6';
							$imagesPerColumn = ceil($numImages / 2);
							for ($i = 0; $i < $numImages; $i++) {
								if ($i % $imagesPerColumn == 0) {
									// Start a new column after a certain number of images
									echo $i > 0 ? '</div>' : ''; // Close previous column if not the first
									echo "<div class='{$colClass}'>";
								}
								$image = $post['images'][$i];

								echo '<figure>';
								echo '<a title="' . lang('Web.gallery_view_image') . '" href="'.$image['media_path'].'" data-lightbox="image-'.$post['id'].'" >';
								echo '<img src="' . $image['media_path'] . '" alt="' . lang('Web.gallery_alt_image') . '" />';
								echo '</a>';

								// Add more-photos div for the last image if there are more than 5 images
								if ($i == $numImages - 1 && $numImages > 5) {
									echo '<div class="more-photos"><span>+' . ($numImages - 5) . '</span></div>';
								}

								echo '</figure>';
							}
							echo '</div>'; // Close last column
						}
					?>
					</div>
				</div>

			

			<?php
			// ===============[   Manage video   ]===================
			if(!empty($post['audio'])){ ?>
				<audio  class="plyr_player" id="audioplayer_<?=$post['id']?>" controls>
					<source src="<?=$post['audio']['media_path']?>" type="audio/mp3" />
				</audio>
			<?php } ?>

			<?php
			// ===============[   Manage video   ]===================
			if(!empty($post['video'])){ ?>
				<div class="dashboard_player" data-message_id="<?=$post['id']?>"  data-poster="<?=$post['video']['media_path']??'';?>" data-thumb="" data-name="<?=$post['video']['media_path']?>" id="myElement_<?=$post['id']?>">
					<video class="plyr_player" width="320" height="240"  playsinline controls >
						<source src="<?=$post['video']['media_path']?>" type="video/mp4">
					</video>
				</div>
			<?php } ?>


		</div>
		<?php } ?>		
		<div class="py-3 d-flex justify-content-between post_counter">
			<div class="post-reactions  px-2">
				<a class="nav-link active getreactiondata" data-post_id="<?= $post['id'] ?>" href="#!">
					<span class="top_reaction_count"><?=$post['reaction']['count']?></span>
					<i class="bi bi-hand-thumbs-up-fill pe-1"></i>
				</a>
			</div>
			<div class="post-interactions d-flex">
				<a href="#!" class="nav-link px-2">
					<i class="fas fa-eye"></i> <?=$post['view_count']?> 
				</a>
				<a class="nav-link px-2" href="#!">
					<i class="bi bi-chat-fill pe-1"></i>
					<?=$post['comment_count']?> <?= lang('Web.comments') ?>
				</a>
				<a class="nav-link px-2 viewshareuser" href="#!" data-post_id="<?=$post['id']?>">
					<i class="bi bi-share ps-1"></i>
					<?=$post['share_count']?> <?= lang('Web.shares') ?>
				</a>
			</div>
		</div>





		<!-- Bottom post START -->
		<ul class="nav nav-pills flex-fill border-top border-bottom">
			<li class="like-btn nav-item flex-fill text-center position-relative">
				<a class="mb-0 <?= isset($post['reaction']['reaction_type']) && $post['reaction']['is_reacted'] == "true" ? ' ' : ' nav-link '; ?> like_action" href="#!">
				<?php
					$reaction_type = "";
					if($post['reaction']['is_reacted'] == "true"){
						switch($post['reaction']['reaction_type']){
							case '1': $reaction_type = "like"; break;
							case '2': $reaction_type = "love"; break;
							case '3': $reaction_type = "wow"; break;
							case '4': $reaction_type = "sad"; break;
							case '5': $reaction_type = "angry"; break;
							case '6': $reaction_type = "haha"; break;
							default : $reaction_type = ""; break;
						}
					} ?>
					
					<?php if(empty($reaction_type)){ ?>
						<div class="reaction-icon add_reaction_one visible" style="display: none;"></div>
					<?php } else { ?>
						<div class="reaction-icon <?= $reaction_type ?> add_reaction_one visible"></div>
					<?php } ?>
					<div class="first_action" <?= (!empty($reaction_type)) ? 'style="display:none"' : '' ?>>
						<span class="like_txt"><i class="bi bi-emoji-smile"></i> <?= lang('Web.react') ?></span>
					</div>

					<div class="reaction-box">
						<div class="reaction-icon like add_reaction" data-reactiontype="1">
							<label><?= lang('Web.like') ?></label>
						</div>
						<div class="reaction-icon love add_reaction" data-reactiontype="2">
							<label><?= lang('Web.love') ?></label>
						</div>
						<div class="reaction-icon haha add_reaction" data-reactiontype="6">
							<label><?= lang('Web.haha') ?></label>
						</div>
						<div class="reaction-icon wow add_reaction" data-reactiontype="3">
							<label><?= lang('Web.wow') ?></label>
						</div>
						<div class="reaction-icon sad add_reaction" data-reactiontype="4">
							<label><?= lang('Web.sad') ?></label>
						</div>
						<div class="reaction-icon angry add_reaction" data-reactiontype="5">
							<label><?= lang('Web.angry') ?></label>
						</div>
					</div>
				</a>
			</li>
			<li class="nav-item flex-fill text-center load_comments">
				<a class="nav-link mb-0" href="#!"><i class="bi bi-chat pe-1"></i><?= lang('Web.comments') ?></a>
			</li>
			<!-- Card share action START -->
			<li class="nav-item flex-fill text-center">
				<a class="nav-link mb-0" href="#" id="cardShareAction" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="bi bi-share ps-1"></i> <?= lang('Web.share') ?>
				</a>
				<!-- Card share action dropdown menu -->
				<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction">
					<li><a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u=<?= $post['post_link'] ?>" target="_blank"> <i class="bi bi-facebook fa-fw pe-2"></i><?= lang('Web.share_on_facebook') ?></a></li>
					<li><a class="dropdown-item" href="https://twitter.com/intent/tweet?url=<?= $post['post_link'] ?>&text=YourShareText" target="_blank"> <i class="bi bi-twitter-x fa-fw pe-2"></i><?= lang('Web.share_on_x') ?></a></li>
					<li><a class="dropdown-item" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $post['post_link'] ?>" target="_blank"> <i class="bi bi-linkedin fa-fw pe-2"></i><?= lang('Web.share_on_linkedin') ?></a></li>
					<li><hr class="dropdown-divider"></li>
					<li><a class="dropdown-item" id="sharepost" href="#" data-bs-toggle="modal" data-bs-target="#share_post_modal" data-pstlnk="<?= $post['post_link'] ?>" data-pstid="<?= $post['id'] ?>"><i class="bi bi-bookmark-check fa-fw pe-2"></i><?= lang('Web.post_on_timeline') ?></a></li>
					<li><a class="dropdown-item" href="#" onclick="`copyPostLink`('<?= $post['post_link'] ?>')"><i class="bi bi-link fa-fw pe-2"></i><?= lang('Web.copy_post_link') ?></a></li>
				</ul>
			</li>
		</ul>

		<?php
			if($post['privacy'] == 1){
			?>
				<div class="d-flex py-1 justify-content-between">
					
					<div class="post-promo">
						<?php if(get_setting('chck-cup_of_coffee')) :?>
						<a class="coffee btn btn-sm mt-1 text-small award_coc" href="javascript:void(0)" >
							<span><i class="bi bi-cup-hot"></i> <?= lang('Web.cup_of_coffee'); ?></span>
						</a>

						<input type="hidden" id="coc" value="<?= get_setting('cup_of_coffee')?>">
						<?php endif;
							if(get_setting('chck-great_job')) :
						?>
						<input type="hidden" id="great_jobvalue" value="<?= get_setting('great_job')?>">
						<a class="great-job btn btn-sm mt-1 text-small award_gj" href="javascript:void(0)">
							<span class="grt_job_btn grtjob"><i class="bi bi-hand-thumbs-up"></i>&nbsp;<?= lang('Web.great_job'); ?></span>
						</a>
						<?php endif; ?>
					</div>
				</div>
		<?php
			}
		?>
		<!-- Comments END -->
		<?php if($post['comments_status'] > 0 ) { ?>
			<ul class="comment-wrap comments_holder mb-0 pt-3 list-unstyled" style="display: none;" >
				<?= load_view('partials/comment_list',$post); ?>
			</ul>
		
		<!-- Add comment -->
		<div class="d-flex pt-3">
			<!-- Avatar -->
			<div class="avatar avatar-xs me-2">
				<a href="#!"> <img class="avatar-img rounded-circle" src="<?=$post['user']['avatar']?>" alt=""> </a>
				
			</div>
			<!-- Comment box  -->
			<form class="nav nav-item w-100 position-relative">
				<textarea  class="form-control autoresizing pe-5 bg-light textarea" rows="1" placeholder="<?= lang('Web.add_comment_placeholder') ?>"></textarea>
				<button class="add_comment nav-link bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0" >
					<i class="bi bi-send-fill"> </i>
				</button>
			</form>
		</div>
		<?php } ?>
	</div>
			
	<?php
	//advertisements will appear only public posts
	if($post['privacy'] == 1){?>
		<div class="advertisement_Section">
			<?php if($post['post_advertisement']) { ?>
				<div class="card-body bg-white border-top p-3">
					<div class="d-flex">
						<div class="me-2 w-25 border">
							<a href="<?=$post['post_advertisement']['link'];?>">
								<img class="avatar-img" src="<?=$post['post_advertisement']['image']?>" alt="<?= lang('Web.ad_image_alt') ?>">
							</a>
						</div>
						<div class="content_section w-75">
							<a href="<?=$post['post_advertisement']['link'];?>" class="small"><?=$post['post_advertisement']['link'];?></a>
							<h6 class="mx-0 px-0"><?=$post['post_advertisement']['title'];?></h6>
							<span class="ml-2"><?= $post['post_text'] ?></span>
							<div class="card card-body mt-4">
								<p class="mb-0 small"><?=$post['post_advertisement']['body'];?></p>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
			<?php if(get_setting('chck-post_advertisement') == 1 && $post['user_id'] != $loggendInUserId) { ?>
				<div class="p-2 d-flex justify-content-center border-top">
					<button class="advertisement_btn btn btn-sm btn-primary">
						<i class="bi bi-plus-square"></i> <?= lang('Web.advertise_here') ?>
					</button>
				</div>
			<?php } ?>
			
			<?php $first_post_ad = empty($first_post_ad) ? true : false; ?>
			
			<?php if(!empty(get_setting('first_post_ad')) && $key == 0 && empty($last_post_id)) { ?>
				<?= get_setting('first_post_ad') ?>
			<?php } ?>
			
			<?php if(!empty(get_setting('second_post_ad')) && $key == 1 && empty($last_post_id)) { ?>
				<?= get_setting('second_post_ad') ?>
			<?php } ?>
			
			<?php if(!empty(get_setting('third_post_ad')) && $key == 2 && empty($last_post_id)) { ?>
				<?= get_setting('third_post_ad') ?>
			<?php } ?>
			
			<?php $first_post_ad == false; ?>
		</div>

	<?php } ?>

</div>



<?php
} }else{ ?>
	<div class="card mb-3">
		<div class="card-body">
			<i class="display-1 text-body-secondary bi bi-calendar-event"></i>
			<h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_posts') ?></h4>
		</div>
	</div>
<?php 
}
?>
