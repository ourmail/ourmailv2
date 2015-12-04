 $(function() {
"use strict";
	Parse.$ = jQuery;
	Parse.initialize("9syVLvZdcJKZD9uAlCoYMKwjtmWxPHFhD4DdYKcN", "HH4p0QrjdzsO74KsoLhhhUZnPYDwExnZ8o9CCAeN"); 

	var Post = Parse.Object.extend("Post");
	
	// ************ C U R R E N T	U S E R *******************
	/*
	function displayCurrentUser() {
		if (Parse.User.current()) {
			console.log("Logged in by "+Parse.User.current().get("username"));
			//Parse.User.logOut();
			//console.log("Logged out now");
		}
		else {
			console.log("Logged in by no one.");
		}
	}
	
	displayCurrentUser();
	*/
	// ****************** L O G I N *************************
	$("#loginForm").submit(function(event) {
		console.log("trying to log in...");
		if (Parse.User.current()) {
			console.log("Logged in by "+Parse.User.current().get("username"));
			Parse.User.logOut();
			console.log("Logged out now");
		}
		event.preventDefault();
		var user = new Parse.User();
		user.set("username", $("#loginUsername").val());
		user.set("password", $("#loginPassword").val());
		user.logIn({
			success: function(user) { //on success, user object is pass back to me
				console.log("login success."); 
				
				var myobject={'authentication' : true, 
						'email' : user.get('email'), 
						'username' : user.get('username'), 
						'contextid' : user.get('contextid')
				}; 
				
				console.log(myobject);
				
				//Set up session for user.
				$.ajax({
					type: 'POST',
					url: 'ajaxPHPpages/set_up_session.php',
					data: myobject,
					async: false,
					success: function(data) {
						console.log(data);
						console.log("Session set up successful");
						window.location.href = 'ajaxPHPpages/update_imap_info.php'; // update imap info for email connections
					},
					error: function(error){
						console.log("Could not set up session");
					}
				});
					 
			},
			error: function(user, error) {
				$('#error').html(error.message);
				//clear all fields
				$("#forgotPasswordLink").click(function(event) {
					$('#error').last().remove();
				 });
				return false;
			}
		});
	});
	/******************** F O R G O T	E M A I L ****************************/
	$("#forgotPasswordForm").submit(function(event) {
		event.preventDefault();
		
		Parse.User.requestPasswordReset($("#forgotPasswordEmail").val(), {
			success: function() {
				 alert("Password reset instructions were successfully sent to your email address.");
				 window.location.href = "main.php";
				 return true;
			},
			error: function(error) {// Fail message
				$('#error').html(error.message);
				//clear all fields
				$('#loginLink').click(function(event) {
					$('#error').last().remove();
				 });
				return false;
			}
			});

	});
	/*************************************************************************/
});

$("#forgotPasswordLink").click(function(event) {
	$("#forgotPasswordForm").css("display", "block");
	$("#loginForm").css("display", "none");
});
$("#loginLink").click(function(event) {
	$("#loginForm").css("display", "block");
	$("#forgotPasswordForm").css("display", "none");
});

