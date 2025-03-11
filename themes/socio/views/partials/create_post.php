<div class="post_highlighter" role="presentation"></div>
    <div class="card cr_pst_sec">
        <div class="card-header pt-3 pb-2" style="display: none;">
            <div class="p-0 d-flex justify-content-between">
                <h6 class="m-0"><?= lang('Web.create_post') ?></h6>
                <div>
                    <a href="#" class="close_post"><i class="bi bi-x-circle"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if(empty($page) && empty($group)): ?>
            <div class="d-flex align-items-center">
                <div class="avatar me-2">
                    <a href="<?=site_url($user_data['username']); ?>">
                        <img class="avatar-img rounded-circle" src="<?= $user_data['avatar'] ?>" alt="">
                    </a>
                </div>
                <div>
                    <h6 class="nav-item card-title mb-0">
                        <a href="<?=site_url($user_data['username']); ?>"><?=$user_data['first_name'].' '.$user_data['last_name']; ?></a>
                    </h6>
                    <div class="pos-rel dropdown-hover">
                        <a aria-expanded="true" class="dropdown-toggle p-0 btn bg-l-gray" data-bs-toggle="dropdown" id="priv_dropdown" href="javascript:void(0);" rel="nofollow">
                            <span id="privacyicon">
                                <i class="fas fa-globe-asia"></i> <?= lang('Web.public') ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu border bg-white" role="menu" data-privacy="6" id="privacydropdown">
                            <li data-val="1">
                                <a href="#" data-post_privacy="1">
                                    <i class="fas fa-globe-asia"></i> <?= lang('Web.public') ?>
                                </a>
                            </li>
                            <li data-val="2">
                                <a href="#" data-post_privacy="2">
                                    <i class="fas fa-user-friends"></i> <?= lang('Web.friends') ?>
                                </a>
                            </li>
                            <li data-val="4">
                                <a href="#" data-post_privacy="4">
                                    <i class="fas fa-users"></i> <?= lang('Web.family') ?>
                                </a>
                            </li>
                            <li data-val="5">
                                <a href="#" data-post_privacy="5">
                                    <i class="bi bi-briefcase"></i> <?= lang('Web.business') ?>
                                </a>
                            </li>
                            <li data-val="3">
                                <a href="#" data-post_privacy="3">
                                    <i class="bi bi-lock-fill"></i> <?= lang('Web.only_me') ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="mb-3 topbg">
                <form class="w-100 position-relative">
                    <input type="hidden" value="_23jo" id="bgclr">
                    <input type="hidden" name="privacy" value="1" id="postprivacy">
                    <textarea class="form-control pe-4 border-0 txt_msg" id="m_pst_txt" rows="2" data-autoresize placeholder="<?= lang('Web.share_your_thoughts') ?>"></textarea>
                    <button type="button" id="emoji-button" class="p-1 btn btn-light position-absolute trigger" style="right: 10px; top: 10px;">😊</button>
                </form>
            </div>

            <div class="color-wigdet">
                <span class="moticon-icon emotiTrigger"></span>
                <div class="color-sec d-flex">
                    <span class="btn btn-danger-soft" title="<?= lang('Web.add_colored_post') ?>" id="color_display"><i class="bi bi-palette"></i></span>
                    <ul class="color_list_container p-0 pt-2 m-0" style="display: none;">
                        <li>
                            <div class="close-color"><i class="bi bi-chevron-left fs-6"></i></div>
                        </li>
                        <li>
                            <div class="_23jo pickclr removeclr" data-varclass="_23jo" data-type="clr" data-bgcolor="#fff" data-frcolor="#797988"></div>
                        </li>
                        <li>
                            <div class="_23ju pickclr" data-varclass="_23ju" data-type="clr" data-bgcolor="#c600ff" data-frcolor="#ffffff"></div>
                        </li>
                        <li>
                            <div class="_2j78 pickclr" data-varclass="_2j78" data-type="clr" data-bgcolor="#111111" data-frcolor="#ffffff"></div>
                        </li>
                        <li>
                            <div class="_2j79 pickclr" data-varclass="_2j79" data-type="clr" data-bgcolor="linear-gradient(45deg, rgb(255, 0, 71) 0%, rgb(44, 52, 199) 100%)" data-frcolor="#fff"></div>
                        </li>
                        <li>
                            <div class="_2j80 pickclr" data-varclass="_2j80" data-type="clr" data-bgcolor="linear-gradient(45deg, rgb(252, 54, 253) 0%, rgb(93, 63, 218) 100%)" data-frcolor="#fff"></div>
                        </li>
                        <li>
                            <div class="_2j81 pickclr" data-varclass="_2j81" data-type="clr" data-bgcolor="linear-gradient(45deg, rgb(93, 99, 116) 0%, rgb(22, 24, 29) 100%)" data-frcolor="#fff"></div>
                        </li>
                        <li>
                            <div class="_2j82 pickclr" data-varclass="_2j82" data-type="clr" data-bgcolor="#00a859" data-frcolor="#fff"></div>
                        </li>
                        <li>
                            <div class="_2j83 pickclr" data-varclass="_2j83" data-type="clr" data-bgcolor="#0098da" data-frcolor="#fff"></div>
                        </li>
                        <li>
                            <div class="_2j84 pickclr" data-varclass="_2j84" data-type="clr" data-bgcolor="#3e4095" data-frcolor="#fff"></div>
                        </li>
                        <li>
                            <div class="_2j85 pickclr" data-varclass="_2j85" data-type="clr" data-bgcolor="#4b4f56" data-frcolor="#fff"></div>
                        </li>
                        <li>
                            <div class="_2j86 pickclr" data-varclass="_2j86" data-type="clr" data-bgcolor="#161616" data-frcolor="#fff"></div>
                        </li>
                        <!-- <li>
                            <div class="togglemenu"><i class="fal fa-th"></i></div>
                        </li> -->
                        <li>
                            <div class="_2j87 pickclr" data-varclass="_2j87" data-type="clr" data-bgimg="bgpst1.png" data-frcolor="#ffffff"></div>
                        </li>
                        <li>
                            <div class="_2j88 pickclr" data-varclass="_2j88" data-bgimg="bgpst2.png" data-frcolor="#ffffff"></div>
                        </li>
                        <li>
                            <div class="_2j89 pickclr" data-varclass="_2j89" data-bgimg="bgpst3.png" data-frcolor="#ffffff"></div>
                        </li>
                        <li>
                            <div class="_2j90 pickclr" data-varclass="_2j90" data-bgimg="bgpst4.png" data-frcolor="#ffffff"></div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mb-3 location_posting d-none">
                <label class="form-label"><i class="bi bi-geo-alt-fill"></i> <?= lang('Web.location') ?></label>
                <input type="text" class="form-control location_input" placeholder="<?= lang('Web.where_are_you') ?>">
            </div>

            <div class="mb-3 image_posting d-none border-top pt-2">
                <div class="row">
                    <h6 class="card-title"><i class="bi bi-image-fill text-success pe-2"></i> <?= lang('Web.image_upload') ?></h6>
                </div>
                <div class="row">
                    <input type="text" id="image_uploader" value="" />
                </div>
            </div>

            <div class="mb-3 video_posting d-none border-top pt-2">
                <div class="row">
                    <h6 class="card-title"><i class="bi bi-camera-reels-fill text-info pe-2"></i> <?= lang('Web.video_upload') ?></h6>
                </div>
                <div class="row">
                    <input type="text" id="video_uploader" value="" />
                </div>
            </div>

            <div class="mb-3 audio_posting d-none border-top pt-2">
                <div class="row">
                    <h6 class="card-title"><i class="bi bi-camera-reels-fill text-info pe-2"></i> <?= lang('Web.audio_upload') ?></h6>
                </div>
                <div class="row">
                    <input type="text" id="audio_uploader" value="" />
                </div>
            </div>

            <!-- Share feed toolbar START -->
            <ul class="nav nav-pills nav-stack small fw-normal justify-content-between">
                <li class="nav-item">
                    <a class="nav-link photos_link bg-light py-1 px-2 mb-0" href="#!">
                        <i class="bi bi-image-fill text-success pe-2"></i> <?= lang('Web.photo') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link video_link bg-light py-1 px-2 mb-0" href="#!">
                        <i class="bi bi-camera-reels-fill text-info pe-2"></i> <?= lang('Web.video') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link audio_link bg-light py-1 px-2 mb-0" href="#!">
                        <i class="bi bi-music-note-beamed text-primary pe-2"></i> <?= lang('Web.audio') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link location_link bg-light py-1 px-2 mb-0">
                        <i class="bi bi-geo-alt-fill text-danger pe-2"></i> <?= lang('Web.location') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('events/create-event'); ?>" class="nav-link event_link bg-light py-1 px-2 mb-0">
                        <i class="bi bi-calendar2-event-fill text-danger pe-2"></i> <?= lang('Web.event') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link event_link bg-light py-1 px-2 mb-0" data-bs-toggle="modal" data-bs-target="#pollModel">
                        <i class="fas fa-poll text-info pe-1"></i> <?= lang('Web.poll') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link event_link bg-light py-1 px-2 mb-0" data-bs-toggle="modal" data-bs-target="#fundModel">
                        <i class="fas fa-hand-holding-usd text-success pe-1"></i> <?= lang('Web.raise_funding') ?>
                    </a>
                </li>
            </ul>
            <!-- Share feed toolbar END -->

            <div class="pt-3 post_bottom" style="display:none">
                <div class="row justify-content-between">
                    <div class="col-lg-12 text-sm-end">
                        <button type="button" class="btn w-100 btn-success-soft post-btn">
                            <i class="bi bi-send"></i> <?= lang('Web.post') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Button to Open the Modal -->



