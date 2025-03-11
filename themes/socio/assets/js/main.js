/*
 Sticky-kit v1.1.3 | MIT | Leaf Corcoran 2015 | http://leafo.net
*/
(function(){var c,f;c=window.jQuery;f=c(window);c.fn.stick_in_parent=function(b){var A,w,J,n,B,K,p,q,L,k,E,t;null==b&&(b={});t=b.sticky_class;B=b.inner_scrolling;E=b.recalc_every;k=b.parent;q=b.offset_top;p=b.spacer;w=b.bottoming;null==q&&(q=0);null==k&&(k=void 0);null==B&&(B=!0);null==t&&(t="is_stuck");A=c(document);null==w&&(w=!0);L=function(a){var b;return window.getComputedStyle?(a=window.getComputedStyle(a[0]),b=parseFloat(a.getPropertyValue("width"))+parseFloat(a.getPropertyValue("margin-left"))+
parseFloat(a.getPropertyValue("margin-right")),"border-box"!==a.getPropertyValue("box-sizing")&&(b+=parseFloat(a.getPropertyValue("border-left-width"))+parseFloat(a.getPropertyValue("border-right-width"))+parseFloat(a.getPropertyValue("padding-left"))+parseFloat(a.getPropertyValue("padding-right"))),b):a.outerWidth(!0)};J=function(a,b,n,C,F,u,r,G){var v,H,m,D,I,d,g,x,y,z,h,l;if(!a.data("sticky_kit")){a.data("sticky_kit",!0);I=A.height();g=a.parent();null!=k&&(g=g.closest(k));if(!g.length)throw"failed to find stick parent";
v=m=!1;(h=null!=p?p&&a.closest(p):c("<div />"))&&h.css("position",a.css("position"));x=function(){var d,f,e;if(!G&&(I=A.height(),d=parseInt(g.css("border-top-width"),10),f=parseInt(g.css("padding-top"),10),b=parseInt(g.css("padding-bottom"),10),n=g.offset().top+d+f,C=g.height(),m&&(v=m=!1,null==p&&(a.insertAfter(h),h.detach()),a.css({position:"",top:"",width:"",bottom:""}).removeClass(t),e=!0),F=a.offset().top-(parseInt(a.css("margin-top"),10)||0)-q,u=a.outerHeight(!0),r=a.css("float"),h&&h.css({width:L(a),
height:u,display:a.css("display"),"vertical-align":a.css("vertical-align"),"float":r}),e))return l()};x();if(u!==C)return D=void 0,d=q,z=E,l=function(){var c,l,e,k;if(!G&&(e=!1,null!=z&&(--z,0>=z&&(z=E,x(),e=!0)),e||A.height()===I||x(),e=f.scrollTop(),null!=D&&(l=e-D),D=e,m?(w&&(k=e+u+d>C+n,v&&!k&&(v=!1,a.css({position:"fixed",bottom:"",top:d}).trigger("sticky_kit:unbottom"))),e<F&&(m=!1,d=q,null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),h.detach()),c={position:"",width:"",top:""},a.css(c).removeClass(t).trigger("sticky_kit:unstick")),
B&&(c=f.height(),u+q>c&&!v&&(d-=l,d=Math.max(c-u,d),d=Math.min(q,d),m&&a.css({top:d+"px"})))):e>F&&(m=!0,c={position:"fixed",top:d},c.width="border-box"===a.css("box-sizing")?a.outerWidth()+"px":a.width()+"px",a.css(c).addClass(t),null==p&&(a.after(h),"left"!==r&&"right"!==r||h.append(a)),a.trigger("sticky_kit:stick")),m&&w&&(null==k&&(k=e+u+d>C+n),!v&&k)))return v=!0,"static"===g.css("position")&&g.css({position:"relative"}),a.css({position:"absolute",bottom:b,top:"auto"}).trigger("sticky_kit:bottom")},
y=function(){x();return l()},H=function(){G=!0;f.off("touchmove",l);f.off("scroll",l);f.off("resize",y);c(document.body).off("sticky_kit:recalc",y);a.off("sticky_kit:detach",H);a.removeData("sticky_kit");a.css({position:"",bottom:"",top:"",width:""});g.position("position","");if(m)return null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),h.remove()),a.removeClass(t)},f.on("touchmove",l),f.on("scroll",l),f.on("resize",y),c(document.body).on("sticky_kit:recalc",y),a.on("sticky_kit:detach",H),setTimeout(l,
0)}};n=0;for(K=this.length;n<K;n++)b=this[n],J(c(b));return this}}).call(this);


