<!-- Main Chat START -->
<div class="d-none d-lg-block">
	<!-- Button -->
	<a class="icon-md btn btn-primary position-fixed end-0 bottom-0 me-5 mb-5 open_chat_button" data-bs-toggle="offcanvas" href="#offcanvasChat" role="button" aria-controls="offcanvasChat">
		<i class="bi bi-chat-left-text-fill"></i>
	</a>

	<!-- Chat sidebar START -->
	<div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasChat">
		<!-- Offcanvas header -->
		<div class="offcanvas-header d-flex justify-content-between">
			<h5 class="offcanvas-title"><?= lang('Web.messaging') ?></h5>
			<div class="d-flex">
				<!-- Close  -->
				<a href="#" class="btn btn-secondary-soft-hover py-1 px-2" data-bs-dismiss="offcanvas" aria-label="<?= lang('Web.close') ?>">
					<i class="fa-solid fa-xmark"></i>
				</a>
			</div>
		</div>
		<!-- Offcanvas body START -->
		<div class="offcanvas-body pt-0 custom-scrollbar">
			<ul class="list-unstyled">
				<li class="p-3 text-center">
					<div class="socio_loader"></div><?= lang('Web.loading_chat_list') ?>
				</li>
			</ul>
		</div>
		<!-- Offcanvas body END -->
	</div>
	<!-- Chat sidebar END -->

	<!-- Chat START -->
	<div aria-live="polite" aria-atomic="true" class="position-relative">
		<div class="toast-container toast-chat d-flex gap-3 align-items-end">
		</div>
	</div>
	<!-- Chat END -->

</div>
<!-- Main Chat END -->
