$(function() {
	"use strict";
	Parse.$ = jQuery;
	Parse.initialize("9syVLvZdcJKZD9uAlCoYMKwjtmWxPHFhD4DdYKcN", "HH4p0QrjdzsO74KsoLhhhUZnPYDwExnZ8o9CCAeN"); 

	var Post = Parse.Object.extend("Post");
	
	// ************ L O G O U T *******************
	
	$("#logout_button").on('click',function(){
		Parse.User.logOut();
		console.log("Logged out now");
		$.post("ajaxPHPpages/logout.php", {'logout' : true}, function(data) {
			if(data.success == true) {
				window.location.href = "index.php";
			}
		}, 'json');			
	});	
	
	
	// ************* E M A I L   D I S P L A Y *****************
	
	function displayFolders() {
		$.post('ajaxPHPpages/email_folders.php', { 'emailFolders' : true }, function(data) {
			if(data != "Failed to load folders") {
				$("#email_folder_sidebar").html(data);				
			}
			else {
				console.log(data);
			}			
		});			
	}
	
	var currentFolder = "default";
	function displayMessages(label, folder) {
		currentFolder = folder;
		$.post('ajaxPHPpages/email_messages.php', { 'emailMessages' : true, "label" : label, "folder" : folder }, function(data) {
			if(data != "Failed to load folders") {
				$("#email_main_display_container").html(data);				
			}
			else {
				console.log(data);
			}			
		});	
	}
	
	$('body').on('click', '.folder-link', function() {
		displayMessages($(this).data('label'), $(this).data('folder'));
	});
	
	$("body").on('click', '.mailtable', function(event){
		
		console.log("Attempting to toggle message");
		
		$message=$(this).closest("table").next();
		console.log($message);
		if ($message.hasClass("hidden")){
			$message.removeClass("hidden");	
			console.log("Message Shown");
		}
		else{
			$message.addClass("hidden");
			console.log("Message hidden");
		}
	});
	
	$("body").on('click', '.removemessage', function(event){
		
		console.log("Attempting to remove message");
		
		var myobject={
			'messageid' : $(this).attr('data-messageid')	
		};
		
		$.ajax({
        	type: 'POST',
            url: 'ajaxPHPpages/remove_message.php',
            data: myobject,
            async: false,
            success: function(data) {
				console.log(data);
				console.log("Remove successful");
				//location.reload(); // refresh page.
				displayMessages(currentFolder);
            },
			error: function(error){
				console.log("Could not delete message.");
			}
        });
	});
	
	$("body").on('click', '.markread', function(event){
		
		console.log("Attempting to mark message as read");
		
		var myobject={
			'messageid' : $(this).attr('data-messageid')	
		};
		
		$seentag=$(this).parent().prev().prev();
		
		$.ajax({
        	type: 'POST',
            url: 'ajaxPHPpages/mark_read.php',
            data: myobject,
            async: false,
            success: function(data) {
				console.log(data);
				console.log("Mark read successful");
				
				
				$seentag.removeClass("unseen");	
				$seentag.addClass("seen");	
				console.log("Marked as read");
            },
			error: function(error){
				console.log("Could not mark message as read.");
			}
        });
	});

	$("body").on('click', '.remove', function(event){
		
		console.log("Attempting to remove account");
		
		var myobject={
			'label' : $(this).attr('data-label')	
		};
		
		$.ajax({
        	type: 'POST',
            url: 'ajaxPHPpages/remove_mailbox.php',
            data: myobject,
            async: false,
            success: function(data) {
				console.log(data);
				console.log("Remove successful");
				//location.reload(); // refresh page.
				displayManagementForms("manageMailboxes");
            },
			error: function(error){
				console.log("Could not delete mailbox.");
			}
        });
	});	
	
	// ************* A C C O U N T   M A N A G E M E N T   D I S P L A Y *****************
	
	function displayOptions() {
		$.post('ajaxPHPpages/account_management_options.php', { 'accountManagement' : true }, function(data) {
			if(data != "Failed to load options") {
				$("#account_management_sidebar").html(data);				
			}
			else {
				console.log(data);
			}			
		});		
	}
	
	function displayManagementForms(option) {
		if(option == "manageMailboxes") {
			$.post('ajaxPHPpages/manage_mailboxes.php', { 'manageMailboxes' : true }, function(data) {
				if(data != "Failed to load options") {
					$("#account_management_display_container").html(data);	
				}
				else {
					console.log(data);
				}			
			});
		}
		else if(option == "accountSettings") {
			// Like above, but username/first name/last name/email/security question settings page.
			$.post('ajaxPHPpages/account_settings.php', { 'accountSettings' : true }, function(data) {
				if(data != "Failed to load options") {
					$("#account_management_display_container").html(data);	
				}
				else {
					console.log(data);
				}			
			});
		}
		else if(option == "passwordSettings") {
			// Like above, but password reset page.
		}
	}	
	
	$('body').on('click', '#mailbox_management_link', function() {
		displayManagementForms("manageMailboxes");
	});
	
	$('body').on('click', '#account_setting_link', function() {
		displayManagementForms("accountSettings");
	});
	
	$('body').on('click', '#password_setting_link', function() {
		displayManagementForms("passwordSettings");
	});
	
	// ************* T A B   F U N C T I O N A L I T Y *****************
	
	$("#email_button").on('click', function() {
		$("#email_dashboard_container").css('display', 'block');
		$("#account_management_container").css('display', 'none');
	});
	
	$("#account_button").on('click', function() {
		$("#email_dashboard_container").css('display', 'none');
		$("#account_management_container").css('display', 'block');
	});
	
	// ************* I N I T I A L   P A G E   S E T U P *****************
	
	displayFolders();
	displayMessages("default", "default");
	
	displayOptions();
	displayManagementForms("manageMailboxes");
	
});