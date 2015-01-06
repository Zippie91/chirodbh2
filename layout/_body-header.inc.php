  <body>
    <div id="wrapper">
      <header>
        <a href="index.php?home=1">
          <img src="/chirodbh2/images/logodbh.png" alt="Chiro Don Bosco Hoboken" />
        </a>
        <div id="header-slogan">
          <img src="/chirodbh2/images/T-shirt_achterkant_achter_elkaar_(kleur).jpg" alt="Slogan Chiro Don Bosco Hoboken" />
        </div>
      </header>
      <nav>
        <ul>
          <li><a href="index.php?home=1">Home</a></li>
          <li><a href="index.php?home=2">Afdelingen</a>
            <ul class="child">
              <?php include('include/nav/afdeling.php'); ?>
            </ul>
          </li>
          <li><a href="index.php?home=3">Werkgroepen</a>
            <ul class="child">
              <?php include('include/nav/werkgroep.php'); ?>
            </ul>
          </li>
          <li><a href="index.php?home=4">Verhuur</a></li>
          <li><a href="index.php?home=5">Contact</a></li>
          <li><a href="index.php?home=6">Links &amp; weetjes</a></li>
        </ul>
      </nav>
