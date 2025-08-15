document.addEventListener('DOMContentLoaded', () => {
  const searchBox = document.getElementById('search-box');
  const productLinks = document.querySelectorAll('.product-card');

  searchBox.addEventListener('input', function() {
      const query = this.value.toLowerCase();

      productLinks.forEach(link => {
          const name = link.getAttribute('data-name').toLowerCase();
          const stock = parseInt(link.getAttribute('data-stock'), 10);
          if (name.includes(query) && stock > 0) {
              link.style.display = 'block';
          } else {
              link.style.display = 'none';
          }
      });
  });
});