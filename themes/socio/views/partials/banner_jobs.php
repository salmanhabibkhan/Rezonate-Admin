<section class="pt-5 pb-0 position-relative" style="background-image: url(<?= load_asset('images/jobs.jpg'); ?>); background-repeat: no-repeat; background-size: cover; background-position: top center;">
    <div class="bg-overlay bg-dark opacity-8"></div>
    <!-- Container START -->
    <div class="container">
        <div class="p-5 position-relative">
            <div class="row">
                <div class="job_heading_wrapper">
                    <div class="job_heading">
                        <h1 class="text-white"><?= lang('Web.find_a_job') ?> <span data-words="Love|Need|Enjoy" style="display: inline-block; width: 153px;"><span style="display: none;"><?= lang('Web.love') ?></span><span style="display: block;"><?= lang('Web.need') ?></span><span style="display: none;"><?= lang('Web.enjoy') ?></span></span></h1>
                        <p class="text-white"><?= lang('Web.find_jobs_opportunities') ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="header_form_wrapper">
                    <form class="align-items-end g-4" action="<?= site_url('jobs'); ?>">
                        <div class="row">
                            <div class="col-lg-4 my-1 col-md-4 col-12">
                                <input type="text" autocomplete="off" name="search" class="form-control" placeholder="<?= lang('Web.search_keyword_placeholder') ?>" <?php if (isset($search)): ?> value="<?= $search ?>" <?php endif; ?>>
                            </div>
                            <div class="col-lg-4 my-1 col-md-4 col-12">
                                <select class="form-select" name="category">
                                    <option value=""><?= lang('Web.select_category') ?></option>
                                    <?php
                                    $currentcategory = $_GET['category'] ?? '';
                                    foreach ($categories as $key => $category):
                                        $isActive = ($category == $currentcategory) ? 'selected="selected"' : ''; ?>
                                        <option <?= $isActive ?> value="<?= $key ?>"><?= $category; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-4 my-1 col-md-4 col-12">
                                <button class="btn btn-primary w-100" type="submit"><i class="fa fa-search"></i> <?= lang('Web.search') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
