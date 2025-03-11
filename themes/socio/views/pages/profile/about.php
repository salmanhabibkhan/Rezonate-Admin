<div class="card">
  <div class="card-header border-0 pb-0">
    <h5 class="card-title"> <?= lang('Web.profile_info') ?> </h5>
  </div>
  <div class="card-body">
    <div class="rounded border px-3 py-2 mb-3">
      <div class="d-flex align-items-center justify-content-between">
        <h6><?= lang('Web.overview') ?></h6>
      </div>
      <p> <?= $user['about_you'] ?> </p>
    </div>
    <div class="row g-4">
    <?php if($user['privacy_birthday']==0 || ($user['privacy_birthday']==1 && $isFriend==1) || ($user['id']==$loggedInUser)) :?>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-calendar-date fa-fw me-2"></i> <?= lang('Web.born') ?> <strong> <?= $user['date_of_birth'] ?></strong>
          </p>
        </div>
      </div>
      <?php endif ;?>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-heart fa-fw me-2"></i> <?= lang('Web.status') ?> <strong> <?= getuserrelation($user['relation_id']) ?> </strong>
          </p>
        </div>
      </div>
      <?php if(!empty($user['working'])):?>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-briefcase fa-fw me-2"></i> <strong> <?= $user['working'] ?> </strong>
          </p>
        </div>
      </div>
      <?php endif ;?>
      <?php if( ($user['privacy_view_phone']==0 || ($user['privacy_view_phone']==1 && $isFriend==1) || ($user['id']==$loggedInUser)) ): ?>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-geo-alt fa-fw me-2"></i> <?= lang('Web.phone_no') ?> <strong> <?= $user['phone'] ?> </strong>
          </p>
        </div>
      </div>
      <?php 
      endif;
      if(($user['privacy_view_email']==0 || ($user['privacy_view_email']==1 && $isFriend==1) || ($user['id']==$loggedInUser)) ): ?>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-envelope fa-fw me-2"></i> <?= lang('Web.email') ?> <strong> <?= $user['email'] ?> </strong>
          </p>
        </div>
      </div> 
      <?php  endif;?>
      <?php if(!empty($user['address'])):?>
      <div class="col-6">
        <div class="d-flex align-items-center rounded border px-3 py-2">
          <p class="mb-0">
            <i class="bi bi-geo-alt fa-fw me-2"></i> <?= lang('Web.lives_in') ?> <strong> <?= $user['address'] ?> </strong>
          </p>
        </div>
      </div>
      <?php endif ;?>
    </div>
  </div>
</div>
