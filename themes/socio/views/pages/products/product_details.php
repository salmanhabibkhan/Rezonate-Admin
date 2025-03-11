<!-- app/Views/pages/blog/blog_detail.php -->

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-3 mt-1">
    <div class="col-lg-8">
        <div class="bg-mode p-4">
            <?php if ($product): ?>
                <div class="card bg-transparent border-0">
                    <?php if (count($product['images']) > 0) : ?>
                        <div class="row">
                            <?php foreach ($product['images'] as $image) : ?>
                                <div class="col-2"><img src="<?= $image['image'] ?>" alt="<?= $product['product_name'] ?>"></div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ; ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <!-- Product name -->
                            <h3><?= $product['product_name'] ?></h3>
                            <div class="row">
                                <div class="col-3">
                                    <a href="#" class="badge bg-danger bg-opacity-10 text-danger mb-2 fw-bold float-left"><?= $product['category'] ?></a>
                                </div>
                                <div class="col-2">
                                    <div class="rounded-1 py-1 px-2 float-left badge bg-light text-dark">$ <?= $product['price'] ?></div>
                                </div>
                               <?php if($product['user_id']!=getCurrentUser()['id']):?>
                                <div class="col-7">
                                    <button href="#!" class="btn btn-primary float-end toast-btn" data-target="chatToast" data-id="<?= $product['user_info']['id'] ?>" type="button"> 
                                        <i class="bi bi-person"></i> <?= esc(lang('Web.contact_seller')) ?> <!-- Translate "Contact Seller" -->
                                    </button>
                                </div>
                                <?php else:?>
                                <div class="col-md-4 offset-md-3">
                                   
                              
                                   
                                    <a href="<?=site_url('products/edit/'.$product['id'])?>" class="btn btn-primary  toast-btn" > 
                                        <i class="bi bi-pencil"></i> <?= esc(lang('Web.edit')) ?>
                                    </a>
                                    <a  class="btn btn-danger  delete_product" data-product_id="<?= $product['id']?>"> 
                                        <i class="bi bi-trash"></i> <?= esc(lang('Web.delete')) ?>
                                    </a>
                                </div>
                                <?php endif ;?>
                            </div>
                            <p class="small text-secondary">
                                <i class="bi bi-calendar-date pe-1"></i><?= date('M d, Y', strtotime($product['created_at'])) ?>
                            </p>
                            <p><?= $product['product_description'] ?></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p><?= esc(lang('Web.product_not_found')) ?></p> <!-- Translate "Product not found" -->
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
$(document).on("click", '.delete_product', function () {

    var that = $(this);
    var product_id = that.data('product_id');
    Swal.fire({
        title: "<?= lang('Web.delete_product_confirm') ?>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonText: "<?= lang('Web.no') ?>",
        cancelButtonColor: "#d33",
        confirmButtonText: "<?= lang('Web.yes') ?>"
    }).then((result) => {
        if (result.isConfirmed) {
            that.html("Sending request");
            $.ajax({
                type: "post",
                url: site_url + "web_api/delete-product",
                dataType: "json",
                data: {
                    product_id: product_id,
                },
                success: function (response) {
                    console.log(response);
                  let timerInterval;
                            Swal.fire({
                                icon: 'success',
                                html: response.message,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                        timer.textContent =
                                            `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                },
                                didClose: () => {
                                    Swal.update({
                                        html: '<i class="fas fa-check-circle"></i> Success!',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        showCloseButton: false,
                                    });
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                            });
                            setTimeout(() => {
                                window.location = "<?= site_url('products/my-products') ?>";
                            }, 4000);
                },
                error: function () {
                    that.html("Send Request");
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
