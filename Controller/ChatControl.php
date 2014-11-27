<?php
require_once('../PHP/DB.class.php');
require_once('../Connection/DB_config.php');

try {
	$conn = new DB($dbOptions);
	
} catch (PDOExecption $e) {
	print "Error!: " . $e->getMessage() . "<br />";
  	die();	
}
?>