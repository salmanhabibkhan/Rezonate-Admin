<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">


    <!-- 1st row starts from here -->
        <div class="row">

            <!-- 1st row 1st column -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= lang('Admin.auto_join');?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    
                    <form action="<?= base_url('admin/update-auto-join') ?>" method="post">
                            <div class="form-group">
                                <label for="user_links_limit"><?= lang('Admin.groups') ?></label>
                                <select name="groups[]" class="form-control" required  id="select2" multiple="multiple">
                                
                                <?php foreach($groups as $group):?>
                                    <option value="<?= $group['id'] ?>" 
                                  
                                        selected
                               
                                    ><?= $group['group_title']?></option>
                                <?php endforeach;?>
                                </select>
                            </div>
                            
                            <!-- <div class="alert alert-warning">This process might take some time, you can check for your site changes after few minutes.</div> -->


                            <button class="btn btn-danger" type="submit"> <?= lang('Admin.submit') ?></button>
                        </form>
                    </div>
                    </div>

                    
                </div>

            </div>


        </div>



    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>    
    	$(document).ready(function() {
            var path = site_url+"/admin/fetch-allgroups";
            $('#select2').select2({
                minimumInputLength: 1,
                scrollAfterSelect:true,

                 ajax: {
                     url: path,
                     dataType: 'json',
                     processResults: function (data) {
                         return {
                         results:  $.map(data, function (item) {
                                 return {
                                     text: item.group_title,
                                     id: item.id
                                 }
                             })
                         };
                     },
                     cache: true
                 }
            });
        });
</script>
<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>