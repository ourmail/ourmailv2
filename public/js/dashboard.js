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
	
	function displayFolders() {
		// Add more information to the options array if necessary
		$.post('ajaxPHPpages/email_folders.php', { 'emailFolders' : true }, function(data) {
			if(data != "Failed to load folders") {
				$("#email_folder_sidebar").html(data);				
			}
			else {
				console.log(data);
			}			
		});			
	}
	
	function displayMessages(folder) {
		// Add more information to the options array if necessary
		$.post('ajaxPHPpages/email_messages.php', { 'emailMessages' : true, "folder" : folder }, function(data) {
			if(data != "Failed to load folders") {
				$("#email_main_display_container").html(data);				
			}
			else {
				console.log(data);
			}			
		});	
	}
	
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
		}
		else if(option == "passwordSettings") {
			// Like above, but password reset page.
		}
	}
	
	// Need some on click functions that work for folders and calls the displayMessages function with the appropriate folder information
	
	
	
	$('body').on('click', '#mailbox_management_link', function() {
		displayManagementForms("manageMailboxes");
	});
	
	$('body').on('click', '#account_setting_link', function() {
		displayManagementForms("accountSettings");
	});
	
	$('body').on('click', '#password_setting_link', function() {
		displayManagementForms("passwordSettings");
	});
	
	
	
	$("#email_button").on('click', function() {
		$("#email_dashboard_container").css('display', 'block');
		$("#account_management_container").css('display', 'none');
		
		// Call Email Functions?
		displayFolders();
		displayMessages("default");
	});
	
	$("#account_button").on('click', function() {
		$("#email_dashboard_container").css('display', 'none');
		$("#account_management_container").css('display', 'block');
		
		// Call Account Functions?
		displayOptions();
		displayManagementForms("manageMailboxes");
	});
});