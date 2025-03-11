<!DOCTYPE html>
<html lang="en" >
<script>
        // Check if the local storage variable 'theme' has the value 'dark'
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            } else {
                document.documentElement.removeAttribute('data-bs-theme');
            }
        })();
    </script>
<!-- <html lang="en" data-bs-theme="dark"> -->

<head>
	<?php
	$title = '';
	if (isset($title) && !empty($title)) {
		$title =  $title . '-' . get_setting('site_name') . get_setting('site_title');
	} else {
		$title =  get_setting('site_name') . get_setting('site_title');
	}
	?>

	<title><?= $title ?></title>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="<?= get_setting('site_name'); ?>">
	<meta name="description" content="<?= get_setting('site_description'); ?>">
	<meta property="og:title" content="<?= $title ?>">
	<!-- Facebook Meta Tags -->
	<meta property="og:url" content="<?= current_url(); ?>">
	<meta property="og:type" content="website">

	<meta property="og:description" content="<?= get_setting('site_description'); ?>">
	<meta property="og:image" content="<?= getMedia(get_setting('site_logo')) ?>">

	
	<script>
		var site_url = '<?= site_url(); ?>'
		</script>


<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="<?= getMedia(get_setting('favicon')) ?>">
<script src="<?= base_url('js_language.js') ?>"></script>

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="<?= load_asset(); ?>vendor/font-awesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?= load_asset(); ?>vendor/bootstrap-icons/bootstrap-icons.css">


	<?php if (isset($css_files)) {
		foreach ($css_files as $file) { ?>
			<link href="<?= load_asset() . $file; ?> " rel="stylesheet" type="text/css">
	<?php }
	} ?>

	<link rel="stylesheet" href="<?= base_url('public'); ?>/toastr/css/toastr.min.css">
	<link rel="stylesheet" href="<?= base_url('public'); ?>/plugins/sweetalert2/sweetalert2.min.css">


	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="<?= load_asset(); ?>css/style.css">
	<script src="<?= base_url('public'); ?>/assets/js/jquery-3.7.1.min.js"></script>
	

</head>

