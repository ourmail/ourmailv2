<?php
session_start();
$contextid=$_SESSION['contextid'];
$label=$_POST['label'];

//var_dump($label);

//include context.io library
require_once 'PHP-ContextIO/class.contextio.php';

//API Key and Secret. Found in the context IO Developers Settings
define('CONSUMER_KEY', 'ru1j2q2s');
define('CONSUMER_SECRET', '0OuLf0mllrvwaPAQ');

//Instantiate the contextio object
$ctxio = new ContextIO(CONSUMER_KEY, CONSUMER_SECRET);

$_SESSION['recache']=true;

//Delete Source
$r=$ctxio->deleteSource($contextid, array(
    "label" =>  $label
));
if ($r === false) {
    throw new exception("Unable to delete Source.");
}
    $returnArray = array('removedlabel' => $label);
	echo json_encode($returnArray);
?>
