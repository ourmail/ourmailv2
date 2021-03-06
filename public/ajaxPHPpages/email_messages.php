<?

session_start();

/*
if(!isset($_SESSION['userauth']) or ($_SESSION['userauth']) != true or !isset($_POST['emailMessages']) or $_POST['emailMessages'] != true) {
	header("Location: /index.php");
	die();
}*/

$imapinfo=$_SESSION['imapinfo'];
$contextid=$_SESSION['contextid'];


// This function creates a modal popup and returns it as an html object
function create_message_popup($body, $subject , $counter)
{
    $message = "<div id='modal_{$counter}' class= 'modal fade' role= 'dialog'><div class= 'modal-dialog'><div class='modal-content'><div class='modal-header'>";
    $message = $message."<h4 class='modal-title'>{$subject}</h4></div><div class= 'modal-body'><p>{$body}</p></div><div class='modal-footer'>";
    $message = $message."<button type= 'button' class='btn btn-default' data-dismiss= 'modal'>Close</button></div></div></div></div>";

    return $message;
}


// This function takes in a message object and prints it to the screen
function print_message($message,$unseen,$counter){
	if(is_array($message)) {
		if(isset($message['addresses']['from']['name'])) {
			$senderName=$message['addresses']['from']['name'];
		}
		else {
			$senderName=$message['addresses']['from']['email'];
		}
		
		$senderEmail=$message['addresses']['from']['email'];
		$receiverEmail=$message['addresses']['to']['0']['email'];
		$subject=$message['subject'];
		$sendTimeSeconds=$message['date'];
		$sendDate=date('M d, Y g:i a', $sendTimeSeconds);
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

//$message_html = <<<EOT
                    
                        
                        // <table border="0" cellspacing="0" cellpadding="0" align="left" style="width:100%;margin:0 auto;background:#FFF;">
                        //     <tr>
                        //         <td colspan="5" style="padding:15px 0;">
                        //             <h1 style="color:#000;font-size:24px;padding:0 15px;margin:0;">From: {$senderName}</h1>
                        //         </td>
                        //     </tr>
                        //     <tr>
                        //         <td style="width:15px;">&nbsp;</td>
                        //         <td class="$seen_status seen_stat" style="width:375px;">
                        //             <span class="mailtable">Subject: {$subject}</span>
                        //         </td>
                        //         <td style="width:15px;">&nbsp;</td>
                        //         <td style="width:180px;padding:0 0 0 0;">
                        //             {$sendDate}<button data-messageid="{$messageid}" class="removemessage"> delete </button>
                        //             <button data-messageid="{$messageid}" class="markread"> Mark as Read </button>         
                        //         <a target="_blank" href="compose.php?to=$senderEmail&from=$receiverEmail"><button>Reply</button></a>
                        //         </td>
                        //         <td style="width:15px;">&nbsp;</td>
                        //     </tr>
                        // </table>
                        // <div class="hidden mailmessage">
                        //     $body
                        // </div>
//EOT;z
        // this is the html code for the email strip
        $message_html = "<tr><td>{$senderName}</td><td>Subject: {$subject}</td><td>{$sendDate}</td>";
        $message_html = $message_html."<td><button data-messageid='{$messageid}'' class='removemessage btn btn-primary btn-md active'> Delete </button></td>";
        $message_html = $message_html."<td><a target='_blank' href='compose.php?to=$senderEmail&from=$receiverEmail'><button class = 'btn btn-primary btn-md active'>Reply</button></a></td>";
        $message_html = $message_html."<td><button data-messageid='{$messageid}' class='markread btn btn-primary btn-md active'> Mark as Read </button></td>";

        // this is the html code for the modal popup. 
        // Every modal object has a unique id so that only that message will pop up.

        $message_html = $message_html."<td><button type='button' class='btn btn-primary btn-md active' data-toggle='modal' data-target= '#modal_{$messageid}'>View Email</button></td></tr>";
        $popup = create_message_popup($body, $subject, $messageid); 
        
        return array($message_html, $popup);


        //return $message_html;          

//EOT;

    //echo $message_html;
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

    //$start = microtime(true);
    //echo "start:";
    //echo $start;
    //echo "<br />";
   
    // Get Messages
    $msgs=$ctxio->listMessagesBySourceAndFolder($contextid,array(
        'label' => $label,
        'folder' => $folder,
        'include_body' => '1'
    ));
    //$end=microtime(true);
    //echo "end:";
    //echo $end;
    //echo "<br />";
    //echo "Elapsed time: ";
    //echo $end - $start;

    if ($msgs === false) {
        //throw new exception("Unable to fetch messages");
        echo "<p id = \"welcome_uname\" class = \"text-center\" >There are no messages</p>";
    }
    else{
        $msgsd=$msgs->getData();
        if(count($msgsd) > 0) {
		print_all_messages($msgsd);
	   }
	   else {
		  echo 'Folder '.rawurldecode($folder).' is Empty<br>';
	   }
    }
    //$total=microtime(true);
    //echo "total:";
    //echo $total - $start;
    
    /*
   
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
	}*/
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