<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="content-tabs bg-white rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li class=""> <a href="<?= site_url('events'); ?>">Events</a></li>
                <li class="active"> <a href="<?= site_url('events/my-events'); ?>">My Events</a></li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-6">
                        <h1 class="h4 card-title mb-lg-0">Event Details</h1>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="btn btn-primary-soft ms-auto w-100" href="<?= site_url('events/create-event'); ?>"><i class="fa-solid fa-plus pe-1"></i> Create Event</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Three Tabs Navigation -->


                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="event-detail-tab" data-bs-toggle="tab" data-bs-target="#event-detail" type="button" role="tab" aria-controls="event-detail" aria-selected="true">Event Detail</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="interested-tab" data-bs-toggle="tab" data-bs-target="#interested" type="button" role="tab" aria-controls="interested" aria-selected="false">Interested</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="going-tab" data-bs-toggle="tab" data-bs-target="#going" type="button" role="tab" aria-controls="going" aria-selected="false">Going</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="event-detail" role="tabpanel" aria-labelledby="event-detail-tab">

                        <div class="ed-main-wrap">
                            <div class="ed-top">
                                <div class="ed-thumb">
                                    <img src="assets/images/event/ed-thumb.png" alt="">
                                </div>
                                <div class="ed-status row">
                                    <div class="col text-center"><i class="bi bi-calendar2-week"></i> January 21, 2021</div>
                                    <div class="col text-center"><i class="bi bi-diagram-3"></i> <span>500</span> Seat</div>
                                    <div class="col text-center"><i class="bi bi-pin-map"></i>Broadw, New York</div>
                                </div>
                                <hr/>
                                <div class="event-info row align-items-center">
                                    <div class="col text-center">
                                        <div class="single-event-info">
                                            <div class="info-icon"><i class="bi bi-blockquote-left"></i></div>
                                            <div class="info-content">
                                                <h5>Event Type</h5>
                                                <p>Web Development</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="single-event-info">
                                            <div class="info-icon"><i class="bi bi-megaphone"></i></div>
                                            <div class="info-content">
                                                <h5>Speaker</h5>
                                                <p>10 Best Speaker</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="single-event-info">
                                            <div class="info-icon"><i class="bi bi-lightning"></i></div>
                                            <div class="info-content">
                                                <h5>Sponsor</h5>
                                                <p>Event Lab</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="ed-tabs-wrapper">

                                <div class="" id="">
                                    <div class="">
                                        <div class="">
                                            <h4>Media companies need to better one then educate advertisers. better one then educate.</h4>
                                            <p>Cras semper, massa vel aliquam luctus, eros odio tempor turpis, ac placerat metus tortor eget magna. Donec mattis posuere pharetra. Donec vestibulum ornare velit ut sollicitudin. Pellentesque in faucibus purus.Nulla nisl tellus, hendrerit nec dignissim pellentesque, posuere in est. Suspendisse bibendum vestibulum elit eu placerat. In ut ipsum in odio euismod tincidunt non lacinia nunc. Donec ligula augue, mattis eu varius ac.</p>
                                            <p>Cras semper, massa vel aliquam luctus, eros odio tempor turpis, ac placerat metus tortor eget magna. Donec mattis posuere pharetra. Donec vestibulum ornare velit ut sollicitudin. Pellentesque in faucibus purus.Nulla nisl tellus, hendrerit nec dignissim pellentesque.</p>
                                            <hr/>
                                            <h4>Location Map.</h4>
                                            <div class="sidebar-google-map">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.6968814208644!2d144.94422726902462!3d-37.820568377228135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d5a3ff30273%3A0x55700729bcaebb85!2s16122%20Collins%20St%2C%20West%20Melbourne%20VIC%203008%2C%20Australia!5e0!3m2!1sen!2sbd!4v1669981086614!5m2!1sen!2sbd" loading="lazy"></iframe>
                                            </div>




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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Profile Image</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($interestedusers as $key => $user) : ?>
                                                <tr>
                                                    <td><?= ++$key ?></td>
                                                    <td><?= $user['username'] ?></td>
                                                    <td><?= $user['email'] ?></td>
                                                    <td><?= $user['gender'] ?></td>
                                                    <td><img src="<?= getMedia($user['avatar']) ?>" alt="" height="50px" width="50px"></td>


                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="row">
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-briefcase"></i>
                                    <h4 class="mt-2 mb-3 text-body">No User Intersted</h4>

                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="going" role="tabpanel" aria-labelledby="going-tab">
                        <?php if (count($goingusers) > 0) : ?>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Profile Image</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($goingusers as $key => $user) : ?>
                                                <tr>
                                                    <td><?= ++$key ?></td>
                                                    <td><?= $user['username'] ?></td>
                                                    <td><?= $user['email'] ?></td>
                                                    <td><?= $user['gender'] ?></td>
                                                    <td><img src="<?= getMedia($user['avatar']) ?>" alt="" height="50px" width="50px"></td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="row">
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-briefcase"></i>
                                    <h4 class="mt-2 mb-3 text-body">No User Going</h4>

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