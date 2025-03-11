<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-3">
        <?= $this->include('partials/settings_sidebar') ?>
    </div>

    <div class="col-lg-6 vstack gap-4">
        <div class="py-0 mb-0">
            <div class="card mb-4">
                <div class="card-header border-0 border-bottom">
                    <h1 class="h5 card-title"><?= lang('Web.blocked_user_title') ?></h1>
                </div>
                <div class="card-body">
                    <?php if($users!=null):?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?= lang('Web.sr') ?></th>
                                    <th><?= lang('Web.user_name') ?></th>
                                    <th><?= lang('Web.profile_image') ?></th>
                                    <th><?= lang('Web.gender') ?></th>
                                    <th><?= lang('Web.action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $key => $user) : ?>
                            <tr>
                                <td><?= ++$key ?></td>
                                <td><b class="mt-1"><?= $user['first_name']." ".$user['last_name'] ?></b></td>
                                <td><img src="<?= $user['avatar'] ?>" width="40px" height="40px" class="rounded-circle"></td>
                                <td><?= $user['gender'] ?></td>
                                <td><button class="btn btn-sm btn-info border-0 unblock" data-user_id="<?= $user['id'] ?>"><?= lang('Web.unblock') ?></button></td>
                            </tr>
                        <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php else:?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-person-fill-slash"></i>
                                    <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_blocked_user') ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php endif ;?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click', '.unblock', function (event) {
    let that = $(this);
    let user_id = that.data('user_id');
   
    Swal.fire({
        title: translate('unblock_user_confirm_title'),
        text: translate('unblock_user_confirm_text'),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: translate('yes_unblock')
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST", 
                url: site_url + "web_api/block-user",
                data: {user_id: user_id},
                success: function(response) {
                    if (response.code == 200) {
                        let timerInterval;
                        Swal.fire({
                            title: translate('success_title'),
                            icon: "success",
                            html: response.message,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.icon = 'success';
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            },
                        }).then((result) => {});

                        setTimeout(() => {
                            window.location = site_url + "settings/blocked-users";
                        }, 4000);
                    }
                },
                error: function(error) {
                    console.error("Error:", error);
                }
            });
        }
    });
});

function translate(key) {
    var translations = {
        'unblock_user_confirm_title': '<?= lang('Web.unblock_user_confirm_title') ?>',
        'unblock_user_confirm_text': '<?= lang('Web.unblock_user_confirm_text') ?>',
        'yes_unblock': '<?= lang('Web.yes_unblock') ?>',
        'success_title': '<?= lang('Web.success_title') ?>',
    };
    return translations[key] || key;
}
</script>

<?= $this->endSection() ?>
