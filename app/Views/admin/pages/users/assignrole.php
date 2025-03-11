<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('Admin.assign_role') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/users/assign-role') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="user_id">
                    <label for=""><?= lang('Admin.assign_role') ?></label>
                    <select name="role" id="users_role" class="form-control"></select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?= lang('Admin.save_changes') ?></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('Admin.close') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
