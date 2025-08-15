<?php

// admin/messages.php
// Allows admins to view messages from 'contact messages' table for viewing and deletion

include '../includes/header.php';
require '../includes/db.php';

// Fetch all contact messages with user info
$stmt = $pdo->query("SELECT cm.id, cm.message, cm.date_sent, u.name, u.email FROM contact_messages cm JOIN users u ON cm.user_id = u.id ORDER BY cm.date_sent DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin - Contact Messages</title>
<link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
<main class="account-container">
	<h1>Contact Messages</h1>
		<table>
		  <thead>
			<tr>
			  <th>ID</th>
			  <th>Name</th>
			  <th>Email</th>
			  <th>Message</th>
			  <th>Date Sent</th>
			  <th>Actions</th>
			</tr>
		  </thead>
		  <tbody>
			<?php if ($messages): ?>
			  <?php foreach ($messages as $msg): ?>
				<tr>
				  <td><?php echo htmlspecialchars($msg['id']); ?></td>
				  <td><?php echo htmlspecialchars($msg['name']); ?></td>
				  <td><?php echo htmlspecialchars($msg['email']); ?></td>
				  <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
				  <td><?php echo htmlspecialchars($msg['date_sent']); ?></td>
				  <td>
					<!-- Delete button -->
					<form method="POST" action="../php/delete_message.php" class="inline-form delete-form">
					  <input type="hidden" name="id" value="<?php echo htmlspecialchars($msg['id']); ?>">
					  <button type="submit">Delete</button>
					</form>
				  </td>
				</tr>
			  <?php endforeach; ?>
			<?php else: ?>
			  <tr><td colspan="6">No messages found.</td></tr>
			<?php endif; ?>
		  </tbody>
		</table>
	<script src="../js/deleteMessage.js"></script>
</body>
</html>