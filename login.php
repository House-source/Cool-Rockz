<?php 

// login.php
// Form for user login

include 'includes/header.php'; 
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

  <main class="form-container">
	<!-- Display error on page -->	
	<?php if (isset($_SESSION['error'])): ?>
		<div class="error-message">
			<?php 
				echo htmlspecialchars($_SESSION['error']);
				unset($_SESSION['error']); // Clear it after showing
			?>
		</div>
	<?php endif; ?>
    <h2>Login</h2>
	
	<!-- Displays Account Purchase History After Login -->
    <form action="php/login.php" method="POST">
		<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
	
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
