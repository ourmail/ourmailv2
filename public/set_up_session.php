<?php
session_start();
if(isset($_POST['authentication'])) {
	if($_POST['authentication'] == true) {
		$_SESSION['userauth'] = true;
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['contextid'] = $_POST['contextid'];
		$_SESSION['recache'] = true;
		
		$returnArray = array('success' => true);
		echo json_encode($returnArray);
	}	
}
?>