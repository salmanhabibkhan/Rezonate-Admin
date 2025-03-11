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
                    <h1 class="h5 card-title"><?= lang('Web.manage_sessions') ?></h1>
                </div>
                <div class="card-body">
                    <?php if($sessions!=null):?>
                       <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th><?= lang('Web.sr') ?></th>
                                        <th><?= lang('Web.web_browser') ?></th>
                                        <th><?= lang('Web.operating_system') ?></th>
                                        <th><?= lang('Web.session_id') ?></th>
                                        <th><?= lang('Web.action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($sessions as $key => $session) : ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><b class="mt-1"><?= $session->browser ?></b></td>
                                    <td><?= $session->os ?></td>
                                    <td><?= $session->id ?></td>
                                    <td>
                                        <?php if($session->id == 'ci_session:'.session_id()): ?>
                                            <button class="btn btn-xs btn-info"><?= lang('Web.current_session') ?></button>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-danger border-0 deletesession" data-session_id="<?= $session->id ?>"><i class="bi bi-trash"></i> <?= lang('Web.delete') ?></button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                       </div>
                    <?php else: ?>
                        <script>
                            window.location = site_url + 'login';
                        </script>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="my-sm-5 py-sm-5 text-center">
                                    <i class="display-1 text-body-secondary bi bi-person-fill-slash"></i>
                                    <h4 class="mt-2 mb-3 text-body"><?= lang('Web.session_not_found') ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click', '.deletesession', function (event) {
    let that = $(this);
    let session_id = that.data('session_id');
   
    Swal.fire({
        title: translate('delete_session_confirm_title'),
        text: translate('delete_session_confirm_title'),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: translate('cancel'),
        
        confirmButtonText: translate('yes_delete')
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: site_url + "web_api/delete-session",
                data: {session_id: session_id},
                success: function(response) {
                    if (response.code == 200) {
                        let timerInterval;
                        Swal.fire({
                            title: translate('delete_session_confirm_title'),
                            icon: "success",
                            html: translate('session_deleted'),
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: () => {
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        });

                        setTimeout(() => {
                            window.location = site_url + "settings/manage-sessions";
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
        'delete_session_confirm_title': '<?= lang('Web.delete_session_confirm_title') ?>',
        'delete_session_confirm_text': '<?= lang('Web.delete_session_confirm_text') ?>', // Corrected key here
        'yes_delete': '<?= lang('Web.yes_delete') ?>',
        'success_title': '<?= lang('Web.success_title') ?>',
        'session_deleted': '<?= lang('Web.session_deleted') ?>',
        
        'cancel':'<?= lang('Web.cancel')?>',
    };
    return translations[key] || key;
}
</script>


<?= $this->endSection() ?>
