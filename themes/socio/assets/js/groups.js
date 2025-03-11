function removeadmin(user_id,group_id)
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
            type: "POST", 
            url: site_url+'web_api/remove-admin',
            data:{ user_id:  user_id,group_id:group_id,} ,
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
                        window.location = $('#currectUrl').val();
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
function makeadmin(user_id,group_id)
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
            type: "POST", 
            url: site_url+'web_api/make-admin', 
            data:{ user_id:  user_id,group_id:group_id,} ,
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
                        window.location = $('#currectUrl').val();
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
function removemember(user_id,group_id)
{
   
    Swal.fire({
    title: "Are you sure?",
    text: "Do you want to remove the user ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, remove it!"
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "POST", 
            url: site_url+'web_api/remove-member', 
            data:{ user_id:  user_id,group_id:group_id,} ,
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
                        window.location = $('#currectUrl').val();
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
function joinGroup(group_id)
{
   
    Swal.fire({
    title: "Are you sure?",
    text: "Do you want to remove the user ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, remove it!"
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "POST", 
            url: site_url+'web_api/join-group', 
            data:{ group_id:group_id} ,
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
                        window.location = $('#currectUrl').val();
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
function leavegroup(group_id)
{
   
    Swal.fire({
    title: "Are you sure?",
    text: "Do you want to leave this group ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, leave it!"
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "POST", 
            url: site_url+'web_api/leave-group', 
            data:{ group_id:group_id} ,
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
                        window.location = $('#currectUrl').val();
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
