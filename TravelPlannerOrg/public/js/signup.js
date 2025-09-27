
document.getElementById('signupForm').addEventListener('submit', function(e) {
  const email= document.querySelector('input[name="email"]').value;
  if(!email.includes('@')||!email.includes('.')){
    e.preventDefault();
    alert("Please enter a valid email address.");
    return;
  }
  const password = document.querySelector('input[name="password"]').value;
  if (password.length < 4) {
    e.preventDefault();
    alert("Password must be at least 6 characters long.");
    return;
  }
  const confirmPassword = document.querySelector('input[name="confirmPassword"]').value;
  if (password !== confirmPassword) {
    e.preventDefault();
    alert("Passwords do not match.");
    return;
  }
  const terms = document.querySelector('input[name="terms"]');
  if (!terms.checked) {
    e.preventDefault();
    alert("You must agree to the terms and conditions!");
  }
});

