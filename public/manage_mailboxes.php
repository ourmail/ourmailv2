<?php
session_start();

if(!isset($_SESSION['userauth']) or ($_SESSION['userauth']) != true) {
	header("Location: login.php");
	die();
}
?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Manage your mailboxes</title>
    
    <script src="//www.parsecdn.com/js/parse-1.6.7.min.js"></script> 
    
        <link rel="stylesheet" href="css/login-style.css">
    
  </head>

  <body>

    <div class="wrapper">
	<div class="container">
		<h1>Manage your mailboxes</h1>
		<br />
		<ul>
			<a href="connect_token.php">
				<div>
					<li id="addmailbox"> Add new mailbox </li>
				</div>
			</a>	
		</ul>
	</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


    
    
    
  </body>
</html>
