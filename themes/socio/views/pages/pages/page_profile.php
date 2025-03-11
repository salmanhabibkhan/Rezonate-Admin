<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/post_html_models') ?>
<div class="row g-4">
    <div class="col-lg-8 vstack gap-4">
        <div class="card">
            <?php if (!empty($page['cover'])) : ?>
            <div class="h-200px rounded-top" style="background-image:url(<?= $page['cover'] ?>);background-size: cover; background-repeat: no-repeat "></div>
            <?php else : ?>
            <div class="h-200px rounded-top" style="background: linear-gradient(90deg, #cf5f5f, #2f4e6e); background-position: center; background-size: cover; background-repeat: no-repeat"></div>
            <?php endif ;?>
            
            <div class="card-body py-0">
                <div class="d-sm-flex align-items-start text-center text-sm-start">
                    <div>
                        <div class="avatar avatar-xxl mt-n5 mb-0">
                            <img class="avatar-img rounded-circle border border-white border-3" src="<?=$page['avatar'] ?>" alt="">
                        </div>
                    </div>
                    <div class="ms-sm-4 mt-sm-3">
                        <h1 class="mb-0 h5"><?= esc($page['page_title']) ?> </h1>
                        <p>@<?= $page['page_username']; ?></p>
                    </div>
                    <div class="d-flex mt-3 justify-content-center ms-sm-auto">
                        <?php if ($page['user_id'] == $user_data['id']) { ?>
                            <a href="<?= site_url('update-page/' . $page['id']); ?>" class="btn btn-danger-soft me-2" type="button">
                                <i class="bi bi-pencil-fill pe-1"></i> <?= lang('Web.edit_page') ?> 
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="card-footer mt-3 pt-2 pb-0">
                <ul class="nav nav-bottom-line align-items-center justify-content-center justify-content-md-start mb-0 border-0">
                    <li class="nav-item"> 
                        <a class="nav-link <?= $section == 'posts' ? 'active' : '' ?>" href="<?= site_url("pages/" . $page['page_username']); ?>"> 
                            <?= lang('Web.posts') ?> 
                        </a> 
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link <?= $section == 'about' ? 'active' : '' ?>" href="<?= site_url("pages/" . $page['page_username']); ?>/about"> 
                            <?= lang('Web.about') ?> 
                        </a> 
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link <?= $section == 'members' ? 'active' : '' ?>" href="<?= site_url("pages/" . $page['page_username']); ?>/followers"> 
                            <?= lang('Web.followers') ?> 
                            <span class="badge bg-success bg-opacity-10 text-success small count_friend"> <?=$page['likes_count']?></span> 
                        </a> 
                    </li>
                </ul>
            </div>
        </div>
        
        <?php if ($section == 'posts' || $section == '') { ?>
            <?php if ($page['user_id'] == $user_data['id']) { 
                echo $this->include('partials/create_post');
            } ?>
            <div id="post_holder" data-post_type="page" data-post_tid="<?= $page['id'] ?>"></div>
        <?php } ?>
        
        <?php if ($section == 'about') { ?>
            <?= $this->include('pages/pages/about') ?>
        <?php } ?>
        <?php if ($section == 'followers') { ?>
            <?= $this->include('pages/pages/members') ?>
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
                        <p><?= esc($page['page_description']) ?></p>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="mb-2"> 
                                <i class="bi bi-calendar-date fa-fw pe-1"></i> <?= lang('Web.category') ?>: <strong><?= $page['page_category'] ?> </strong> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header d-sm-flex justify-content-between border-0">
                        <h5 class="card-title py-2 my-0"><?= lang('Web.suggested_pages') ?></h5>
                        <a class="btn btn-primary-soft btn-sm" href="<?= site_url('pages') ?>"> <?= lang('Web.see_all_pages') ?></a>
                    </div>
                    <div class="card-body">
                        <?php if (count($getUnLikedPages) > 0) : ?>
                            <?php foreach ($getUnLikedPages as $unlikedpage) : ?>
                                <div class="row g-3">
                                    <div class="hstack gap-2 mb-3 d-flex justify-content-between">
                                        <div class="group_info d-flex">
                                            <div class="avatar">
                                                <a href="<?= site_url("pages/" . $unlikedpage['page_username']); ?>">
                                                    <img class="avatar-img rounded-circle" src="<?= getMedia($unlikedpage['avatar']) ?>" alt=""> 
                                                </a>
                                            </div>
                                            <div class="ms-2">
                                                <a class="h6 mb-0" href="<?= site_url("pages/" . $unlikedpage['page_username']); ?>"> 
                                                    <?= $unlikedpage['page_title'] ?>
                                                </a><br/>
                                                <small class="mb-0 small text-truncate">
                                                    <?= $unlikedpage['likes_count'] ?> <?= lang('Web.members') ?><?php if ($unlikedpage['likes_count'] > 0) echo "s"?>
                                                </small>
                                            </div>
                                        </div>
                                        <a class="btn btn-sm likepage_btn" data-page_id="<?= $unlikedpage['id'] ?>" data-is_liked="<?= $unlikedpage['is_liked'] ?>" href="#" style="font-size:25px">
                                            <?php if ($unlikedpage['is_liked'] == 1): ?> 
                                                <i class="bi bi-hand-thumbs-up-fill text-primary"></i> 
                                            <?php else: ?> 
                                                <i class="bi bi-hand-thumbs-up"></i> 
                                            <?php endif; ?> 
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <?= lang('Web.no_suggested_pages_found') ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header d-sm-flex justify-content-between border-0">
                        <h5 class="card-title py-2 my-0"><?= lang('Web.followers') ?></h5>
                        <a class="btn btn-primary-soft btn-sm" href="<?= site_url("pages/" . $page['page_username']); ?>/followers"> <?= lang('Web.see_all_followers') ?></a>
                    </div>
                    <div class="card-body">
                        <?php if (count($getshortmembers)) : ?>
                            <div class="row g-3">
                                <?php foreach ($getshortmembers as $user) : ?>
                                    <div class="hstack gap-2 mb-3 d-flex justify-content-between">
                                        <div class="group_info d-flex">
                                            <div class="avatar">
                                                <a href="#!"> 
                                                    <img class="avatar-img rounded-circle" src="<?= getMedia($user['avatar']) ?>" alt=""> 
                                                </a>
                                            </div>
                                            <div class="mt-3 ms-1">
                                                <a class="h6 mt-3" href="#">  
                                                    <?= $user['username'] ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php else: ?>
                            <?= lang('Web.no_user_likes_page') ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).on('click', '.likepage_btn', function (event) {
    let that = $(this);
    let is_liked = that.data('is_liked');
    let page_id = that.data('page_id');
    let confirmationMessage = is_liked == 1 ? "<?= lang('Web.unlike_page') ?>" : "<?= lang('Web.like_page') ?>";
    Swal.fire({
        title: "<?= lang('Web.are_you_sure') ?>",
        text: confirmationMessage,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "<?= lang('Web.yes') ?>"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "<?= site_url('web_api/like-page') ?>",
                data: { page_id: page_id },
                success: function (response) {
                    if (response.data == 1) {
                        that.html('<i class="bi bi-hand-thumbs-up-fill text-primary "></i>');
                    } else {
                        that.html('<i class="bi bi-hand-thumbs-up"></i>');
                    }
                    that.data('is_liked', is_liked == 1 ? 0 : 1);
                    $('#likes_count' + page_id).html(response.likes_count + " Likes");
                    Swal.fire({
                        title: "<?= lang('Web.success') ?>",
                        icon: "success",
                        text: response.message,
                        timer: 4000,
                        timerProgressBar: true,
                        willClose: () => clearInterval(timerInterval)
                    });
                },
                error: function (error) {
                    Swal.fire({
                        title: "<?= lang('Web.error') ?>",
                        icon: "error",
                        text: "<?= lang('Web.error_message') ?>"
                    });
                }
            });
        }
    });
});

$(document).on('click', '.delete_page_user', function (event) {
    let that = $(this);
    let deleted_user_id = that.data('user_id');
    let page_id = "<?= $page['id'] ?>";
    Swal.fire({
        title: "<?= lang('Web.are_you_sure') ?>",
        text: "<?= lang('Web.remove_user') ?>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "<?= lang('Web.yes') ?>"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "<?= site_url('web_api/remove-page-user') ?>",
                data: { deleted_user_id: deleted_user_id, page_id: page_id },
                success: function (response) {
                    Swal.fire({
                        title: "<?= lang('Web.success') ?>",
                        icon: "success",
                        text: response.message,
                        timer: 4000,
                        timerProgressBar: true
                    }).then(() => window.location = site_url + "pages/<?= $page['page_username'] ?>/followers");
                },
                error: function (error) {
                    Swal.fire({
                        title: "<?= lang('Web.error') ?>",
                        icon: "error",
                        text: "<?= lang('Web.error_message') ?>"
                    });
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
