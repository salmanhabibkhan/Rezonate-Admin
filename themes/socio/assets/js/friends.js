$(document).ready(function () {
    bindNavEvents();
    $('.cardtitle').html(translations.friends);
    get_friends();
});

function bindNavEvents() {
    $(".friends_tab").on("click", function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.siblings('.active').removeClass('active');
        $this.addClass('active');
        var action = $this.attr('class').split(' ')[2];
        switch(action) {
            case 'fr_lists':
                get_friends();
                $('.cardtitle').html(translations.friends);
                break;
            case 'fr_request':
                $('.cardtitle').html(translations.friend_requests);
                get_friend_request();
                break;
            case 'fr_suggesions':
                $('.cardtitle').html(translations.suggestions);
                get_friends_suggsions();
                break;
            case 'fr_sent':
                $('.cardtitle').html(translations.sent_requests);
                sent_friend_request();
                break;
            default:
                console.error(translations.error);
        }
    });
}
$('.searchformbuttton').on("click", function (e) {
    e.preventDefault();
    var action = $('.friends_search_tab .active').data('crtab');       
    switch(action) {
        case 'fr_lists':
            get_friends();
            $('.cardtitle').html(translations.friends); // Use translation or fallback
            break;
        case 'fr_request':
            $('.cardtitle').html(translations.friend_requests); // Use translation or fallback
            get_friend_request();
            break;
        case 'fr_suggesions':
            $('.cardtitle').html(translations.suggestions); // Use translation or fallback
            get_friends_suggsions();
            break;
        case 'fr_sent':
            $('.cardtitle').html(translations.sent_requests); // Use translation or fallback
            sent_friend_request();
            break;
        default:
            console.error(translations.error);
    }
});

function compile_friends(friends_array) {
    let html = '';
    $.each(friends_array, function (index, friend) { 
        
        html += `<div class="d-md-flex align-items-center friend_item mb-4">
                    <div class="avatar me-3 mb-3 mb-md-0">
                        <a href="` + site_url + `/` + friend.username + `"> <img class="avatar-img rounded-circle" src="${friend.avatar}" alt="${friend.first_name}"> </a>
                    </div>
                    <div class="w-100">
                        <div class="d-sm-flex align-items-start">
                            <h6 class="mb-0"><a href="` + site_url + `/` + friend.username + `">${friend.first_name} ${friend.last_name}</a></h6>
                        </div>
                        <ul class="avatar-group mt-1 list-unstyled align-items-sm-center">
                            <li class="small">${friend.details.mutualfriendsCount} ${translations.mutual_friends}</li>
                        </ul>
                    </div>
                    <div class="ms-md-auto d-flex w-100 mr-1">`;
                    html += `<select class="form-select friends_privacy me-2" data-user_id="${friend.id}" >`;
                        html += `<option value="2" ${friend.role === '2' ? 'selected="selected"' : ''}>${translations.friends}</option>`;
                        html += `<option value="3" ${friend.role === '3' ? 'selected="selected"' : ''}>${translations.family}</option>`;
                        html += `<option value="4" ${friend.role === '4' ? 'selected="selected"' : ''}>${translations.business}</option>`;
                    html += `</select>`;
            html += `<button data-user_id="${friend.id}" class="btn btn-primary-soft btn-sm mb-0 me-2 unfriend" >${translations.unfriend}</button>`;
        html += `</div></div>`;
    });
    return html;
}

function compile_suggestions(friends_array) {
    let html = '';
    $.each(friends_array, function (index, friend) { 
        html += `<div class="d-md-flex align-items-center friend_suggetion mb-4">
                    <div class="avatar me-3 mb-3 mb-md-0">
                        <a href="` + site_url + `/` + friend.username + `">
                            <img class="avatar-img rounded-circle" src="${friend.avatar}" alt="${friend.first_name}">
                        </a>
                    </div>
                    <div class="w-100">
                        <div class="d-sm-flex align-items-start">
                            <h6 class="mb-0">
                                <a href="` + site_url + `/` + friend.username + `">${friend.first_name} ${friend.last_name}</a>
                            </h6>
                        </div>
                        <ul class="avatar-group mt-1 list-unstyled align-items-sm-center">
                            <li class="small">${friend.details.mutualfriendsCount} ${translations.mutual_friends}</li>
                        </ul>
                    </div>
                    <div class="ms-md-auto d-flex">`;

        if (friend.ispending == 1) {
            html += `<button data-user_id="${friend.id}" class="btn btn-secondary-soft btn-sm mb-0 me-2 cancel_req">
                        <i class="bi bi-person-dash"></i> ${translations.cancel_request}
                     </button>`;
        } else {
            html += `<button data-user_id="${friend.id}" class="btn btn-primary-soft btn-sm mb-0 me-2 send_req">
                        <i class="bi bi-person-plus"></i> ${translations.add_friend}
                     </button>`;
        }
        
        html += `</div></div>`;
    });
    return html;
}

