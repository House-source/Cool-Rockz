<?php

// contact.php
// Simple contact form to allow users to contact admins.

include 'includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login or show error
    header('Location: login.php'); // or display a message
    exit;
}

// Assume user info stored in session
$userName = $_SESSION['user_name']; // e.g., "John Doe"
$userEmail = $_SESSION['user_email']; // e.g., "john@example.com"
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Contact Us - CoolRockz</title>
<link rel="stylesheet" href="css/styles.css" />
</head>
<body>
	<main class="form-container">
	<h2>Contact Us</h2>
	
	<!-- Feedback message container -->
	<p id="form-status"></p>
	<form id="contactForm" action="php/contact.php" method="POST">
	  <!-- Hidden CSRF token -->
	  <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

	  <!-- Display user info -->
	  <p>Name: <?php echo htmlspecialchars($userName); ?></p>
	  <p>Email: <?php echo htmlspecialchars($userEmail); ?></p>

	  <!-- Hidden inputs to send data -->
	  <input type="hidden" name="name" value="<?php echo htmlspecialchars($userName); ?>">
	  <input type="hidden" name="email" value="<?php echo htmlspecialchars($userEmail); ?>">

	  <label for="message">Message</label>
	  <textarea id="message" name="message" rows="5" required></textarea>

	  <button type="submit">Send Message</button>
	</form>

	<script src='js/contact.js'></script>

	</main>
<footer>
  <p>&copy; 2025 CoolRockz Inc.</p>
</footer>
</body>
</html>