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
                        <h3 class="card-title"><?= lang('Admin.auto_page_like') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?= lang('Admin.collapse') ?>">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    
                        <div class="alert alert-info"><?= lang('Admin.backup_recommendation') ?></div>

                        <form action="<?= base_url('admin/update-auto-like') ?>" method="post">
                            <div class="form-group">
                                <label for="user_links_limit"><?= lang('Admin.page_names') ?></label>
                                <select name="pages[]" class="form-control" required id="select2" multiple="multiple">
                                    <?php foreach($pages as $page): ?>
                                        <option value="<?= $page['id'] ?>" selected><?= $page['page_title'] ?></option>
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
            var path = site_url+"/admin/fetch-allpages";
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
                                     text: item.page_title,
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