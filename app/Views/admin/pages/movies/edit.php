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
                        <form action="<?= base_url('admin/movies/update/' . $movie['id']) ?>" method="post" enctype="multipart/form-data" id="update_movie">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="movie_name"><?= lang('Admin.movie_name'); ?></label>
                                        <input type="text" class="form-control" name="movie_name" placeholder="<?= lang('Admin.movie_name'); ?>" value="<?= $movie['movie_name']; ?>">
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?= !empty($validation->getError('movie_name')) ? "<span class='text-danger'>" . $validation->getError('movie_name') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genre"><?= lang('Admin.genre'); ?></label>
                                        <select name="genre" class="form-control">
                                            <option value=""><?= lang('Admin.select_movie_genre'); ?></option>
                                            <?php foreach (MOVIE_GENRES as $value) : ?>
                                                <option value="<?= $value ?>" <?= $movie['genre'] == $value ? "selected" : ""; ?>> <?= $value ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= !empty($validation->getError('genre')) ? "<span class='text-danger'>" . $validation->getError('genre') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stars"><?= lang('Admin.stars'); ?></label>
                                        <input type="text" class="form-control" name="stars" placeholder="<?= lang('Admin.stars'); ?>" value="<?= $movie['stars']; ?>">
                                        <?= !empty($validation->getError('stars')) ? "<span class='text-danger'>" . $validation->getError('stars') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="producer"><?= lang('Admin.producer'); ?></label>
                                        <input type="text" class="form-control" name="producer" placeholder="<?= lang('Admin.producer'); ?>" value="<?= $movie['producer']; ?>">
                                        <?= !empty($validation->getError('producer')) ? "<span class='text-danger'>" . $validation->getError('producer') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cover"><?= lang('Admin.movie_thumbnail'); ?></label>
                                        <input type="file" class="form-control" name="cover_pic" placeholder="<?= lang('Admin.movie_thumbnail'); ?>" value="<?= old('cover_pic') ?>">
                                        <?= !empty($validation->getError('cover_pic')) ? "<span class='text-danger'>" . $validation->getError('cover_pic') . "</span> " : ''; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="source"><?= lang('Admin.video'); ?></label>
                                        <input type="file" class="form-control" name="video" placeholder="<?= lang('Admin.video'); ?>" value="<?= old('video') ?>">
                                        <?= !empty($validation->getError('video')) ? "<span class='text-danger'>" . $validation->getError('video') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="duration"><?= lang('Admin.duration'); ?></label>
                                        <input type="text" class="form-control" name="duration" placeholder="<?= lang('Admin.duration'); ?>" value="<?= $movie['duration']; ?>">
                                        <?= !empty($validation->getError('duration')) ? "<span class='text-danger'>" . $validation->getError('duration') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="release_year"><?= lang('Admin.release_year'); ?></label>
                                        <input type="text" class="form-control" name="release_year" placeholder="<?= lang('Admin.release_year'); ?>" value="<?= $movie['release_year']; ?>">
                                        <?= !empty($validation->getError('release_year')) ? "<span class='text-danger'>" . $validation->getError('release_year') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rating"><?= lang('Admin.rating'); ?></label>
                                        <input type="text" class="form-control" name="rating" placeholder="<?= lang('Admin.rating'); ?>" value="<?= $movie['rating']; ?>">
                                        <?= !empty($validation->getError('rating')) ? "<span class='text-danger'>" . $validation->getError('rating') . "</span> " : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="source"><?= lang('Admin.source'); ?></label>
                                        <input type="text" class="form-control" name="source" placeholder="<?= lang('Admin.source'); ?>" value="<?= $movie['source']; ?>">
                                        <?= !empty($validation->getError('source')) ? "<span class='text-danger'>" . $validation->getError('source') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description"><?= lang('Admin.description'); ?></label>
                                        <textarea name="description" id="description" rows="2" class="form-control"><?= $movie['description'] ?></textarea>
                                        <?= !empty($validation->getError('description')) ? "<span class='text-danger'>" . $validation->getError('description') . "</span> " : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><?= lang('Admin.submit'); ?></button>
                                    <a href="<?= base_url('admin/movies') ?>" class="btn btn-danger"><?= lang('Admin.cancel'); ?></a>
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
        $("#update_movie").validate({
            ignore: ':hidden:not(:checkbox)',
            errorElement: 'label',
            errorClass: 'is-invalid text-danger',
            validClass: 'is-valid',
            rules: {
                movie_name: {
                    required: true
                },
                genre: {
                    required: true
                },
                stars: {
                    required: true
                },
                producer: {
                    required: true
                },
                duration: {
                    required: true
                },
                description: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                movie_name: {
                    required: "<?= lang('Admin.validation_movie_name_required'); ?>"
                },
                genre: {
                    required: "<?= lang('Admin.validation_genre_required'); ?>"
                },
                stars: {
                    required: "<?= lang('Admin.validation_stars_required'); ?>"
                },
                producer: {
                    required: "<?= lang('Admin.validation_producer_required'); ?>"
                },
                duration: {
                    required: "<?= lang('Admin.validation_duration_required'); ?>"
                },
                description: {
                    required: "<?= lang('Admin.validation_description_required'); ?>",
                    minlength: "<?= lang('Admin.validation_description_minlength'); ?>"
                }
            }
        });
    });
</script>

<?= $this->include('admin/script') ?>
<?= $this->endSection() ?>
