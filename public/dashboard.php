<?php

session_start();
$imapinfo=$_SESSION['imapinfo'];
$contextid=$_SESSION['contextid'];

// Helper Functions

//This function prints a folder to the side navbar
function print_folder($folder,$label){
    $output="<li>\n<a href=\"dashboard.php?label=" . rawurlencode($label) . "&folder=" .rawurlencode($folder) . "\">" .$folder . "</a>\n</li>\n";
    echo $output;
}

//This function prints a mailbox to the side navbar. It call print_folder to print folders contained in a mailbox.
function print_mailbox($account){
    $label=$account['label'];
 
$output = <<<EOL
    <li>
        $labels
    <ul class="sidebar-brand">
EOL;
    
    echo $output;
    foreach($account['folders'] as $folder){
        print_folder($folder,$label);
    }       
    echo "</ul>\n</li>\n";
$output = <<<EOL
        </ul>
    </li>
EOL;
echo $output;
}

//This function prints all mailboxes
function print_all_mailboxes($accounts){
    foreach($accounts as $account){
        print_mailbox($account);
    }
}

// This function takes in a message object and prints it to the screen
function print_message($message,$unseen){

$senderName=$message['addresses']['from']['name'];
$subject=$message['subject'];
$sendTimeSeconds=$message['date'];
$sendDate=date('Y/m/d H:i:s', $sendTimeSeconds);
$messageid=$message['message_id'];

if (count($message['body'])==2){
    $body=$message['body']['1']['content'];
}
elseif (count($message['body'])==1){
    $body=$message['body']['0']['content'];
}
else{
    $body="No Body";
}
if($unseen === false){
    $seen_status="seen";
}
elseif($unseen === true ){
    $seen_status="unseen";
}

$message_html = <<<EOT
                    
                        
                        <table border="0" cellspacing="0" cellpadding="0" align="left" style="width:100%;margin:0 auto;background:#FFF;">
                            <tr>
                                <td colspan="5" style="padding:15px 0;">
                                    <h1 style="color:#000;font-size:24px;padding:0 15px;margin:0;">From: {$senderName}</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:15px;">&nbsp;</td>
                                <td class="$seen_status" style="width:375px;">
                                    <span class="mailtable">Subject: {$subject}</span>
                                </td>
                                <td style="width:15px;">&nbsp;</td>
                                <td style="width:180px;padding:0 0 0 0;">
                                    {$sendDate}<button data-messageid="{$messageid}" class="removemessage"> delete </button>
                                </td>
                                <td style="width:15px;">&nbsp;</td>
                            </tr>
                        </table>
                        <div class="hidden mailmessage">
                            $body
                        </div>
EOT;

echo $message_html;
}

// This function takes list of message objects and prints them all
function print_all_messages($msgsd,$unseen=false){
    foreach($msgsd as $msg){
        print_message($msg,$unseen);
    }
}

// This function fetches messages and prints them all.
function get_messages_and_print($label,$folder){

    global $ctxio;
    global $imapinfo;
    global $contextid;

    // Get Unread Messages
    $msgs=$ctxio->listMessagesBySourceAndFolder($contextid,array(
        'label' => $label,
        'folder' => $folder,
        'include_body' => '1',
        'flag_seen' => '0' 
    ));
    if ($msgs === false) {
        throw new exception("Unable to fetch messages");
    }
    $msgsd=$msgs->getData();
    print_all_messages($msgsd,true);
    
    // Get Read Messages
    $msgs=$ctxio->listMessagesBySourceAndFolder($contextid,array(
        'label' => $label,
        'folder' => $folder,
        'include_body' => '1',
        'flag_seen' => 1
    ));
    if ($msgs === false) {
        throw new exception("Unable to fetch messages");
    }
    $msgsd=$msgs->getData();
    print_all_messages($msgsd);
}

// This function fetches the new mailbox based on whats folder is selected by the user.
function refresh_mailbox(){
    global $imapinfo;
    //var_dump($imapinfo);
// FIXME. Do error checking for wrong variables passed.
    if (array_key_exists('label',$_GET) and array_key_exists('folder',$_GET)){
        $label=$_GET['label'];
        $folder=$_GET['folder'];
    } else {
        $label=$imapinfo['0']['label'];
        $folder=$imapinfo['0']['folders']['0'];
    }
    get_messages_and_print($label,$folder);
}

// Helper Functions end

// Include Context IO Library
require_once 'PHP-ContextIO/class.contextio.php';

// API Key and Secret. Get the Users email from Parse
define('CONSUMER_KEY', 'ru1j2q2s');
define('CONSUMER_SECRET', '0OuLf0mllrvwaPAQ');

// Get all the information regarding mailboxes from the contextio.

//Instantiate the contextio object
$ctxio = new ContextIO(CONSUMER_KEY, CONSUMER_SECRET);
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

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- Font Awesome Font-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
              <?php
                  // Print all mailboxes on the left side.
                  print_all_mailboxes($imapinfo);
              ?>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                  <?php
                  // Print mailbox messages on the right side
                  refresh_mailbox();
                  ?>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    
    <!-- Dashboard Script -->
    <script src="js/dashboard.js"></script>

    <!-- Menu Toggle Script -->
<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
    
</body>
</html>
