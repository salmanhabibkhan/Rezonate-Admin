<div class="card">
  <div class="card-header border-0 pb-0">
    <h5 class="card-title"><?= lang('Web.page_followers') ?></h5>
  </div>
  <div class="card-body">
    <div class="rounded border px-3 py-2 mb-3">   
      <div class="row g-4">
        <div class="col-12">
        <?php if(count($getallusermembers) > 0): ?>
          <ul style="list-style-type: none;">
            <?php foreach ($getallusermembers as $user) : ?>
              <li>
                <a href="<?= site_url('/' . $user['id']) ?>">
                  <div class="rounded d-sm-flex border-0 mb-1 p-3 position-relative">
                    <div class="avatar text-center">
                      <img class="avatar-img rounded-circle" src="<?= getMedia($user['avatar']) ?>" alt="">
                    </div>
                    <div class="mx-sm-3 my-2 my-sm-0">
                      <p class="small">
                        <b><a href="<?= site_url($user['username']) ?>"><?= $user['first_name'] . ' ' . $user['last_name'] ?></a></b><br>
                        <a href="<?= site_url($user['username']) ?>" style="color:inherit;">@<?= $user['username'] ?></a>
                      </p>
                    </div>
                    <?php if(getCurrentUser()['id'] == $page['user_id']): ?>
                      <div class="d-flex ms-auto">
                        <div class="dropdown position-absolute end-0 top-0 mt-3 me-3">
                          <a href="#" class="z-index-1 text-secondary btn position-relative py-0 px-2" id="cardNotiAction2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardNotiAction2">
                            <li>
                              <a class="dropdown-item delete_page_user" href="#" data-user_id="<?= $user['id'] ?>">
                                <i class="bi bi-person-x-fill fa-fw pe-2"></i><?= lang('Web.remove') ?>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </a>
              </li>
            <?php endforeach ?>
          </ul>
        <?php else: ?>
          <div class="row">
            <div class="my-sm-5 py-sm-5 text-center">
              <i class="display-1 text-body-secondary bi bi-briefcase"></i>
              <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_user_liked') ?></h4>
            </div>
          </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
