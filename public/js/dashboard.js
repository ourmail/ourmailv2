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
	
	$(".markread").on('click', function(event){
		
		console.log("Attempting to mark message as read");
		
		var myobject={
			'messageid' : $(this).attr('data-messageid')	
		};
		
		$seentag=$(this).parent().prev().prev();
		
		$.ajax({
        	type: 'POST',
            url: 'mark_read.php',
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
});