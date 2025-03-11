<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <!-- 1st row starts from here -->
        <div class="row">

            <div class="col-md-12">
           
                <div class="card card-primary">
                    <div class="card-body">
                        <form id="edit_event_form" action="<?= base_url('admin/events/update/'.$event['id']) ?>" enctype="multipart/form-data" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name"><?= lang('Admin.event_name') ?></label>
                                    <input type="text" class="form-control" name="name" placeholder="<?= lang('Admin.event_name') ?>" value="<?= $event['name']; ?>">
                                    <?php $validation = \Config\Services::validation();
                                    echo !empty($validation->getError('name')) ? "<span class='text-danger'>" . $validation->getError('name') . "</span> " : '';
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="description"><?= lang('Admin.event_description') ?></label>
                                    <textarea name="description" class="form-control" rows="1" placeholder="<?= lang('Admin.event_description') ?>"><?= $event['description']; ?></textarea>
                                    <?php
                                    echo !empty($validation->getError('description')) ? "<span class='text-danger'>" . $validation->getError('description') . "</span> " : '';
                                    ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="location"><?= lang('Admin.location') ?></label>
                                    <input type="text" class="form-control" name="location" placeholder="<?= lang('Admin.location') ?>" value="<?= $event['location']; ?>">
                                    <?php
                                    echo !empty($validation->getError('location')) ? "<span class='text-danger'>" . $validation->getError('location') . "</span> " : '';
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="url"><?= lang('Admin.url') ?></label>
                                    <input type="text" class="form-control" name="url" placeholder="<?= lang('Admin.url') ?>" value="<?= $event['url']; ?>">
                                    <?php
                                    echo !empty($validation->getError('url')) ? "<span class='text-danger'>" . $validation->getError('url') . "</span> " : '';
                                    ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="start_date"><?= lang('Admin.start_date') ?></label>
                                    <input type="date" class="form-control" name="start_date" placeholder="<?= lang('Admin.start_date') ?>" value="<?= $event['start_date']; ?>">
                                    <?php
                                    echo !empty($validation->getError('start_date')) ? "<span class='text-danger'>" . $validation->getError('start_date') . "</span> " : '';
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="start_time"><?= lang('Admin.start_time') ?></label>
                                    <input type="time" class="form-control" name="start_time" placeholder="<?= lang('Admin.start_time') ?>" value="<?= $event['start_time']; ?>">
                                    <?php
                                    echo !empty($validation->getError('start_time')) ? "<span class='text-danger'>" . $validation->getError('start_time') . "</span> " : '';
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="end_date"><?= lang('Admin.end_date') ?></label>
                                    <input type="date" class="form-control" name="end_date" placeholder="<?= lang('Admin.end_date') ?>" value="<?= $event['end_date']; ?>">
                                    <?php
                                    echo !empty($validation->getError('end_date')) ? "<span class='text-danger'>" . $validation->getError('end_date') . "</span> " : '';
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_time"><?= lang('Admin.end_time') ?></label>
                                    <input type="time" class="form-control" name="end_time" placeholder="<?= lang('Admin.end_time') ?>" value="<?= $event['end_time']; ?>">
                                    <?php
                                    echo !empty($validation->getError('end_time')) ? "<span class='text-danger'>" . $validation->getError('end_time') . "</span> " : '';
                                    ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.update') ?></button>
                                    <a href="<?= base_url('admin/events') ?>" class="btn btn-danger"><?= lang('Admin.cancel') ?></a>
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


<!-- Include jQuery Validation Plugin -->

<script  >
$(document).ready(function () {
        $("#edit_event_form").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid ',
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 6
                },
                like_amount: {
                    required: true
                },
                share_amount: {
                    required: true,
                    min: 0
                },
                comment_amount: {
                    required: true,
                    min: 0
                },
                po_comment_amount: {
                    required: true,
                    min: 0
                },
                po_share_amount: {
                    required: true,
                    min: 0
                },
                po_like_amount: {
                    required: true,
                    min: 0
                },
            },
            // Add any additional settings or callbacks if needed
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>