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
                    <form action="<?= base_url('admin/posts/update/' . $post['id']) ?>" method="post" id="post_form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="post_text">Post Text</label>
                <input type="text" class="form-control" name="post_text" placeholder="Post Text" value="<?= $post['post_text'] ?>">
                <?php $validation = \Config\Services::validation(); ?>
                <?php echo !empty($validation->getError('post_text')) ? "<span class='text-danger'>" . $validation->getError('post_text') . "</span> " : ''; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user_id">Post User ID</label>
                <input type="text" class="form-control" name="user_id" placeholder="User ID" value="<?= $post['user_id'] ?>">
                <?php echo !empty($validation->getError('user_id')) ? "<span class='text-danger'>" . $validation->getError('user_id') . "</span> " : ''; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="privacy">Privacy</label>
                <input type="text" class="form-control" name="privacy" placeholder="Privacy" value="<?= $post['privacy'] ?>">
                <?php echo !empty($validation->getError('privacy')) ? "<span class='text-danger'>" . $validation->getError('privacy') . "</span> " : ''; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="feeling_type">Feeling Type</label>
                <input type="text" class="form-control" name="feeling_type" placeholder="Feeling Type" value="<?= $post['feeling_type'] ?>">
                <?php echo !empty($validation->getError('feeling_type')) ? "<span class='text-danger'>" . $validation->getError('feeling_type') . "</span> " : ''; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="feeling">Feeling</label>
                <input type="text" class="form-control" name="feeling" placeholder="Feeling" value="<?= $post['feeling'] ?>">
                <?php echo !empty($validation->getError('feeling')) ? "<span class='text-danger'>" . $validation->getError('feeling') . "</span> " : ''; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label for="">Post Cover</label>
            <input type="file" class="form-control" name="cover">
            <?php echo !empty($validation->getError('cover')) ? "<span class='text-danger'>" . $validation->getError('cover') . "</span> " : ''; ?>
        </div>
        <div class="col-md-6">
            <label for=""> Post Avatar</label>
            <input type="file" class="form-control" name="avatar">
            <?php echo !empty($validation->getError('avatar')) ? "<span class='text-danger'>" . $validation->getError('avatar') . "</span> " : ''; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label for=""> Post Description</label>
            <textarea name="post_link" id="" cols="30" rows="10" class="form-control"><?= $post['post_link']; ?></textarea>
            <?php echo !empty($validation->getError('post_link')) ? "<span class='text-danger'>" . $validation->getError('post_link') . "</span> " : ''; ?>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= base_url('admin/groups') ?>" class="btn btn-danger">Cancel</a>
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
        $("#post_form").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid',
            rules: {
                post_text: {
                    required: true
                },
                privacy: {
                    required: true
                },
                feeling_type: {
                    required: true
                },
                feeling: {
                    required: true
                },

            },

        });
    });
</script>


<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>