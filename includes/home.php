<?php
$query_homeposts = 'SELECT * from home_posts ORDER BY id DESC';
$homeposts = $conn->query($query_homeposts);
$totalRows_homeposts = $homeposts->rowCount();

while($row_homeposts = $homeposts->fetch(PDO::FETCH_ASSOC)) {
  echo "<h1>" . $row_homeposts['titel'] . "</h1>";
  echo "<p>" . $row_homeposts['text'] . "</p>";
  echo "<br />";
}
?>
