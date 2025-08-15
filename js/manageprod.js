document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.delete-link').forEach(link => {
    link.addEventListener('click', function(e) {
      if (!confirm('Are you sure you want to delete this product?')) {
        e.preventDefault(); // Stop the navigation
      }
    });
  });
});