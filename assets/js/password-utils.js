// password-utils.js

/**
 * Toggles password visibility for the specified input field
 * @param {string} inputId - The ID of the password input field
 */
function togglePassword(inputId) {
    // Get the input element and its associated toggle button
    const input = document.getElementById(inputId);
    if (!input) return;

    const button = input.parentElement.querySelector('.password-toggle');
    if (!button) return;

    const icon = button.querySelector('svg');
    if (!icon) return;

    // SVG paths for eye icons
    const VISIBLE_EYE = `
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
        <circle cx="12" cy="12" r="3"></circle>
    `;

    const HIDDEN_EYE = `
        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
        <line x1="1" y1="1" x2="23" y2="23"></line>
    `;

    // Toggle password visibility
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = HIDDEN_EYE;
    } else {
        input.type = 'password';
        icon.innerHTML = VISIBLE_EYE;
    }
}

// Initialize password toggle functionality for all password fields
document.addEventListener('DOMContentLoaded', function() {
    // Add the functionality to any password field that has the toggle button
    const passwordFields = document.querySelectorAll('input[type="password"]');
    
    passwordFields.forEach(field => {
        const parentDiv = field.parentElement;
        if (parentDiv && parentDiv.classList.contains('password-field')) {
            // Ensure the field has an ID
            if (!field.id) {
                field.id = 'password-' + Math.random().toString(36).substr(2, 9);
            }
        }
    });
});