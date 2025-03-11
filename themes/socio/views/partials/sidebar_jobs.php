<div class="col-lg-3">

    <!-- Navbar START-->
    <nav class="navbar navbar-expand-lg mx-0"> 
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSideNavbar">
            <div class="offcanvas-body d-block px-2 px-lg-0 left_sidebar">
                <div class="card overflow-hidden">
                    <div class="card-header border-0 border-bottom">
                        <div class="row g-2">
                            <div class="col">
                                <h5 class="card-title mb-lg-0"><?= lang('Web.job_categories') ?></h5>
                            </div>
                        </div>
                    </div>
                            
                    <div class="card-body">
                        <?php
                            $currentcategory = $_GET['category'] ?? '';
                        ?>
                        <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
                            <li class="nav-item">
                                <a class="nav-link small" href="<?= site_url('jobs'); ?>">
                                    <span class="bi bi-briefcase"></span>
                                    <span><?= lang('Web.all_jobs') ?></span>
                                </a>
                            </li>
                        
                        <?php 
                            foreach ($categories as $key =>  $category): 
                                $isActive = ($category == $currentcategory) ? 'active bg-light' : ''; ?>

                                <li class="nav-item <?= $isActive ?>">
                                    <a class="nav-link small <?= $isActive ?>" href="<?= site_url('jobs'); ?>?category=<?= $key  ?>" title="<?= $category; ?>">
                                        <span class="bi bi-briefcase"></span>
                                        <span><?= $category; ?> <?= lang('Web.jobs') ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
               