function get_notifications() {

  
  $(".noti_list_ul").html('<div class="socio_loader"></div>');

  $.ajax({
    type: "POST",
    data:{'limit': 5},
    url: site_url + "web_api/notifications/new",
    dataType: "json",
    success: function (response) {
      var html = "";
      if (response.code == 200) {
        if(response.data.length > 0){          
          $.each(response.data, function (indx, noti) {
            html +=
              '<li><div class="list-group-item list-group-item-action  badge-unread d-flex border-0 mb-1 px-3 py-1 position-relative">\
                  <div class="avatar text-center d-none d-sm-inline-block">\
                    <img class="avatar-img rounded-circle" src="'+noti.notifier.avatar +'" alt="">\
                  </div>\
                  <div class="ms-sm-3 d-flex">\
                    <div>\
                      <p class="mb-2"><a href="'+site_url+'/'+noti.notifier.username+'"><strong>' +noti.notifier.first_name +' '+noti.notifier.last_name +'</strong></a><span class="small"> <a href="'+site_url+'/notification/'+noti.id+'" style="color:#676A79;">' +noti.text +'</a></span></p>\
                    </div>\
                    <p class="small ms-3"><small>' +noti.created_human +"</small></p>\
                  </div>\
                </div>\
              </li>";
          });
          $(".noti_list_ul").html(html);
        }else{
          html += '<div class="p-3">\
                  <div class="ms-sm-3 text-center">\
                    <div>\
                      <p class="small mb-2"><i class="bi bi-bell"> </i> ' +response.message +'</p>\
                    </div>\
                  </div>\
                </div>\
              ';
        }
        $(".noti_list_ul").replaceWith(html);
      }
    },
  });
}


$(document).on("click", ".notification_dropdown", function () {
  get_notifications();
});

$(document).on("click", ".clear_all_noti", function () {
  $.ajax({
    type: "POST",
    url: site_url + "web_api/notifications/mark-all-as-read",
    dataType: "json",
    success: function (response) {
      if (response.code == 200) {
        $(".badge-unread").removeClass("badge-unread");
      }
    },
  });
});

function showAlert(text, title, icon) {
  if (icon == undefined) icon = "info";
  Swal.fire({ title, text, icon, showCloseButton: true });
}



$(document).on("click", ".award_coc", function (event) {
  event.preventDefault();

  let cocBtn = $(this);
  if (cocBtn.data("requestInProgress")) return;

  let postCard = cocBtn.closest(".post_card");
  let postId = postCard.data("pstid");
  cocBtn.addClass("active");

  // Prepare post data
  let postData = {
      post_id: postId,
  };
  let coc = $("#coc").val();
  cocBtn.data("requestInProgress", true);

  // AJAX request
  $.ajax({
      type: "POST",
      url: site_url + "web_api/get-balance",
      dataType: "json",
      success: function (response) {
        
          if (parseFloat(response.balance) > parseFloat(coc)) {
            Swal.fire({
              title: translations.confirm_award,
              text: translations.available_balance + " " + response.balance + " " +
                    translations.amount_deduction + " " + coc + " " +
                    translations.amount_deduction_message,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: translations.yes,
              cancelButtonText: translations.no,
              
          }).then((result) => {
                  if (result.isConfirmed) {
                      $.ajax({
                          type: "POST",
                          url: site_url + "/web_api/post/cup-of-coffee",
                          data: postData,
                          success: function (response) {
                              if (response.status == 400) {
                                  Swal.fire({
                                      icon: "warning",
                                      text: response.message,
                                  });
                              }
                              if (response.status == 200) {
                                  let timerInterval;
                                  Swal.fire({
                                      icon: "success",
                                      html: response.message,
                                      timer: 2000,
                                      timerProgressBar: true,
                                      didOpen: () => {
                                          const timer = Swal.getPopup().querySelector("b");
                                          timerInterval = setInterval(() => {
                                              timer.textContent = `${Swal.getTimerLeft()}`;
                                          }, 100);
                                      },
                                      willClose: () => {
                                          clearInterval(timerInterval);
                                      },
                                      didClose: () => {
                                          Swal.update({
                                              html: '<i class="fas fa-check-circle"></i> !',
                                              showCancelButton: false,
                                              showConfirmButton: false,
                                              showCloseButton: false,
                                          });
                                      },
                                  }).then((result) => {
                                      // Optional: Additional logic after success
                                  });
                                  setTimeout(() => {
                                      // window.location = site_url;
                                  }, 4000);
                              }
                          },
                          error: function (error) {
                              console.error("Error:", error);
                          },
                      });
                  }
              });
          } else {
              showAlert(translations.insufficient_balance, translations.low_balance, "warning");
          }
      },
      complete: function () {
          setTimeout(() => {
              cocBtn.data("requestInProgress", false);
          }, 2000); // Reset the flag
      },
  });
});


