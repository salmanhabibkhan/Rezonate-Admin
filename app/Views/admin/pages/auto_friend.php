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
                        <h3 class="card-title"><?= lang('Admin.auto_friend') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?= lang('Admin.collapse') ?>">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    
                        <!-- <div class="alert alert-info"><?= lang('Admin.backup_recommendation') ?></div> -->
                        <form action="<?= base_url('admin/update-auto-friend') ?>" method="post">
                            <div class="form-group">
                                <label for="user_links_limit"><?= lang('Admin.usernames') ?></label>
                                <select name="users[]" class="form-control" required id="select2" multiple="multiple">
                                    <?php foreach($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" selected><?= $user['username'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button class="btn btn-danger" type="submit"><?= lang('Admin.submit') ?></button>
                        </form>
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
            var path = site_url+"/admin/fetch-alluser";
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
                                     text: item.first_name+' '+item.last_name+' ('+item.username+')',
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