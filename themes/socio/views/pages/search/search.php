<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<div class="row g-3 mt-1 search_container">

    <div class="col-md-8 col-lg-8 vstack gap-3">

        <div class="card rounded shadow-sm ">
            <div class="p-3">

                <form action="<?= site_url('search') ?>" method="get">
                    <div class="d-flex justify-content-between textaligning ">
                        <div class="d-flex gap-3">
                            <!-- Search Input -->
                            <div class="">
                                <input type="text" name="term" id="term" required class="form-control" placeholder="Keyword" value="<?= $_GET['term'] ?? '' ?>" autocomplete="off">
                            </div>


                            <!-- Search Button -->
                            <button type="submit" class="btn btn-primary "><i class="bi bi-search"> </i>
                                Search</button>

                        </div>
                        <!-- Additional Dropdown -->

                    </div>
                </form>

            </div>
        </div>

        <div class="content-tabs  rounded shadow-sm clearfix">


            <!-- Navigation tabs -->
            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active " id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="true">
                        <i class="bi bi-people-fill"></i> Users
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages" type="button" role="tab" aria-controls="pages" aria-selected="false">
                        <i class="bi bi-book-fill"></i> Pages
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="groups-tab" data-bs-toggle="tab" data-bs-target="#groups" type="button" role="tab" aria-controls="groups" aria-selected="false">
                        <i class="bi bi-people"></i> Groups
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="event-tab" data-bs-toggle="tab" data-bs-target="#event" type="button" role="tab" aria-controls="event" aria-selected="false">
                        <i class="bi bi-calendar-event"></i> Events
                    </button>
                </li>
            </ul>


        </div>


        <div class="card">


            <div class="card-body">

                <!-- Tab panes -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <div class="row mb-3">
                            <div class="border-bottom pb-1 mb-2 d-flex justify-content-between">
                                <div>
                                    <h4>Users</h4>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-bars fa-fw"></i> Filters
                                    </button>
                                    <form action="<?= site_url('search') ?>">
                                        <ul class="dropdown-menu p-4 dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <input type="hidden" id="term" value="<?= $_GET['term'] ?? '' ?>"
                                                name="term">
                                            <li class="mb-3">
                                                <p>Verified</p>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_verified" id="verified-all" value="" checked="" <?php if (isset($_GET['is_verified']) && $_GET['is_verified'] == '') : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="verified-all">All</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_verified" id="verified-on" value="1" <?php if (isset($_GET['is_verified']) && $_GET['is_verified'] == 1) : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="verified-on">Verified</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_verified" id="verified-off" value="0" <?php if (isset($_GET['is_verified']) && $_GET['is_verified'] == 0) : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="verified-off">Unverified</label>
                                                </div>
                                            </li>

                                            <li class="mb-3">
                                                <p>Gender</p>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="gender-all" value="" checked="" <?php if (isset($_GET['gender']) && $_GET['gender'] == '') : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="gender-all">All</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="gender-female" value="female" <?php if (isset($_GET['gender']) && $_GET['gender'] == 'female') : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="gender-female">Female</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="gender-male" value="male" <?php if (isset($_GET['gender']) && $_GET['gender'] == 'male') : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="gender-male">Male</label>
                                                </div>
                                            </li>
                                            <!-- Profile Picture Filter -->
                                            <li class="mb-3">
                                                <p>Profile Picture</p>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="avatar" id="image-all" value="" <?php if (isset($_GET['gender']) && $_GET['gender'] == '') : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="image-all">All</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="avatar" id="image-yes" value="1" <?php if (isset($_GET['avatar']) && $_GET['avatar'] == '1') : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="image-yes">Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="avatar" id="image-no" value="0" <?php if (isset($_GET['avatar']) && $_GET['avatar'] == '0') : ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="image-no">No</label>
                                                </div>
                                            </li>
                                            <div>
                                                <button class="btn btn-info">Filter</button>
                                            </div>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                            <?php if (count($users) > 0) : ?>
                                <div class="row row-cols-1 row-cols-md-4 g-4">
                                    <?php foreach ($users as $user) : ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class=" card">
                                                <figure><img src="<?= getMedia($user['avatar']) ?>" class="card-img-top" alt="<?= $user['first_name'] ?>"></figure>
                                                <span class="text-center my-1"><a href="<?= site_url('/' . $user['username']) ?>"><?= $user['first_name'] . ' ' . $user['last_name'] ?></a></span>
                                                <a class="btn btn-primary" href="<?= site_url( $user['username']) ?>"><i class=" bi bi-eye"></i>   View details</a>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php else : ?>
                                <div class="row">
                                    <div class="my-sm-5 py-sm-5 text-center">
                                        <i class="display-1 text-body-secondary bi bi-people-fill"></i>
                                        <h4 class="mt-2 mb-3 text-body">No User Found</h4>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pages" role="tabpanel" aria-labelledby="pages-tab">
                        <div class="row">
                            <div class="border-bottom pb-1 mb-2 d-flex justify-content-between">
                                <div>
                                    <h4>Pages</h4>
                                </div>
                            </div>
                            <?php if (count($pages) > 0) : ?>
                                <?php foreach ($pages as $page) : ?>


                                    <div class="col-lg-3 col-md-4 col-sm-4">
                                        <div class="group-box border p-2 rounded">
                                            <figure><img alt="" src="<?= $page['cover'] ?>"></figure>
                                            <a href="<?= site_url('pages/' . $page['page_username']) ?>"> <?= substr($page['page_title'], 0, 10) . (strlen($page['page_title']) > 10 ? '...' : '') ?></a>
                                            <span><?= $page['likes_count'] ?> Likes</span>
                                            <a class="btn btn-primary" href="<?= site_url('pages/' . $page['page_username']) ?>"><i class=" bi bi-user"></i> View Page</a>
                                        </div>
                                    </div>

                                <?php endforeach ?>

                            <?php else : ?>
                                <div class="row">
                                    <div class="my-sm-5 py-sm-5 text-center">
                                        <i class="display-1 text-body-secondary bi bi-book-fill"></i>
                                        <h4 class="mt-2 mb-3 text-body">No Page Found</h4>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="groups-tab">
                        <div class="row">
                            <div class="border-bottom pb-1 mb-2 d-flex justify-content-between">
                                <div>
                                    <h4>Groups</h4>
                                </div>
                            </div>
                            <?php if (count($groups) > 0) : ?>
                                <?php foreach ($groups as $group) : ?>

                                    <div class="col-lg-3 col-md-4 col-sm-4">
                                        <div class="group-box border p-2 rounded">
                                            <figure><img alt="" src="<?= $group['cover'] ?>"></figure>
                                            <a href="<?= site_url('group/' . $group['group_name']) ?>"><?= $group['group_name'] ?></a>

                                            <a class="btn btn-primary" href="<?= site_url('group/' . $group['group_name']) ?>"><i class=" bi bi-user"></i> View Group</a>
                                        </div>
                                    </div>



                                <?php endforeach ?>

                            <?php else : ?>
                                <div class="row">
                                    <div class="my-sm-5 py-sm-5 text-center">
                                        <i class="display-1 text-body-secondary bi bi-book-fill"></i>
                                        <h4 class="mt-2 mb-3 text-body">No Group Found</h4>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="event" role="tabpanel" aria-labelledby="event-tab">
                            <div class="row">
                            <div class="border-bottom pb-1 mb-2 d-flex justify-content-between">
                                <div>
                                    <h4>Events</h4>
                                </div>
                            </div>
                                <?php if (count($events) > 0) : ?>
                                    <?php foreach ($events as $event) : ?>
                                        <div class="col-md-3">
                                            <div class="card mt-2">
                                                <div class="card-heading">
                                                    <div class="image-container">
                                                        <img src="<?= $event['cover'] ?>" class="card-img-top" alt="<?= $event['name'] ?>">
                                                    </div>
                                                </div>
                                                <div class="card-body text-center">
                                                    <h6><a href="<?= site_url('events') ?>"><?= $event['name'] ?></a></h6>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <div class="row">
                                        <div class="my-sm-5 py-sm-5 text-center">
                                            <i class="display-1 text-body-secondary bi bi-calendar-event"></i>
                                            <h4 class="mt-2 mb-3 text-body">No Event Found</h4>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

</div>