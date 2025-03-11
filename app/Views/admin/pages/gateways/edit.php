<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">


        <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        <form action="<?= base_url('admin/gateways/update/' . $gateways['id']) ?>" method="post" id="gateway_form" enctype="multipart/form-data">
                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Gateway Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Gateway Name" value="<?= $gateways['name'] ?>" required>
                                    <?php $validation = \Config\Services::validation(); ?>
                                    <?php echo !empty($validation->getError('name')) ? "<span class='text-danger'>" . $validation->getError('name') . "</span> " : ''; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currency">Currency</label>
                                    <input type="text" class="form-control" name="currency" placeholder="Currency" value="<?= $gateways['currency'] ?>" required>
                                    <?php echo !empty($validation->getError('currency')) ? "<span class='text-danger'>" . $validation->getError('currency') . "</span> " : ''; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rate">Rate</label>
                                    <input type="text" class="form-control" name="rate" placeholder="Rate" value="<?= $gateways['rate'] ?>" required>
                                    <?php echo !empty($validation->getError('rate')) ? "<span class='text-danger'>" . $validation->getError('rate') . "</span> " : ''; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="minimum_amount">Minimum Amount</label>
                                    <input type="text" class="form-control" name="minimum_amount" placeholder="Minimum Amount" value="<?= $gateways['minimum_amount'] ?>" required>
                                    <?php echo !empty($validation->getError('minimum_amount')) ? "<span class='text-danger'>" . $validation->getError('minimum_amount') . "</span> " : ''; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maximum_amount">Maximum Amount</label>
                                    <input type="text" class="form-control" name="maximum_amount" placeholder="Maximum Amount" value="<?= $gateways['maximum_amount'] ?>" required>
                                    <?php echo !empty($validation->getError('maximum_amount')) ? "<span class='text-danger'>" . $validation->getError('maximum_amount') . "</span> " : ''; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fix_charge">Fix Charge</label>
                                    <input type="text" class="form-control" name="fix_charge" placeholder="Fix Charge" value="<?= $gateways['fix_charge'] ?>" required>
                                    <?php echo !empty($validation->getError('fix_charge')) ? "<span class='text-danger'>" . $validation->getError('fix_charge') . "</span> " : ''; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control" name="logo" placeholder="Logo" >
                                    <?php echo !empty($validation->getError('logo')) ? "<span class='text-danger'>" . $validation->getError('logo') . "</span> " : ''; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?= base_url('admin/gateways') ?>" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>



    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $(document).ready(function() {
        $("#gateway_form").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid',
            rules: {
                name: {
                    required: true
                },
                currency: {
                    required: true
                },
                rate: {
                    required: true,
                    number: true
                },
                minimum_amount: {
                    required: true,
                    number: true
                },
                maximum_amount: {
                    required: true,
                    number: true
                },
                fix_charge: {
                    required: true,
                    number: true
                }
            },
            messages: {
                name: {
                    required: "Please enter the gateway name"
                },
                currency: {
                    required: "Please enter the currency"
                },
                rate: {
                    required: "Please enter the rate",
                    number: "Please enter a valid number"
                },
                minimum_amount: {
                    required: "Please enter the minimum amount",
                    number: "Please enter a valid number"
                },
                maximum_amount: {
                    required: "Please enter the maximum amount",
                    number: "Please enter a valid number"
                },
                fix_charge: {
                    required: "Please enter the fix charge",
                    number: "Please enter a valid number"
                }
                // Add messages for other fields
            }
        });
    });
</script>


<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>