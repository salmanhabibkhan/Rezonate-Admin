<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>

<form action="<?=base_url('verifypurchasecode')?>" method="post">
    <div class="row mb-3 mt-3">
        <div class="col-md-6 offset-md-3">
            <h3 class="fw-bold">Verify your purchase code </h3>
            <div class="form-group my-3">
                <label for="">Domain Name </label>
                <input type="text" readonly name="domain_name" class="form-control" placeholder="Domain name " value="<?= base_url() ?>" >
            </div>
            <div class="form-group my-3">
                <label for="">Email </label>
                <input type="email"  name="email" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="form-group my-3">
                <label for="">Purchase Code  </label>
                <input type="text" name="purchasecode" class="form-control" placeholder=" Purchase Code " required>
            </div>
            <div class="form-group my-3">
                <button type="submit" class="btn btn-success">Verify Code</button>
            </div>
        </div>
    </div>
</form>



<?= $this->endSection() ?>

