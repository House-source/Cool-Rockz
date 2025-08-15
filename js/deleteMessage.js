document.addEventListener('DOMContentLoaded', () => {
  const deleteForms = document.querySelectorAll('.delete-form');

  deleteForms.forEach(form => {
    form.addEventListener('submit', function(event) {
      if (!confirm('Delete this message?')) {
        event.preventDefault(); // stop form submission if canceled
      }
    });
  });
});