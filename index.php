<?php
  echo 'Hello';
  require_once('Connection/db_connection.php');
  echo 'again\n';
  include('layout/_head.inc.php');
  include('layout/_body-header.inc.php');

  /* Main content */
  include('layout/_body-content-main.inc.php');
  ?>
  <!-- Body Main Content -->
  <?php include('include/home.php'); ?>
  <!-- End Main Content -->
  <?php
  /* Aside */
  include('layout/_body-content-aside.inc.php');
  ?>
  <!-- Body Aside -->

  <!-- End Aside -->
  <?php
  include('layout/_body-footer.inc.php');

  /* Close all connections */
  $conn = null;
?>
