<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <!-- Here begins the magical journey of your story creation! -->
    <div class="col-md-8 col-lg-6 vstack gap-4">

        <div class="card">
            <div class="card-body">
                <?php if (count($stories) > 0) : ?>
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">
                                <i class="bi bi-plus-circle-fill"></i> <?= lang('Web.add_new_story') ?>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">
                                <i class="bi bi-book-fill"></i> <?= lang('Web.my_stories') ?>
                            </button>
                        </li>
                    </ul>
                <?php endif; ?>
                <div class="tab-content mt-3" id="myTabsContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <form method="post" enctype="multipart/form-data" id="createStory">
                            <h3><?= lang('Web.add_new_story') ?></h3>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="media"><?= lang('Web.choose_your_media') ?></label>
                                    <input type="file" name="media" id="media" class="form-control" onchange="validateUpload()">
                                    <input type="hidden" id="type" value="text" name="type">
                                    <input type="hidden" id="duration" value="10" name="duration">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="description"><?= lang('Web.story_caption') ?></label>
                                    <textarea name="description" id="description" rows="10" class="form-control" placeholder="<?= lang('Web.story_caption') ?>"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-info" id="add-story-btn">
                                        <i class="bi bi-plus-circle"></i> <?= lang('Web.add_story_button') ?>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <?php if (count($stories) > 0) : ?>
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th><?= lang('Web.sr') ?></th>
                                        <th><?= lang('Web.media') ?></th>
                                        <th><?= lang('Web.caption') ?></th>
                                        <th><?= lang('Web.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stories as $key => $story) : ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td> <a href="<?= getMedia($story['media']) ?>">
                                                    <img src="<?= ($story['type'] == 'image') ?  getMedia($story['media']) :  getMedia('uploads/placeholder/video-thumbnail.png') ?>" alt="sds" style="width: 50px;height:50px;">
                                                </a></td>
                                            <td> <span class="mt-2"><?= $story['description'] ?></span> </td>
                                            <td> <a href="#" class="btn btn-danger btn-xs mt-2 deletestory" data-story_id="<?= $story['id'] ?>"> <i class="bi bi-trash "></i> <?= lang('Web.delete_story') ?></a> </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <!-- Main content END -->
</div>

<script src="<?= base_url('public'); ?>/assets/js/jquery.validate.min.js"></script>
<script>
    function validateUpload() {
        var file = $('#media')[0].files[0];
        if (file == " " || file == null) {
            $('#type').val('text');
        }
        var fileType = file.type.split('/')[0];

        if (fileType === 'image') {
            // It's an image! Nothing more to check.
            $('#type').val('image');
            $('#duration').val(10);

        } else if (fileType === 'video') {
            // It's a video! Check the duration.
            var video = document.createElement('video');
            var url = URL.createObjectURL(file);

            video.preload = 'metadata';
            video.onloadedmetadata = function() {
                var duration = video.duration;

                if (video.duration <= 30) {
                    $('#type').val('video');
                    $('#duration').val(parseInt(video.duration));
                } else {
                    // Video duration exceeds 30 seconds.
                    alert("<?= lang('Web.video_too_long') ?>");
                    $('#media').val('');
                    $('#duration').val('');
                }
                URL.revokeObjectURL(url);
            };

            video.src = url;
        } else {
            // It's neither an image nor a video.
            Swal.fire({
                title: "<?= lang('Web.invalid_upload') ?>",
                icon: "error",
                html: "<?= lang('Web.select_image_or_video') ?>",
                timer: 4000,
                timerProgressBar: true,
            });
            $('#media').val('');
        }
    }
    $(document).ready(function() {
        var form = $('#createStory');
        form.validate({
            rules: {
                media: {
                    required: true
                },
            },
            messages: {
                media: {
                    required: "<?= lang('Web.media_required') ?>"
                },
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).closest('.form-control').removeClass('is-invalid');
            },
           
            submitHandler: function(form) {
                var formData = new FormData(form);

                // Append avatar and cover files to FormData
                formData.append('media', $('#media')[0].files[0]);

                $.ajax({
                    type: 'POST',
                    url: site_url + 'web_api/story/create', // Adjust this to your controller's path
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle success
                        alert(response.message);
                        setTimeout(() => {
                            window.location.href = site_url;
                        }, 3000);
                    },
                    error: function() {
                        // Handle error
                        alert("<?= lang('Web.error_adding_story') ?>");
                    }
                });
            }
        });
    });
    $(document).on('click', ".deletestory", function() {
    var that = $(this);
        var story_id = that.data('story_id');
        let confirmation = confirm('<?= lang('Web.are_you_sure_delete_story') ?>');
        if (confirmation == true) {
            $.ajax({
                type: "post",
                url: site_url + "web_api/story/delete-story",
                dataType: "json",
                data: {
                    story_id: story_id
                },
                success: function(response) {
                    alert(response.message)
                    window.location = site_url + "create-story";

                },
                error: function() {
                    that.html('<i class="bi bi-person-plus-fill pe-1"></i> <?= lang('Web.error_deleting_story') ?>');
                }
            });
        }

    });
</script>

<?= $this->endSection() ?>
