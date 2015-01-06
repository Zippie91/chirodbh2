<?php
  $afdeling_query = 'SELECT * FROM afdeling WHERE actief = 1 ORDER BY id';
  $afdelingen = $conn->query($afdeling_query);
  
  while($afdeling = $afdelingen->fetch(PDO::FETCH_ASSOC)) {
	echo "<li><a href=index.php?home=2&afdeling=" . $afdeling['id'] . ">" . $afdeling['naam'] . "</a></li>";  
  }
?>