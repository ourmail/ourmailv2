 $(function() {
"use strict";
	Parse.$ = jQuery;
	Parse.initialize("9syVLvZdcJKZD9uAlCoYMKwjtmWxPHFhD4DdYKcN", "HH4p0QrjdzsO74KsoLhhhUZnPYDwExnZ8o9CCAeN"); 

	var Post = Parse.Object.extend("Post");

	// ************ L O G O U T *******************
	
	$("#logout").on('click',function(){
		Parse.User.logOut();
		console.log("Logged out now");
		window.location.replace('login.php');	
	});
});