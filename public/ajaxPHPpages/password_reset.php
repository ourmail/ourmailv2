<?php
session_start();
if(!isset($_POST['passwordReset']) or ($_POST['passwordReset']) != true) {
	header("Location: index.php");
	die();
}
?>

<head>
	<link href="css/account_settings.css" rel="stylesheet">
</head>

<div class="container">
	<h1>Change Password</h1>
	<div  class="passwordResetContainer">
		<span class="status">An email has been sent to your account with further instructions.</span><br>
		<button class="btn btn-default" id="passwordResetButton">Request Password Change</button>
	</div>
</div>