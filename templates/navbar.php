<?php
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase" style="background: linear-gradient(109.6deg, rgb(84, 13, 110) 11.2%, rgb(238, 66, 102) 100.2%)"> <!-- Changed Navbar color -->
  <div class="container">
    <a class="navbar-brand h1 d-flex align-items-center" href="./index.php">
      <img src="./images/logo.jpg" alt="MA Creations Logo" class="me-2" style="height: 60px; border-radius: 20px;"> <!-- Added logo -->
      <?php echo "MA Creations" ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MyNavbar" aria-controls="MyNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="MyNavbar">
      <form class="d-flex btn-search" role="search" action="search.php" method="GET">
        <div class="input-group">
          <input class="form-control" type="search" name="q" placeholder="<?php echo $lang['Search'] ?>" aria-label="Search" required="required" />
          <button class="btn btn-outline-light" type="submit"><?php echo 'Go' ?></button> <!-- Button enabled -->
        </div>
      </form>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php foreach ($navbarItems as $itemName => $itemLink) : ?>
          <li class="nav-item">
            <a class="nav-link <?php pageActive($pageTitle, $itemName); ?>" href="<?php echo $itemLink; ?>"><?php echo $lang[$itemName]; ?></a>
          </li>
        <?php endforeach; ?>
        <li class="nav-item">
          <a class="btn btn-light position-relative" href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
              <?php echo $cartCount; ?>
              <span class="visually-hidden">unread messages</span>
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
