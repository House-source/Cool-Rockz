// Fetch and render cart items
function fetchCart() {
  fetch('php/load_cart.php')
    .then(res => res.json())
    .then(data => {
      if (Array.isArray(data)) {
        renderCart(data);
      } else if (data.error) {
        alert(data.error);
        document.querySelector('#cart-table tbody').innerHTML =
          '<tr><td colspan="5">You must be logged in to view your cart.</td></tr>';
      }
    })
    .catch(err => {
      console.error('Error fetching cart:', err);
    });
}

function renderCart(items) {
  const tbody = document.querySelector('#cart-table tbody');
  tbody.innerHTML = '';
  let total = 0;

  if (items.length === 0) {
    tbody.innerHTML = '<tr><td colspan="5">Your cart is empty.</td></tr>';
    document.getElementById('cart-total').textContent = '$0.00';
    return;
  }

  items.forEach(item => {
    const price = Number(item.price);
    if (isNaN(price)) {
      console.warn('Invalid price:', item.price);
      return; // skip invalid items
    }
    const subtotal = price * item.quantity;
    total += subtotal;

    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.name}</td>
      <td>$${price.toFixed(2)}</td>
      <td>
        <input class="qty-input" data-id="${item.product_id}" type="number" min="1" max="${item.stock_quantity}" value="${item.quantity}">
      </td>
      <td>$${subtotal.toFixed(2)}</td>
      <td>
        <button class="remove-btn" data-id="${item.product_id}">Remove</button>
      </td>
    `;
    tbody.appendChild(row);
  });

  document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
  attachCartEvents();
}

function attachCartEvents() {
  // Quantity input change
  document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('change', (e) => {
      const productId = e.target.dataset.id;
      let newQty = parseInt(e.target.value);
      if (newQty < 1) {
        e.target.value = 1;
        newQty = 1;
      }
      const maxStock = parseInt(e.target.max, 10);
      if (newQty > maxStock) {
        alert(`Only ${maxStock} item(s) in stock.`);
        e.target.value = maxStock;
        newQty = maxStock;
      }

      fetch('php/update_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}&quantity=${newQty}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          fetchCart();  // Refresh cart after update
        } else {
          alert('Failed to update quantity: ' + (data.error || 'Unknown error'));
          fetchCart();  // Revert input on failure
        }
      })
      .catch(err => {
        alert('Error updating cart: ' + err.message);
        console.error(err);
        fetchCart();  // Revert input on error
      });
    });
  });

  // Remove button click
  document.querySelectorAll('.remove-btn').forEach(button => {
    button.addEventListener('click', (e) => {
      const productId = e.target.dataset.id;

      fetch('php/delete_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          fetchCart();  // Refresh cart after removal
        } else {
          alert('Failed to remove item.');
        }
      })
      .catch(err => {
        alert('Error removing item: ' + err.message);
        console.error(err);
      });
    });
  });
}

document.addEventListener('DOMContentLoaded', fetchCart);

// Button: create order from cart items
document.getElementById('checkout-btn').addEventListener('click', () => {
  fetch('php/submit_order.php', {
    method: 'POST'
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Order placed! Order ID: ' + data.order_id);
      window.location.href = 'account.php'; // or orders.php
    } else {
      alert(data.error || 'Failed to place order.');
    }
  })
  .catch(err => {
    console.error(err);
    alert('Checkout failed.');
  });
});
