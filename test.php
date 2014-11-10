<?php
/* Connection to database */
require_once("Connection/db_connection.php");

/* Query the database */
$query_homeposts = 'SELECT * from homeposts';
$homeposts = $conn->query($query_homeposts);
$totalRows_homeposts = $homeposts->rowCount();

include('_head.inc.php');
include('_body-header.inc.php');

/* Main content */
include('_body-content-main.inc.php');
?>
<!-- Body Main Content -->
<?php
while($row_homeposts = $homeposts->fetch(PDO::FETCH_ASSOC)) {
  echo "<h1>" . $row_homeposts['titel'] . "</h1>";
  echo $row_homeposts['text'];
  echo "<br />";
}
?>
  <!-- End Main Content -->
<?php
/* Aside */
include('_body-content-aside.inc.php');
?>
<!-- Body Aside -->
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lacinia maximus lectus a luctus. Morbi elementum ipsum vitae tellus sagittis, et efficitur ante interdum. Nullam maximus lacinia ante sit amet luctus. Curabitur nec tortor rhoncus, bibendum odio quis, volutpat ex. Mauris vehicula lorem semper nulla congue, a porttitor ipsum ullamcorper. Quisque volutpat tortor ac sem imperdiet iaculis. Duis volutpat lacinia urna, eget aliquam mi interdum et. Ut vitae laoreet nibh.
</p>
<!-- End Aside -->
<?php
include('_body-footer.inc.php');
?>