<?
session_start();
session_regenerate_id();

if(!isset($_SESSION['userauth']) or ($_SESSION['userauth']) != true) {
	header("Location: index.php");
	die();
}

if(isset($_SESSION['recache'])){
	echo "Rechache was set";
	header("Location: ajaxPHPpages/update_imap_info.php");
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

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/simple-sidebar.css" rel="stylesheet">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link href="css/dashboard.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Comfortaa:700' rel='stylesheet' type='text/css'>

	<!-- Script Load Area -->
	
	<!-- jQuery -->
    <script src="js/jquery.js"></script>
	
	<!-- Parse -->
    <script src = "http://www.parsecdn.com/js/parse-latest.js"></script>
	
	<!-- Main JS Script -->
    <script src = "js/dashboard.js"></script>
	
	<script src="js/manage_mailboxes.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 

</head>

<body>

	<!-- START OF NAVIGATION BAR HTML CODE -->

	<div id="navigation_bar"> 
		<!-- Corner logo? -->

		<nav class="navbar navbar-default">
  			<div class="container-fluid">
    			
    			<div class="navbar-header">
      				<a class="navbar-brand" href="#">Ourmail</a>
    			</div>
    			
    			<div>
					<ul class="nav navbar-nav ">
        				<li><a href="#" id= "main_button">Main</a></li>
        				<li><a href="#" id= "email_button">Email</a></li>
        				<li><a href="#" id= "account_button">Account</a></li>

        				<li>
	        				<div class="dropdown">
						    <button class="btn btn-primary dropdown-toggle" id = "theme" type="button" data-toggle="dropdown"> Theme
						    <span class="caret"></span></button>
						    <ul class="dropdown-menu">	
						      <li><a href="#" id= "redtheme" style= "font-family: 'Comfortaa', Arial;">Red</a></li>
						      <li><a href="#" id= "greentheme" style= "font-family: 'Comfortaa', Arial;">Green</a></li>
						      <li><a href="#" id= "bluetheme" style= "font-family: 'Comfortaa', Arial;">Blue</a></li>
						    </ul>
						  	</div>
						</li>
      				</ul>

					  	

					<ul class="nav navbar-nav navbar-right">
        				<li><a href="#" id = "logout_button"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
      				</ul>
    			</div>
  			
  			</div>
		</nav>
	
	</div>
	
	<!-- END OF NAVIGATION BAR HTML CODE -->
	
	<!-- CODE TO BE DISPLAYED UNDER MAIN TAB IN NAV BAR -->
	
	<div id="main_dashboard_container">
		
		<img src="img/logo.png" alt="Ourmail Logo" id ="main_logo" class = "img-responsive center-block">
		<p id = "welcome_uname" class = "text-center" >username</p>

	</div>

	<!-- CODE TO BE DISPLAYED UNDER EMAIL TAB IN NAV BAR -->

	<div id="email_dashboard_container">
		<div id="email_folder_sidebar" class="col-xs-12 col-md-2">
			<!-- Email Sidebar Area -->
			<li class="list-group-item" id="composeLink"><a href="#" style= "font-family: 'Comfortaa', Arial;">Compose New Email</a></li>
		</div>
		
		<div id="email_main_display_container" class="col-xs-12 col-md-10">
			<!-- Email Display Area -->
		</div>
	</div>
	
	<!-- CODE TO BE DISPLAYED UNDER EMAIL TAB IN BOTTOM NAV BAR -->
		<nav id="bottomEmailNavbar" class="navbar navbar-default navbar-fixed-bottom">
			<div class="container-fluid">
				<!-- Compose Email link -->
				<ul class="nav navbar-nav navbar-right" data-toggle="modal" data-target="#composeModal">
					<li><a href="#">Compose New Email</a></li>
				</ul>

				
			</div>
		</nav>
	
	<!-- CODE TO BE DISPLAYED UNDER ACCOUNTS TAB IN NAV BAR -->

	<div id="account_management_container">
		<div id="account_management_sidebar" class="col-xs-12 col-md-3">
			<ul>
				<li class="list-group-item" id="account_setting_link" style= "font-family: 'Comfortaa', Arial;"><a href="#">Change Account Information</a></li>
				<li class="list-group-item" id="password_setting_link" style= "font-family: 'Comfortaa', Arial;"><a href="#">Change Password</a></li>
				<li class="list-group-item" id="mailbox_management_link" style= "font-family: 'Comfortaa', Arial;"><a href="#">Manage Mailboxes</a></li>
			</ul>
		</div>
		
		<div id="account_management_display_container" class="col-xs-12 col-md-6">
			Account Display Area
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="composeModal" tabindex="-1" role="dialog" aria-labelledby="composeModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		<form id="compose">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="composeModalLabel">Compose Email</h4>
			</div>
			<div class="modal-body">
				<!-- Sender Email address Line -->
				<div class="form-group">
					<label>From:</label>
					<select id='from' name='from' form="compose">
						<?php
							$imapinfo=$_SESSION['imapinfo'];
							foreach($imapinfo as $account){
								if ($account['email']==$from)
									$selected="selected";
								else
									$selected="";
								$output = <<<EOL
								<option value="{$account['email']}" $selected>{$account['email']}</option>
EOL;
								echo $output;
							}
						?>
					</select>
				</div>
				<!-- To Whom Line -->
				<div class="form-group">
					<label>To:</label>
					<input type="text" class="form-control" id="to">
				</div>
				<!-- Subject Line -->
				<div class="form-group">
					<label>Subject:</label>
					<input type="text" class="form-control" id="subject">
				</div>
				<!-- Message Box -->
				<div class="form-group">
					<label>Message:</label>
					<textarea rows="10" cols="50" type="text" class="form-control" id="message"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button id="send_email" class="btn btn-primary" data-dismiss="modal">Send</button>
			</div>
		</form>
		</div>
	  </div>
	</div>
	
</body>
<html>
