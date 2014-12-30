<?php
require_once('../PHP/DB.class.php');
require_once('../PHP/Chat.class.php');
require_once('../PHP/ChatBase.class.php');
require_once('../PHP/ChatLine.class.php');
require_once('../PHP/ChatUser.class.php');
require_once('../Connection/db_config.inc.php');

session_name('gastenboek');
session_start();

if(get_magic_quotes_gpc()) {
  //If magic quotes is enabled, strip the extra slashes
  array_walk_recursice($_GET, create_function('&$v,$k','$v = stripslashes($v);'));
  array_walk_recursice($_POST,create_function('&$v,$k','$v = stripslashes($v);'));	
}

try {
	$conn = new DB($dbOptions);
	
	$response = array();
	
	// Handling the supported actions:
	switch($_GET['action']) {
	  case 'login':
	    $response = Chat::login($_POST['name'], $_POST['email']);
		break;
	  
	  case 'checkLogged':
	    $response = Chat::checkLogged();
		break;
		
	  case 'logout':
	    $response = Chatt::logout();
		break;
		
	  case 'submitChat':
	    $response = Chat::submitChat($_POST['chatText']);
		break;
		
	  case 'getUsers':
	    $response = Chat::getUsers();
		break;
		
	  case 'getChats':
	    $response = Chat::getChats($_GET['lastID']);
		break;
		
	  default:
	    throw new Exception('Wrong action!');	
	}
	
	echo json_encode($response);
	
} catch (PDOExecption $e) {
	print "Error!: " . $e->getMessage() . "<br />";
  	die();	
}
?>