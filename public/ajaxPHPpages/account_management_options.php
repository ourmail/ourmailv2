<?php
session_start();
if(!isset($_POST['accountManagement']) or ($_POST['accountManagement']) != true) {
	header("Location: index.php");
	die();
}
?>
<ul>
	<li id="mailbox_management_link"><a href="#">Manage Mailboxes</a></li>
	<li id="account_setting_link"><a href="#">Change Acount Information</a></li>
	<li id="password_setting_link"><a href="#">Change Password</a></li>
</ul>