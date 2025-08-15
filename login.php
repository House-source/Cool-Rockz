<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - CoolRockz</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="logo">CoolRockz</div>
      <input type="checkbox" id="toggle-menu">
      <label for="toggle-menu" class="menu-icon">&#9776;</label>
      <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="catalogue/index.html">Catalogue</a></li>
        <li><a href="cart.html">Cart</a></li>
        <li><a href="login.php" class="active">Login</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main class="form-container">
    <h2>Login</h2>
	
	<!-- Displays Account Purchase History After Login -->
    <form action="php/login.php" method="POST">
		<label for="email">Email</label>
		<input type="email" id="email" name="email" required />

		<label for="password">Password</label>
		<input type="password" id="password" name="password" required />

		<button type="submit">Login</button>
		<p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>
  </main>

  <footer>
    <p>&copy; 2025 CoolRockz Inc.</p>
  </footer>
</body>
</html>
