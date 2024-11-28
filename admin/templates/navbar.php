<nav class="navbar navbar-expand-lg text-capitalize" style="background: linear-gradient(109.6deg, rgb(84, 13, 110) 11.2%, rgb(238, 66, 102) 100.2%);">
  <div class="container">

    <a class="navbar-brand d-flex align-items-center h1 text-white" href="./dashboard.php">
      <img src="./images/logo.jpg" alt="Logo" class="me-2" style="height: 50px; width: 50px; border-radius: 20px;">
      Dashboard
    </a>

    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#MyNavbar" aria-controls="MyNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(100%);"></span>
    </button>
    <div class="collapse navbar-collapse" id="MyNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link text-white" href="edit-customers.php">Customers</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="edit-orders.php">Orders</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="./edit-products.php">Products</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
              echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') : 'Guest'; 
            ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="./edit-profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="../">Visit Store</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="./logout.php">LogOut</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
