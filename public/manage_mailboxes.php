<?php
session_start();
if(!isset($_SESSION['userauth']) or ($_SESSION['userauth']) != true) {
	header("Location: login.php");
	die();
}

if(isset($_SESSION['recache'])){
	header("Location: update_imap_info.php");
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
<?php

$imapinfo=$_SESSION['imapinfo'];

foreach($imapinfo as $mailbox){
$output = <<<EOL
	<li>
		{$mailbox['label']} <button data-label="{$mailbox['label']}" class="remove">delete</button>
	</li>
EOL;
echo $output;
}
				
?>
			
			<li id="addmailbox"> <a href="connect_token.php">Add new mailbox</a> </li>
				
			<li><a href="dashboard.php">Dashboard</a></li>
			
			<li id="logout">
				Logout
			</li>
		</ul>
	</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/manage_mailboxes.js"></script>
    
    
  </body>
</html>
