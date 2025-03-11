<div class="card">
    <!-- Card header START -->
    <div class="card-header border-0 pb-0">
        <h5 class="card-title"><?= lang('Web.friends') ?></h5>
    </div>
    <!-- Card header END -->
    <!-- Card body START -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php if($user['privacy_see_friend']==0 || ($user['privacy_see_friend']==1 && $isFriend=='1') || ($user['id']==$loggedInUser)) :?>
                <?php  if(count($friends)>0 ): ?>
                    <?php foreach($friends as $friend):?>
                        <div class="d-md-flex align-items-center friend_item mb-4">
                            <div class="avatar me-3 mb-3 mb-md-0">
                                <a href="<?= site_url($friend['username'])?>"> <img class="avatar-img rounded-circle"
                                        src="<?= getMedia($friend['avatar']) ?>" alt=""> </a>
                            </div>
                            <div class="w-100">
                                <div class="d-sm-flex align-items-start">
                                    <h6 class="mb-0"><a href="<?= site_url($friend['username'])?>"> <?= $friend['first_name']." ".$friend['last_name']?></a></h6>
                                </div>
                                <ul class="avatar-group mt-1 list-unstyled align-items-sm-center">
                                    <li class="small"><?= $friend['countMutualFriend'] ?> <?= lang('Web.mutual_friends') ?></li>
                                </ul>
                            </div>
                            <div class="ms-md-auto d-flex">
                            <?php if($loggedInUser==$user['id']): ?>
                                <a data-user_id="<?php echo $friend['id'] ;?>"
                                    class="btn btn-primary-soft btn-sm mb-0  me-2 unfrienduser"><?= lang('Web.unfriend') ?></a>
                            <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="my-sm-5 py-sm-5 text-center">
                            <i class="display-1 text-body-secondary bi bi-people"></i>
                            <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_friends') ?></h4>
                        </div>
                    </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Card body END -->
</div>

