<?php
session_start();
if(!isset($_POST['manageMailboxes']) or ($_POST['manageMailboxes']) != true) {
	header("Location: index.php");
	die();
}
?>
<div class="container">
	<h1 style= "font-family: 'Comfortaa', Arial;">Manage your mailboxes</h1>
	<br />
	<ul>
<?php
$imapinfo=$_SESSION['imapinfo'];

foreach($imapinfo as $mailbox){
$output = <<<EOL
	<li  >
		<button id = "manageButton" type="button" data-label="{$mailbox['label']}" class="remove" style= "font-family: 'Comfortaa', Arial;">Delete</button> <spin> {$mailbox['label']}</spin> 
	</li>
EOL;
echo $output;
}		
?>			
		<br><li id="addmailbox"> <a href="connect_token.php" target="_blank" style= "font-family: 'Comfortaa', Arial;">Add new mailbox</a> </li>
	</ul>
</div>
    