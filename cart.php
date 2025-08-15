<?php 

// cart.php
// Cart used to hold products for purchase.
// Modify item quantity, remove products, submit orders.
// Tied to user in database (only accessible to registered users)

include 'includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shopping Cart - CoolRockz</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>

  <main class="cart-container">
    <h2>Your Shopping Cart</h2>
    <table id="cart-table">
      <thead>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Total</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
        <!-- Items will be injected by JavaScript -->
      </tbody>
    </table>

    <div class="cart-summary">
      <p><strong>Grand Total:</strong> $<span id="cart-total">0.00</span></p>
      <button id="checkout-btn">Submit Order</button>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 CoolRockz Inc.</p>
  </footer>

<script src="js/cart.js"></script>
  
</body>
</html>
