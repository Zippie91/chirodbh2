<?php
  $werkgroep_query = 'SELECT * FROM hoofdpagina WHERE page_id = :page_id and groep = :groep';
  $werkgroepen = $conn->prepare($werkgroep_query);
  $werkgroepen->execute(array(':page_id' => $_GET['home'], ':groep' => $_GET['groep']));
  $werkgroep = $werkgroepen->fetch(PDO::FETCH_ASSOC);
  
  echo $werkgroep['text'];
?>