<?php

session_start();

//Helper Functions

//This function builds the imapinfo_object, which contains information about the users email accounts.
function buildImapInfo(&$imapinfo, $ctxio, $contextid){

    $r = $ctxio->listSources($contextid);
    if ($r === false){
        throw new exception("Could not fetch sources");
    }
    
    $r = $r->getData();
    
    foreach($r as $source){

        $account=array();

        //Get Current Account Label
        $label=$source['label'];
        $account['label']=$label;
        $account['folders']=array();

        //Get mail account folders.
        $f=$ctxio->listSourceFolders($contextid, array(
            'label' => $label
        ));
        if ($f === false) {
            throw new exception("Could not fetch folders");
        } 

        $f=$f->getData();

        //Iterate over folders
        foreach($f as $folder){
            //Store Folders
            array_push($account['folders'],$folder['name']);
        }
        array_push($imapinfo,$account);
    }
    //var_dump($imapinfo);
}

//Helper Function End

// Include Context IO Library
require_once 'PHP-ContextIO/class.contextio.php';

// API Key and Secret. Get the Users email from Parse
define('CONSUMER_KEY', 'ru1j2q2s');
define('CONSUMER_SECRET', '0OuLf0mllrvwaPAQ');
$contextid=$_SESSION['contextid'];

$imapinfo=array();

//Instantiate the contextio object
$ctxio = new ContextIO(CONSUMER_KEY, CONSUMER_SECRET);

// Start memcached server
$mem = new Memcached();
$mem->addServer("127.0.0.1", 11211);

buildImapInfo($imapinfo, $ctxio, $contextid);

$_SESSION['imapinfo']=$imapinfo;

if(isset($_SESSION['recache'])){
    unset($_SESSION['recache']);
}
header("Location: manage_mailboxes.php");
die();

?>
