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
	<form id="signupForm">
		<div class="form-group">
			<label for="firstname">Name:</label>
			<input class="form-control" id="firstname">
			<input class="form-control" id="lastname">
		</div>
		
		<div class="form-group">
			<label for="email">Email Address:</label>
			<input class="form-control" type = "email" id="email" autocomplete="on">
		</div>
		
		<div class="form-group">
			<label for="username">Username:</label>
			<input class="form-control" type = "text" id="username" autocomplete="off">
		</div>
		
		<div class="form-group">
			<span class="finish" id="savesuccess">Your account information has been saved.<br></span>
			<button class="btn btn-default" id="submitaccount">Save Account Information</button>
		</div>
	</form>
</div>
    