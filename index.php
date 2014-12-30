<?php
  /* Connection to Database */
  require_once('Connection/db_connection.php');

  include('layout/_head.inc.php');
  include('layout/_body-header.inc.php');

  /* Main content */
  include('layout/_body-content-main.inc.php');
  ?>
  <!-- Body Main Content -->
  <?php

  switch($_GET["home"]) {
    case 1:
      include('include/home.php');
      break;
    case 2:
      include('include/afdeling.php');
      break;
    case 3:
      include('include/werkgroep.php');
      break;
    case 4:
      include('include/verhuur.php');
      break;
    case 5:
      include('include/contact.php');
      break;
    case 6:
      include('include/links.php');
      break;
    default:
      include('include/home.php');
  }
   ?>
  <!-- End Main Content -->
  <?php
  /* Aside */
  include('layout/_body-content-aside.inc.php');
  ?>
  <!-- Body Aside -->
  <?php include('include/aside/attention.php'); ?>
  <?php include('include/aside/activiteit.php'); ?>
  <?php include('include/aside/gastenboek.php'); ?>
  <!-- End Aside -->
  <?php
  include('layout/_body-footer.inc.php');

  /* Close all connections */
  $conn = null;
?>