function compile_get_requests(friends_array) {
    let html = '';
    $.each(friends_array, function (index, friend) { 
        html += `<div class="d-md-flex align-items-center get_request_item mb-4">
                    <div class="avatar me-3 mb-3 mb-md-0">
                        <a href="` + site_url + `/` + friend.username + `"> <img class="avatar-img rounded-circle" src="${friend.avatar}" alt="${friend.first_name}"> </a>
                    </div>
                    <div class="w-100">
                        <div class="d-sm-flex align-items-start">
                            <h6 class="mb-0"><a href="` + site_url + `/` + friend.username + `">${friend.first_name} ${friend.last_name}</a></h6>
                        </div>
                        <ul class="avatar-group mt-1 list-unstyled align-items-sm-center">
                            <li class="small">${friend.details.mutualfriendsCount} ${translations.mutual_friends}</li>
                        </ul>
                    </div>
                    <div class="ms-md-auto d-flex">`;
        
            html += `<button data-user_id="${friend.id}" class="btn btn-primary-soft btn-sm mb-0 accept_req me-2 ">${translations.accept}</button>`;
            html += `<button data-user_id="${friend.id}" class="btn btn-danger-soft btn-sm mb-0  me-2 delete_request">${translations.delete}</button>`;
        html += `
                    </div>
                </div>`;
    });
    return html;
}

function nodata_html(msg){
    return `<div class="row">
                <div class="my-sm-5 py-sm-5 text-center">
                    <i class="display-1 text-body-secondary bi bi-people"></i>
                    <h4 class="mt-2 mb-3 text-body">`+msg+`</h4>
                </div>
            </div>`;
}

function get_friends() {
    $(".socio_loader").show();
    var keyword = $('#keyword').val();
    var gender = $('#gender').val();
    var relation = $('#relation').val();
    $.ajax({
        type: "post",
        url: site_url + "web_api/get-friends",
        dataType: "json",
        data:{ keyword:  keyword,gender:gender,relation:relation} ,
        success: function (res) {
            if(res.data != ''){
                var htmlFriends = compile_friends(res.data,'friends');
            }else{
                var htmlFriends = nodata_html(res.message);
            }
            $("#friends_holder").html(htmlFriends);
        },
        complete: function(){
            $(".socio_loader").hide();
        }
    });
}

function get_friend_request() {
    $(".socio_loader").show();
    $.ajax({
        type: "post",
        url: site_url + "web_api/friend-requests",
        dataType: "json",
        success: function (res) {
            if(res.data != ''){
                var htmlFriends = compile_get_requests(res.data);
            }else{
                var htmlFriends = nodata_html(res.message);
            }
            $("#friends_holder").html(htmlFriends);
        },
        complete: function(){
            $(".socio_loader").hide();
        }
        
    });
}

function sent_friend_request() {
    $(".socio_loader").show();
    $.ajax({
        type: "post",
        url: site_url + "web_api/get-sent-requests",
        dataType: "json",
        success: function (res) {
            if(res.data != ''){
                var htmlFriends = compile_suggestions(res.data);
            }else{
                var htmlFriends = nodata_html(res.message);
            }
            $("#friends_holder").html(htmlFriends);
        },
        complete: function(){
            $(".socio_loader").hide();
        }
    });
}

function get_friends_suggsions() {
    $(".socio_loader").show();
    var keyword = $('#keyword').val();
    var gender = $('#gender').val();
    var relation = $('#relation').val();
    $.ajax({
        type: "post",
        url: site_url + "web_api/fetch-recommended",
        dataType: "json",
        data:{ keyword:keyword,gender:gender,relation:relation} ,
        success: function (res) {
            if(res.data != ''){
                var htmlFriends = compile_suggestions(res.data);
            }else{
                var htmlFriends = nodata_html(res.message);
            }
            $("#friends_holder").html(htmlFriends);
        },
        complete: function(){
            $(".socio_loader").hide();
        }
    });
}

