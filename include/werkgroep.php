<?php 
if(isset($_GET['groep'])) { 
    $werkgroep_id = (int)$_GET['groep'];
	
	$werkgroep_query = 'SELECT * FROM werkgroep WHERE id = :id and actief = :actief';
	$werkgroepen = $conn->prepare($werkgroep_query);
	$werkgroepen->execute(array(':id' => $werkgroep_id, ':actief' => 1));
	$werkgroep = $werkgroepen->fetch(PDO::FETCH_ASSOC);
	echo "<h1>" . $werkgroep['naam'] . "</h1>";
	
	switch($_GET['groep']) {
	  case 1:
	    include('include/werkgroep/leiding.php');
		break;
	  case 2:
	    include('include/werkgroep/veebees.php');
		break;
	  default: 
	    include('include/werkgroep/default.php');
		break;
	}
} else { ?>
  <h1>Werkgroepen</h1>	
  <p>De Chiro wordt gevormd en ondersteund door een aantal werkgroepen, elk met hun eigen taak. Het doel van deze groepen is voor elke werkgroep hetzelfde: Zorgen dat het kind in een veilige en leuke omgeving zich kan amuseren. </p>
  <?php
  $werkgroep_query = 'SELECT * FROM werkgroep WHERE actief = 1';
  $werkgroepen = $conn->query($werkgroep_query);
  echo "<p>";
  while($werkgroep = $werkgroepen->fetch(PDO::FETCH_ASSOC)) {
	echo "<a href=index.php?home=3&groep=" . $werkgroep['id'] . ">" . $werkgroep['naam'] . "</a><br /><br />";
  }
  echo "</p>";
} ?>