<?php

// includes/header.php
// Used in all webpages for consistent navigation and session management across the website.

// Force HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $httpsUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $httpsUrl");
    exit();
}

session_start();

$baseUrl = '/shopping_site/'; // static reference point for paths

// Session Timeout (e.g., 20 min inactivity)
$timeout = 20 * 60; // 20 minutes
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > $timeout) {
    session_unset();
    session_destroy();
    header("Location: {$baseUrl}login.php?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time(); // update timestamp

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
?>
<header>
  <nav class="navbar">
    <div class="logo">CoolRockz</div>
    <input type="checkbox" id="toggle-menu" />
    <label for="toggle-menu" class="menu-icon">&#9776;</label>
    <ul class="nav-links">
      <li><a href="<?php echo $baseUrl; ?>index.php">Home</a></li>
      
      <li class="dropdown">
        <a href="<?php echo $baseUrl; ?>catalogue/index.php">Catalogue</a>
        <ul class="dropdown-content">
          <li><a href="<?php echo $baseUrl; ?>catalogue/rocks.php">Rockz</a></li>
          <li><a href="<?php echo $baseUrl; ?>catalogue/stands.php">Standz</a></li>
        </ul>
      </li>
      
      <!-- Login / My Account Link -->
      <?php if ($is_logged_in): ?>
		<li><a href="<?php echo $baseUrl; ?>cart.php">Cart</a></li>
        <li><a href="<?php echo $baseUrl; ?>account.php">My Account</a></li>
		<li><a href="<?php echo $baseUrl; ?>contact.php">Contact</a></li>
		<li><a href="<?php echo $baseUrl; ?>includes/logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="<?php echo $baseUrl; ?>login.php">Login</a></li>
      <?php endif; ?>

      <!-- Admin Panel (if user is admin) -->
      <?php if ($is_admin): ?>
        <li><a href="<?php echo $baseUrl; ?>admin.php">Admin Panel</a></li>
      <?php endif; ?>

      
    </ul>
  </nav>
</header>