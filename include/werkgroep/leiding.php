<?php
  $actieve_afd = afdelingAantal($conn);
  foreach($actieve_afd as $afd_id) {
	echo "<h2>" . afdelingNaam($afd_id, $conn) . "</h2>";
	
	$leiding_query = 'SELECT * FROM ploeg WHERE functie = 1 and afdeling = :afdeling';
    $leiding = $conn->prepare($leiding_query);  
	$leiding->execute(array(':afdeling' => $afd_id));
	
	while($leider = $leiding->fetch(PDO::FETCH_ASSOC)) {
      user($leider);
    }
  }
?>
<?php
function user(array $leider) { ?>
  <div class="ploeg">
      <div class="naam"><?php echo $leider['naam']; ?></div>
      <?php if(stristr($leider['functie'], '2')) { ?>
      <div class="groeps"><h4>Groepsleiding</h4></div>
      <?php } ?>
      <div class="foto">
  	    <?php if($leider['foto'] != null) { ?>
          <img src="/chirodbh2/images/smoelenboek/<?php echo $leider['foto']; ?>" />
        <?php } else { ?>
          <img src="/chirodbh2/images/smoelenboek/default.jpg" />
        <?php } ?>
      </div>
      <div class="tekst">
        <ul>
          <?php if($leider['adres'] != null) { ?>
          <li><b>Adres: </b><?php echo $leider['adres']; ?></li>
          <?php } ?>
          <?php if($leider['telefoon'] != null) { ?>
          <li><b>Telefoon: </b><?php echo $leider['telefoon']; ?></li>
          <?php } ?>
          <?php if($leider['email'] != null) { ?>
          <li><b>Email: </b> <a href="mailto:<?php echo $leider['email']; ?>"><?php echo $leider['email']; ?></a></li>
          <?php } ?>
          <?php if($leider['geboortedatum'] != null) { ?>
          <li><b>Geboortedatum: </b><?php echo date('d-m-Y', strtotime($leider['geboortedatum'])); ?></li>
          <?php } ?>
          <?php if($leider['jaarchiro'] != null) { ?>
          <li><b>Aantal jaar in de Chiro: </b><?php echo $leider['jaarchiro']; ?></li>
          <?php } ?>
          <?php if($leider['favo_spel'] != null) { ?>
          <li><b>Favoriet spel: </b><?php echo $leider['favo_spel']; ?></li>
          <?php } ?>
        </ul>
      </div>
    </div>
<?php } ?>
<?php 
function afdelingNaam($afd_id, $conn) {
	$afdeling_query = 'SELECT * FROM afdeling WHERE id = :afd_id and actief = :actief';
	$afdelingen = $conn->prepare($afdeling_query);
	$afdelingen->execute(array(':afd_id' => $afd_id, ':actief' => 1));
	$afdeling = $afdelingen->fetch(PDO::FETCH_ASSOC);

	return $afdeling['naam'];	
}

function afdelingAantal($conn) {
  $afdeling_query = 'SELECT * FROM afdeling WHERE actief = 1';
  $afdelingen = $conn->query($afdeling_query);
  $totaal_afdelingen = $afdelingen->rowCount();
  
  $actief_afdeling = array();
  
  while($afdeling = $afdelingen->fetch(PDO::FETCH_ASSOC)) {
    array_push($actief_afdeling, $afdeling['id']);
  }
  
  return $actief_afdeling;	
}
?>