<?php include("db_config.inc.php"); ?>
<?php
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $user, $password);
}  catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br />";
  die();
}
?>
