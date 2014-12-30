<?php
$query_hoofdpagina = 'SELECT * from hoofdpagina WHERE page_id = :page_id';
$hoofdpagina = $conn->prepare($query_hoofdpagina, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$hoofdpagina->execute(array(':page_id' => $_GET["home"]));
$verhuur = $hoofdpagina->fetch(PDO::FETCH_ASSOC);

echo "<h1>" . $verhuur['titel'] . "</h1>";
echo $verhuur['text'];
?>
