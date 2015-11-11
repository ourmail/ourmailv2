<?php
session_start();
$contextid=$_SESSION['contextid'];
$messageid=$_POST['messageid'];

//include context.io library
require_once 'PHP-ContextIO/class.contextio.php';

//API Key and Secret. Found in the context IO Developers Settings
define('CONSUMER_KEY', 'ru1j2q2s');
define('CONSUMER_SECRET', '0OuLf0mllrvwaPAQ');

//Instantiate the contextio object
$ctxio = new ContextIO(CONSUMER_KEY, CONSUMER_SECRET);

//Delete Source
$r=$ctxio->deleteMessage($contextid, array(
    'message_id' =>  $messageid,
));
if ($r === false) {
    throw new exception("Unable to delete message.");
}
    $returnArray = array('removedmessage' => true);
	echo json_encode($returnArray);
?>
