<?
session_start();
session_regenerate_id();

if(!isset($_SESSION['userauth']) or ($_SESSION['userauth']) != true) {
	header("Location: index.php");
	die();
}

if(isset($_SESSION['recache'])){
	header("Location: update_imap_info.php");
	die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ourmail Dashboard</title>

    <link href="css/dashboard.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

	<div id="navigation_bar"> 
		<!-- Corner logo? -->
	
		<ul>
			<li><a href="#" id="email_button">Email</a></li>
			<li><a href="#" id="account_button">Account</a></li>
			<li><a href="#" id="logout_button">Logout</a></li>
		</ul>
	
	</div>
	
	<div id="email_dashboard_container">
		<div id="email_folder_sidebar">
			Email Sidebar Area
		</div>
		
		<div id="email_main_display_container">
			Email Display Area
		</div>
	</div>
	
	<div id="account_management_container">
		<div id="account_management_sidebar">
			Account Sidebar Area
		</div>
		
		<div id="account_management_display_container">
			Account Display Area
		</div>
	</div>
	<!-- Script Load Area -->
	
	<!-- jQuery -->
    <script src="js/jquery.js"></script>
	
	<!-- Parse -->
    <script src = "http://www.parsecdn.com/js/parse-latest.js"></script>
	
	<!-- Main JS Script -->
    <script src = "js/dashboard.js"></script>
	
	<script src="js/manage_mailboxes.js"></script>

</body>
<html>