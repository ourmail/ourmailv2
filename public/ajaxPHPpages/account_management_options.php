<?php
session_start();
if(!isset($_POST['accountManagement']) or ($_POST['accountManagement']) != true) {
	header("Location: index.php");
	die();
}
?>
<ul>
	<li id="mailbox_management_link">Manage Mailboxes</li>
	<li id="account_setting_link">Change Acount Information</li>
	<li id="password_setting_link">Change Password</li>
</ul>