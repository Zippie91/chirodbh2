<?php
$query_links = 'SELECT * from links ORDER BY id';
$links = $conn->prepare($query_links, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$links->execute(array(':page_id' => $_GET["home"]));
?>
<h1>Nuttige links &amp; weetjes</h1>
<p>Op deze pagina vind je enkele links naar pagina's met informatie over de chiro en weetjes over de werking.</p>
<?php
while($row_links = $links->fetch(PDO::FETCH_ASSOC)) {
  echo "<p>";
  echo "<a href=\"http://" . $row_links['url'] . "\" target=_blank>" . $row_links['omschrijving'] . "</a>";
  echo "</p>";
}
?>
