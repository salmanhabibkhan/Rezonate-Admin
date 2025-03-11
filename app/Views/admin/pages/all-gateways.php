<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">


    
        <div class="row">

            <div class="col-md-12">
           
                <div class=" card card-primary table-card">
                    <!-- <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div> -->
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered admin-side-tables table-striped">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                               <h1 class="table_title"><?= $page_title ?></h1>
                                <a href="<?= base_url('admin/gateways/create')?>" class="btn btn-success btn-sm mb-3 float-right "> <i class="fa fa-plus mr-2 text-light"></i> Create New Gateways</a>
                                
                               </div>
                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Currency</th>
                                        <th>rate</th>
                                        <th>Minimum Amount</th>
                                        <th>Maximum Amount</th>
                                        <th>Fix Charge</th>
                                        <th>Percentage Charge</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($gateways as $key=> $gateway): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $gateway['name'] ?></td>
                                        <td><?= $gateway['currency'] ?></td>
                                        <td><?= $gateway['rate'] ?></td>
                                        <td><?= $gateway['minimum_amount'] ?></td>
                                        <td><?= $gateway['maximum_amount'] ?></td>
                                        <td><?= $gateway['fix_charge'] ?></td>
                                        <td><?= $gateway['percentage_charge'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/gateways/edit/'.$gateway['id'])?>"><button class="btn btn-sm btn-primary btn-wave">
                                                        <i class="fa fa-pen mr-2 text-light"></i>
                                                        Edit
                                                    </button></a>
                                            <a href="<?= base_url('admin/gateways/delete/'.$gateway['id'])?>" onclick="return confirm('Are You Sure')"><button class="btn btn-sm btn-danger btn-wave">
                                                        <i class="fa fa-trash mr-2 text-light"></i>
                                                        Delete
                                                    </button></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>