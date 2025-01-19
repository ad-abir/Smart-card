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
        `;
        document.head.appendChild(style);
    }

    // Create error message elements for each required field
    requiredInputs.forEach(input => {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.id = `${input.id}-error`;
        input.parentElement.appendChild(errorDiv);
    });

    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
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
    }

    function validateField(input) {
        const errorDiv = document.getElementById(`${input.id}-error`);
        if (!input.value.trim()) {
            errorDiv.textContent = `${input.previousElementSibling.textContent} is required`;
            errorDiv.style.display = 'block';
            input.classList.add('input-error');
            return false;
        } else {
            errorDiv.style.display = 'none';
            input.classList.remove('input-error');
            return true;
        }
    }

    // Add blur event listeners to all required fields
    requiredInputs.forEach(input => {
        input.addEventListener('blur', () => {
            validateField(input);
        });

        // Clear error on input
        input.addEventListener('input', () => {
            const errorDiv = document.getElementById(`${input.id}-error`);
            errorDiv.style.display = 'none';
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
            firstInvalidField.focus();
        }
    });
});