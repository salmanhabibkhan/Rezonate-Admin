<div class="card">
  <div class="card-header border-0 pb-0">
    <h5 class="card-title">Group Profile Info</h5>
  </div>
  <div class="card-body">
    <div class="rounded border px-3 py-2 mb-3">
      <div class="d-flex align-items-center justify-content-between">
        <h6>Overview</h6>
      </div>
      <p> <?= $group['about_group'] ?> </p>
    </div>
    <div class="row g-4">
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-people fa-fw me-2"></i> Members Count: <strong> <?= $group['members_count'] ?></strong>
          </p>
        </div>
      </div>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-shield-lock fa-fw me-2"></i> Privacy: <strong> <?= ucfirst($group['privacy']) ?> </strong>
          </p>
        </div>
      </div>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-card-checklist fa-fw me-2"></i> Category: <strong> <?= GROUP_CATEGORIES[$group['category']] ?>
          
          
          
          </strong>
          </p>
        </div>
      </div>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-calendar fa-fw me-2"></i> Created on: <strong> <?= date("M d, Y", strtotime($group['created_at'])) ?> </strong>
          </p>
        </div>
      </div>
      <!-- Add more group details as needed -->
    </div>
  </div>
</div>
