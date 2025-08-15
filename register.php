<?php 

// register.php
// Form for user registration

include 'includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - CoolRockz</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>

<main class="form-container">
  <h2>Create an Account</h2>

  <!-- Error Message Display -->
  <?php if (isset($_SESSION['register_error'])): ?>
    <div class="error-message">
      <?php 
        echo htmlspecialchars($_SESSION['register_error']); 
        unset($_SESSION['register_error']);
      ?>
    </div>
  <?php endif; ?>

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
