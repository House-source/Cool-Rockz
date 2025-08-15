function handleContactSubmit(event) {
  event.preventDefault();

  const form = document.getElementById('contactForm');
  const submitButton = form.querySelector('button[type="submit"]');
  const statusMsg = document.getElementById('form-status');

  // Retrieve message
  const message = document.getElementById('message').value.trim();

  // Basic validation
  if (!message) {
    statusMsg.style.color = 'red';
    statusMsg.textContent = 'Please enter your message.';
    return false;
  }

  // Show sending
  statusMsg.style.color = 'blue';
  statusMsg.textContent = 'Sending...';

  // Disable button
  submitButton.disabled = true;

  // Send via AJAX
  fetch('php/contact.php', {
    method: 'POST',
    body: new FormData(form)
  })
  .then(response => response.text())
  .then(data => {
    statusMsg.style.color = 'green';
    statusMsg.textContent = data;
    submitButton.disabled = false;
    // Optionally clear message
    document.getElementById('message').value = '';
  })
  .catch(error => {
    statusMsg.style.color = 'red';
    statusMsg.textContent = 'An error occurred.';
    submitButton.disabled = false;
  });

  return false; // prevent default
}

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('contactForm');
  form.addEventListener('submit', handleContactSubmit);
});