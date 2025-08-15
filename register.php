<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - CoolRockz</title>
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
		<h2>Create an Account</h2>
		<form action="php/register.php" method="POST">
			<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />
	
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <label for="confirm-password">Confirm Password</label>
      <input type="password" id="confirm-password" name="confirm-password" required />

      <button type="submit">Register</button>
      <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
  </main>

  <footer>
    <p>&copy; 2025 CoolRockz</p>
  </footer>
</body>
</html>
