$(function() {
	$(".mailtable").on('click', function(event){
		
		console.log("Attempting to toggle message");
		
		$message=$(this).next();
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
});