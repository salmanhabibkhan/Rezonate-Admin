<div class="col-lg-3">
    <div class="row g-4">
        <!-- Card follow START -->
        <div class="col-sm-6 col-lg-12">
            <?php if(get_setting('is_friend_system')==1) :?>
            <div class="card">
                <div class="card-header pb-0 border-0  d-flex justify-content-between border-0">
                    <h5 class="card-title mb-0 fs-6 pt-2"><?= lang('Web.people_you_may_know') ?></h5>
                    <a class="btn btn-primary-soft btn-sm refresh_suggestion" href="#!"> <i class="bi bi-arrow-clockwise"></i></a>
                </div>
                <div class="card-body ">
                    <div class="who_to_follow">
                        <div class="socio_loader"></div>
                    </div>
                    <!-- View more button -->
                    <div class="d-grid mt-3">
                        <a class="btn btn-sm btn-primary-soft" href="<?= site_url('friends') ?>"><?= lang('Web.view_more') ?></a>
                    </div>
                </div>
            </div>
            <?php endif ;?>
        </div>
        <div class="col-sm-6 col-lg-12">
        <?php if(get_setting('chck-blogs')==1) :?>
            <div class="card">
                <!-- Card header START -->
                <div class="card-header pb-0 border-0  d-flex justify-content-between border-0">
                    <h5 class="card-title mb-0 fs-6 pt-2"><?= lang('Web.articles_and_blogs') ?></h5>
                </div>
                <div class="card-body">
                    <div class="recent-blog">
                        <div class="socio_loader"></div>
                    </div>
                    <div class="d-grid mt-3">
                        <a class="btn btn-sm btn-primary-soft" href="<?= site_url('blogs'); ?>"><?= lang('Web.view_more') ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ;?>
    </div>
    <?php if(!empty(get_setting('sidebar_ad'))):?>
		<?= get_setting('sidebar_ad') ?> 
	<?php endif ;?>
