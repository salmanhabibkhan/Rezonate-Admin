<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<!-- Hero section-->
<section class="bg-primary bg-position-top-center bg-repeat-0 py-5" style="background-image: url('<?= base_url('public/uploads/prd-bg.jpg') ?>');backaground-repeat:no-repeat">
    <div class="pb-lg-5 mb-lg-3">
        <div class="container py-lg-5 my-lg-5">
            <div class="row mb-4 mb-sm-5">
                <div class="col-lg-7 col-md-9 text-center text-sm-start">
                    <!-- <h1 class="text-white lh-base"><span class='fw-light'><?= esc(lang('Web.curated_goods')) ?></h1> <!-- Translate "Curated Goods for Every Need" -->
                    <!-- <h2 class="h5 text-white fw-light"><?= esc(lang('Web.prime_picks')) ?></h2> Translate "Prime Picks..." --> -->
                </div>
            </div>
            <div class="row pb-lg-5 mb-4 mb-sm-5">
                <div class="col-lg-6 col-md-8">
                     <div class="input-group input-group-lg flex-nowrap">
                    <!--    <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input class="form-control rounded-end" type="text" placeholder="<?= esc(lang('Web.start_search')) ?>"> <!-- Translate "Start your search" -->
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured products (Carousel)-->
<section class="container position-relative pt-3 pt-lg-0 pb-5 mt-lg-n10" style="z-index: 10;">
    <div class="card px-lg-2 border-0 shadow-sm">
        <div class="card-body px-4 pt-5 pb-4">
            
            <div class="d-flex justify-content-between border-bottom mb-3">
                <div class="text-left">
                    <h2 class="h3"><?= esc(lang('Web.featured_products')) ?></h2> <!-- Translate "Discover featured products" -->
                    <p class="text-muted"><?= esc(lang('Web.handpicked_items')) ?></p> <!-- Translate "Every week we hand-pick..." -->
                </div>
                <div>
                    <a href="<?= site_url('products/create-product') ?>" class="btn btn-primary m-1"><?= esc(lang('Web.add_new_product')) ?></a> <!-- Translate "Add New Product" -->
                    <a href="<?= site_url('products/my-products') ?>" class="btn btn-primary m-1">
                        <i class="bi bi-person"></i> <?= esc(lang('Web.my_products')) ?> <!-- Translate "My Products" -->
                    </a>
                </div>
            </div>

            <!-- Carousel-->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <!-- Dynamically generate carousel items -->
                    <div class="carousel-item active">
                        <div class="row">
                            <?php foreach ($sliderproducts as $key => $sliderproduct) : ?>
                                <div class="col-md-3">
                                    <img class="d-block w-100" src="<?= $sliderproduct['images'][0]['image']?>" alt="Image <?= $key?>" style="min-height:300px;max-height:300px;">
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <!-- Previous and Next controls -->
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only"><?= esc(lang('Web.previous')) ?></span> <!-- Translate "Previous" -->
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only"><?= esc(lang('Web.next')) ?></span> <!-- Translate "Next" -->
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Recent products grid-->
<section class="container pb-5 mb-lg-3">
    <!-- Heading-->
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 me-2"><?= esc(lang('Web.recent_products')) ?></h2> <!-- Translate "The Most Recent Products" -->
        <div class="pt-3">
            <form action="<?= site_url('products')?>" id="productform" method="get">
                <select class="form-select me-2" id="productcategory" name="category">
                    <option value=""><?= esc(lang('Web.select_category')) ?></option> <!-- Translate "Select Category" -->
                    <?php foreach (PRODUCT_CATEGORIES as $key => $product) : ?>
                        <option value="<?= $key ?>" <?= ($key==$category)? 'selected':'' ?>><?= $product ?></option>
                    <?php endforeach ?>
                </select>
            </form>
        </div>
    </div>

    <!-- Grid-->
    <div class="row pt-2 mx-n2">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-grid-gutter mt-2">
                    <div class="card product-card-alt">
                        <div class="product-thumb">
                            <!-- <button class="btn-wishlist btn-sm" type="button"><i class="bi bi-heart"></i></button> -->
                            <div class="product-card-actions">
                                <a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="<?= site_url('products/details/'.$product['id']) ?>"><i class="bi bi-eye"></i></a>
                                <!-- <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="bi bi-cart"></i></button> -->
                            </div>
                            <a class="product-thumb-overlay" href="<?= site_url('products/details/'.$product['id']) ?>"></a>
                            <img src="<?= $product['images'][0]['image'] ?>" alt="Product 1" style="min-height:300px;max-height:300px;">
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                <div class="text-muted fs-xs me-1">
                                    <?= esc(lang('Web.by')) ?> 
                                    <a class="product-meta fw-medium" href="<?= site_url($product['user_info']['username']) ?>">
                                        <?= $product['user_info']['first_name']." ".$product['user_info']['last_name'] ?>
                                    </a>
                                    <br> <?= esc(lang('Web.in')) ?> 
                                    <a class="product-meta fw-medium" href="#"><?= $product['category'] ?></a>
                                </div>
                            </div>
                            <h3 class="product-title fs-sm mb-2">
                                <a href="<?= site_url('products/details/'.$product['id']) ?>"><?= substr($product['product_name'], 0, 15) ?></a>
                            </h3>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-sm me-2"><i class="bi bi-cloud-download text-muted me-1"></i>109<span class="fs-xs ms-1"><?= esc(lang('Web.sales')) ?></span></div>
                                <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">$<?= $product['price'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <div class="row">
                <div class="col-md-12">
                    <?php if (!empty($category)) : ?>
                        <div class="alert alert-danger"><?= esc(lang('Web.no_products_category')) ?></div> <!-- Translate "No Products Found in this category" -->
                    <?php else : ?>
                        <div class="alert alert-danger"><?= esc(lang('Web.no_products')) ?></div> <!-- Translate "No Products Found" -->
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    $(document).ready(function() {
        $(".btn-outline-primary, .btn-outline-success").click(function() {
            var $this = $(this);
            if ($this.hasClass('btn-outline-primary')) {
                $this.toggleClass('btn-primary btn-outline-primary');
            } else if ($this.hasClass('btn-outline-success')) {
                $this.toggleClass('btn-success btn-outline-success');
            }
        });
        $('#productcategory').change(function() {
            $('#productform').submit(); // Submit the form
        });
    });
</script>

<?= $this->endSection() ?>
