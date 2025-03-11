<?php
if ($post['parent_id'] > 0 && !empty($post['parent_id']) && !empty($post['shared_post'])) { ?>
    <?= $post['post_text'] ?>
    <div class="card mb-2 post_card" data-pstid="<?= $post['id'] ?>">
        <div class="card-header border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <!-- Avatar -->
                    <div class="avatar me-2">
                        <?php
                        $avatar = $post['shared_post']['user']['avatar'];
                        $arrow = '';
                        $page_group_link = '';
                        $page_group_name = '';
                        
                        $link = site_url($post['shared_post']['user']['username']);
                        $name = $post['shared_post']['user']['first_name'] . " " . $post['shared_post']['user']['last_name'];
                        ?>
                        <a href="<?= $link ?>"> <img class="avatar-img rounded-circle" src="<?= $avatar ?>" alt=""> </a>
                        <i class="bi bi-check-circle-fill verified_circle"></i>
                    </div>
                    <!-- Info -->
                    <div>
                        <div class="nav nav-divider">
                            <h6 class="nav-item card-title mb-0"> <a href="<?= $link; ?>"><?= $name ?> </a></h6>
                            <?php if (!empty($post['shared_post']['tagged_users']) && count($post['shared_post']['tagged_users']) > 0) { ?>
                                <?= lang('Web.with') ?>
                                <span class="ps-2">
                                    <?php foreach ($post['shared_post']['tagged_users'] as $key => $tag_user) : ?>
                                        <a href="<?= site_url($tag_user['username']) ?>">
                                            <?= $tag_user['first_name'] . ' ' . $tag_user['last_name'] ?>
                                        </a>
                                        <?php if ($key < count($post['shared_post']['tagged_users']) - 2) : ?>,
                                        <?php elseif ($key == count($post['shared_post']['tagged_users']) - 2) : ?> <?= lang('Web.and') ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </span>
                            <?php } ?>
                            <?php if (!empty($post['post_location'])) { ?>
                                <span class="nav-item small"> <?= lang('Web.is_in') ?>&nbsp;<strong><a target="_blank" href="https://www.google.com/maps/place/<?= $post['post_location'] ?>"><?= $post['post_location'] ?></a></strong></span>
                            <?php } ?>
                            <?php if ($post['post_type'] == 'avatar') { ?>
                                <span class="ps-2 small"> <?= lang('Web.updated_profile_picture') ?>.</span>
                            <?php } ?>
                            <?php if ($post['post_type'] == 'cover') { ?>
                                <span class="ps-2 small"> <?= lang('Web.updated_cover_photo') ?>.</span>
                            <?php } ?>
                            <?php if ($post['shared_post']['parent_id'] != 0 && $post['shared_post']['parent_id'] != null) { ?>
                                <span class="ps-2"><?= lang('Web.shared_post') ?></span>
                            <?php } ?>
                            <?php if (!empty($post['page'])) {
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
                            <a href="<?= $page_group_link ?>"> <?= $page_group_name ?></a>
                        </div>
                        <div class="dropdown">
                            <a class="mb-0 small" href="<?= $post['shared_post']['post_link'] ?>">
                                <?= $post['created_human'] ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shared Post Content -->
        <?php if ($post['shared_post']['product_id'] > 0) { ?>
            <img src="<?= $post['shared_post']['product']['images'][0]['image'] ?>" alt="">
            <div class="row mt-3">
                <div class="col-md-9">
                    <p><?= $post['shared_post']['post_text'] ?></p>
                    <h6><b><?= $post['shared_post']['product']['product_name'] ?></b></h6>
                    <span><b><?= lang('Web.price') ?>:</b> <?= $post['shared_post']['product']['price'] ?> (<?= $post['shared_post']['product']['currency'] ?>)</span>
                    <br><span><b><?= lang('Web.category') ?>:</b> <?= $post['shared_post']['product']['category'] ?> </span>
                    <br><span> <i class="bi bi-geo-alt-fill text-primary"></i> <?= $post['shared_post']['product']['location'] ?> </span>
                </div>
                <div class="col-md-3 mt-4">
                    <?php if ($post['shared_post']['product']['user_id'] != getCurrentUser()['id']) : ?>
                        <a href="<?= site_url('products/details/' . $post['shared_post']['product']['id']) ?>" class="btn btn-primary-hover btn-outline-primary rounded-pill"><?= lang('Web.buy_product') ?></a>
                    <?php else : ?>
                        <a href="<?= site_url('products/details/' . $post['shared_post']['product']['id']) ?>" class="btn btn-primary-hover btn-outline-primary rounded-pill"><?= lang('Web.edit_product') ?></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php } elseif ($post['shared_post']['post_type'] == 'poll') { ?>
            <span class="ml-2" style="margin-left: 20px;"><?= $post['shared_post']['post_text'] ?></span>
            <div class="card card-body mt-4">
                <div class="vstack gap-4 gap-sm-3 mt-3">
                    <?php foreach ($post['shared_post']['poll']['poll_options'] as $options) : ?>
                        <?php
                        $percentage = ($post['shared_post']['poll']['poll_total_votes'] != 0)
                            ? 100 * $options['no_of_votes'] / $post['shared_post']['poll']['poll_total_votes']
                            : 0;
                        ?>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="overflow-hidden w-100 me-3">
                                <div class="progress bg-primary bg-opacity-10 position-relative vote_the_option" style="height: 30px;" data-poll_option_id="<?= $options['id'] ?>" data-poll_id="<?= $post['shared_post']['poll']['id'] ?>" data-is_voted="<?= $post['shared_post']['poll']['is_voted'] ?>">
                                    <div class="progress-bar bg-primary bg-opacity-25" role="progressbar" style="width: <?= (int)$percentage ?>%" aria-valuenow="<?= (int)$percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    <span class="position-absolute pt-1 ps-3 fs-6 fw-normal text-truncate w-100"><?= $options['option_text'] ?></span>
                                </div>
                            </div>
                            <div class="flex-shrink-0"><?= (int)$percentage ?>%</div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php } elseif ($post['shared_post']['event_id'] > 0) { ?>
            <div class="row">
                <div class="col-md-12">
                    <p><?= $post['shared_post']['post_text'] ?></p>
                    <img src="<?= $post['shared_post']['event']['cover'] ?>" alt="" class="w-100">
                    <?php $start_date = new DateTime($post['shared_post']['event']['start_date']); ?>
                    <a href="<?= site_url('events/event-details/' . $post['shared_post']['event']['id']) ?>">
                        <button class="badge rounded-pill bg-primary mt-3 "><?= $start_date->format('d / M / Y') ?></button>
                        <h6 class="mt-2"><b><?= $post['shared_post']['event']['name'] ?></b></h6>
                    </a>
                </div>
            </div>
        <?php } elseif ($post['shared_post']['post_type'] == 'donation' && $post['shared_post']['fund_id'] != 0) { ?>
            <div class="row">
                <div class="col-md-12">
                    <img src="<?= $post['shared_post']['donation']['image'] ?>" alt="" class="w-100">
                    <h5 class="text-center mt-3"><?= $post['shared_post']['donation']['title'] ?></h5>
                    <p class="text-center mt-3 short-description" id="shortDescription<?= $post['id'] ?>" onclick="toggleDescription(<?= $post['id'] ?>)" style="cursor: pointer;"><?= substr($post['shared_post']['donation']['description'], 0, 4) ?>...</p>
                    <p class="text-center mt-3 full-description" id="fullDescription<?= $post['id'] ?>" style="display: none;" onclick="toggleDescription(<?= $post['id'] ?>)" style="cursor: pointer;"><?= $post['shared_post']['donation']['description'] ?></p>
                    <div class="progress bg-primary bg-opacity-10 position-relative" style="height: 10px;margin:10px;">
                        <?php
                        $percentage = 100 * (int)$post['shared_post']['donation']['collected_amount'] / $post['shared_post']['donation']['amount'];
                        ?>
                        <div class="progress-bar bg-primary bg-opacity-100" role="progressbar" style="width:<?= $percentage; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span style="margin: 10px 0px 10px 10px"><?= $post['shared_post']['donation']['collected_amount'] ?> <?= lang('Web.collected') ?></span>
                    <button class="btn mb-1 btn-primary btn-xs float-end donationbtn" style="margin: 0px 10px 0px 0px;" data-fund_id="<?= $post['shared_post']['donation']['id'] ?>"><?= lang('Web.donate') ?></button>
                </div>
            </div>
        <?php } else { ?>
            <div class="inner_post <?= $post['shared_post']['bg_color'] ?? 'clr_pst' ?>">
                <?php
                if (!empty($post['shared_post']['post_text'])) {
                    $maxLength = 100;
                    $truncatedText = (strlen($post['shared_post']['post_text']) > $maxLength)
                        ? substr($post['shared_post']['post_text'], 0, $maxLength) . "..."
                        : $post['shared_post']['post_text'];

                    $textcolor = empty($post['shared_post']['bg_color']) ? 'text-dark' : '';
                    echo "<p class='short-text {$textcolor}' dir='auto'>{$truncatedText}</p>";

                    if (strlen($post['shared_post']['post_text']) > $maxLength) {
                        echo "<p class='full-text' dir='auto' style='display: none;'>{$post['shared_post']['post_text']}</p>";
                        echo "<a href='javascript:void(0);' class='read-more'>" . lang('Web.read_more') . "</a>";
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>
<?php } elseif ($post['parent_id'] > 0 && !empty($post['parent_id']) && empty($post['shared_post'])) { ?>
    <div class="row">
        <div class="col-md-12">
            <span><?= $post['post_text'] ?></span>
            <div class="alert alert-warning" role="alert">
                <strong><?= lang('Web.content_unavailable') ?></strong>
                <p><?= lang('Web.content_unavailable_reason') ?></p>
            </div>
        </div>
    </div>
<?php } ?>
