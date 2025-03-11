var mloader1 =
    '<div class="mloader1 socio-skeleton"><div class="skeleton-header"><div class="skeleton-avatar"></div><div class="skeleton-body"><div class="skeleton-line skeleton-line-half"></div><div class="skeleton-line skeleton-line-quarter"></div></div></div><div class="skeleton-content"><div class="skeleton-line"></div><div class="skeleton-line"></div><div class="skeleton-line"></div></div><div class="skeleton-image"></div></div>';

var nopost_found = `<div class="row no_pst bg-white"><div class="my-sm-5 py-sm-5 text-center"><i class="display-1 text-body-secondary bi bi-card-list"></i><h4 class="mt-2 mb-3 text-body">${translations.no_more_posts}</h4></div></div>`;
var scroll_loading = false;
var postPhotos = [];
var postVideo = [];
var postAudio = [];
var image_uploader;
var postActionRequest = false;
function get_all_posts() {
  if (scroll_loading == true) return;
  if ($(".no_pst").length > 0) return;

  scroll_loading = true;
  let last_post_id = 0;
  const post_holder = $("#post_holder");
  post_holder.append(mloader1);

  last_post_id = post_holder.find(".post_card").last().data("pstid");

  let post_data = {
    get_html: 1,
    last_post_id: last_post_id,
  };

  if (post_holder.data("post_type") !== undefined) {
    let post_type = post_holder.data("post_type");
    let tid = post_holder.data("post_tid");
    if (post_type === "personal") {
      post_data["user_id"] = tid;
    }
    if (post_type === "group") {
      post_data["group_id"] = tid;
    }
    if (post_type === "page") {
      post_data["page_id"] = tid;
    }
    if (post_type === "single_post") {
      post_data["post_id"] = post_holder.data("postid");
    }
    if (post_type === "video") {
      post_data["post_type"] = 2;
    }
    if (post_type === "saved_post") {
      post_data["post_type"] = 5;
    }
  }
  if($(".user_avatar").length > 0) {
    var ApiPath = site_url + "web_api/post/newsfeed"
  }else{
    var ApiPath = site_url + "public_api/public_newsfeed";
  }

  $.ajax({
    type: "GET",
    url: ApiPath,
    data: post_data,
    dataType: "json", // Change to 'json' if the response is JSON
    success: function (response) {
      post_holder.find(".mloader1").remove();
      scroll_loading = false;

      if (response.data.length > 0) {
        post_holder.append(response.data);

        initPostPlugins();
      } else {
        post_holder.append(nopost_found);
      }

      // Assuming the response is HTML. If it's JSON, you might need response.data or similar
    },
    error: function (xhr, status, error) {
      scroll_loading = false;
      post_holder.append(error);

      // Handle errors here
      console.log("Error occurred: " + error);
    },
  });
}

function load_friend_suggestions() {

  
  var post_data = {};
  $(".who_to_follow").html('<div class="socio_loader"></div>');

  $.ajax({
    type: "POST",
    url: site_url + "web_api/fetch-recommended",
    data: post_data,
    dataType: "json", // Change to 'json' if the response is JSON
    success: function (response) {
      // console.log(response);
      if (response.code == 200) {
        var html = "";
        $.each(response.data, function (ind, val) {
          html +=
            '<div class="hstack gap-2 mb-3">\
                    <div class="avatar">\
                        <a href="#!"> <img class="avatar-img rounded-circle" src="' +
            val.avatar +
            '" alt=""> </a>\
                    </div>\
                    <div class="overflow-hidden">\
                        <a class="h6 mb-0" href="' +
            site_url +
            "/" +
            val.username +
            '">' +
            val.first_name +
            " " +
            val.last_name +
            ' </a>\
                        <p class="mb-0 small text-truncate">@' +
            val.username +
            "</p>\
                    </div>";
          if (val.ispending == 1) {
            html +=
              '<a class="send_frnd_req btn btn-primary rounded-circle icon-md ms-auto" data-uid="' +
              val.id +
              '" data-ispending="' +
              val.ispending +
              '" href="#"><i class="bi bi-person-check-fill"></i></a></div>';
          } else {
            html +=
              '<a class="send_frnd_req btn btn-primary-soft rounded-circle icon-md ms-auto" data-uid="' +
              val.id +
              '" data-ispending="' +
              val.ispending +
              '" href="#"><i class="fa-solid fa-plus"></i></a></div>';
          }
        });
      }
      
      $(".who_to_follow").html(html);
    },
  });
}

function load_single_post(post_id) {
  var post_data = {
    post_id: post_id,
    get_html: 1,
  };
  $.ajax({
    type: "GET",
    url: site_url + "web_api/post/detail",
    data: post_data,
    dataType: "json", // Change to 'json' if the response is JSON
    success: function (response) {
      // Assuming the response is HTML. If it's JSON, you might need response.data or similar
      $("#post_holder").append(response.data);
    },
    error: function (xhr, status, error) {
      // Handle errors here
      console.error("Error occurred: " + error);
    },
  });
}

function reset_upload(type = "images") {
  if (type == "images") {
    postPhotos = [];
  } else {
    postVideo = [];
  }
  postAudio = [];
  $(".jquery-uploader-card").each(function (index, element) {
    $(element).find(".file-delete").trigger("click");
  });
}

function copyPostLink(link) {
  // Create a temporary textarea element
  var textarea = document.createElement("textarea");
  textarea.value = link;
  document.body.appendChild(textarea);

  // Select the text and copy it to clipboard
  textarea.select();
  document.execCommand("copy");

  // Remove the temporary textarea
  document.body.removeChild(textarea);

  // Optional: Display an alert or a tooltip to inform the user that the link has been copied
  showAlert(translations.link_copy_clipboard, translations.success, "success");
}
var timestamp = function (createdDate) {
  var timeIndex = 0;
  var shifts = [
    35,
    60,
    60 * 3,
    60 * 60 * 2,
    60 * 60 * 25,
    60 * 60 * 24 * 4,
    60 * 60 * 24 * 10,
  ];
  console.log(createdDate);
  var now = new Date(createdDate);
  var shift = shifts[timeIndex++] || 0;
  var date = new Date(now - shift * 1000);

  return date.getTime() / 1000;
};

