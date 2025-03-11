<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <div class="row">
                    
                    <div class="col-md-12" style="text-align: center;">
                        <a href="<?= site_url('become-donor') ?>" class="float-end btn btn-success btn-xs"><i class="bi bi-plus-circle"></i></a>

                        <img src="<?= site_url('uploads/placeholder/blood.png') ?>" style="text-align: center;" alt="">
                    </div>
                </div>
            </div>
            <form action="<?= site_url('find-donors') ?>" method="get">
                <div class="row mt-2 mb-3">
                    <div class="col-md-6 offset-md-2">
                        <select name="blood_group"  class="form-control">
                            <option value=""><?= lang('Web.select_blood_group') ?></option>
                            <option value="A+" <?= ($blood_group=='A+')?'selected' :'' ?> >A+</option>
                            <option value="B+" <?= ($blood_group=='B+')?'selected' :'' ?>>B+</option>
                            <option value="AB+" <?= ($blood_group=='AB+')?'selected' :'' ?>>AB+</option>
                            <option value="O+"<?= ($blood_group=='O+')?'selected' :'' ?>>O+</option>
                            <option value="A-" <?= ($blood_group=='A-')?'selected' :'' ?>>A-</option>
                            <option value="B-"<?= ($blood_group=='B-')?'selected' :'' ?>>B-</option>
                            <option value="AB-"<?= ($blood_group=='AB-')?'selected' :'' ?>>AB-</option>
                            <option value="O-" <?= ($blood_group=='O-')?'selected' :'' ?>>O-</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success block"> <i class="bi bi-search"></i> <?= lang('Web.find') ?> </button>    
                    </div>
                </div>
            </form>
            <div class="row">
            <div class="col-md-12">
                <table class="table text-center">
                    <thead>
                    <tr>
                        <th><?= lang('Web.user_name') ?></th>
                        <th><?= lang('Web.email') ?></th>
                        <th><?= lang('Web.blood_group') ?></th>
                        <th><?= lang('Web.phone_number') ?></th>
                        <th><?= lang('Web.location') ?></th>
                    </tr>

                    </thead>
                    <tbody>
                        <?php if(count($users)>0):?>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $user['first_name']." ".$user['last_name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['blood_group'] ?></td>
                                    <td><?= $user['phone'] ?></td>
                                    <td><?= $user['address'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else:?>
                            <tr><td colspan="5" style="text-align:center;"> <span class="text-danger"><b><?= lang('Web.no_data_found') ?></b></span>  </td></tr>
                        <?php endif;?>

                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
