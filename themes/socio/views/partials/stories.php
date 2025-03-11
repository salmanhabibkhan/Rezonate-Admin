<div class="d-flex gap-2 mb-2 px-2">
    <!-- Create Story Box -->
    <div class="position-relative bg-white rounded-3">
        <div class="card add_story_box border h-200px px-4 px-sm-5 shadow-none d-flex align-items-center justify-content-center text-center" 
            style="background-image: url('<?= $user_data['avatar'] ?>'); background-size: cover; background-position: center;">
            <div class="add_btn">
                <a class="stretched-link btn btn-primary rounded-circle icon-md" href="<?= site_url('create-story') ?>">
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>
        </div>
        <h6 class="mb-0 small text-center p-2"><?= lang('Web.create_story') ?></h6>
    </div>

    <!-- Stories -->
    <div id="stories" class="storiesWrapper stories-square stories user-icon carousel scroll-enable">
        <!-- User stories can be dynamically loaded here -->
    </div>
</div>