$(document).on("click", ".award_gj", function (event) {
  event.preventDefault();

  let gjBtn = $(this);
  if (gjBtn.data("requestInProgress")) return;

  let postCard = gjBtn.closest(".post_card");
  let postId = postCard.data("pstid");
  gjBtn.addClass("active");

  // Prepare post data
  let postData = {
      post_id: postId,
  };
  let gj = $("#great_jobvalue").val();
  gjBtn.data("requestInProgress", true);

  // AJAX request
  $.ajax({
      type: "POST",
      url: site_url + "web_api/get-balance",
      dataType: "json",
      success: function (response) {
          Swal.fire({
              title: translations.confirm_award,
              text: translations.available_balance + " " + response.balance + " " +
                    translations.amount_deduction + " " + gj + " " +
                    translations.amount_deduction_message,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: translations.yes_confirm,
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      type: "POST",
                      url: site_url + "/web_api/post/great-job",
                      data: postData,
                      success: function (response) {
                          if (response.status == 400) {
                              Swal.fire({
                                  icon: "warning",
                                  text: response.message,
                              });
                          }
                          if (response.status == 200) {
                              let timerInterval;
                              Swal.fire({
                                  icon: "success",
                                  html: translations.success_message_gj,
                                  timer: 2000,
                                  timerProgressBar: true,
                                  didOpen: () => {
                                      const timer = Swal.getPopup().querySelector("b");
                                      timerInterval = setInterval(() => {
                                          timer.textContent = `${Swal.getTimerLeft()}`;
                                      }, 100);
                                  },
                                  willClose: () => {
                                      clearInterval(timerInterval);
                                  },
                                  didClose: () => {
                                      Swal.update({
                                          html: '<i class="fas fa-check-circle"></i> Success!',
                                          showCancelButton: false,
                                          showConfirmButton: false,
                                          showCloseButton: false,
                                      });
                                  },
                              }).then((result) => {
                                  // Optional: Additional logic after success
                              });
                              setTimeout(() => {
                                  // window.location = site_url;
                              }, 4000);
                          }
                      },
                      error: function (error) {
                          console.error("Error:", error);
                      },
                  });
              }
          });
      },
      complete: function () {
          setTimeout(() => {
              gjBtn.data("requestInProgress", false);
          }, 2000); // Reset the flag
      },
  });
});

$(document).on("click", ".deleteallnotification", function () {
  let that = $(this);

  $.ajax({
      type: "post",
      url: site_url + "web_api/notifications/delete-all-notifications",
      data:{},
      dataType: "json",
      success: function (response) {
      if (response.code == 200) {
          alert(response.message);
          
          window.location=site_url+'notifications';

      }
      },
  });
});    


