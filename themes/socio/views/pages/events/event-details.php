<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="content-tabs bg-white rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li class=""> <a href="<?= site_url('events'); ?>"><?= lang('Web.events') ?></a></li>
                <li class=""> <a href="<?= site_url('events/my-events'); ?>"><?= lang('Web.my_events') ?></a></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-9">
                        <h1 class="h4 card-title mb-lg-0"><?= lang('Web.event_details') ?></h1>
                    </div>
                    <div class="col-sm-4 col-lg-3">
                        <a class="btn justify-content-end btn-primary-soft ms-auto w-100" href="<?= site_url('events/create-event'); ?>"><i class="fa-solid fa-plus pe-1"></i> <?= lang('Web.create_event') ?></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <?php if($user_data['id'] == $event['user_id']): ?>
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="event-detail-tab" data-bs-toggle="tab" data-bs-target="#event-detail" type="button" role="tab" aria-controls="event-detail" aria-selected="true"><?= lang('Web.event_detail') ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="interested-tab" data-bs-toggle="tab" data-bs-target="#interested" type="button" role="tab" aria-controls="interested" aria-selected="false"><?= lang('Web.interested') ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="going-tab" data-bs-toggle="tab" data-bs-target="#going" type="button" role="tab" aria-controls="going" aria-selected="false"><?= lang('Web.going') ?></button>
                    </li>
                </ul>
                <?php endif; ?>
                
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="event-detail" role="tabpanel" aria-labelledby="event-detail-tab">
                        <div class="ed-main-wrap">
                            <div class="ed-top">
                                <div class="ed-thumb">
                                    <img src="assets/images/event/ed-thumb.png" alt="">
                                </div>
                                <h2><?= esc($event['name']) ?></h2>
                                <?php
                                    $start_time = new \DateTime($event['start_time']);
                                    $end_time = new \DateTime($event['end_time']);
                                ?>
                                <hr/>
                                <div class="event-info row align-items-center">
                                    <div class="col text-center">
                                        <div class="single-event-info">
                                            <div class="info-icon"><i class="bi bi-stopwatch-fill"></i></div>
                                            <div class="info-content">
                                                <h5><?= lang('Web.event_start_time') ?></h5>
                                                <p><?= date("d-M-Y", strtotime($event['start_date'])) . " " . $start_time->format('h:i a') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="single-event-info">
                                            <div class="info-icon"><i class="bi bi-calendar-check"></i></div>
                                            <div class="info-content">
                                                <h5><?= lang('Web.event_end_time') ?></h5>
                                                <p><?= date("d-M-Y", strtotime($event['end_date'])) . " " . $end_time->format('h:i a') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="single-event-info">
                                            <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                                            <div class="info-content">
                                                <h5><?= lang('Web.location') ?></h5>
                                                <p><?= esc($event['location']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ed-tabs-wrapper">
                                <div>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-10">
                                            <img src="<?= getMedia($event['cover']) ?>" alt="" width="100%">
                                            <h3 class="mt-3"><?= lang('Web.event_description') ?></h3>
                                            <p><?= esc($event['description']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="interested" role="tabpanel" aria-labelledby="interested-tab">
                        <?php if (count($interestedusers) > 0) : ?>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th><?= lang('Web.name') ?></th>
                                                <th><?= lang('Web.email') ?></th>
                                                <th><?= lang('Web.gender') ?></th>
                                                <th><?= lang('Web.profile_image') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($interestedusers as $key => $user) : ?>
                                                <tr>
                                                    <td><?= ++$key ?></td>
                                                    <td><?= esc($user['username']) ?></td>
                                                    <td><?= esc($user['email']) ?></td>
                                                    <td><?= esc($user['gender']) ?></td>
                                                    <td>
                                                        <img src="<?= getMedia($user['avatar']) ?>" alt="<?= esc($user['username']) ?>" width="50">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-person-x"></i>
                                    <h4 class="mt-2 mb-3 text-body"> <p><?= lang('Web.no_interested_users') ?></p> </h4>

                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane fade" id="going" role="tabpanel" aria-labelledby="going-tab">
                        <?php if (count($goingusers) > 0) : ?>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th><?= lang('Web.name') ?></th>
                                                <th><?= lang('Web.email') ?></th>
                                                <th><?= lang('Web.gender') ?></th>
                                                <th><?= lang('Web.profile_image') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($goingusers as $key => $user) : ?>
                                                <tr>
                                                    <td><?= ++$key ?></td>
                                                    <td><?= esc($user['username']) ?></td>
                                                    <td><?= esc($user['email']) ?></td>
                                                    <td><?= esc($user['gender']) ?></td>
                                                    <td>
                                                        <img src="<?= getMedia($user['avatar']) ?>" alt="<?= esc($user['username']) ?>" width="50">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-person-x"></i>
                                    <h4 class="mt-2 mb-3 text-body"> <p><?= lang('Web.no_going_users') ?></p> </h4>

                                </div>
                            </div>   
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
