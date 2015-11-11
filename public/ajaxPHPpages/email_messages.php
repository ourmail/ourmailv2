<?

session_start();

if(!isset($_SESSION['userauth']) or ($_SESSION['userauth']) != true or !isset($_POST['emailMessages']) or $_POST['emailMessages'] != true) {
	header("Location: /index.php");
	die();
}

$imapinfo=$_SESSION['imapinfo'];
$contextid=$_SESSION['contextid'];

// This function takes in a message object and prints it to the screen
function print_message($message,$unseen){
	if(is_array($message)) {
		$senderName=$message['addresses']['from']['name'];
		$senderEmail=$message['addresses']['from']['email'];
		$receiverEmail=$message['addresses']['to']['0']['email'];
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
                                <td class="$seen_status seen_stat" style="width:375px;">
                                    <span class="mailtable">Subject: {$subject}</span>
                                </td>
                                <td style="width:15px;">&nbsp;</td>
                                <td style="width:180px;padding:0 0 0 0;">
                                    {$sendDate}<button data-messageid="{$messageid}" class="removemessage"> delete </button>
                                    <button data-messageid="{$messageid}" class="markread"> Mark as Read </button>         
                                <a target="_blank" href="compose.php?to=$senderEmail&from=$receiverEmail"><button>Reply</button></a>
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
	else {
		echo nl2br(rawurldecode($message))."<br>";
	}
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
	if(count($msgsd) > 0) {
		print_all_messages($msgsd);
	}
	else {
		echo 'Folder '.rawurldecode($folder).' is Empty<br>';
	}
}

// This function fetches the new mailbox based on whats folder is selected by the user.
function refresh_mailbox(){
    global $imapinfo;
    //var_dump($imapinfo);
	// FIXME. Do error checking for wrong variables passed.
	if (isset($_POST['label']) && $_POST['label'] != "default") {
		$label=rawurlencode($_POST['label']);
	}
	else {
		$label=$imapinfo['0']['label'];
	}
	if (isset($_POST['folder']) && $_POST['folder'] != "default") {
		$folder=rawurlencode($_POST['folder']);
	}
	else {
		$folder=$imapinfo['0']['folders']['0'];
	}
    get_messages_and_print($label,$folder);
}

// Helper Functions end

// Include Context IO Library
require_once '../PHP-ContextIO/class.contextio.php';

// API Key and Secret. Get the Users email from Parse
define('CONSUMER_KEY', 'ru1j2q2s');
define('CONSUMER_SECRET', '0OuLf0mllrvwaPAQ');

// Get all the information regarding mailboxes from the contextio.

//Instantiate the contextio object
$ctxio = new ContextIO(CONSUMER_KEY, CONSUMER_SECRET);

refresh_mailbox();
?>