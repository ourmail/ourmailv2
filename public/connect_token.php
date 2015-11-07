<?php
session_start();
$contextid=$_SESSION['contextid'];

//include context.io library
require_once 'PHP-ContextIO/class.contextio.php';

//API Key and Secret. Found in the context IO Developers Settings
define('CONSUMER_KEY', 'ru1j2q2s');
define('CONSUMER_SECRET', '0OuLf0mllrvwaPAQ');
define('CALLBACK', 'https://google.com');

//Instantiate the contextio object
$ctxio = new ContextIO(CONSUMER_KEY, CONSUMER_SECRET);

//Get a connect token
$r=$ctxio->addConnectToken($contextid, array(
    "callback_url" =>  CALLBACK
));

if ($r === false) {
    throw new exception("Unable to get a connect token.");
}
else{
    //redirect user to connect token UI
    $token = $r->getData();
    //print $token['token'];
    //$_SESSION['ContextIO-connectToken']=$token['token'];
    $_SESSION['recache'] = true;
    header("Location: ". $token['browser_redirect_url']);
}

?>
