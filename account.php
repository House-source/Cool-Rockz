<?php 

// account.php
// View and edit user information, view order history.

include 'includes/header.php'; 
require 'includes/db.php'; // your database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found with ID: " . htmlspecialchars($user_id);
    exit();
}

if (!$user) {
    // User not found in database; redirect or handle error
    header('Location: login.php');
    exit();
}

// Fetch purchase history
$stmt_orders = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt_orders->execute([$user_id]);
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

// Initialize $orders as empty array if none found
if (!$orders) {
    $orders = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Account - CoolRockz</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>	
<main class="account-container">
  <h2>My Account</h2>

  <section class="user-info">
    <h3>User Information</h3>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Member Since:</strong> <?php echo date('M Y', strtotime($user['date_joined'])); ?></p>
	
	<!-- Edit Profile button -->
	<p><a href="profile.php" class="btn-edit">Edit Profile</a></p>
  </section>

  <section class="order-history">
    <h3>Purchase History</h3>
    <?php if (count($orders) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Order ID</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
          <td><?php echo htmlspecialchars($order['order_date']); ?></td>
          <td>#<?php echo htmlspecialchars($order['id']); ?></td>
          <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
          <td><?php echo htmlspecialchars($order['status']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p>You have no orders yet.</p>
    <?php endif; ?>
  </section>
</main>

<footer>
  <p>&copy; 2025 CoolRockz Inc.</p>
</footer>
</body>
</html>