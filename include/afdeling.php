<?php if(isset($_GET['afdeling'])) { ?>
  <?php 
    $afdeling_id = (int)$_GET['afdeling'];
	
	$afdeling_query = 'SELECT * FROM afdeling WHERE id = :id and actief = :actief';
	$afdelingen = $conn->prepare($afdeling_query);
	$afdelingen->execute(array(':id' => $afdeling_id, ':actief' => 1));
	$afdeling = $afdelingen->fetch(PDO::FETCH_ASSOC);
	echo "<h1>" . $afdeling['naam'] . "</h1>";
	
	$programma_query = 'SELECT * FROM programma WHERE afdeling = :afdeling ORDER BY datum ASC';
	$programmas = $conn->prepare($programma_query);
	$programmas->execute(array(':afdeling' => $afdeling_id));
	
	while($programma = $programmas->fetch(PDO::FETCH_ASSOC)) { ?>
	  <div class="programma">
        <h4><?php echo date('d-m-Y', strtotime($programma['datum'])) . ": " . $programma['begintijd'] . " - " . $programma['eindtijd']; ?></h4>
        <h2><?php echo $programma['titel']; ?></h2>
        <p><?php echo $programma['bericht']; ?></p>
      </div>
	<?php } ?>  
<?php } else { ?>
  <h1>Afdelingen</h1>
  <p>De verschillende leeftijden in de Chiro zijn opgedeeld in verschillende afdelingen. Op deze pagina's vind je de programma's voor de komende zondagen. Elke 2 maanden wordt er een krantje uitgedeeld en komen ook de nieuwe programma's voor die 2 maanden hier op deze pagina's. </p>
  
  <?php 
    $afdeling_query = 'SELECT * FROM afdeling WHERE actief = 1 ORDER BY id'; 
  	$afdelingen = $conn->query($afdeling_query);
	echo "<p>";
	while($afdeling = $afdelingen->fetch(PDO::FETCH_ASSOC)) {
	  echo "<a href=index.php?home=2&afdeling=" . $afdeling['id'] . ">" . $afdeling['naam'] . "</a><br /><br />";
	}
	echo "</p>";
} ?>

