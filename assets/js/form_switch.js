// Function to toggle password visibility
function togglePassword(id) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}

// Function to go to specific step
function goToStep(step) {
    document.querySelectorAll('.step').forEach(el => {
        el.classList.remove('active');
    });
    
    document.querySelectorAll('.progress-step').forEach(el => {
        el.classList.remove('active');
        el.classList.remove('completed');
    });
    
    document.getElementById('step' + step).classList.add('active');
    
    // Update progress bar
    for (let i = 1; i <= step; i++) {
        if (i === step) {
            document.getElementById('step' + i + '-progress').classList.add('active');
        } else {
            document.getElementById('step' + i + '-progress').classList.add('completed');
        }
    }
}

// Function to show notification
function showNotification(message, isError = false) {
    // Create notification element if it doesn't exist
    let notification = document.querySelector('.notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.className = 'notification';
        document.querySelector('.container').appendChild(notification);
    }
    
    // Set notification content and style
    notification.textContent = message;
    notification.classList.add(isError ? 'error' : 'success');
    notification.style.display = 'block';
    
    // Hide notification after 5 seconds
    setTimeout(() => {
        notification.style.display = 'none';
        notification.classList.remove('error', 'success');
    }, 5000);
}

// Handle email form submission
document.getElementById('email-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const formData = new FormData();
    formData.append('email', email);
    
    // Show loading state
    const submitBtn = this.querySelector('.submit-btn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;
    
    fetch('../services/email.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        if (data.status === 'success') {
            showNotification(data.message);
            goToStep(2);
        } else {
            showNotification(data.message, true);
        }
    })
    .catch(error => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        showNotification('An error occurred. Please try again.', true);
        console.error('Error:', error);
    });
});

// Handle verification form submission
document.getElementById('verification-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Collect the 6-digit code
    const codeInputs = document.querySelectorAll('.verification-code input');
    let verificationCode = '';
    codeInputs.forEach(input => {
        verificationCode += input.value;
    });
    
    // Create form data
    const formData = new FormData();
    formData.append('verification_code', verificationCode);
    
    // Show loading state
    const submitBtn = this.querySelector('.submit-btn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Verifying...';
    submitBtn.disabled = true;
    
    fetch('../services/verify_code.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        if (data.status === 'success') {
            showNotification(data.message);
            goToStep(3);
        } else {
            showNotification(data.message, true);
        }
    })
    .catch(error => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        showNotification('An error occurred. Please try again.', true);
        console.error('Error:', error);
    });
});

// Handle password form submission
document.getElementById('password-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const password = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    
    if (password !== confirmPassword) {
        showNotification('Passwords do not match!', true);
        return;
    }
    
    // Create form data
    const formData = new FormData();
    formData.append('new_password', password);
    
    // Show loading state
    const submitBtn = this.querySelector('.submit-btn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Resetting...';
    submitBtn.disabled = true;
    
    fetch('../services/reset_password.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        if (data.status === 'success') {
            showNotification(data.message);
            // Redirect to login page after 2 seconds
            setTimeout(() => {
                window.location.href = '/signin';
            }, 2000);
        } else {
            showNotification(data.message, true);
        }
    })
    .catch(error => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        showNotification('An error occurred. Please try again.', true);
        console.error('Error:', error);
    });
});

// Auto-tabbing for verification code inputs
const codeInputs = document.querySelectorAll('.verification-code input');

codeInputs.forEach((input, index) => {
    input.addEventListener('input', function() {
        if (this.value.length === 1 && index < codeInputs.length - 1) {
            codeInputs[index + 1].focus();
        }
    });
    
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
            codeInputs[index - 1].focus();
        }
    });
});

// Resend code functionality
document.querySelector('.resend-link').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Disable the link temporarily
    this.style.pointerEvents = 'none';
    this.textContent = 'Sending...';
    
    fetch('../services/resend_otp.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showNotification(data.message);
        } else {
            showNotification(data.message, true);
        }
        
        // Re-enable the link after 30 seconds
        setTimeout(() => {
            this.style.pointerEvents = 'auto';
            this.textContent = 'Resend Code';
        }, 30000);
    })
    .catch(error => {
        showNotification('An error occurred. Please try again.', true);
        console.error('Error:', error);
        
        // Re-enable the link
        this.style.pointerEvents = 'auto';
        this.textContent = 'Resend Code';
    });
});