function getStories() {
  // Fetch stories using AJAX
  // Initialize an empty array to hold the stories
  let stories = [];

  // Fetch stories using AJAX
  $.ajax({
    type: "post",
    url: site_url + "web_api/story/get-stories",
    processData: false,
    contentType: false,
    dataType: "json",

    success: function (response) {
      // Update stories array with the received data
      response.data.forEach(function (user) {
        var storyItems = [];
        user.stories.forEach(function (story) {
          const dateString = story.created_at;
          const date = new Date(dateString);
          const unixTimestamp = Math.floor(date.getTime() / 1000); // Convert milliseconds to seconds

          var item = [
            story.id,
            story.type,
            50,
            story.media,
            story.thumbnail,
            "#",
            story.description,
            false,
            timestamp(story.created_at),
          ];

          storyItems.push(item);
        });

        // Build the Zuck story
        var zuckStory = Zuck.buildTimelineItem(
          user.id,
          user.avatar,
          user.first_name + " " + user.last_name,
          "",
          "Test3",
          storyItems
        );

        // Add the built story to the stories array
        stories.push(zuckStory);
      });

      // Render the stories
      new Zuck("stories", {
        backNative: false, // uses window history to enable back button on browsers/android
        previousTap: true, // use 1/3 of the screen to navigate to previous item when tap the story
        skin: "snapgram", // container class
        autoFullScreen: false, // enables fullscreen on mobile browsers
        avatars: true, // shows user photo instead of last story item preview
        list: false, // displays a timeline instead of carousel
        openEffect: true, // enables effect when opening story
        cubeEffect: true, // enables the 3d cube effect when sliding story
        backButton: true, // adds a back button to close the story viewer
        /* IMP - turn this reactive: FALSE or leave it commented if not using any framework */
        // reactive: true,    // set true if you use frameworks like React to control the timeline
        rtl: false, // enable/disable RTL
        localStorage: true, // set true to save "seen" position. Element must have a id to save properly.
        stories: stories,
      });
    },
  });
}

function initializeImageUploader() {
  image_uploader = $("#image_uploader")
    .uploader({
      multiple: true,
      autoUpload: false,
      selecttype: "image",
    })
    .on("file-add", function (event, data) {
      if (!data || !data.files || !Array.isArray(data.files)) {
        console.error("Invalid data received in file-add event");
        return;
      }
      highlighPost();
      
      // Process each file
      data.files.forEach(function (file) {
        // Check if the file is an image
        if (file.type && file.type.startsWith("image")) {
          // Check file size (e.g., 5MB max)
          const maxSize = 5 * 1024 * 1024; // 5MB
          //if (file.size <= maxSize) {
            postPhotos.push(file); // Add only if it's an image and size is acceptable
          //} else {
          //  showAlert(translations.image_file_too_large, translations.warning, "warning");
          //}
        } else {
          console.warn(translations.only_image_files_allowed);
          showAlert(translations.only_image_files_allowed, translations.warning, "warning");
        }
      });
    });
}

function initializeVideoUploader() {
  $("#video_uploader")
    .uploader({
      multiple: false,
      autoUpload: false,
      selecttype: "video",
    })
    .on("file-add", function (event, data) {
      // Clear postPhotos if any video is being uploaded
      if (postPhotos.length > 0) {
        reset_upload("images");
      }

      // Check if 'data.file' is defined
      if (!data || !data.file) {
        console.warn(translations.only_video_files_allowed);
        return;
      }

      // Get the selected video file
      let videoFile = data.file;

      // Warn if the selected file is not a video
      if (!videoFile.type.startsWith("video/")) {
        onsole.warn(translations.only_video_files_allowed);
        return;
      }
      highlighPost();
      // Replace postVideo with the newly selected video file
      postVideo = [videoFile];
    });
}
function initializeAudioUploader() {
  $("#audio_uploader")
    .uploader({
      multiple: false,
      autoUpload: false,
      selecttype: "audio",
    })
    .on("file-add", function (event, data) {
      // Clear postPhotos if any audio is being uploaded
      if (postPhotos.length > 0) {
        reset_upload("images");
      }

      // Check if 'data.file' is defined
      if (!data || !data.file) {
        console.error("Invalid data received in file-add event");
        return;
      }

      // Get the selected audio file
      let audioFile = data.file;

      // Warn if the selected file is not a audio
      if (!audioFile.type.startsWith("audio/")) {
        console.warn(
          "Only audio files are allowed. The selected file is not a audio."
        );
        return;
      }
      highlighPost();
      // Replace postaudio with the newly selected audio file
      postAudio = [audioFile];
    });
}

function initPrePostPlugins() {
  new EmojiPicker({
    trigger: [
      {
        selector: ".trigger",
        insertInto: [".txt_msg"], // '.selector' can be used without array
      },
    ],
    closeOnSelect: true,
  });





}

function initPostPlugins() {
  Plyr.setup(".plyr_player");
}

function highlighPost() {
  var cr_pst_sec = $(".cr_pst_sec");
  cr_pst_sec.find(".post_bottom").slideDown();
  cr_pst_sec.find(".card-header").show();
  $(".post_highlighter").show();
  cr_pst_sec.addClass("post_active");
  $("html,body").animate({ scrollTop: cr_pst_sec.offset().top }, "slow");
}

function removeHighlightPost() {
  $(".removeclr").trigger("click");
  $(".cr_pst_sec").removeClass("post_active");
  $(".post_highlighter").hide();
  var cr_pst_sec = $(".cr_pst_sec");
  cr_pst_sec.find(".card-header").slideUp();
  cr_pst_sec.find(".post_bottom").slideUp();
  cr_pst_sec.removeClass("post_active");
}

function checkPostColor(up_count) {
  var getUrl = $("#m_pst_txt");
  var getWitebg = $("_23jo");
  var txtString = getUrl.val();
  var check_up_count = up_count;

  if (txtString.length > 300 || check_up_count == 0) {
    getUrl.removeClass("clr_pst");
    getUrl.prev(".profile-on-post").removeClass("hidden");
    getUrl.parents(".topbg").removeClass("active_large").removeAttr("style");
    getUrl.css("color", "#000");
    getWitebg.css("color", "#000");
    $(".pst_selected_clr").removeClass("pst_selected_clr");
    return true;
  }
  return false;
}

