<?php
  $werkgroep_query = 'SELECT * FROM werkgroep WHERE actief = 1 ORDER BY id';
  $werkgroepen = $conn->query($werkgroep_query);
  
  while($werkgroep = $werkgroepen->fetch(PDO::FETCH_ASSOC)) {
	echo "<li><a href=index.php?home=3&groep=" . $werkgroep['id'] . ">" . $werkgroep['naam'] . "</a></li>"; 
  }
?>