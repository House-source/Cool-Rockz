document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('add-btn');
  if (btn) {
    btn.addEventListener('click', () => {
      const product = JSON.parse(btn.getAttribute('data-product'));
      product.qty = 1; // default quantity
      addToCart(product);
    });
  }
});

function addToCart(product) {
  fetch('../php/add_cart.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `product_id=${encodeURIComponent(product.id)}&quantity=${encodeURIComponent(product.qty)}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Added to cart!');
      // Optionally refresh cart UI here
    } else if (data.error) {
      alert('Error: ' + data.error);
    }
  })
  .catch(() => {
    alert('Network error. Try again later.');
  });
}