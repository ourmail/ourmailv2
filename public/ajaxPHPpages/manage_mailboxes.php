<?php
session_start();
if(!isset($_POST['manageMailboxes']) or ($_POST['manageMailboxes']) != true) {
	header("Location: index.php");
	die();
}
?>
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
		<li id="addmailbox"> <a href="connect_token.php" target="_blank">Add new mailbox</a> </li>
	</ul>
</div>
    