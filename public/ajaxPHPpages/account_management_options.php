<?php
session_start();
if(!isset($_POST['accountManagement']) or ($_POST['accountManagement']) != true) {
	header("Location: index.php");
	die();
}
?>
<ul>
	<li class="list-group-item" id="mailbox_management_link"><a href="#">Manage Mailboxes</a></li>
	<li class="list-group-item" id="account_setting_link"><a href="#">Change Account Information</a></li>
	<li class="list-group-item" id="password_setting_link"><a href="#">Change Password</a></li>
</ul>