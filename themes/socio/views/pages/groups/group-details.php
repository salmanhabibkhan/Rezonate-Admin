<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <?= $this->include('partials/sidebar') ?>

    <div class="col-md-8 col-lg-6 vstack gap-4">
        <div class="content-tabs bg-white rounded shadow-sm clearfix">
            <ul class="clearfix m-0 p-1">
                <li class=""> <a href="<?= site_url('groups'); ?>">Groups</a></li>
                <li class="active"> <a href="<?= site_url('my-groups'); ?>">My Groups</a></li> 
            </ul>
        </div>

        <div class="card">
            <div class="card-header border-0 border-bottom">
                <div class="row g-2">
                    <div class="col-lg-6">
                        <h1 class="h4 card-title mb-lg-0">Group Details</h1>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- <a class="btn btn-primary-soft ms-auto w-100" href="<?= site_url('events/create-event'); ?>"><i class="fa-solid fa-plus pe-1"></i> Create Event</a> -->
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Three Tabs Navigation -->
                
                    <ul class="nav ">
                        
                        <li class="nav-link active"><a data-toggle="tab" class="btn btn-primary-soft"  href="#details">Group Details</a></li>
                        <li class="nav-link"><a data-toggle="tab" class="btn btn-primary-soft" href="#group_members">Group Members</a></li>
                    </ul>
                <div class="tab-content">
                    
                    <div id="details" class="tab-pane fade in active show">
                       
                        <div class="row g-3">
                            <div class="col-sm-6 col-xl-6">
                                <div class="card h-100">
                                    <div class="card-body position-relative p-0" style="text-align:center; margin:0 auto">
                                        <div class="position-relative" style="max-height: 200px;overflow: hidden;">
                                            <img class="img-fluid rounded-top" src="<?= getMedia($group['cover']) ?>" alt="Event Cover">
                                        </div>
                                        <h6 class="mt-3"><?= $group['group_name']; ?></h6>
                                        <p class="small"><i class="bi bi-geo-alt pe-1"></i> <?= $group['members_count'] ?></p>
                                       
                                        
                                    </div>
                                
                                </div>
                            </div>
                            <div class="col-6 ">
                                <h6 class="mt-2"><b>Group Category:</b> <?= GROUP_CATEGORIES[$group['category']] ?> </h6>
                                <p class="mt-2"><b>Group About:</b> <?= $group['about_group'] ?> </p>
                                <p class="mt-2"><b>Group Category:</b> <?= $group['privacy'] ?> </p>
                            </div>                 
                        </div>
                    </div>
                    <div id="group_members" class="tab-pane fade">
                    <?php if(count($groupmembers)>0): ?>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Profile Image</th>
                                            <th>User/Admin</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($groupmembers as $key => $user ):?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td><?= $user['username'] ?></td>
                                            <td><?= $user['gender'] ?></td>
                                            <td><img src="<?=getMedia($user['avatar'])?>" alt="" height="50px" width="50px"></td>
                                            <td>
                                               
                                                <?php if($user['is_admin']==1): ?>
                                                    <span class="badge bg-success" >Admin</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info" >User</span>
                                                <?php endif; ?>
                                            </td>
                                          
                                            <td>
                                            <?php if($group['is_admin'] && $user['user_id']!=$user_data['id']): ?>
                                                <?php if($group['user_id']!=$user['user_id'] ): ?>
                                                
                                                    <?php if($user['is_admin']==1 ): ?>
                                                        <button class="btn btn-danger-soft btn-sm" onclick="removeadmin('<?= $user['user_id'] ?>')" title="Remove Admin"> <i class="bi bi-trash"></i> Dismiss Admin</button>
                                                    <?php else: ?>
                                                        <button class="btn btn-success btn-sm" onclick="makeadmin('<?= $user['user_id'] ?>')" title="Make Group Admin"> <i class="bi bi-check-circle"></i> Make Admin</button>
                                                    <?php endif; ?>
                                                    <button class="btn btn-danger btn-sm" onclick="removemember('<?= $user['user_id'] ?>')" title="Remove user" ><i class="bi bi-trash"></i> Delete </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                                               
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="row">
                            <div class="my-sm-5 py-sm-5 text-center">
                                <i class="display-1 text-body-secondary bi bi-briefcase"></i>
                                <h4 class="mt-2 mb-3 text-body">No Group Member Exist</h4>
                               
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>

</script>
<?= $this->endSection() ?>
