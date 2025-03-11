<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">


    <!-- 1st row starts from here -->
        <div class="row">

            <!-- 1st row 1st column -->
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add New Movie</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                    <div class="row">
							<div class="col-md-4">
								<div class="d-flex align-items-center add-admn-movie" id="select-f-cover">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4,4H7L9,2H15L17,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4M12,7A5,5 0 0,0 7,12A5,5 0 0,0 12,17A5,5 0 0,0 17,12A5,5 0 0,0 12,7M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9Z"></path></svg>
									Select								</div>
								<small class="admin-info">Movie thumbnail, required size: 400x570.</small>
							</div>
							<div class="col-md-8">
								<div class="form-group form-float">
									<div class="form-line">
										<label class="form-label">Movie Title</label>
										<input type="text" id="name" name="name" class="form-control">
										<small class="admin-info">Choose a title for the movie, max 23 characters allowed.</small>
									</div>
								</div>
								<div class="form-group form-float">
									<div class="form-line">
										<label class="form-label">Description</label>
										<textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
										<small class="admin-info">Choose a description for the movie, min 23 characters allowed.</small>
									</div>
								</div>
							</div>
						</div>
                    
                        <!-- <div class="form-group">
                            <label for="user_links_limit">Game URL</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Game Image URL</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div>

                        <div class="form-group">
                            <label for="user_links_limit">Game Name</label>
                            <input type="text" id="user_links_limit" class="form-control" value="10277277272727">
                        </div> -->

                        <div class="form-group form-float">
                            <div class="form-line">
                            	<label class="form-label">Movie Source</label>
                                <input type="text" id="embed_source" name="iframe" class="form-control" onchange="Wo_ToggleMoviewsSource(this)">
                                <small class="admin-info">Import a movie from other sites, Example: (youtube.com, vimeo.com, site.com/video.mp4)</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center">
                            <hr class="d-block w-25  ">
                            <h4 class="text-center">OR</h4>
                            <hr class="w-25">
                        </div>
                      
                        <div class="form-group form-float">
                            <div class="form-line">
                            	<label class="form-label">Stars</label>
                                <textarea name="stars" id="stars" class="form-control" cols="30" rows="3"></textarea>
                                <small class="admin-info"><small>Set movie stars, separated by comma(,).</small></small>
                            </div>
                        </div>
                      

                        <div class="form-group form-float">
                            <div class="form-line">
								<div class="btn-file d-flex align-items-center">
									<input type="file" id="film" accept="video/*" name="source" value="C:\fakepath\source" class="hidden">
									<div class="mr-2 change-file-ico">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16.5,6V17.5A4,4 0 0,1 12.5,21.5A4,4 0 0,1 8.5,17.5V5A2.5,2.5 0 0,1 11,2.5A2.5,2.5 0 0,1 13.5,5V15.5A1,1 0 0,1 12.5,16.5A1,1 0 0,1 11.5,15.5V6H10V15.5A2.5,2.5 0 0,0 12.5,18A2.5,2.5 0 0,0 15,15.5V5A4,4 0 0,0 11,1A4,4 0 0,0 7,5V17.5A5.5,5.5 0 0,0 12.5,23A5.5,5.5 0 0,0 18,17.5V6H16.5Z"></path></svg>
									</div>
									<div class="full-width">
										<b id="movie-name">Upload Movie File</b>
										<small class="admin-info">MP4 only allowed.</small>
									</div>
								</div>
                            </div>
                        </div>



                        <div class="row">
							<div class="col-md-6">
								<div class="form-group form-float">
									<div class="form-line">
										<label class="form-label">Release</label>
										<input type="number" id="release" name="release" class="form-control" min="1960" max="2023">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-float">
									<div class="form-line">
										<label class="form-label">Duration</label>
										<input type="number" id="duration" name="duration" class="form-control" min="10" max="350">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<label for="country">Country</label>
								<select class="form-control show-tick" id="country" name="country">
																	<option value="united-states">United States</option>
																	<option value="china">China</option>
																	<option value="india">India</option>
																	<option value="iran">Iiran</option>
																	<option value="japan">japan</option>
																	<option value="turkey">Turkey</option>
																	<option value="russia">Russia</option>
																	<option value="france">France</option>
																	<option value="united-kingdom">United Kingdom</option>
																</select>
							</div>

							<div class="col-md-6">
								<label for="quanlity">Quality</label>
								<select class="form-control show-tick" id="quanlity" name="quanlity">
									<option value="cam">CAMRip</option>
									<option value="ts">TS</option>
									<option value="vsh">VHSRip</option>
									<option value="wp">WP</option>
									<option value="scr">SCR (VHSScr)</option>
									<option value="dvds">DVDScr</option>
									<option value="ts">TC</option>
									<option value="ldr">LDRip</option>
									<option value="tv">TVRip</option>
									<option value="sat">SATRip</option>
									<option value="dvb">DVBRip</option>
									<option value="dtv">DTVRip</option>
									<option value="dvd">DVD</option>
									<option value="hdr">HDRip</option>
									<option value="web-dl">WEB-DL</option>
									<option value="hd-tv">HD-TV</option>
									<option value="hd">HD DVD</option>
								</select>
							</div>
							<div class="col-md-6">
								<label for="genre">Genre</label>
								<select class="form-control show-tick" id="genre" name="genre">
																	<option value="action">Action</option>
																	<option value="comedy">Comedy</option>
																	<option value="drama">Drama</option>
																	<option value="horror">Horror</option>
																	<option value="mythological">Mythological</option>
																	<option value="war">War</option>
																	<option value="adventure">Adventure</option>
																	<option value="family">Family</option>
																	<option value="sport">Sport</option>
																	<option value="animation">Animation</option>
																	<option value="crime">Crime</option>
																	<option value="fantasy">Fantasy</option>
																	<option value="musical">Musical</option>
																	<option value="romance">Romance</option>
																	<option value="thriller">Thriller</option>
																	<option value="history">History</option>
																	<option value="documentary">Documentary</option>
																	<option value="tvshow">TV Show</option>
																</select>
							</div>
							<div class="col-md-6">
								<div class="form-group form-float">
									<div class="form-line">
										<label class="form-label">Rating</label>
										<input type="number" id="rating" name="rating" class="form-control" min="1" max="10" step="0.1">
										<small class="admin-info">Movie rating, set a number from 1 to 10.</small>
									</div>
								</div>
							</div>
						</div>


                        <button class="btn btn-danger"> Submit</button>
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