function get_updates(){


  
  $.ajax({
      type: "GET",
      url: site_url + "updates",
      dataType: "json",
      success: function(response) {
            if (response.code === "200") {
              var data = response.data;
              var noti_badge = $('.badge-notif');

              // Notification count
              if (noti_badge.length > 0) {
                  if (data.unseen_notifications > 0) {
                      noti_badge.show();
                  } else {
                      noti_badge.hide();
                  }
              }
              setTimeout(() => {
                get_updates();
              }, 5000);
          } else if (response.code === "401") { // Assuming '401' indicates not logged in or unauthorized
              // Redirect to login page
              window.location.href = "/login"; // Adjust the path as necessary
          }
          
      },
  });

  


}

$(document).ready(function(){
  get_updates();  
  $.ajax({
      type: "POST",
      url: site_url + "public_api/recent-blogs",
      success: function(response) {
        
          if (response.code === "200") {
              var blogDiv = '';
              $.each(response.data, function(index, blog) {
                  // Create a new div with the required structure
                  blogDiv += '<div class="py-2 border-bottom">' +
                      '<p class="mb-0"><a href="'+site_url+'blog-details/'+ blog.id+'">' + blog.title + '</a></p>' +
                      '<small>' + blog.created_at + '</small>' +
                      '</div>';
              });
               // Append the new div to the blogContainer
               $('.recent-blog').html(blogDiv);
          }
      },
  });


  
  

});




/*
 * Bootstrap Cookie Alert by Wruczek
 * https://github.com/Wruczek/Bootstrap-Cookie-Alert
 * Released under MIT license
 */
(function () {
  "use strict";

  var cookieAlert = document.querySelector(".cookiealert");
  var acceptCookies = document.querySelector(".acceptcookies");

  if (cookieAlert != null) {
      
    cookieAlert.offsetHeight; // Force browser to trigger reflow (https://stackoverflow.com/a/39451131)

    // Show the alert if we cant find the "acceptCookies" cookie
    if (!getCookie("acceptCookies")) {
        cookieAlert.classList.add("show");
    }

    // When clicking on the agree button, create a 1 year
    // cookie to remember user's choice and close the banner
    acceptCookies.addEventListener("click", function () {
        setCookie("acceptCookies", true, 365);
        cookieAlert.classList.remove("show");

        // dispatch the accept event
        window.dispatchEvent(new Event("cookieAlertAccept"))
    });

  }

  // Cookie functions from w3schools
  function setCookie(cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      var expires = "expires=" + d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for (var i = 0; i < ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) === ' ') {
              c = c.substring(1);
          }
          if (c.indexOf(name) === 0) {
              return c.substring(name.length, c.length);
          }
      }
      return "";
  }
});



document.addEventListener("DOMContentLoaded", function () {
    const formContainer = document.getElementById("dynamicForm");
    const addButton = document.getElementById("addButton");
    const getValuesButton = document.getElementById("getValuesButton");
    const outputDiv = document.getElementById("output");
    let fieldCount = 1;

    addButton.addEventListener("click", function () {
        if (fieldCount < 5) {
            fieldCount++;
            const newField = document.createElement("div");
            newField.classList.add("form-group");
            newField.innerHTML = `
                <label for="input${fieldCount}">Option ${fieldCount}:</label>
                <div class="input-group">
                <input type="text" class="form-control" id="input${fieldCount}" required>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-danger removeButton">-</button>
                    </div>
                </div>
            `;
            formContainer.appendChild(newField);

            if (fieldCount === 5) {
                addButton.disabled = true;
            }
        }
    });

    formContainer.addEventListener("click", function (event) {
        const removeButton = event.target.closest(".removeButton");

        if (removeButton) {
            formContainer.removeChild(removeButton.closest(".form-group"));
            fieldCount--;
            if (fieldCount < 5) {
                addButton.disabled = false;
            }
            const formFields = formContainer.querySelectorAll('.form-control');
          const valuesArray = [];
          formFields.forEach(field => {
              valuesArray.push(field.value);
          });
          const valuesString = valuesArray.join(',');
          outputDiv.textContent = valuesString;
        }
    });

    formContainer.addEventListener("change", function () {
        const formFields = formContainer.querySelectorAll('.form-control');
        const valuesArray = [];
        formFields.forEach(field => {
            valuesArray.push(field.value);
        });
        const valuesString = valuesArray.join(',');
        $('#output').val(valuesString);
    });
});

