 $(function() {
"use strict";
	Parse.$ = jQuery;
	Parse.initialize("9syVLvZdcJKZD9uAlCoYMKwjtmWxPHFhD4DdYKcN", "HH4p0QrjdzsO74KsoLhhhUZnPYDwExnZ8o9CCAeN"); 

	var Post = Parse.Object.extend("Post");

	// ************ C U R R E N T   U S E R *******************
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
	
	// ****************** L O G I N *************************
	
	$("#login").submit(function(event) {
		event.preventDefault();
		var user = new Parse.User();
		user.set("username", $("#username").val());
		user.set("password", $("#password").val());
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
              		url: 'set_up_session.php',
              		data: myobject,
              		async: false,
              		success: function(data) {
						console.log(data);
				  		console.log("Session set up successful");
						window.location.replace('manage_mailboxes.php'); // go to the manage mailboxes page.
              		},
					error: function(error){
						console.log("Could not set up session");
					}
        		});
					 
			},
			error: function(user, error) {
				console.log("Parse login error:" + error.message);
				alert("Parse Error (" + error.code + "): " + error.message);
			}
		});
	});
});