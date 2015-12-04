$(function() {
	console.log("Hello World");
	$("#compose").submit(function(event){
		console.log("In the compose function");
		
		event.preventDefault();
		
		$from=$("#from").val();
		$to=$("#to").val();
		$subject=$("#subject").val();
		$message=$("#message").val();
		
		console.log("Attempting to send message.")
		console.log($from);
		console.log($to);
		console.log($subject);
		console.log($message);
		
		
  		$.ajax({
   			type: "POST",
    		url: "https://mandrillapp.com/api/1.0/messages/send.json",
    		data: {
      			'key': 'bMm6MYko9E4ayLNZ60pJoQ',
      			'message': {
        			'from_email': $from,
        			'to': [
          				{
            				'email': $to,
          				}
        			],
        			'subject': $subject,
        			'html': $message
      			}
    		},
			async: false,
			success: function(data) {
				console.log(data);
				console.log("Send Successful");
            },
			error: function(error){
				console.log("Could not send Message");
			}
  		});
	});
});