<!-- The Modal -->
    <div class="modal fade" id="pollModel" tabindex="-1" aria-labelledby="pollModelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pollModelLabel"><?= lang('Web.create_poll') ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('Web.close') ?>"></button>
                </div>
                <div class="modal-body">
                    <label for="post_text"><?= lang('Web.question') ?></label>
                    <input type="text" class="form-control" id="post_text" required>

                    <!-- Initial form fields -->
                    <div id="dynamicForm">
                        <div class="form-group">
                            <label for="input1"><?= lang('Web.option_1') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="input1" required>
                                <button type="button" class="btn btn-success" id="addButton">+</button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="output">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="pollsubmit"><?= lang('Web.save_changes') ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('Web.close') ?></button>
                </div>

        
            </div>
        </div>
    </div>



<div class="modal fade" id="fundModel" tabindex="-1" aria-labelledby="pollModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pollModelLabel"><?= lang('Web.raise_funding') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('Web.close') ?>"></button>
      </div>
      <form method="post" id="donation_form">
        <div class="modal-body">
          <div class="form-group mt-2">
            <label for=""><?= lang('Web.donation_title') ?></label>
            <input type="text" name="post_text" class="form-control">
          </div>
          <div class="form-group mt-2">
            <label for=""><?= lang('Web.donation_image') ?></label>
            <input type="file" class="form-control" name="donation_image">
          </div>
          <div class="form-group mt-2">
            <label for=""><?= lang('Web.donation_amount') ?></label>
            <input type="number" min="0" class="form-control" name="amount">
            <input type="hidden" name="post_type" value="donation">
          </div>
          <div class="form-group mt-2">
            <label for=""><?= lang('Web.donation_description') ?></label>
            <textarea name="description" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="pollsubmit"><?= lang('Web.save_changes') ?></button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('Web.close') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
