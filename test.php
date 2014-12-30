<?php
/* Connection to database */
require_once("Connection/db_connection.php");

/* Query the database */
$query_homeposts = 'SELECT * from home_posts ORDER BY id DESC';
$homeposts = $conn->query($query_homeposts);
$totalRows_homeposts = $homeposts->rowCount();

include('layout/_head.inc.php');
include('layout/_body-header.inc.php');

/* Main content */
include('layout/_body-content-main.inc.php');
?>
<!-- Body Main Content -->
<?php
while($row_homeposts = $homeposts->fetch(PDO::FETCH_ASSOC)) {
  echo "<h1>" . $row_homeposts['titel'] . "</h1>";
  echo "<p>" . $row_homeposts['text'] . "</p>";
  echo "<br />";
}
?>
  <!-- End Main Content -->
<?php
/* Aside */
include('layout/_body-content-aside.inc.php');
?>
<!-- Body Aside -->
<h3>Let op!</h3>
<p></p>
<h3>Volgende activiteit</h3>
<h3>Gastenboek</h3>
<?php include('includes/gastenboek/gastenboek.php'); ?>
<!-- End Aside -->
<?php
include('layout/_body-footer.inc.php');

$homeposts->CloseCursor();
$conn = null;
?>
