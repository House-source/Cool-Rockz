<?php
session_start();
// Define default links or variables
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
?>

<header>
  <nav class="navbar">
    <div class="logo">CoolRockz</div>
    <input type="checkbox" id="toggle-menu" />
    <label for="toggle-menu" class="menu-icon">&#9776;</label>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      
      <li class="dropdown">
        <a href="catalogue/index.php">Catalogue</a>
        <ul class="dropdown-content">
          <li><a href="catalogue/rocks.php">Rockz</a></li>
          <li><a href="catalogue/stands.php">Standz</a></li>
        </ul>
      </li>

      <li><a href="cart.php">Cart</a></li>
      
      <!-- Login / My Account Link -->
      <?php if ($is_logged_in): ?>
        <li><a href="account.php">My Account</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>

      <!-- Admin Panel (if user is admin) -->
      <?php if ($is_admin): ?>
        <li><a href="admin.php">Admin Panel</a></li>
      <?php endif; ?>

      <li><a href="contact.php">Contact</a></li>
    </ul>
  </nav>
</header>