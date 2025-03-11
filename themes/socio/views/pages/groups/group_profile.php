<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/post_html_models') ?>
<div class="row g-4">
    <div class="col-lg-8 vstack gap-4">
        <div class="card">
            <?php if(empty($group['cover'])): ?>
                <div class="h-200px rounded-top" style=" background: linear-gradient(90deg, #cf5f5f, #2f4e6e); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
            <?php else: ?>
                <div class="h-200px rounded-top" style="background-image:url(<?= getMedia($group['cover']) ?>);  background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
            <?php endif; ?>

            <div class="card-body py-0">
                <div class="d-sm-flex align-items-start text-center text-sm-start">
                    <div>
                        <div class="avatar avatar-xxl mt-n5 mb-3">
                            <img class="avatar-img rounded-circle border border-white border-3" src="<?= getMedia($group['avatar']) ?>" alt="">
                        </div>
                    </div>
                    <div class="ms-sm-4 mt-sm-3">
                        <h1 class="mb-0 h5"><?= esc($group['group_title']) ?></h1> 
                        <p>@<?= $group['group_name']; ?></p>
                    </div>
                    <div class="d-flex mt-3 justify-content-center ms-sm-auto">
                        <div class="dropdown">
                            <button class="icon-md btn btn-light" type="button" id="profileAction2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileAction2">
                                <?php if($userdata['id']==$group['user_id']):?>
                                    <li><a class="dropdown-item" href="<?= site_url('edit-group/'.$group['id']) ;?>"><i class="bi bi-pencil fa-fw pe-2"></i><?= lang('Web.edit_group') ?></a></li> 
                                    <li><a class="dropdown-item delete_group" href="#" data-group_id="<?= $group['id'] ;?>"><i class="bi bi-trash fa-fw pe-2"></i><?= lang('Web.delete_group') ?></a></li>
                                <?php elseif ($group['is_joined']): ?>   
                                    <li><a class="dropdown-item leave_group" href="#" data-group_id="<?= $group['id'] ;?>"><i class="bi bi-box-arrow-right fa-fw pe-2"></i><?= lang('Web.leave_group') ?></a></li>
                                <?php else:?>
                                    <li><a class="dropdown-item join_group" href="#" data-group_id="<?= $group['id'] ;?>"><i class="bi bi-plus-circle fa-fw pe-2"></i><?= lang('Web.join_group') ?></a></li>
                                <?php endif ;?>
                            </ul>
                        </div> 
                    </div>
                </div>
                <ul class="list-inline mb-0 text-center text-sm-start mt-3 mt-sm-0">
                    <!-- <li class="list-inline-item"><i class="bi bi-calendar2-plus me-1"></i> Created at <?= date("M d, Y", strtotime($group['created_at'])) ?></li> -->
                   
                        <?php
                            $uri = service('uri');
                            $segments = $uri->getSegments();
                            $currentURL = base_url(implode('/', $segments));
                        ?>
                    <input type="hidden" id="currectUrl" value="<?= $currentURL ;?>"> 
                </ul>
            </div>
            <div class="card-footer mt-3 pt-2 pb-0">
                <ul class="nav nav-bottom-line align-items-center justify-content-center justify-content-md-start mb-0 border-0">
                    <li class="nav-item"> <a class="nav-link <?= $section == 'posts' ? 'active' : '' ?>" href="<?= site_url("group/" . $group['group_name']); ?>"> <?= lang('Web.posts') ?> </a> </li>
                    <li class="nav-item"> <a class="nav-link <?= $section == 'about' ? 'active' : '' ?>" href="<?= site_url("group/" . $group['group_name']); ?>/about"> <?= lang('Web.about') ?> </a> </li>
                    <li class="nav-item"> <a class="nav-link <?= $section == 'members' ? 'active' : '' ?>" href="<?= site_url("group/" . $group['group_name']); ?>/members"> <?= lang('Web.members') ?> <span class="badge bg-success bg-opacity-10 text-success small count_friend"> <?php echo count($groupmembers);?></span> </a> </li>
                </ul>
            </div>
        </div>

        <?php
        if ($section == 'posts' || $section == '') { 
            if($group['is_joined'])
            {
        ?>
              <?= $this->include('partials/create_post') ?>
        <?php } ?>
            <div id="post_holder" data-post_type="group" data-post_tid="<?= $group['id'] ?>"></div>
        <?php } ?>
        <?php if ($section == 'about') { ?>
            <?= $this->include('pages/groups/about') ?>
        <?php } ?>
        <?php if ($section == 'members') { ?>
            <?= $this->include('pages/groups/members') ?>
        <?php } ?>
    </div>

    <div class="col-lg-4">
        <div class="row g-4">
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between border-0">
                        <h5 class="card-title py-2 my-0"><?= lang('Web.about') ?></h5>
                    </div>
                    <div class="card-body position-relative pt-0">
                        <p><?= esc($group['about_group']) ?></p>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="mb-2"> <i class="bi bi-calendar-date fa-fw pe-1"></i> <?= lang('Web.privacy') ?>: <strong><?= $group['privacy'] ?> </strong> </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header d-sm-flex justify-content-between border-0">
                        <h5 class="card-title py-2 my-0"><?= lang('Web.members') ?></h5>
                        <a class="btn btn-primary-soft btn-sm" href="<?= site_url('group/'.$group['group_name']); ?>/members"><?= lang('Web.see_all_members') ?></a>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($group_short_members)) : ?>
                            <div class="row g-3">
                                <?php foreach ($group_short_members as $member) : ?>
                                    <div class="col">
                                        <div class="card text-center">
                                            <div class="card-body p-3">
                                                <div class="avatar avatar-lg">
                                                    <img class="avatar-img rounded-circle" src="<?= getMedia($member['avatar'], 'avatar') ?>" alt="Member Avatar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p><?= lang('Web.no_members_found') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header d-sm-flex justify-content-between border-0">
                        <h5 class="card-title py-2 my-0"><?= lang('Web.suggested_group') ?></h5>
                        <a class="btn btn-primary-soft btn-sm" href="<?= site_url('groups')?>"> <?= lang('Web.see_all_groups') ?></a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3"> 
                            <?php if(count($unjoined_groups)>0) :?>
                                <?php foreach($unjoined_groups as $ugroup): ?>
                                <div class="hstack gap-2 mb-3 d-flex justify-content-between">
                                    <div class="group_info d-flex">
                                        <div class="avatar"> 
                                            <a href="#!"> <img class="avatar-img rounded-circle" src="<?= getMedia($ugroup['avatar']) ?>" > </a>
                                        </div>
                                        <div class="ms-2">
                                            <a class="h6 mb-0" href="<?= $ugroup['group_name'] ;?>"><?= substr($ugroup['group_title'], 0, 20); ?> </a><br/>
                                            <small class="mb-0 small text-truncate"><?= $ugroup['members_count'] ;?> <?= lang('Web.members') ?></small>
                                        </div>
                                    </div>
                                    <a class="btn btn-sm <?=($ugroup['is_joined']==0)? 'btn-primary join_group':'btn-success'?> " data-group_id="<?= $ugroup['id'] ;?>" href="#"><?=($ugroup['is_joined']==0)? '<i class="fa-solid fa-plus"> </i> '.lang('Web.join_group'):'<i class="bi bi-check-circle-fill"> </i> '.lang('Web.joined')?></a>
                                </div>
                                <?php endforeach ;?>
                            <?php endif ;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).on('click', '.delete_group', function (event) {
        let that = $(this);
        let group_id = that.data('group_id');
        Swal.fire({
            title: "<?= lang('Web.are_you_sure_delete_group') ?>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "<?= lang('Web.delete_confirm_button') ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('web_api/delete-group') ?>",
                    data: {group_id: group_id},
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                title: "<?= lang('Web.success') ?>",
                                icon: "success",
                                html: response.message,
                                timer: 4000,
                                timerProgressBar: true,
                            });
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                    }
                });
            }
        });
    });

    $(document).on('click', '.leave_group', function (event) {
        let that = $(this);
        let group_id = that.data('group_id');
        Swal.fire({
            title: "<?= lang('Web.are_you_sure_leave_group') ?>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "<?= lang('Web.leave_confirm_button') ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('web_api/leave-group') ?>",
                    data: {group_id: group_id},
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                title: "<?= lang('Web.success') ?>",
                                icon: "success",
                                html: response.message,
                                timer: 4000,
                                timerProgressBar: true,
                            });
                            setTimeout(() => {
                                window.location = "<?= site_url('groups') ?>";
                            }, 4000);
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                    }
                });
            }
        });
    });

    $(document).on('click', '.join_group', function (event) {
        let that = $(this);
        let group_id = that.data('group_id');
        Swal.fire({
            title: "<?= lang('Web.are_you_sure_join_group') ?>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "<?= lang('Web.join_confirm_button') ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('web_api/join-group') ?>",
                    data: {group_id: group_id},
                    success: function(response) {
                        if (response.code == 200) {
                            that.removeClass('btn-primary join_group').addClass('btn-success').html('<i class="bi bi-check-circle-fill"> </i> <?= lang('Web.joined') ?>');
                            Swal.fire({
                                title: "<?= lang('Web.success') ?>",
                                icon: "success",
                                html: response.message,
                                timer: 4000,
                                timerProgressBar: true,
                            });
                            setTimeout(() => {
                                window.location = "<?= site_url('group/' . $group['group_name']) ?>";
                            }, 4000);
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                    }
                });
            }
        });
    });
    </script>
</div>
<?= $this->endSection() ?>
