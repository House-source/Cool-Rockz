// Sample cart data (in full implementation this would come from backend)
let cartItems = [
  { id: 1, name: "Smiley Rock", price: 5, quantity: 1 },
  { id: 2, name: "Adjustable Brass Arm Stand", price: 15, quantity: 2 },
];

// Render Cart Table
function renderCart() {
  const tbody = document.querySelector('#cart-table tbody');
  tbody.innerHTML = '';

  cartItems.forEach((item, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.name}</td>
      <td>$${item.price.toFixed(2)}</td>
      <td>
        <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="qty-input"/>
      </td>
      <td>$${(item.price * item.quantity).toFixed(2)}</td>
      <td><button data-index="${index}" class="remove-btn">Remove</button></td>
    `;
    tbody.appendChild(row);
  });

  updateTotal();
}

// Get cart $ total
function updateTotal() {
  let total = 0;
  cartItems.forEach(item => {
    total += item.price * item.quantity;
  });
  document.getElementById('grand-total').textContent = total.toFixed(2);
}

// Update Cart if quantity is updated
document.addEventListener('input', function (e) {
  if (e.target.classList.contains('qty-input')) {
    const index = e.target.getAttribute('data-index');
    const newQty = parseInt(e.target.value);
    if (newQty > 0) {
      cartItems[index].quantity = newQty;
      renderCart();
    }
  }
});

// Respond to button presses
document.addEventListener('click', function (e) {
	
	// 'remove' button removes item from cart
  if (e.target.classList.contains('remove-btn')) {
    const index = e.target.getAttribute('data-index');
    cartItems.splice(index, 1);
    renderCart();
  }
	
	// 'submit order' button clears cart when order is submitted
  if (e.target.id === 'submit-order') {
    alert('Order submitted! (test)');
    cartItems = [];
    renderCart();
  }
});

renderCart();
