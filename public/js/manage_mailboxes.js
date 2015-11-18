 $(function() {
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

 