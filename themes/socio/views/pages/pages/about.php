<div class="card">
  <div class="card-header border-0 pb-0">
    <h5 class="card-title"><?= lang('Web.page_profile_info') ?></h5>
  </div>
  <div class="card-body">
    <div class="rounded border px-3 py-2 mb-3">
      <div class="d-flex align-items-center justify-content-between">
        <h6><?= lang('Web.overview') ?></h6>
      </div>
      <p> <?= $page['page_description'] ?> </p>
    </div>
    <div class="row g-4">
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-people fa-fw me-2"></i> <?= lang('Web.followers_count') ?>: <strong> <?= $page['likes_count'] ?></strong>
          </p>
        </div>
      </div>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-shield-lock fa-fw me-2"></i> <?= lang('Web.facebook') ?>: <strong> <?= ucfirst($page['facebook']) ?> </strong>
          </p>
        </div>
      </div>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-card-checklist fa-fw me-2"></i> <?= lang('Web.category') ?>: <strong> <?= $page['page_category'] ; ?></strong>
          </p>
        </div>
      </div>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-calendar fa-fw me-2"></i> <?= lang('Web.created_on') ?>: <strong> <?= date("M d, Y", strtotime($page['created_at'])) ?> </strong>
          </p>
        </div>
      </div>
      <!-- Add more group details as needed -->
    </div>
  </div>
</div>
