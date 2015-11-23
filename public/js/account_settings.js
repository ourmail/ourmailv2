$(function() {
	// ************** I N I T I A L I Z E *******************
	"use strict"
	Parse.$ = jQuery;
	Parse.initialize("9syVLvZdcJKZD9uAlCoYMKwjtmWxPHFhD4DdYKcN", "HH4p0QrjdzsO74KsoLhhhUZnPYDwExnZ8o9CCAeN");

	function defaultPopulate() {
		var user = Parse.User.current();

		var username = user.get("username");
		var firstname = user.get("firstName");
		var lastname = user.get("lastName");
		var email = user.get("email");

		$('#firstname').val(firstname);
		$('#lastname').val(lastname);
		$('#email').val(email);
		$('#username').val(username);
	}

	$('#submitaccount').click(function() {
		var user = Parse.User.current();

		var firstname = $('#firstname').val();
		var lastname = $('#lastname').val();
		var email = $('#email').val();
		var username = $('#username').val();

		user.set("firstName", firstname);
		user.set("lastName", lastname);
		user.set("email", email);
		user.set("username", username);

		user.save(null, {
  			success: function() {
    			$('#savesuccess').css('display', 'block');
				$("#welcome_uname").html("Welcome " + username + " !");
  			},
  			error: function(user, error) {
  				console.log(error);
  			}
		});
	});

	defaultPopulate();
});