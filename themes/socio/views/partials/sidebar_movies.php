<div class="col-lg-3">

    <!-- Navbar START-->
    <nav class="navbar navbar-expand-lg mx-0"> 
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSideNavbar">
            
            <div class="offcanvas-body d-block px-2 px-lg-0 left_sidebar">
                <div class="card overflow-hidden">
                        <div class="card-body">
                            <ul class="nav nav-link-secondary flex-column fw-bold gap-2">

                          
                            <?php 
                                // Assuming $currentGenre holds the genre parameter from the current URL.
                                $currentGenre = $_GET['genre'] ?? '';

                                foreach ($genres as $genre): 
                                    $isActive = ($genre == $currentGenre) ? 'active' : '';?>
                                    <li class="nav-item ">
                                        <a class="nav-link <?= $isActive ?>" href="<?= site_url('movies'); ?>?genre=<?= urlencode($genre); ?>" title="<?= $genre; ?>">
                                            <span class="bi bi-film"></span>
                                            <span><?= $genre; ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                            


                            </ul>
                        </div>
                </div>
                <?= $this->include('partials/sidebar_bottom') ?>
                <!-- Copyright -->
                <p class="small text-center mt-1">©<?=date('Y');?> <a class="text-reset" target="_blank" href="<?=site_url();?>"> <?=get_setting('site_name');?> </a></p>
            </div>
        </div>
    </nav>
    <!-- Navbar END-->
</div>