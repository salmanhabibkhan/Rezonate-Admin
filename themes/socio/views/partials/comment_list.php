<?php
if (isset($comments) && !empty($comments)) {
    foreach ($comments as $comment) { ?>
    <li class="comment-item" data-commentid="<?= $comment['id']; ?>">
        <div class="d-flex">
            <!-- Avatar -->
            <div class="avatar avatar-xs">
                <a href="#!"><img class="avatar-img border rounded-circle" src="<?= $comment['avatar'] ?>" alt=""></a>
            </div>
            <!-- Comment by -->
            <div class="ms-2">
                <div class="bg-light p-2 rounded commentdata">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1"> <a href="<?= site_url($comment['username']); ?>"> <?= $comment['first_name'] . ' ' . $comment['last_name']; ?> </a> </h6>
                        <small class="ms-2"><?= $comment['created_human'] ?></small>
                    </div>
                    <p class="small mb-0"><?= $comment['comment'] ?></p>
                </div>
                <?php
                $isliked = false;
                if ($comment['reaction']['is_reacted']) {
                    $isliked = true;
                } ?>
                <!-- Comment react -->
                <ul class="nav nav-divider pt-2 small">
                    <li class="nav-item">
                        <a class="nav-link mb-0 <?= $isliked ? "active" : "" ?> comment_like_action" href="#!">
                            <i class="bi bi-hand-thumbs-up pe-1"></i>
                            <?php if ($isliked) { ?>
                                <span class="like_txt"><?= lang('Web.liked') ?></span>
                            <?php } else { ?>
                                <span class="like_txt"><?= lang('Web.like') ?></span>
                            <?php } ?>
                            (<span class="like_count"><?= $comment['like_count'] ?></span>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link reply_comment_action" href="#!"><?= lang('Web.reply') ?></a>
                    </li>

                    <?php if ($comment['user_id'] == getCurrentUser()['id']) { ?>
                        <li class="nav-item">
                            <a class="nav-link deletecomment" href="#!" data-comment_id="<?= $comment['id'] ?>"> <?= lang('Web.delete') ?></a>
                        </li>
                    <?php } ?>

                    <?php if ($comment['reply_count'] > 0) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#!"> <span class="replycount"><?= $comment['reply_count'] ?></span> <?= lang('Web.replies') ?></a>
                        </li>
                    <?php } ?>
                </ul>

                <?php if ($comment['reply_count'] > 0) { ?>
                    <ul style="list-style-type:none;" class="reply_list_main">
                        <?php foreach ($comment['comment_replies'] as $reply) { ?>
                            <li class="reply-item" data-reply_item="<?= $reply['id']; ?>">
                                <div class="d-flex">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-xs">
                                        <a href="#!"><img class="avatar-img border rounded-circle" src="<?= $reply['avatar'] ?>" alt=""></a>
                                    </div>
                                    <!-- Comment by -->
                                    <div class="ms-2">
                                        <div class="bg-light p-2 rounded commentdata">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1"> <a href="<?= site_url($reply['username']); ?>"> <?= $reply['first_name'] . ' ' . $reply['last_name']; ?> </a> </h6>
                                                <small class="ms-2"><?= $reply['created_human'] ?></small>
                                            </div>
                                            <p class="small mb-0"><?= $reply['comment'] ?></p>
                                        </div>
                                        <?php
                                        $isliked = false;
                                        if ($reply['reaction']['is_reacted']) {
                                            $isliked = true;
                                        } ?>
                                        <!-- Comment react -->
                                        <ul class="nav nav-divider pt-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 <?= $isliked ? "active" : "" ?> comment_like_action" href="#!">
                                                    <i class="bi bi-hand-thumbs-up pe-1"></i>
                                                    <?php if ($isliked) { ?>
                                                        <span class="like_txt"><?= lang('Web.liked') ?></span>
                                                    <?php } else { ?>
                                                        <span class="like_txt"><?= lang('Web.like') ?></span>
                                                    <?php } ?>
                                                    (<span class="like_count"><?= $reply['like_count'] ?></span>)
                                                </a>
                                            </li>

                                            <?php if ($reply['user_id'] == getCurrentUser()['id']) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link delete_commentreply" href="#!" data-reply_id="<?= $reply['id'] ?>"> <?= lang('Web.delete') ?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </li>
<?php }
}
?>
