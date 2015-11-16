<?
session_start();

if(!isset($_SESSION['userauth']) or ($_SESSION['userauth']) != true or !isset($_POST['emailFolders']) or $_POST['emailFolders'] != true) {
	header("Location: /index.php");
	die();
}

$imapinfo=$_SESSION['imapinfo'];
$contextid=$_SESSION['contextid'];

// Helper Functions

//This function prints a folder to the side navbar
function print_folder($folder,$label){
    //$output="<li>\n<a data-label=\"".rawurlencode($label).'" data-folder="'.rawurlencode($folder).'" class="folder-link" href="#">' .$folder . "</a>\n</li>\n";
	$output="<li>\n<a data-label=\"".$label.'" data-folder="'.$folder.'" class="folder-link" href="#">' .$folder . "</a>\n</li>\n";
    echo $output;
}

//This function prints a mailbox to the side navbar. It call print_folder to print folders contained in a mailbox.
function print_mailbox($account){
    $label=$account['label'];
 
//$output = <<<EOL
    //<li>
        //$label
    //<ul class="sidebar-brand">
//EOL;
    
    //echo $output;
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
    
    $tab_output = "<ul class='nav nav-tabs nav-justified'>";
    $counter_one = 0;

    foreach($accounts as $account)
    {
        // getting account label here and cleaning it to only get account name
        $cur_label = $account['label'];
        $cur_label = substr($cur_label , 0 , strpos($cur_label, ":"));          

        $tab_output = $tab_output."<li><a data-toggle='tab' href='#".$counter_one."'>".$cur_label."</a></li>";
        ++$counter_one;
    }

    $tab_output = $tab_output."</ul><div class='tab-content'>";
    echo $tab_output;
    
    $counter_two = 0;

    foreach($accounts as $account)
    {
        $cur_label = $account['label'];
        $cur_label = substr($cur_label , 0 , strpos($cur_label, ":"));         

        $tab_output = "<div id='".$counter_two."' class='tab-pane fade'>";
        echo $tab_output;
        print_mailbox($account);
        $tab_output = "</p></div>";
        echo $tab_output;
        ++$counter_two;
    }

    $tab_output = "</div>";
        
    echo $tab_output;
}

// Include Context IO Library
require_once '../PHP-ContextIO/class.contextio.php';

// API Key and Secret. Get the Users email from Parse
define('CONSUMER_KEY', 'ru1j2q2s');
define('CONSUMER_SECRET', '0OuLf0mllrvwaPAQ');

// Get all the information regarding mailboxes from the contextio.

//Instantiate the contextio object
$ctxio = new ContextIO(CONSUMER_KEY, CONSUMER_SECRET);

print_all_mailboxes($imapinfo);
?>