$(document).on('click',".ignore_req", function () {
    $(this).parents('.friend_item').slideUp();
});

$(document).on('click',".cancel_req", function () {
    var that = $(this);
    that.html(translations.canceling_request);
    that.removeClass('cancel_req');
    var user_id = that.data('user_id');
    $.ajax({
        type: "post",
        url: site_url + "web_api/make-friend",
        dataType: "json",
        data:{friend_two:user_id},
        success: function (response) {
            that.addClass('send_req');
            that.html('<i class="bi bi-person-plus-fill pe-1"></i> ' + translations.add_friend);
            that.removeClass('btn-secondary-soft').addClass('btn-primary-soft');
        },
        error:function(){
            that.html('<i class="bi bi-person-plus-fill pe-1"></i> ' + translations.add_friend);
        }
    });
});
$(document).on('change',".friends_privacy", function () {
    var that = $(this);
    var role = that.val();
    var user_id = that.data('user_id');
    $.ajax({
        type: "post",
        url: site_url + "web_api/change-friend-role",
        dataType: "json",
        data:{user_id:user_id,role:role},
        success: function (response) {
            alert(response.message);
        },
        error:function(){
            that.html('<i class="bi bi-person-plus-fill pe-1"></i> Add Fried');
        }
    });
});
$(document).on('click',".send_req", function () {
    var that = $(this);
    that.html(translations.sending_request);
    
    var user_id = that.data('user_id');
    $.ajax({
        type: "post",
        url: site_url + "web_api/make-friend",
        dataType: "json",
        data:{friend_two:user_id},
        success: function (response) {
            if(response.ispending===0 && response.friend_status==='Not Friends')
            {
                showAlert(response.message, translations.friend_request_status, "warning");
                that.removeClass('send_req');
                that.html("<i class='bi bi-person-plus'></i> " + translations.add_friend);
            }else{
                that.addClass('cancel_req');
                that.removeClass('send_req');
                that.html(`${translations.cancel_request}`);
                that.removeClass('btn-primary-soft').addClass('btn-secondary-soft');
            }
        },
        error:function(){
            that.html('<i class="bi bi-person-plus-fill pe-1"></i> ' + translations.add_friend);
        }
    });
});
$(document).on('click',".accept_req", function () {
    var that = $(this);
    that.html(translations.accepting_request);
    that.removeClass('send_req');
    var user_id = that.data('user_id');
    var request_action = 'accept';
    $.ajax({
        type: "post",
        url: site_url + "web_api/friend-request-action",
        dataType: "json",
        data:{user_id:user_id,request_action:request_action},
        success: function (response) {
            $(that).closest('.get_request_item').remove();
        },
        error:function(){
            that.html('<i class="bi bi-person-plus-fill pe-1"></i> ' + translations.add_friend);
        }
    });
});
$(document).on('click',".delete_request", function () {
    var that = $(this);
    that.html(translations.deleting_request);
    that.removeClass('send_req');
    var user_id = that.data('user_id');
    var request_action = 'decline';
    $.ajax({
        type: "post",
        url: site_url + "web_api/friend-request-action",
        dataType: "json",
        data:{user_id:user_id,request_action:request_action},
        success: function (response) {
            $(that).closest('.get_request_item').remove();
        },
        error:function(){
            that.html('<i class="bi bi-person-plus-fill pe-1"></i> ' + translations.send_request);
        }
    });
});
$(document).on('click', ".unfriend", function () {
    var that = $(this);
    that.html(translations.sending_request); // Use translation for "Sending request"
    that.removeClass('send_req');
    var user_id = that.data('user_id');

    // Use translation for the confirmation dialog
    let confirmation = confirm(translations.unfriend_confirmation); 
    if (confirmation == true) {
        $.ajax({
            type: "post",
            url: site_url + "web_api/unfriend",
            dataType: "json",
            data: { user_id: user_id },
            success: function (response) {
                $(that).closest('.friend_item').remove();
            },
            error: function () {
                that.html('<i class="bi bi-person-plus-fill pe-1"></i> ' + translations.add_friend); // Use translation for "Add Friend"
            }
        });
    }
});

$(document).on('click',".accept_req", function () {
    var that = $(this);
    var user_id = that.data('user_id');
    $.ajax({
        type: "post",
        url: site_url + "web_api/make-friend",
        dataType: "json",
        data:{friend_two:user_id},
        success: function (response) {
        }
    });
});