// form-validation.js
document.addEventListener('DOMContentLoaded', function() {
    // Get the form
    const form = document.querySelector('form');
    if (!form) return;

    // Get all required inputs
    const requiredInputs = form.querySelectorAll('[required]');

    // Create and append notification container
    const notificationContainer = document.createElement('div');
    notificationContainer.className = 'notification-container';
    document.body.appendChild(notificationContainer);

    // Add styles
    if (!document.querySelector('#validation-styles')) {
        const style = document.createElement('style');
        style.id = 'validation-styles';
        style.textContent = `
            .notification-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
            }

            .notification {
                background-color: #dc2626;
                color: white;
                padding: 12px 24px;
                border-radius: 4px;
                margin-bottom: 10px;
                font-size: 14px;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.3s ease;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }

            .notification.success {
                background-color: #10b981;
            }

            .notification.show {
                opacity: 1;
                transform: translateX(0);
            }

            .field-error {
                color: #dc2626;
                font-size: 0.875rem;
                margin-top: 0.25rem;
                display: none;
            }

            .input-error {
                border: 1px solid #dc2626 !important;
            }
            
            .shake {
                animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
            }

            @keyframes shake {
                10%, 90% {
                    transform: translate3d(-1px, 0, 0);
                }
                20%, 80% {
                    transform: translate3d(2px, 0, 0);
                }
                30%, 50%, 70% {
                    transform: translate3d(-3px, 0, 0);
                }
                40%, 60% {
                    transform: translate3d(3px, 0, 0);
                }
            }
        `;
        document.head.appendChild(style);
    }

    // Create error message elements for each required field
    requiredInputs.forEach(input => {
        if (!document.getElementById(`${input.id}-error`)) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'field-error';
            errorDiv.id = `${input.id}-error`;
            input.parentElement.appendChild(errorDiv);
        }
    });

    // Function to show notification
    window.showNotification = function(message, type = 'error') {
        const notification = document.createElement('div');
        notification.className = `notification ${type === 'success' ? 'success' : ''}`;
        notification.textContent = message;
        notificationContainer.appendChild(notification);

        // Trigger reflow for animation
        notification.offsetHeight;
        notification.classList.add('show');

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    };

    // Validate email format
    function isValidEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    // Function to validate a field
    function validateField(input) {
        const errorDiv = document.getElementById(`${input.id}-error`);
        
        // Skip if no error div found
        if (!errorDiv) return true;
        
        // Get field label text (if available)
        let fieldName = input.id.charAt(0).toUpperCase() + input.id.slice(1);
        if (input.previousElementSibling && input.previousElementSibling.tagName === 'LABEL') {
            fieldName = input.previousElementSibling.textContent;
        }
        
        // Empty field validation
        if (!input.value.trim()) {
            errorDiv.textContent = `${fieldName} is required`;
            errorDiv.style.display = 'block';
            input.classList.add('input-error');
            return false;
        }
        
        // Email format validation
        if (input.type === 'email' && !isValidEmail(input.value.trim())) {
            errorDiv.textContent = 'Please enter a valid email address';
            errorDiv.style.display = 'block';
            input.classList.add('input-error');
            return false;
        }
        
        // Password minimum length validation
        if (input.type === 'password' && input.value.length < 6) {
            errorDiv.textContent = 'Password must be at least 6 characters';
            errorDiv.style.display = 'block';
            input.classList.add('input-error');
            return false;
        }
        
        // Valid field
        errorDiv.style.display = 'none';
        input.classList.remove('input-error');
        return true;
    }

    // Add blur event listeners to all required fields
    requiredInputs.forEach(input => {
        input.addEventListener('blur', () => {
            validateField(input);
        });

        // Clear error on input
        input.addEventListener('input', () => {
            const errorDiv = document.getElementById(`${input.id}-error`);
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
            input.classList.remove('input-error');
        });
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        let hasErrors = false;
        let firstInvalidField = null;

        requiredInputs.forEach(input => {
            if (!validateField(input)) {
                hasErrors = true;
                if (!firstInvalidField) {
                    firstInvalidField = input;
                }
            }
        });

        if (hasErrors) {
            e.preventDefault();
            showNotification('Please fill in all required fields');
            
            // Add shake animation to the form container
            const container = document.querySelector('.container');
            if (container) {
                container.classList.add('shake');
                setTimeout(() => {
                    container.classList.remove('shake');
                }, 500);
            }
            
            // Focus the first invalid field
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        }
        
        // Check for hidden email field (if using it for other purposes)
        const emailInput = document.getElementById('email');
        const hiddenEmailField = document.querySelector('input[name="userEmail"]');
        if (emailInput && hiddenEmailField) {
            hiddenEmailField.value = emailInput.value;
        }
    });
    
    // Check URL for error or success messages
    const urlParams = new URLSearchParams(window.location.search);
    const errorMsg = urlParams.get('error');
    const successMsg = urlParams.get('success');
    
    if (errorMsg) {
        showNotification(decodeURIComponent(errorMsg));
    }
    
    if (successMsg) {
        showNotification(decodeURIComponent(successMsg), 'success');
    }
    
    // Check for PHP session messages
    const errorContainer = document.querySelector('.notification.error[style*="display: block"]');
    const successContainer = document.querySelector('.notification.success[style*="display: block"]');
    
    if (errorContainer) {
        showNotification(errorContainer.textContent);
        errorContainer.style.display = 'none';
    }
    
    if (successContainer) {
        showNotification(successContainer.textContent, 'success');
        successContainer.style.display = 'none';
    }
});

// Password toggle functionality
function togglePassword(id) {
    const passwordInput = document.getElementById(id);
    if (passwordInput) {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Optionally change the icon if you have an icon element
        const icon = passwordInput.nextElementSibling?.querySelector('svg');
        if (icon) {
            // Update icon based on password visibility (you can customize this)
            // This is just a placeholder for whatever SVG icon system you're using
        }
    }
}