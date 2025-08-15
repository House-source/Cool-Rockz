<?php

// db_error.php
// Handler page if database connection cannot be established.

include '../includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Service Unavailable - CoolRockz</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>

  <main class="home-container">
    <div>
      <h1>Something went wrong.</h1>
        <p>We're currently having trouble connecting to our database.</p>
        <p>Please try again later, or contact support if the issue persists.</p>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 CoolRockz Inc.</p>
  </footer>
</body>
</html>