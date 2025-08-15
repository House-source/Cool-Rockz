<?php

// admin.php
// Admin dashboard only visible to users with 'admin' user_role

include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/styles.css" /> <!-- optional -->
</head>
<body>
	<main class="home-container">
		<div>
			<h1>Admin Dashboard</h1>
				<ul>
					<li><a href="admin/manage_product.php">Manage Products</a> - Manage the inventory from the front end.</li>
					<li><a href="admin/manage_users.php">Manage Users</a> - Manage all users, including user role.</li>
					<li><a href="admin/messages.php">View Contact Messages</a> - View messages sent in from users.</li>
				</ul>
		</div>
	</main>
</body>
</html>