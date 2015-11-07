<?php
session_start();
$imapinfo=$_SESSION['imapinfo'];



if(isset($_GET['from'])){
  $from=$_GET['from'];
}
if(isset($_GET['to'])){
  $to=$_GET['to'];
}
?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Compose Email</title>

   <script src="//www.parsecdn.com/js/parse-1.6.7.min.js"></script> 
    
    
        <link rel="stylesheet" href="css/login-style.css">
    
    
  </head>

  <body>


    <div class="wrapper">
	<div class="container">
		<h1>Send Email</h1>
		
		<form id="compose">
      From
      <select id='from' name='from' form="compose">
        <?php
          foreach($imapinfo as $account){
            
            if ($account['email']==$from){
              $selected="selected";
            }
            else{
              $selected="";
            }
            
$output = <<<EOL
  <option value="{$account['email']}" $selected>{$account['email']}</option>
EOL;
echo $output;
          } 
        ?>      
      </select>
      <?php
        if(!isset($to)){
          $to='';
        }
$output = <<<EOL
 <input id='to' type='email' placeholder='Email' value="{$to}">
EOL;
echo $output;
      ?>
			<input id='subject' type="text" placeholder="Subject">
			<input id='message' type="text" placeholder="Message">
			<button type="submit" id="sendmail">Send</button>
		</form>
	</div>
</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

     <script src="js/compose.js"></script>

    
    
    
  </body>
</html>
