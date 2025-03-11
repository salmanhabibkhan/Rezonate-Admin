<div class="card">
  <div class="card-header border-0 pb-0">
    <h5 class="card-title"></h5>
    <h5><?= lang('Web.group_members') ?></h5>
  </div>
  <div class="card-body">
    <div class="rounded border px-3 py-2 mb-3">   
      <div class="row g-4">
        <div class="col-12">
          <?php if(count($groupmembers) > 0): ?>
          <ul style="list-style-type: none;">
            <?php foreach ($groupmembers as $user) : ?>
              <li class="notification_row">
                <a href="<?= site_url('notification/' . $user['id']) ?>">
                  <div class="rounded notification_item d-sm-flex border-0 mb-1 p-3 position-relative">
                    <div class="avatar text-center">
                      <img class="avatar-img rounded-circle" src="<?= getMedia($user['avatar']) ?>" alt="">
                    </div>
                    <!-- Info -->
                    <div class="mx-sm-3 my-2 my-sm-0">
                      <p class="small"><b><a href="<?= site_url($user['username']) ?>"><?= $user['first_name'] . ' ' . $user['last_name'] ?></a></b><br>
                      <a href="" style="color:inherit;">@<?= $user['username'] ?></a></p>
                    </div>
                    <!-- Action -->
                    <div class="d-flex ms-auto">
                      <p class="small me-5 text-nowrap"></p>
                      <!-- Notification action START -->
                      <div class="dropdown position-absolute end-0 top-0 mt-3 me-3">
                        <?php if($group['is_admin'] && $user['user_id'] != $user_data['id']): ?>
                          <a href="#" class="z-index-1 text-secondary btn position-relative py-0 px-2" id="cardNotiAction2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                          </a>
                        <?php endif; ?>
                        <!-- Card share action dropdown menu -->
                        <?php if($group['is_admin'] && $user['user_id'] != $user_data['id']): ?>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardNotiAction2">
                          <?php if($group['user_id'] != $user['user_id']): ?>
                            <?php if($user['is_admin'] == 1): ?>
                              <li><a class="dropdown-item" href="#" onclick="removeadmin('<?= $user['user_id'] ?>','<?= $group['id'] ?>')" title="<?= lang('Web.remove_admin') ?>"><i class="bi bi-x-circle"></i> <?= lang('Web.remove_admin') ?></a></li>
                            <?php else: ?>
                              <li><a class="dropdown-item" href="#" onclick="makeadmin('<?= $user['user_id'] ?>','<?= $group['id'] ?>')"><i class="bi bi-check-circle"></i>  <?= lang('Web.make_admin') ?></a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="#" onclick="removemember('<?= $user['user_id'] ?>','<?= $group['id'] ?>')" title="<?= lang('Web.delete_user') ?>"><i class="bi bi-trash"></i> <?= lang('Web.delete_user') ?></a></li>
                          <?php endif; ?>
                        </ul>
                        <?php endif; ?>
                      </div>
                      <!-- Notification action END -->
                    </div>
                  </div>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
          <?php else: ?>
            <div class="row">
              <div class="my-sm-5 py-sm-5 text-center">
                <i class="display-1 text-body-secondary bi bi-briefcase"></i>
                <h4 class="mt-2 mb-3 text-body"><?= lang('Web.no_group_members_exist') ?></h4>
              </div>
            </div>
          <?php endif; ?>
        </div>
        <!-- Add more group details as needed -->
      </div>
    </div>
  </div>
</div>
<script>
  function removeadmin(user_id)
{
   
    Swal.fire({
    title: "Are you sure?",
    text: "Do you want to remove the admin ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, remove it!"
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "POST", // You can change this to 'GET' if needed
            url: "<?= site_url('web_api/remove-admin') ?>", // Specify the URL where you want to send the data
            data:{ user_id:  user_id,group_id:<?= $group['id'] ?>,} ,
            success: function(response) {
                if (response.code == 400) {
                    $('#phone').focus();
                    Swal.fire({
                        icon: 'warning',
                        text: response.data.phone,
                    });
                    $('#phone').focus();
                }
                if (response.code == 200) {

                    let timerInterval;
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        html: response.message,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector(
                            "b");
                            timerInterval = setInterval(() => {
                                timer.textContent =
                                    `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                       
                    });
                    setTimeout(() => {
                      window.location = "<?= site_url('group/'.$group['group_name'].'/members') ?>";
                    }, 4000);

                    // 
                }
            },
            error: function(error) {
                // Handle the error response here
                console.error("Error:", error);
            }
        });
    }
    });
}
function makeadmin(user_id)
{
   
    Swal.fire({
    title: "Are you sure?",
    text: "Do you want to make this user as  admin ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, create it!"
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "POST", // You can change this to 'GET' if needed
            url: "<?= site_url('web_api/make-admin') ?>", // Specify the URL where you want to send the data
            data:{ user_id:  user_id,group_id:<?= $group['id'] ?>,} ,
            success: function(response) {
                if (response.code == 400) {
                    $('#phone').focus();
                    Swal.fire({
                        icon: 'warning',
                        text: response.data.phone,
                    });
                    $('#phone').focus();
                }
                if (response.code == 200) {

                    let timerInterval;
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        html: response.message,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector(
                            "b");
                            timerInterval = setInterval(() => {
                                timer.textContent =
                                    `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                       
                    });
                    setTimeout(() => {
                      window.location = "<?= site_url('group/'.$group['group_name'].'/members') ?>";
                    }, 4000);

                    // 
                }
            },
            error: function(error) {
                // Handle the error response here
                console.error("Error:", error);
            }
        });
    }
    });
}
function removemember(user_id)
{
   
    Swal.fire({
    title: "Are you sure?",
    text: "Do you want to remove the admin ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, remove it!"
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "POST", // You can change this to 'GET' if needed
            url: "<?= site_url('web_api/remove-member') ?>", // Specify the URL where you want to send the data
            data:{ user_id:  user_id,group_id:<?= $group['id'] ?>,} ,
            success: function(response) {
                if (response.code == 400) {
                    $('#phone').focus();
                    Swal.fire({
                        icon: 'warning',
                        text: response.data.phone,
                    });
                    $('#phone').focus();
                }
                if (response.code == 200) {

                    let timerInterval;
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        html: response.message,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector(
                            "b");
                            timerInterval = setInterval(() => {
                                timer.textContent =
                                    `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                       
                    });
                    setTimeout(() => {
                        window.location = "<?= site_url('group/'.$group['group_name'].'/members') ?>";
                    }, 4000);

                    // 
                }
            },
            error: function(error) {
                // Handle the error response here
                console.error("Error:", error);
            }
        });
    }
    });
}
</script>