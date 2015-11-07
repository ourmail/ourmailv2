<?php

$email=$_POST['email'];

require_once 'PHP-ContextIO/class.contextio.php';

define('CONSUMER_KEY', 'ru1j2q2s');
define('CONSUMER_SECRET', '0OuLf0mllrvwaPAQ');

$contextIO = new ContextIO(CONSUMER_KEY,CONSUMER_SECRET);

// Add a new account
$r = $contextIO->addAccount(array(
	'email' => $email,
));
if ($r === false) {
	throw new exception("Unable to add Account");
}

// Get Data
$data=$r->getData();
    
//echo the id
echo $data['id'];