$(document).ready(function () {
  get_all_posts();
  initPrePostPlugins();
  
  load_friend_suggestions();


  if ($(".storiesWrapper").length > 0) {
    getStories();
  }

  $(document).on("focus", "#m_pst_txt", function () {
    highlighPost();
  });

  $("body").on("click", ".post_highlighter", function (event) {
    event.preventDefault();
    removeHighlightPost();
  });

  $(document).on("focus", ".close_post", function () {
    removeHighlightPost();
  });

  // set post privacy
  $("body").on("click", "#privacydropdown li a", function (e) {
    e.preventDefault();

    $("#privacyicon").html($(this).html());
    var that = $(this);
    $("#postprivacy").val(that.data("post_privacy"));
  });

  //privacy dropdown

  $("body").on("click", "#privacydropdown li", function (event) {
    event.preventDefault();

    var that = $(this);
    var val = that.data("val");
    var parent = that.parents(".general-dropdown");
    var trig = parent.find(".dropdown-toggle");

    var currnticon = that.find("a").html();

    trig.find("#privacyicon i").removeClass();
    parent.find("#privacydropdown").attr("data-privacy", val);
    trig.find("#privacyicon i").removeAttr("class");
    // alert(that.find('i').attr("class"));
    // console.log(trig.find("#privacyicon i"));
    trig.find("#privacyicon i").addClass(that.find("i").attr("class"));
    trig.find("#privacyicon").html(currnticon);
    $("#privacydropdown").attr("data-privacy", val);
  });

  $("body").on("click", "#color_display", function (e) {
    $(this).addClass("trans-color");
    var $colorListContainer = $(".color_list_container");

    if ($colorListContainer.is(":visible")) {
      // If the container is visible, animate it out to the left
      $colorListContainer.animate({ left: "-100%" }, 500, function () {
        // Hide it after the animation completes
        $(this).hide();
      });
    } else {
      // If the container is hidden, first show it, then animate it in from the left
      $colorListContainer.show().animate({ left: "0px" }, 500);
    }
  });

  $("body").on("click", ".close-color", function (e) {
    $(this)
      .parents(".color-sec")
      .find("#color_display")
      .removeClass("trans-color");
    $(this).parents(".cr_pst_sec").find("#color-child-sec").hide();
    var $colorListContainer = $(".color_list_container");

    if ($colorListContainer.is(":visible")) {
      // If the container is visible, animate it out to the left
      $colorListContainer.animate({ left: "-100%" }, 500, function () {
        // Hide it after the animation completes
        $(this).hide();
      });
    }
  });

  $("body").on("click", ".pickclr", function (event) {
    event.preventDefault();
    var that = $(this);
    var chkClr = checkPostColor();
    if (chkClr) return;
    $("#bgclr").val(that.data("varclass"));
    var topBG = that.parents(".cr_pst_sec").find(".topbg");
    var txtArea = topBG.find("textarea");
    var bgImg = that.data("bgimg");
    var bgImgUrl = "https://images.socioon.com/assets/images/post/";
    topBG.find(".pst_selected_clr").removeClass("pst_selected_clr");
    that.addClass("pst_selected_clr");
    txtArea.css("min-height", "172px");

    if (bgImg != undefined) {
      var imageUrl = bgImgUrl + bgImg;
      topBG.css({
        "background-image": "url(" + imageUrl + ")",
        "background-repeate": "no-repeat",
        "background-size": "cover",
      });
    } else {
      topBG.css("background", that.data("bgcolor"));
    }
    txtArea.css("color", that.data("frcolor"));
    if (that.data("bgcolor") == "#fff") {
      txtArea.removeClass("clr_pst");
      topBG.removeClass("active_large");
      topBG.find(".profile-on-post").removeClass("hidden");
    } else {
      txtArea.addClass("clr_pst");
      topBG.addClass("active_large");
      topBG.find(".profile-on-post").addClass("hidden");
    }
    topBG.find("textarea").addClass("bg-no");
  });

  // function removeClrPost(){

  //   txtArea.removeClass('clr_pst');
  //        topBG.removeClass('active_large');
  //        topBG.find('.profile-on-post').removeClass('hidden');

  // }

  $("body")
    .on("mouseenter", ".like-btn", function () {
      var that = $(this);
      that.find(".reaction-box").show();
      that.find(".reaction-icon").each(function (i, e) {
        setTimeout(function () {
          $(e).addClass("show");
        }, i * 100);
      });
    })
    .on("mouseleave", ".like-btn", function () {
      $(".reaction-icon").removeClass("show");
    });

  $(document).on("click", ".refresh_suggestion", function (e) {
    e.preventDefault();
    load_friend_suggestions();
  });

  $(document).on("click", ".greeting_close", function (e) {
    e.preventDefault();
    var that = $(this);

    that.parents(".greetings_message").slideUp();
    document.cookie =
      "greetingClosed=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
  });

  $(document).on("click", ".post-btn", function () {
    var that = $(this);
    var text = $(".txt_msg").val();
    // if (text == "") {
    //   //alert("Please enter some text");
    //   showAlert("Please enter some text", "Empty Post", "warning");
    //   return;
    // }
    var privacy = $("#postprivacy").val();
    var location = $(".location_input").val();
    var bgclr = $("#bgclr").val();
    var location = $(".location_input").val();

    var formData = new FormData();
    formData.append("post_text", text);
    formData.append("privacy", privacy);
    formData.append("post_location", location);

    formData.append("bg_color", bgclr);
    formData.append("get_html", 1);

    postPhotos.forEach(function (file) {
      formData.append("images[]", file.file);
    });

    if (postVideo.length > 0) {
      formData.append("video", postVideo[0]);
    }

    if (postAudio.length > 0) {
      formData.append("audio", postAudio[0]);
    }

    const post_holder = $("#post_holder");
    if (post_holder.data("post_type") !== undefined) {
      let post_type = post_holder.data("post_type");
      let tid = post_holder.data("post_tid");

      if (post_type === "group") {
        formData.append("group_id", tid);
      }
      if (post_type === "page") {
        formData.append("page_id", tid);
      }
    }

    // Optional: Check if any files have been added
    if (postPhotos.length === 0) {
      // Handle the case when no files are selected
      console.log("No files selected.");
      // If you want to prevent submission without files, uncomment the next line
      // return;
    }

    // Log FormData contents for debugging
    for (var pair of formData.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }

    $.ajax({
      type: "post",
      url: site_url + "web_api/post/create",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      beforeSend: function () {
        that.prop("disabled", true); // Disable the button
        that.html(
          '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Posting...'
        );
      },
      success: function (response) {
        $(".txt_msg").val("");
        $(".location_input").val("");
        postPhotos = [];
        postVideo = [];
        postAudio = [];
        reset_upload();
        initPostPlugins();
        removeHighlightPost();
        $("#post_holder").prepend(response.data);
        initPostPlugins();
        $("html,body").animate(
          { scrollTop: $("#post_holder").offset().top - 70 },
          "slow",
          function () {}
        );
      },
      error: function (xhr, status, error) {
        console.error("Error occurred: " + error);
        Swal.fire({
          text:translations.input_required,            
          icon: "success",
          showconfirmButton:false,
          confirmButtonColor: "#3085d6",      
          confirmButtonText: translations.ok,
          
        });
      },
      complete: function () {
        that.html("Post"); // Reset button text
        that.prop("disabled", false); // Enable the button
      },
    });
  });
  $(document).on("click", ".privacy", function (e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag
    let that = $(this);
    let postCard = that.closest(".post_card");
    var privacy = that.data("privacy");
    let postId = postCard.data("pstid");

    $.ajax({
      type: "POST",
      url: site_url + "web_api/post/change-privacy",
      data: { privacy: privacy, post_id: postId },
      dataType: "json",
      success: function (response) {
        alert(response.message);
        // Update the privacy icon after a successful AJAX request
        let privacy_icon = that.closest(".dropdown").find(".privacy_icon i");

        if (privacy === 1) {
          privacy_icon
            .attr("title", translations.public_post)
            .removeClass()
            .addClass("bi bi-globe");
        } else if (privacy === 2) {
          privacy_icon
            .attr("title", translations.friends)
            .removeClass()
            .addClass("bi bi-people-fill");
        } else if (privacy === 3) {
          privacy_icon
            .attr("title", translations.only_me)
            .removeClass()
            .addClass("bi bi-person-fill");
        } else if (privacy === 4) {
          privacy_icon
            .attr("title", translations.family)
            .removeClass()
            .addClass("bi bi-person-hearts");
        } else if (privacy === 5) {
          privacy_icon
            .attr("title", translations.business)
            .removeClass()
            .addClass("bi bi-briefcase-fill");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error occurred: " + error);
        showAlert(translations.error_occurred);
      },
    });
  });

  //adding comment

  $(document).on("click", ".add_comment", function (e) {
    e.preventDefault();

    let commentButton = $(this);
    let postCard = commentButton.closest(".post_card");
    let textarea = commentButton.siblings("textarea");
    let commentText = textarea.val().trim();

    if (commentText === "") {
        alert(translations.please_enter_some_text);
        return;
    }

    let postId = postCard.data("pstid");
    let postData = {
        comment_text: commentText,
        post_id: postId,
    };

    // Clear the textarea after getting the value
    textarea.val("");

    $.ajax({
        type: "POST",
        url: site_url + "web_api/post/comments/add?get_html=1",
        data: postData,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.code == 200 && response.data) {
                postCard.find(".comments_holder").append(response.data).slideDown();
                postCard
                    .find(".cmnt_count")
                    .html(parseInt(postCard.find(".cmnt_count").html()) + 1);
            } else {
                // Handle non-successful responses
                showAlert(translations.comment_not_added + ": " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error occurred: " + error);
            showAlert(translations.error_adding_comment);
        },
    });
  });

  //adding comment
  $(document).on("click", ".load_comments", function (e) {
    e.preventDefault();

    let commentButton = $(this);
    let postCard = commentButton.closest(".post_card");

    let postId = postCard.data("pstid");
    let postData = {
      post_id: postId,
    };

    // Clear the textarea after getting the value
    $(".textarea").val("");

    $.ajax({
      type: "GET",
      url: site_url + "web_api/post/comments/getcomment",
      data: postData,
      dataType: "json",
      success: function (response) {
        if (response.code == 200 && response.data) {
          postCard.find(".comments_holder").append(response.data).slideDown();
        } else {
          // Handle non-successful responses
          showAlert(response.message);
        }
        (" +noti.text +");
      },
      error: function (xhr, status, error) {
        console.log("Error occurred: " + error);
        showAlert("Comment not exist on this post");
      },
    });
  });

  $(document).on("click", ".send_frnd_req", function (e) {
    e.preventDefault();
    var that = $(this);
    var fr_id = that.data("uid");

    var post_data = {
      friend_two: fr_id,
    };
    $.ajax({
      type: "POST",
      url: site_url + "web_api/make-friend",
      data: post_data,
      dataType: "json",
      success: function (response) {
        if (response.ispending == 1) {
          showAlert(response.message, translations.friend_request_status, "success");
          that
            .removeClass("btn-primary-soft")
            .addClass("btn-primary")
            .html('<i class="bi bi-person-check-fill"></i>');
        } else {
          showAlert(response.message, translations.friend_request_status, "success");

          that
            .addClass("btn-primary-soft")
            .removeClass("btn-primary")
            .html('<i class="fa-solid fa-plus"></i>');
        }
      },
    });
  });

  $(document).on("click", ".like_action .add_reaction", function (event) {
    event.preventDefault();

    let likeButton = $(this);

    let reaction_type = likeButton.data("reactiontype");
    let postCard = likeButton.closest(".post_card");

    if (postActionRequest == true) {
      showAlert("Please wait for the current process to finish");
      $(".reaction-icon").removeClass("show");
      return;
    }
    postActionRequest = true; // Set the flag

    let postId = postCard.data("pstid");
    let isLiked = postCard.find(".like_action").hasClass("active");
    $(".reaction-icon").removeClass("show");

    let likeCount = likeButton.find(".like_count");
    let top_like_count = postCard.find(".top_reaction_count");
    let currentCount = parseInt(top_like_count.text(), 10) || 0;
    let reactionTypeClass = likeButton.attr("class").split(" ")[1];
    let currentStatusIcon = postCard.find(".reaction-icon.visible");

    currentStatusIcon
      .removeClass("like love haha wow sad angry")
      .addClass(reactionTypeClass)
      .show();
    likeButton.parents(".reaction-box").hide(); // Hide the reaction box
    postCard.find(".like-btn").find(".nav-link").removeClass("nav-link");
    postCard.find(".first_action").hide();
    postCard.find(".add_reaction").show();

    // Update the button state and count only if not liked before
    if (!isLiked) {
      postCard.find(".like_action").addClass("active");
      // likeText.text("Liked");
      currentCount += 1; // Increment count
    }

    likeCount.text(currentCount);
    top_like_count.text(currentCount);

    // Prepare post data
    let postData = {
      post_id: postId,
      action: "reaction",
      reaction_type: reaction_type,
    };

    $.ajax({
      type: "POST",
      url: site_url + "web_api/post/action",
      data: postData,
      dataType: "json",
      success: function (response) {
        postActionRequest = false;
        if (response.code === 200) {
          alert(response.message);
        }
      },
      complete: function () {
        postActionRequest = false;
      },
    });
  });

  //unlike post
  $(document).on("click", ".like_action .add_reaction_one ", function (event) {
    event.preventDefault();

    let likeButton = $(this);
    let postCard = likeButton.closest(".post_card");

    if (!postCard.find(".like_action").hasClass("active")) {
      $(".like_action .add_reaction").first().trigger("click");
      return;
    }

    // Guard against rapid multiple interactions
    if (postActionRequest == true) {
      showAlert(translations.process_in_progress);
      return;
    }
    $(".reaction-icon").removeClass("show");
    postActionRequest = true;

    let currentCountElement = postCard.find(".top_reaction_count");
    let currentCount = parseInt(currentCountElement.text(), 10) || 0;

    // Ensure count doesn't go negative due to rapid clicks or other issues
    let newCount = Math.max(0, currentCount - 1);

    // Update the UI to reflect the removal of the reaction
    postCard.find(".reaction-icon.visible").hide();
    postCard
      .find(".add_reaction_one")
      .removeClass("active")
      .addClass("nav-link");
    postCard.find(".like_count, .top_reaction_count").text(newCount);
    postCard.find(".first_action").show().addClass("nav-link pb-0");

    // Prepare data for the server request
    let postData = {
      post_id: postCard.data("pstid"),
      action: "reaction",
      reaction_type: "0", // Indicate removal of reaction
    };

    // Perform the request to update the server about the reaction change
    $.ajax({
      type: "POST",
      url: site_url + "web_api/post/action",
      data: postData,
      dataType: "json",
      success: function (response) {
        if (response.code !== 200) {
          console.error(translations.failed_to_update_reaction, response.message);
          // Consider reverting UI changes here if needed
        }
        postActionRequest = false;
      },
      complete: function () {
        // Allow new interactions
        postActionRequest = false;
      },
    });
  });

  $(document).on("click", ".award_coc", function (event) {
    event.preventDefault();

    let cocBtn = $(this);
    if (cocBtn.data("requestInProgress")) return; // Prevents rapid clicks

    let postCard = cocBtn.closest(".post_card");
    let postId = postCard.data("pstid");
    cocBtn.addClass("active");

    // Prepare post data
    let postData = {
      post_id: postId,
    };

    cocBtn.data("requestInProgress", true); // Set the flag

    // AJAX request
    $.ajax({
      type: "POST",
      url: site_url + "web_api/get-balance",
      data: postData,
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.code === 200) {
          alert(response.message);
        }
      },
      complete: function () {
        setTimeout(() => {
          cocBtn.data("requestInProgress", false);
        }, 2000); // Reset the flag
      },
    });
  });

  $(document).on("click", ".first_action", function (event) {
    var that = $(this);
    that
      .parent()
      .removeClass("nav-link")
      .find(".reaction-box .like ")
      .trigger("click");
    that.hide();
  });

  $(document).on("click", ".advertisement_btn", function () {
    var form = `<div class="advertisement_form m-2">      
                    <div class="card card-body">
                        <h4>${translations.boost_visibility_heading}</h4>
                        <p class="bg-warning p-2"><small>${translations.advertisement_description}</small></p>
                        <form class="advertisement-form">
                            <div class="mb-3">
                                <label for="title" class="form-label">${translations.title_label}</label>
                                <input type="text" required="required" class="form-control" name="title" placeholder="${translations.title_placeholder}">
                            </div>
                            <div class="mb-3">
                                <label for="link" class="form-label">${translations.link_label}</label>
                                <input type="url" required="required" class="form-control" name="link" placeholder="${translations.link_placeholder}">
                            </div>
                            <div class="mb-3">
                                <label for="body" class="form-label">${translations.body_label}</label>
                                <textarea class="form-control" name="body" rows="3" required="required" placeholder="${translations.body_placeholder}"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">${translations.image_label}</label>
                                <input type="file" class="form-control" required="required" name="image">
                                <small>${translations.image_recommended_size}</small>
                            </div>
                            <button type="submit" class="btn btn-primary">${translations.submit_button}</button>
                        </form>
                    </div>
                </div>`;

    $(this).closest(".advertisement_Section").html(form);
  });

  // Handle form submission
  $(document).on("submit", ".advertisement-form", function (event) {
    event.preventDefault();

    let formData = new FormData(this); // Change here: Use 'this' to refer to the form
    let submitUrl = site_url + "web_api/post/add-advertisement"; // Use your server URL

    let postCard = $(this).closest(".post_card"); // Ensure this targets the correct element
    let postId = postCard.data("pstid"); // Make sure 'pstid' is correctly set in your HTML

    formData.append("post_id", postId); // Add post ID to the form data

    // AJAX POST request
    $.ajax({
      type: "POST",
      url: submitUrl,
      data: formData,
      processData: false, // tell jQuery not to process the data
      contentType: false, // tell jQuery not to set contentType
      dataType: "json",
      success: function (response) {
      
        if (response.code == 200) {
          Swal.fire({
            text:translations.form_submitted_successfully,            
            icon: "success",
            showconfirmButton:false,
            confirmButtonColor: "#3085d6",      
            confirmButtonText: translations.ok,
            
          })
          $(".advertisement_form").slideUp();
        }
      },
      error: function (xhr, status, error) {
        console.error(translations.error_occurred + ": " + error);
      },
    });
  });

  $(document).on("input", ".autoresizing", function () {
    $(this).height("auto");
    $(this).height(this.scrollHeight);
  });

  // Delegate the keydown event for form submission on Enter
  $(document).on("keydown", ".autoresizing", function (e) {
    if (e.key === "Enter" && !e.shiftKey && !e.ctrlKey) {
      e.preventDefault();
      var that = $(this);
      that.next(".add_comment").trigger("click");
    }
  });

  $(document).on("click", ".edit_post", function (event) {
    event.preventDefault();
    var that = $(this);
    var post_text = that.data("post_text");
    $("#edit_post_id").val(that.data("post_id"));
    $("#edit_post_text").val(post_text);
  });
  $(document).on("click", "#update_post", function (event) {
    event.preventDefault();
    var that = $(this);
    let post_id = $("#edit_post_id").val();
    let update_text = $("#edit_post_text").val();
    if (update_text == null || update_text == "") {
      Swal.fire({
        title: "error",
        icon: "error",
        html: "Post text can not be empty",
        timer: 80000,
        timerProgressBar: true,
      });
      return false;
    }
    $.ajax({
      type: "post",
      url: site_url + "web_api/post/update-post",
      data: { post_id: post_id, post_text: update_text },
      success: function (response) {
        if (response.status == 200) {
          Swal.fire({
            title: "success",
            icon: "success",
            html: response.message,
            timer: 4000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.icon = "success";
              const timer = Swal.getPopup().querySelector("b");
              timerInterval = setInterval(() => {
                timer.textContent = `${Swal.getTimerLeft()}`;
              }, 4000);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            window.location.reload();
          });
        }
      },
    });
  });

  $(document).on("click", ".post_action", function (event) {
    event.preventDefault();

    let that = $(this);

    if (that.data("requestInProgress")) return; // Prevents rapid clicks

    let postAction = that.data("pst_action");
    let postCard = that.closest(".post_card");
    let postId = postCard.data("pstid");
    let confrimation = 1;
    

    Swal.fire({
      title: translations.confirm_action,

      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: translations.no,

      confirmButtonText: translations.yes,
    }).then((result) => {
      if (result.isConfirmed) {
        let postData = {
          post_id: postId,
          action: postAction,
        };

        that.data("requestInProgress", true); // Set the flag
        if(postAction=='delete')
          {
            postCard.slideUp().remove();
          }
        // AJAX request
        $.ajax({
          type: "POST",
          url: site_url + "web_api/post/action",
          data: postData,
          dataType: "json",
          success: function (response) {
            showAlert(response.message, translations.post_action, 'success');
            let listItem = that.closest("li");
            let savePostButton = listItem.find(
              '.post_action[data-pst_action="save"]'
            );
            
            if (response.code == 200) {
              if (response.action == "saved_post") {
                if (response.type == 0) {
                  savePostButton.html(
                    "<i class='bi bi-bookmark fa-fw pe-2'></i> " + translations.save_post
                  );
                } else {
                  savePostButton.html(
                   '<i class="bi bi-bookmark-fill"></i> ' + translations.unsave_post
                  );
                }
              }

              if (response.action == "delete") {
                postCard.slideUp().remove();
              }
            }
            let disableComment = listItem.find(
              '.post_action[data-pst_action="disablecomments"]'
            );

            if (response.code == 200) {
              if (response.action == "disablecomments") {
                if (response.type == 0) {
                  disableComment.html(
                      "<i class='bi bi-check-circle fa-fw pe-2'></i> " + translations.enable_comments
                  );
              } else {
                  disableComment.html(
                      "<i class='bi bi-slash-circle fa-fw pe-2'></i> " + translations.disable_comments
                  );
              }
                window.location = window.location.href;
              }
              if (response.action == "delete") {
               
                var postCountText = $(".total_post_count").text();
                var postCount = parseInt(postCountText);
                
                postCount--;
                
                $(".total_post_count").text(postCount);
                
              }
              
            }
          },
          complete: function () {
            setTimeout(() => {
              that.data("requestInProgress", false);
            }, 2000); // Reset the flag
          },
        });
      }
    });
  });

  $(document).on("click", ".comment_like_action", function (event) {
    event.preventDefault();

    let likeButton = $(this);
    if (likeButton.data("requestInProgress")) return; // Prevents rapid clicks

    let commentItem = likeButton.closest(".comment-item");
    let commentId = commentItem.data("commentid"); // Assuming a data attribute for comment ID
    let isLiked = likeButton.hasClass("active");
    let likeText = likeButton.find(".like_txt");
    let likeCount = likeButton.find(".like_count");
    let currentCount = parseInt(likeCount.text(), 10);

    let postCard = likeButton.closest(".post_card");
    let postId = postCard.data("pstid");

    // Toggle the like status
    if (isLiked) {
      likeButton.removeClass("active");
      likeText.text(translations.like);
      likeCount.text(currentCount - 1);
    } else {
      likeButton.addClass("active");
      likeText.text(translations.liked);
      likeCount.text(currentCount + 1);
    }

    // Prepare post data for comment like
    let postData = {
      comment_id: commentId,
      action: "reaction",
      reaction_type: 1,
      post_id: postId,
    };

    likeButton.data("requestInProgress", true); // Set the flag

    // AJAX request for comment like
    $.ajax({
      type: "POST",
      url: site_url + "web_api/post/comments/like",
      data: postData,
      dataType: "json",
      success: function (response) {
        if (response.code === 200) {
          alert(response.message);
        }
      },
      complete: function () {
        likeButton.data("requestInProgress", false); // Reset the flag
      },
    });
  });

  //read more on post
  $(document).on("click", ".read-more", function (event) {
    // Find the associated full text and toggle it
    $(this).siblings(".short-text").hide();
    $(this).siblings(".full-text").slideToggle();

    // Change the text of the link accordingly
    $(this).text($(this).text() == translations.read_more ? translations.read_less : translations.read_more);
  });

  $(document).on("click", ".reply_comment_action", function (e) {
    e.preventDefault();

    let replyButton = $(this);
    let commentItem = replyButton.closest(".comment-item");
    let commentId = commentItem.data("commentid"); // Ensure each comment has a unique ID

    // Check if reply box already exists
    if (commentItem.find(".reply-box").length === 0) {
      let replyBoxHtml =
        '<div class="d-flex p-3"><div class="avatar avatar-xs me-2"></div><div class="reply-box w-100 mt-2">' +
        '<textarea class="form-control mb-2" placeholder="' + translations.write_reply_placeholder + '"></textarea>' +
            '<button class="btn btn-primary btn-sm submit_reply" type="button">' + translations.submit_reply + '</button>' +
        "</div></div>";
      commentItem.append(replyBoxHtml);
    }
  });

  $(document).on("click", ".delete_comment_action", function (e) {
    e.preventDefault();

    let replyButton = $(this);
    let commentItem = replyButton.closest(".comment-item");
    let commentId = commentItem.data("commentid"); // Ensure each comment has a unique ID
  });

  $(document).on("click", ".submit_reply", function (e) {
    e.preventDefault();
    let submitButton = $(this);
    let commentItem = submitButton.closest(".comment-item");
    let commentId = commentItem.data("commentid");
    let replyText = submitButton.siblings("textarea").val().trim();

    if (replyText === "") {
      showAlert("Please enter a reply", "Text Required", "error");
      return;
    }

    let postData = {
      comment_id: commentId,
      reply_text: replyText,
    };

    // Clear the textarea after getting the value
    submitButton.siblings("textarea").val("");

    $.ajax({
      type: "POST",
      url: site_url + "web_api/post/comments/reply",
      data: postData,
      dataType: "json",
      success: function (response) {
        if (response.data) {
          // Create the <li> element for each reply
          var replyItem = `
                <li class="reply-item" data-reply_item="${response.data.id}">
                    <div class="d-flex">
                        <!-- Avatar -->
                        <div class="avatar avatar-xs">
                            <a href="#!"><img class="avatar-img border rounded-circle" src="${
                              response.data.avatar
                            }" alt=""></a>
                        </div>
                        <!-- Comment by -->
                        <div class="ms-2">
                            <div class="bg-light p-2 rounded commentdata">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1"> <a href="${
                                      response.data.username
                                    }">${response.data.first_name} ${
            response.data.last_name
          }</a> </h6>
                                    <small class="ms-2">${
                                      response.data.created_human
                                    }</small>
                                </div>
                                <p class="small mb-0">${
                                  response.data.comment
                                }</p>
                            </div>
                            <!-- Comment react -->
                            <ul class="nav nav-divider pt-2 small">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 ${
                                      response.data.reaction.is_reacted
                                        ? "active"
                                        : ""
                                    } comment_like_action" href="#!">
                                        <i class="bi bi-hand-thumbs-up pe-1"></i>
                                        ${
                                          response.data.reaction.is_reacted
                                            ? '<span class="like_txt">Liked</span>'
                                            : '<span class="like_txt">Like</span>'
                                        }
                                        (<span class="like_count">${
                                          response.data.like_count
                                        }</span>)
                                    </a>
                                </li>
                               
                                <li class="nav-item">
                                  <a class="nav-link delete_commentreply" href="#!" data-reply_id="${
                                    response.data.id
                                  }">  Delete</a>
                              </li>
                            
                                <!-- Add other elements as needed -->
                            </ul>
                        </div>
                    </div>
                </li>
            `;

          // Append the <li> element to the <ul>
          commentItem.find(".reply_list_main").append(replyItem);

          console.log(replyItem);

          // commentItem.closest('.replylist').append(replydata); // Assuming the server response includes the HTML for the new reply
        } else {
          alert(response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error occurred: " + error);
        alert("An error occurred while posting the reply.");
      },
    });
  });

  $(document).on("click", ".photos_link", function (e) {
    e.preventDefault();
    postVideo = [];
    $(".location_posting").hide();
    $(".video_posting").hide();
    $(".audio_posting").hide();
    $(".image_posting")
      .removeClass("d-none")
      .slideDown(function () {
        initializeImageUploader();
      });
  });

  $(document).on("click", ".video_link", function (e) {
    e.preventDefault();

    $(".image_posting").hide();
    $(".location_posting").hide();
    $(".audio_posting").hide();
    $(".video_posting")
      .removeClass("d-none")
      .slideDown(function () {
        initializeVideoUploader();
      });
  });

  $(document).on("click", ".audio_link", function (e) {
    e.preventDefault();

    $(".image_posting").hide();
    $(".location_posting").hide();
    $(".video_posting").hide();
    $(".audio_posting")
      .removeClass("d-none")
      .slideDown(function () {
        initializeAudioUploader();
      });
  });

  $(document).on("click", ".location_link", function (e) {
    $(".image_posting").hide();

    $(".video_posting").hide();

    e.preventDefault();
    if ($(".location_posting").hasClass("d-none")) {
      $(".location_posting").removeClass("d-none").slideDown();
    } else {
      $(".location_posting").slideToggle();
    }
  });
}); //document ready ends

winprevScroll = 0;
$(window).on("scroll", function () {
  if ($(".single_post").length == 0) {
    var docheight = $(window).scrollTop() + $(window).height();
    if (docheight < 700) {
      var MinusNumber = 600;
    } else if (docheight < 3600) {
      var MinusNumber = 1800;
    } else {
      var MinusNumber = 3000;
    }

    var remainHeight = $(document).height() - MinusNumber;
    // console.log(remainHeight);
    if (docheight > remainHeight && scroll_loading == false) {
      if (!$("body").hasClass("single_post")) {
        if ($("#post_holder").find(".mloader1").length == 0) {
          $("#post_holder").append(mloader1);
        }

        get_all_posts(6);
      }
    }
    ///=============================================
    /// Video start stop on scroll
    var tolerancePixel = $("body").offset().top;
    // Get current browser top and bottom
    var bottHeight = $(window).height();
    var winScrollTop = $("body").scrollTop();
    var media = $(".jwplayer");

    winprevScroll = winScrollTop;
  }
});

$(document).on("click", "#sharepost", function (event) {
  let that = $(this);
  let postId = that.data("pstid");
  $("#share_post_id").val(postId);
});

$(document).on("click", ".deletecomment", function (event) {
  event.preventDefault();
  let that = $(this);

  let submitUrl = site_url + "web_api/post/comments/delete";
  let postCard = that.closest(".post_card");
  // Extract comment_id from data attribute
  let comment_id = that.data("comment_id");

  // Prepare comment data
  let commentData = {
    comment_id: comment_id,
  };

  // AJAX POST request
  $.ajax({
    type: "POST",
    url: submitUrl,
    data: commentData,
    dataType: "json",
    success: function (response) {
      console.log(response);
      if (response.code == 200) {
    
      
      // Example usage
      showAlert(translations.comment_deleted_success);
      
        that.closest(".comment-item").remove();
        postCard.find(".comments_holder").append(response.data).slideDown();
        postCard
          .find(".cmnt_count")
          .html(parseInt(postCard.find(".cmnt_count").html()) - 1);
      }
    },
    error: function (xhr, status, error) {
      console.error("An error occurred: " + error);
    },
  });
});
$(document).on("click", ".delete_commentreply", function (event) {
  event.preventDefault();
  let that = $(this);
  let submitUrl = site_url + "web_api/post/comments/replies/delete";
  let postCard = that.closest(".post_card");

  let reply_id = that.data("reply_id");

  // Prepare comment data
  let replyData = {
    reply_id: reply_id,
  };
  $.ajax({
    type: "POST",
    url: submitUrl,
    data: replyData,
    dataType: "json",
    success: function (response) {
      console.log(response);
      if (response.code == 200) {
        showAlert(response.message);
        that.closest(".reply-item").remove();
        postCard.find(".comments_holder").append(response.data).slideDown();
        postCard
          .find(".replycount")
          .html(parseInt(postCard.find(".replycount").html()) - 1);
      }
    },
    error: function (xhr, status, error) {
      console.error("An error occurred: " + error);
    },
  });
});
$(document).on("click", ".vote_the_option", function (event) {

  event.preventDefault();

  let that = $(this);
  let submitUrl = site_url + "web_api/post/poll-vote";
  let poll_id = that.data("poll_id");
  let poll_option_id = that.data("poll_option_id");
  let is_voted = that.data("is_voted");
  if(is_voted==1)
  {
    showAlert(translations.already_voted_cant_vote_again,translations.warning)
    return;
  }
  let replyData = {
    poll_id: poll_id,
    poll_option_id
  };
  $.ajax({
    type: "POST",
    url: submitUrl,
    data: replyData,
    dataType: "json",
    success: function (response) {

      if (response.status == 200) {
        showAlert(response.message,"Success",'success');
        setTimeout(function() {
          window.location.reload();
      }, 5000);
      }
      else{
        showAlert(response.message,"Warning",'warning');
      }
    },
    
  });
});
// Function to check if a cookie exists
function getCookie(name) {
  var cookies = document.cookie.split(";");
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i].trim();
    if (cookie.indexOf(name + "=") === 0) {
      return cookie.substring((name + "=").length, cookie.length);
    }
  }
  return null;
}

