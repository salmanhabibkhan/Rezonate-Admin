<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-3">
    <?= $this->include('partials/sidebar') ?>
    <div class="col-md-4 col-lg-4 vstack gap-3">
        <div class="content-tabs card rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1 friends_search_tab">
                <li class="nav-item friends_tab fr_lists active" data-crtab='fr_lists'>
                    <a href="#"><?= lang('Web.friends') ?></a>
                </li>
                <li class="nav-item friends_tab fr_request" data-crtab='fr_request'>
                    <a href="#"><?= lang('Web.friend_requests') ?></a>
                </li>
                <li class="nav-item friends_tab fr_suggesions" data-crtab='fr_suggesions'>
                    <a href="#"><?= lang('Web.suggestions') ?></a>
                </li>
                <li class="nav-item friends_tab fr_sent" data-crtab='fr_sent'>
                    <a href="#"><?= lang('Web.sent_requests') ?></a>
                </li>
            </ul>
        </div>

        <div class="card friends_holder">
            <div class="card-header border-0 border-bottom">
                <h1 class="h4 card-title mb-lg-0 cardtitle"></h1>
            </div>
            <div class="card-body">
                <div class="socio_loader"></div>
                <div class="row" id="friends_holder">
                    <div class="row">
                        <div class="my-sm-5 py-sm-5 text-center">
                            <i class="display-1 text-body-secondary bi bi-people"></i>
                            <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_friends') ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->include('partials/right_sidebar_friends') ?>
</div>


<script>
var translations = {
    friend_requests: "<?= esc(lang('Web.friend_requests')) ?>",
    suggestions: "<?= esc(lang('Web.suggestions')) ?>",
    sent_requests: "<?= esc(lang('Web.sent_requests')) ?>",
    no_friends: "<?= esc(lang('Web.no_friends')) ?>",
    cancel_request: "<?= esc(lang('Web.cancel_request')) ?>",
    accept: "<?= esc(lang('Web.accept')) ?>",
    delete: "<?= esc(lang('Web.delete')) ?>",
    canceling_request: "<?= esc(lang('Web.canceling_request')) ?>",
    error: "<?= esc(lang('Web.error')) ?>",
    confirm_unfriend: "<?= esc(lang('Web.confirm_unfriend')) ?>",
    friends: "<?= esc(lang('Web.friends')) ?>",
    family: "<?= esc(lang('Web.family')) ?>",
    business: "<?= esc(lang('Web.business')) ?>",
    unfriend: "<?= esc(lang('Web.unfriend')) ?>",
    mutual_friends: "<?= esc(lang('Web.mutual_friends')) ?>",
    error_message: "<?= esc(lang('Web.error')) ?>",
    accepting_request: "<?= esc(lang('Web.accepting_request')) ?>",
    deleting_request: "<?= esc(lang('Web.deleting_request')) ?>",
    send_request: "<?= esc(lang('Web.send_request')) ?>",
    friend_request_status: "<?= esc(lang('Web.friend_request_status')) ?>",
    sending_request: "<?= esc(lang('Web.sending_request')) ?>",
    unfriend_confirmation: "<?= esc(lang('Web.unfriend_confirmation')) ?>",
    add_friend: "<?= esc(lang('Web.add_friend')) ?>",
    error_message: "<?= esc(lang('Web.error')) ?>",
    type_a_message: "<?= esc(lang('Web.type_a_message')) ?>",
    no_conversation: "<?= esc(lang('Web.no_conversation')) ?>",
    find_friends: "<?= esc(lang('Web.find_friends')) ?>",
    
    
    
};
</script>
<?= $this->endSection() ?>
