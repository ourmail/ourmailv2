<?php
session_start();
if(!isset($_POST['accountSettings']) or ($_POST['accountSettings']) != true) {
	header("Location: index.php");
	die();
}
?>

<head>
	<link href="css/account_settings.css" rel="stylesheet">
	<script src = "js/account_settings.js"></script>
</head>

<div class="container">
	<h1>Change Account Information</h1>
	<br />
	<ul>

	<div id="container">
			<div class="col-xs-12 col-md-6" class="Account Settings">

				<div id="signupForm">
						Name:<br>
						<input class="form-control" class = "name"  type = "name" id="firstname">
						<input class="form-control" class = "name" id="lastname"><br><br>
				    
				    	Email Address:<br>
						<input class="form-control" class = "samebox" class="form-control" type = "email" id="email" autocomplete="on"><br><br>
					
						Username:<br>
						<input class="form-control" class = "samebox" type = "text" id="username" autocomplete="off"><br><br>

						<span class="finish" id="savesuccess">Your account information has been saved.<br></span>
						<button class="btn btn-default" id = "submitaccount">Save Account Information</button>
				</div>
			<br />
			</div>
</div>
    