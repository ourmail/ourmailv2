<?

session_start();

if(!isset($_SESSION['userauth']) or ($_SESSION['userauth']) != true or !isset($_POST['emailMessages']) or $_POST['emailMessages'] != true) {
	header("Location: /index.php");
	die();
}

$imapinfo=$_SESSION['imapinfo'];
$contextid=$_SESSION['contextid'];


// This function creates a modal popup and returns it as an html object
function create_message_popup($body, $subject , $counter)
{
    $message = "<div id= '{$counter}' class= 'modal fade' role= 'dialog'><div class= 'modal-dialog'><div class='modal-content'><div class='modal-header'>";
    $message = $message."<h4 class='modal-title'>{$subject}</h4></div><div class= 'modal-body'><p>{$body}</p></div><div class='modal-footer'>";
    $message = $message."<button type= 'button' class='btn btn-default' data-dismiss= 'modal'>Close</button></div></div></div></div>";

    return $message;
}


// This function takes in a message object and prints it to the screen
function print_message($message,$unseen,$counter){
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

        // this is the html code for the email strip
        $message_html = "<tr><td>{$senderName}</td><td>Subject: {$subject}</td><td>{$sendDate}</td>";
        $message_html = $message_html."<td><button data-messageid='{$messageid}'' class='removemessage'> Delete </button></td>";
        $message_html = $message_html."<td><a target='_blank' href='compose.php?to=$senderEmail&from=$receiverEmail'><button>Reply</button></a></td>";
        $message_html = $message_html."<td><button data-messageid='{$messageid}' class='markread'> Mark as Read </button></td>";

        // this is the html code for the modal popup. 
        // Every modal object has a unique id so that only that message will pop up.
        $message_html = $message_html."<td><button type='button' class='btn' data-toggle='modal' data-target= '#{$counter}'>View Email</button></td></tr>";
        $popup = create_message_popup($body, $subject, $counter); 
        
        return array($message_html, $popup);
	}
	
    else {
		//echo nl2br(rawurldecode($message))."<br>";
        return nl2br(rawurldecode($message))."<br>";
	}
}

// This function takes list of message objects and prints them all
function print_all_messages($msgsd,$unseen=false){

    $all_messages = "<table class ='table table-hover'>";
    $all_popups = "";
    $counter = 1000;

    foreach($msgsd as $msg)
    {
        list($mess , $new_pop) = print_message($msg,$unseen,$counter);
        $all_messages = $all_messages.$mess;
        $all_popups = $all_popups.$new_pop;

        ++$counter;
    }

    $all_messages = $all_messages."</table>";
    echo $all_messages;
    echo $all_popups;
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
	if(count($imapinfo) == 0) {
		echo "No email account is registered to this account.";
	}
	else {
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