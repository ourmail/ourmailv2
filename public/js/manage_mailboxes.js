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
	
	$(".remove").on('click', function(event){
		
		console.log("Attempting to remove account");
		
		var myobject={
			'label' : $(this).attr('data-label')	
		};
		
		$.ajax({
        	type: 'POST',
            url: 'remove_mailbox.php',
            data: myobject,
            async: false,
            success: function(data) {
				console.log(data);
				console.log("Remove successful");
				location.reload(); // refresh page.
            },
			error: function(error){
				console.log("Could not delete mailbox.");
			}
        });
	});
});