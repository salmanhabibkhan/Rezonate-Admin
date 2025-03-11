
function change_settings_value(key, value, callback){
	
	$.ajax({
		url: site_url+'admin/api/update_settings',
		type: 'POST',
		dataType: 'json',
		data: {key, value},
	})
	.done(function(response) {
		// Call the callback function after successful update
            if (callback && typeof callback === 'function') {
                callback(response);
            }
	})
	.fail(function(response) {
		 if (callback && typeof callback === 'function') {
                callback(response);
            }
	})
	.always(function() {
		console.log("complete");
	});
}


function showError(title,msg){
	$(document).Toasts('create', {
		title: title,
		body: msg,
		position: 'bottomRight',
		autohide:true,
		class:'alert-danger'
	  })
}

jQuery(document).ready(function($) {

	//mark menu active
	$(".admin_sidebar .nav-link.active").parents('.has-treeview').addClass('menu-open');
	var currentPath = window.location.pathname.split('/').pop();

    $('.nav-sidebar a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(currentPath) !== -1){
            $this.addClass('active');
            $this.closest('.has-treeview').addClass('menu-open');
            $this.closest('.nav-treeview').prev('.nav-link').addClass('active'); // For parent nav-link
        }
    });

	//when checkbox is changed. change the value in admin
	$("body").on('change', '.settings_checkbox', function(event) {
		event.preventDefault();
		var that = $(this);
		var key = that.data('key');
		var value = that.is(":checked")?1:0;

		change_settings_value(key, value, function(res) {
				if(res.success){
				}else{
					showError('Error', res.error);
				}
		});



	});
	

	//when textbox is updated update that textbox
	$("body").on('blur', '.settings_text', function(event) {
	    event.preventDefault();
	    var that = $(this);
	    var key = that.attr('name');
	    var value = that.val();
	    that.next('small').hide();

	    // Insert message element dynamically
	    var messageBox = $('<span class="update-message">Updating value in database...</span>');
	    that.after(messageBox);
	    that.css('background-color', 'lightgreen');
    	change_settings_value(key, value, function(res) {
	       	if(res.success){
	       		messageBox.fadeOut(2000, function() { $(this).remove();  that.next('small').show(); });
	        	that.css('background-color', '');	
	       	}else{
				
					showError('Error', res.error);
				
	       		messageBox.html('<span class="update-message">'+res.error+'</span>');
	       		messageBox.fadeOut(3000, function() { $(this).remove(); that.next('small').show();	});
	        	that.css('background-color', '#fdd1ce');
	       	}
    	});
	});

	//menu opener
	$('body').on('click', '.nav-item.has-treeview > a', function(e) {
        e.preventDefault(); // Prevent default anchor behavior

        var $this = $(this); // The clicked item
        var $parent = $this.parent(); // The parent nav-item
        var $subMenu = $parent.find('.nav-treeview'); // The submenu

        // Toggle the submenu
        $subMenu.slideToggle();

        // Optionally, toggle some class for changing icons or styles
        $parent.toggleClass('menu-open');
    });




});