<body>

	<!-- ======================= Header START -->
	<header class="navbar-light fixed-top header-static bg-mode">

		<!-- Logo Nav START -->
		<nav class="navbar navbar-expand-lg">
			<div class="container">
				<!-- Logo START -->
				<a class="navbar-brand w-25" href="<?= site_url(); ?>">

					<?php
					$site_logo = get_setting('site_logo');

					if (!empty($site_logo)) {
						$site_logo = getMedia($site_logo);
					} else {
						$site_logo = load_asset() . 'images/logo.png';
					}
					?>
					<img class="light-mode-item navbar-brand-item" src="<?= $site_logo ?>" alt="logo">
					<img class="dark-mode-item navbar-brand-item" src="<?= $site_logo ?>" alt="logo">
				</a>
				<!-- Logo END -->


				<?php
					if($user_data['id'] != 0){ ?>
					<div>
						<!-- Responsive navbar toggler -->
						<button class="navbar-toggler ms-auto icon-md btn btn-light p-0 collapsed" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSideNavbar" aria-controls="offcanvasSideNavbar" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-animation">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</button>

						<button class="navbar-toggler ms-auto icon-md btn btn-light p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
							<i class="bi bi-gear  fs-4"></i>
						</button>
					</div>
					<!-- Main navbar START -->
					<div class="ms-5 collapse navbar-collapse d-lg-flex w-100">



						</ul>
						<!-- Nav items END -->

						<!-- Nav Search START -->
						<div class="nav mt-3 mt-lg-0 px-4 px-lg-0 flex-fill">
							<div class="nav-item w-100">
								<form method="get" action="<?= site_url('search'); ?>" class="rounded position-relative">
									<input class="form-control ps-5 bg-light" name="term" type="search" placeholder="<?= lang('Web.search_placeholder') ?>" value="<?= $_GET['term'] ?? ''; ?>" aria-label="Search">

									<button class="btn bg-transparent px-2 py-0 position-absolute top-50 start-0 translate-middle-y" type="submit"><i class="bi bi-search fs-5"> </i></button>
								</form>
							</div>
						</div>
						<!-- Nav Search END -->
					</div>
					<!-- Main navbar END -->
					<div class="ms-5 collapse navbar-collapse d-lg-flex" id="navbarCollapse">
						<!-- Nav right START -->
						<ul class="nav flex-nowrap align-items-center ms-sm-3 list-unstyled">


							<?php if ($user_data['role'] == 2) { ?>
								<li class="nav-item">
									<a class="nav-link" href="<?= site_url('admin/dashboard'); ?>" title="Admin Panel">
										<span class="s-6"></span>
									</a>
								</li>
							<?php } ?>
							<li class="nav-item ms-3">
								<a class="nav-link  icon-md btn btn-light p-0 open_chat_button" data-bs-toggle="offcanvas" href="#offcanvasChat" role="button" aria-controls="offcanvasChat">
									<i class="bi bi-chat-square-dots  fs-4"></i>
								</a>
							</li>

							<li class="nav-item ms-3">
								<a class="nav-link  icon-md btn btn-light p-0" href="<?= site_url('settings/general-settings'); ?>">
									<i class="bi bi-gear  fs-4"></i>
								</a>
							</li>
							<li class="nav-item dropdown ms-2">
								<a class="nav-link  icon-md btn btn-light p-0 notification_dropdown" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
									<span class="badge-notif animation-blink"></span>
									<i class="bi bi-bell fs-4"> </i>
								</a>
								<div class="dropdown-menu dropdown-animation dropdown-menu-end dropdown-menu-size-md p-0 shadow-lg border-0" aria-labelledby="notifDropdown">
									<div class="card shadow h-100">
										<div class="card-header d-flex justify-content-between align-items-center px-3 py-2">
											<h6 class="m-0"><i class="bi bi-bell"> </i> <?= lang('Web.notifications') ?> </h6>
											<a class="small clear_all_noti" href="#"><?= lang('Web.mark_all_read') ?></a>
										</div>
										<div class="card-body p-0">
											<ul class="list-group noti_list_ul list-group-flush list-unstyled p-2">

											</ul>
										</div>
										<div class="card-footer text-center py-2">
											<a href="<?= site_url('notifications'); ?>" class="btn btn-sm btn-primary-soft"><?= lang('Web.see_all') ?></a>
										</div>
									</div>
								</div>

							</li>
							<!-- Notification dropdown END -->

							<li class="nav-item ms-3 dropdown">
								<a class="nav-link btn icon-md p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
									<img class="avatar-img rounded-2 user_avatar" src="<?= $user_data['avatar'] ?>" alt="">
								</a>
								<ul class="dropdown-menu dropdown-animation dropdown-menu-end pt-3 small me-md-n3" aria-labelledby="profileDropdown">
    <!-- Profile info -->
								<li class="px-3">
									<div class="d-flex align-items-center position-relative">
										<!-- Avatar -->
										<div class="avatar me-3">
											<img class="avatar-img rounded-circle" src="<?= $user_data['avatar'] ?>" alt="avatar">
										</div>
										<div>
											<a class="h6 stretched-link" href="<?= site_url($user_data['username']) ?>"><?= $user_data['first_name'] . ' ' . $user_data['last_name']; ?></a>
											<p class="small m-0">@<?= $user_data['username'] ?></p>
										</div>
									</div>
									<a class="dropdown-item btn btn-primary-soft btn-sm my-2 text-center" href="<?= site_url($user_data['username']) ?>"><?= lang('Web.view_profile') ?></a>
								</li>
								<!-- Links -->
								<?php if ($user_data['role'] == 2) : ?>
									<li><a class="dropdown-item" href="<?= site_url('admin/dashboard'); ?>"><i class="bi bi-gear fa-fw me-2"></i><?= lang('Web.admin_panel') ?></a></li>
								<?php endif; ?>
								<li><a class="dropdown-item" href="<?= site_url('settings/general-settings'); ?>"><i class="bi bi-gear fa-fw me-2"></i><?= lang('Web.settings_privacy') ?></a></li>
								<li><a class="dropdown-item" href="<?= site_url('packages'); ?>"><i class="bi bi-currency-dollar fa-fw me-2"></i><?= lang('Web.upgrade_to_pro') ?></a></li>
								<li class="dropdown-item">
									<div class="form-check form-switch">
										<input class="form-check-input" type="checkbox" role="switch" id="switchdarktheme">
										<label class="form-check-label" for="switchdarktheme">Dark Theme</label>
									</div> 
								</li>
								<li class="dropdown-divider"></li>
								<li><a class="dropdown-item bg-danger-soft-hover" href="<?= site_url('logout') ?>"><i class="bi bi-power fa-fw me-2"></i><?= lang('Web.sign_out') ?></a></li>
								</ul>

							</li>
							<!-- Profile START -->

						</ul>
						<!-- Nav right END -->
					</div>
				<?php
				}else{ ?>
					<a class="btn btn-sm btn-primary" href="<?=site_url('register');?>">Register</a>
				<?php } ?>

			</div>
		</nav>
		<!-- Logo Nav END -->
	</header>
	<!-- ======================= Header END -->

	<!-- **************** MAIN CONTENT START **************** -->
	<main>
		
	


		<!-- Container START -->
		<div class="<?= (isset($is_full_layout)) ? '' : 'container' ?> ">

			<?= $this->renderSection('content') ?>

		</div>
		<!-- Container END -->
		<?php if (get_setting('cookie-alert') == '1') : ?>
			<div class="cookie-alert" id="cookieAlert" style="position: fixed; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: #343a40; color: #fff; text-align: center; z-index: 9999;">
				<div class="container">
					<div class="row">
						<div class="col-10">
							We use cookies to ensure you get the best experience on our website. <a href="#" class="btn btn-primary btn-sm ms-2" id="acceptCookies">Accept</a>
						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>


	</main>
	<?php
	if (get_setting('chk-chat') == 1) {
	?>
		<?= $this->include('partials/main_chat') ?>
		
		<script src="<?= load_asset(); ?>js/chat.js"></script>
	<?php
	}
	?>
	<!-- JS libraries, plugins and custom scripts -->

	<!-- END Bootstrap-Cookie-Alert -->




	<!-- Bootstrap JS -->
	<script src="<?= load_asset(); ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url('public'); ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
	<script src="<?= load_asset(); ?>js/main.js"></script>
	<script src="<?= base_url('public'); ?>/plugins/toastr/js/toastr.min.js"></script>
	<script>
		function setCookie(name, value, days) {
			const date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));  // Cookie expires after 'days'
			const expires = "expires=" + date.toUTCString();
			document.cookie = name + "=" + value + ";" + expires + ";path=/";  // Use path=/ to allow access site-wide
		}

		// Function to get a cookie by name
		function getCookie(name) {
			const nameEQ = name + "=";
			const ca = document.cookie.split(';');
			for (let i = 0; i < ca.length; i++) {
				let c = ca[i];
				while (c.charAt(0) === ' ') c = c.substring(1);
				if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
			}
			return null;
		}

		// Check if the cookie exists on page load
		window.onload = function () {
			const cookieAccepted = getCookie("cookieAccepted");
			if (cookieAccepted !== "true") {
				document.getElementById("cookieAlert").style.display = "block";
			} else {
				document.getElementById("cookieAlert").style.display = "none";
			}
		};

		// Add an event listener to the "Accept" button
		document.getElementById("acceptCookies").addEventListener("click", function () {
			setCookie("cookieAccepted", "true", 365);  // Store cookie for 365 days
			document.getElementById("cookieAlert").style.display = "none";
		});
</script>
<?php
	//loading files from controller.
	if (isset($js_files)) {
		foreach ($js_files as $file) {
			if (filter_var($file, FILTER_VALIDATE_URL)) {
				echo '<script src="' . $file . '"></script>' . "\n";
			} else {
				echo '<script src="' . load_asset() . $file . '"></script>' . "\n";
			}
		}
	} ?>

</body>

</html>