$(document).ready(function(){
  $('#pollsubmit').click(function(event){
    event.preventDefault();
    var post_text = $('#post_text').val();
    var poll_option = $('#output').val();
    
    if(post_text==null ||post_text==''){
      alert('Poll title can not be empty');
      return;
    }
    if(poll_option==null ||poll_option==''){
      alert('Poll option can not be empty');
      return;
    }
      $.ajax({
        type: 'post',
        url: site_url+'/web_api/post/create',
        data:{post_type:"poll",post_text:post_text,poll_option:poll_option},
        success: function (response) {
          window.location.reload();
        }
      });
  
  });
});
$(document).ready(function(){
  $('#donation_form').submit(function(event){
    event.preventDefault();  

    // Custom validation
    var postText = $('input[name="post_text"]').val().trim();
    var amount = $('input[name="amount"]').val().trim();
    var description = $('textarea[name="description"]').val().trim();
    var image = $('input[name="donation_image"]').val();
    var validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if(postText === '' || amount === '' || description === '') {
      alert('Please fill in all fields.');
      return;
    }

    if(parseInt(amount) <= 0) {
      alert('Please enter a valid donation amount.');
      return;
    }

    if(image === '') {
      alert('Please upload a donation image.');
      return;
    }

    var extension = image.split('.').pop().toLowerCase();
    if(validExtensions.indexOf(extension) === -1) {
      alert('Please upload an image with a valid extension (jpg, jpeg, png, gif).');
      return;
    }

    var formData = new FormData(this);
    $.ajax({
      type: 'post',
      url: site_url + '/web_api/post/create',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        alert('Donation Post is created');
          window.location.reload(); // Reload the page after showing the message
      
      }
    });
    
  });
});

function toggleDescription(post_id) {
  var shortDesc = document.getElementById('shortDescription'+post_id);
  var fullDesc = document.getElementById('fullDescription'+post_id);
  var toggleBtn = document.querySelector('.toggle-description');

  if (fullDesc.style.display === 'none') {
    shortDesc.style.display = 'none';
    fullDesc.style.display = 'block';
    toggleBtn.textContent = 'Show Short Description';
  } else {
    shortDesc.style.display = 'block';
    fullDesc.style.display = 'none';
    toggleBtn.textContent = 'Show Full Description';
  }
}


function setCookie(name, value, days) {
  const date = new Date();
  date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
  const expires = "expires=" + date.toUTCString();
  document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Function to get a cookie by name
function getCookie(name) {
  const decodedCookie = decodeURIComponent(document.cookie);
  const ca = decodedCookie.split(';');
  name = name + "=";
  for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) === ' ') {
          c = c.substring(1);
      }
      if (c.indexOf(name) === 0) {
          return c.substring(name.length, c.length);
      }
  }
  return "";
}

// Check if the cookie exists on page load
window.onload = function () {
  const cookieAccepted = getCookie("cookieAccepted");
  if (!cookieAccepted) {
      document.getElementById("cookieAlert").style.display = "block";
  }
};

// Add an event listener to the "Accept" button
document.getElementById("acceptCookies").addEventListener("click", function () {
  setCookie("cookieAccepted", "true", 365);  // Set cookie for 365 days
  document.getElementById("cookieAlert").style.display = "none";
});

let checkdark = localStorage.getItem('theme');
if(checkdark=='dark')
{
    $('#switchdarktheme').prop('checked', true);
}
$('#switchdarktheme').on('change', function() {
    if (this.checked) {
        // If checked, set theme to dark
        localStorage.setItem('theme', 'dark');
        $('html').attr('data-bs-theme', 'dark');
    } else {
        // If unchecked, remove the dark theme
        localStorage.removeItem('theme');
        $('html').removeAttr('data-bs-theme');
    }
});








