// js/cart.js

let cartItems = [];

// Load cart data from server and render
function loadCart() {
  fetch(`${baseUrl}php/load_cart_data.php`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        cartItems = data.items;
        renderCart();
      } else {
        alert(data.message);
      }
    })
    .catch(error => {
      console.error('Error loading cart:', error);
    });
}

// Render cart table from server data
function renderCart() {
  const tbody = document.querySelector('#cart-table tbody');
  if (!tbody) return; // ensure table exists on page
  tbody.innerHTML = '';

  let grandTotal = 0;

  cartItems.forEach((item, index) => {
    const total = item.price * item.quantity;
    grandTotal += total;
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.name}</td>
      <td>$${item.price.toFixed(2)}</td>
      <td><input type="number" min="1" value="${item.quantity}" data-index="${index}" class="qty-input"></td>
      <td>$${total.toFixed(2)}</td>
      <td><button data-index="${index}" class="remove-btn">Remove</button></td>
    `;
    tbody.appendChild(row);
  });

  document.getElementById('grand-total').textContent = grandTotal.toFixed(2);

  // Attach event listeners
  document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('change', handleQtyChange);
  });
  document.querySelectorAll('.remove-btn').forEach(btn => {
    btn.addEventListener('click', handleRemove);
  });
}

// Handle quantity change
function handleQtyChange(e) {
  const index = e.target.dataset.index;
  const newQty = parseInt(e.target.value);
  if (newQty > 0 && index !== undefined) {
    const item = cartItems[index];
    fetch(`${baseUrl}php/update_cart.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ product_id: item.product_id, action: 'update', quantity: newQty })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        loadCart();
      } else {
        alert('Error: ' + data.message);
      }
    });
  }
}

// Handle remove item
function handleRemove(e) {
  const index = e.target.dataset.index;
  if (index !== undefined) {
    const item = cartItems[index];
    fetch(`${baseUrl}php/update_cart.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ product_id: item.product_id, action: 'remove' })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        loadCart();
      } else {
        alert('Error: ' + data.message);
      }
    });
  }
}

// Add product to cart
function addToCart(product) {
  fetch(`${baseUrl}php/update_cart.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ product_id: product.id, action: 'add', quantity: product.qty || 1 })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      loadCart();
      alert(`${product.name} added to cart!`);
    } else {
      alert('Error: ' + data.message);
    }
  });
}

// Initialize on page load
window.onload = () => {
  loadCart();
};