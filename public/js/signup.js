$(function() {
	// ************** I N I T I A L I Z E *******************
	"use strict"
	Parse.$ = jQuery;
	Parse.initialize("9syVLvZdcJKZD9uAlCoYMKwjtmWxPHFhD4DdYKcN", "HH4p0QrjdzsO74KsoLhhhUZnPYDwExnZ8o9CCAeN"); 

	// ************ C U R R E N T   U S E R *******************
	function displayCurrentUser() {
		if (Parse.User.current()) {
			console.log("Logged in by "+Parse.User.current().get("username"));
			$("#current-user").html("Current User is "+Parse.User.current().get("username"));
		}
		else {
			console.log("Logged in by no one.");
			$("#current-user").html("Current User is no one.");
		}
	}
	
	displayCurrentUser();

	// ******************** S I G U P ************************
	$("#signup").submit(function(event){
		event.preventDefault();

        var $username = $('#username');

		var newUser = new Parse.User();
		newUser.set("username", $("#username").val());
		newUser.set("password", $("#password").val());
		newUser.set("email", $("#signupEmail").val());
        $.ajax({
              type: 'POST',
              url: 'signup_context.php',
              data: $username,
              async:false,
              success: function(contextid) {
				  console.log(contextid);
				newUser.set('contextid',contextid);
              }
        });
		newUser.signUp(null, {
			success: function(newUser) {
				console.log("signup success.");
	            $('#signup').fadeOut(500);
	            $('.wrapper').addClass('form-success');
				Parse.User.logOut();
				//window.location.replace('login.php'); // go to index page for login
			},
			error: function(newUser, error) {
				alert("Parse Error(" + error.code + "): " + error.message);
			}
		});
	});

// NO CODE BEYOND THIS POINT
// ADD CODE IN $(function(){ ... });
});