// Check if the greeting message should be displayed when the page loads
$(document).ready(function () {
  var greetingClosed = getCookie("greetingClosed");
  if (greetingClosed && greetingClosed === "true") {
    // Hide the greeting message if the cookie is found and its value is true
    $(".greetings_message").hide();
  }
});

$(document).on("click", ".donationbtn", function () {
  var that = $(this);
  var fund_id = that.data('fund_id');
  $('#fund_id').val(fund_id);
  $('#donationModel').modal('show');
});
$(document).on("submit", "#donatefundForm", function(event) {
  event.preventDefault();

  Swal.fire({
    title: translations.are_you_sure,
    text: translations.donation_confirmation_text,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: translations.yes_proceed,
    cancelButtonText: translations.cancel
    
}).then((result) => {
    if (result.isConfirmed) {
      // Proceed with form submission
      var form = $(this);
      $.ajax({
        type: 'post',
        url: site_url + 'web_api/donate',
        data: form.serialize(),
        success: function(response) {
          
          if (response.code == '200') {
            $('#donationModel').modal('hide');
            Swal.fire({
              text: response.message,
              icon: 'success',
              confirmButtonColor: '#3085d6',
              confirmButtonText: translations.ok,
              
          });
            // Reload the window after 5 seconds
            setTimeout(function() {
              window.location.reload();
            }, 5000);
          } else {
            Swal.fire({
              text: response.message,
              title:translations.donation_failed,
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: translations.ok,
              
          });
          }
        }
      });
    }
  });
});
$(document).on("click", ".getreactiondata", function () {
  var that = $(this);
  
  var postId = that.data('post_id');
  let postData = {
    post_id:postId,
  };

  $.ajax({
    type: 'post',
    url: site_url + 'web_api/post/get-post-reaction',
    data:postData ,
    success: function(response) {
      let responseData = response;

      // Check if data exists for each reaction
      updateTabContent('likeContent', responseData.data[1]);
      updateTabContent('loveContent', responseData.data[2]);
      updateTabContent('hahaContent', responseData.data[3]);
      updateTabContent('wowContent', responseData.data[4]);
      updateTabContent('sadContent', responseData.data[5]);
      updateTabContent('angryContent', responseData.data[6]);

      // Open the modal after updating the content
      var emojiModal = new bootstrap.Modal(document.getElementById('emojiModal'));
      emojiModal.show();
  
     
      
    }
  });
  
});
$(document).on("click", ".viewshareuser", function () {
  var that = $(this);
  
  var postId = that.data('post_id');
  let postData = {
    post_id:postId,
  };

  $.ajax({
    type: 'post',
    url: site_url + 'web_api/post/get-post-share-users',
    data:postData ,
    success: function(response) {
      let responseData = response;
      updateTabContent('angryContent', responseData.data[6]);

      // Open the modal after updating the content
      var emojiModal = new bootstrap.Modal(document.getElementById('emojiModal'));
      emojiModal.show();
  
     
      
    }
  });
  
})
function updateTabContent(tabId, data) {
  var tabContent = $('#' + tabId);
  if (data.length > 0) {
      var userList = '<ul class="list-group">';
      data.forEach(function(user) {
          userList += '<li class="list-group-item my-1 border-0">';
          userList += '<img src="' + user.avatar + '" alt="' + user.username + '" width="30" class="rounded-circle me-2">';
          userList += user.first_name + ' ' + user.last_name + ' (' + user.username + ')';
          userList += '</li>';
      });
      userList += '</ul>';
      tabContent.html(userList);
  } else {
      tabContent.html('No data found for this reaction.');
  }
}