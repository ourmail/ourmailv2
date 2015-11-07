$(function() {
	$(".mailtable").on('click', function(event){
		
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
	
	$(".removemessage").on('click', function(event){
		
		console.log("Attempting to remove message");
		
		var myobject={
			'messageid' : $(this).attr('data-messageid')	
		};
		
		$.ajax({
        	type: 'POST',
            url: 'remove_message.php',
            data: myobject,
            async: false,
            success: function(data) {
				console.log(data);
				console.log("Remove successful");
				location.reload(); // refresh page.
            },
			error: function(error){
				console.log("Could not delete message.");
			}
        });
	});
});