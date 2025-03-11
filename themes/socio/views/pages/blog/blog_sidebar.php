<div class="col-lg-4">
    <div class="row g-4">
        <!-- Card News START -->
        <div class="col-sm-6 col-lg-12">
            <div class="card">
                <!-- Card header START -->
                <div class="card-header pb-0 border-0">
                    <h5 class="card-title mb-0"><?= esc(lang('Web.recent_post')) ?></h5> <!-- Translate "Recent post" -->
                </div>
                <!-- Card header END -->
                <!-- Card body START -->
                <div class="card-body">
                    <!-- News item -->
                   <div class="recent-blog"></div>
                </div>
                <!-- Card body END -->
            </div>
        </div>
        <!-- Card News END -->

        <!-- Card Tags START -->
        <div class="col-sm-6 col-lg-12">
            <div class="card">
                <!-- Card header START -->
                <div class="card-header pb-0 border-0">
                    <h5 class="card-title mb-0"><?= esc(lang('Web.tags')) ?></h5> <!-- Translate "Tags" -->
                </div>
                <!-- Card header END -->
                <!-- Card body START -->
                <div class="card-body">
                    <!-- Tag list START -->
                    <ul class="list-inline mb-0 d-flex flex-wrap gap-2 recent_tags">
                    </ul>
                    <!-- Tag list END -->
                </div>
                <!-- Card body END -->
            </div>
        </div>
        <!-- Card Tags END -->
    </div>
    <!-- Right sidebar END -->
</div>

<script>
$(document).ready(function(){
    $.ajax({
        type: "POST",
        url: site_url + "web_api/recent-tags",
        success: function(response) {
            if (response.code === "200") {
                $.each(response.data, function(index, tag) {
                    var listItem = '<li class="list-inline-item m-0">' +
                        '<a class="btn btn-outline-light btn-sm" href="' + site_url + 'blog-tags/' + tag.id + '">' + tag.name + '</a>' +
                        '</li>';
                    $('.recent_tags').append(listItem);
                });
            }
        },
    });
});
</script>
