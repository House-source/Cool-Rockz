<?php

// index.php
// homepage for Cool Rockz
// Introduction to site and informs users on features, requests registration

include 'includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home - CoolRockz</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>

  <main class="home-container">
    <div>
      <h1>Welcome to CoolRockz Inc.</h1>
		<p>Your one-stop shop for cool rocks and cool rocks accessories. Have a look around!</p><br>
	  <h2>If you like what you see, <a href="<?php echo $baseUrl; ?>register.php">register</a> for an account!</h2>
		<p> With your account you get access to these sweet perks:<p><br>
		<ul>
			<li>Become a part of our coveted Cool Rockz Crew!</li>
			<li>Fill your shopping cart and make an order!</li>
			<li>View your account page and check the status of an order. You can also reflect on all the great orders you've made in the past!.</li>
			<li>Send us a message! Complaints or compliments, we're happy to hear from you!</li>
		</ul>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 CoolRockz Inc.</p>
  </footer>
</body>
</html>
