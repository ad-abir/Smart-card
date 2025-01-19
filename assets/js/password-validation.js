// password-validation.js

document.addEventListener('DOMContentLoaded', function() {
    // Get password elements
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    if (!passwordInput || !confirmPasswordInput) return;

    // Create validation message containers
    const passwordField = passwordInput.parentElement;
    const confirmPasswordField = confirmPasswordInput.parentElement;
    
    const passwordMessage = document.createElement('div');
    passwordMessage.className = 'validation-message';
    passwordField.parentElement.appendChild(passwordMessage);
    
    const confirmMessage = document.createElement('div');
    confirmMessage.className = 'validation-message';
    confirmPasswordField.parentElement.appendChild(confirmMessage);

    // Password validation criteria
    const criteria = {
        minLength: 8,
        hasUpperCase: /[A-Z]/,
        hasLowerCase: /[a-z]/,
        hasNumber: /\d/,
        hasSpecialChar: /[!@#$%^&*(),.?":{}|<>]/
    };

    // Function to validate password
    function validatePassword(password) {
        const errors = [];
        
        if (password.length < criteria.minLength) {
            errors.push(`At least ${criteria.minLength} characters`);
        }
        if (!criteria.hasUpperCase.test(password)) {
            errors.push("One uppercase letter");
        }
        if (!criteria.hasLowerCase.test(password)) {
            errors.push("One lowercase letter");
        }
        if (!criteria.hasNumber.test(password)) {
            errors.push("One number");
        }
        if (!criteria.hasSpecialChar.test(password)) {
            errors.push("One special character");
        }
        
        return errors;
    }

    // Function to update validation messages
    function updateValidationMessage(input, message, isValid) {
        const messageDiv = input.parentElement.parentElement.querySelector('.validation-message');
        messageDiv.textContent = message;
        messageDiv.className = `validation-message ${isValid ? 'valid' : 'invalid'}`;
        input.classList.toggle('invalid-input', !isValid);
    }

    // Event listener for password input
    passwordInput.addEventListener('input', function() {
        const errors = validatePassword(this.value);
        
        if (errors.length > 0) {
            updateValidationMessage(
                this,
                `Password requires: ${errors.join(", ")}`,
                false
            );
        } else {
            updateValidationMessage(this, "Password meets all requirements ✓", true);
        }
        
        // Check confirm password match if it has value
        if (confirmPasswordInput.value) {
            checkPasswordMatch();
        }
    });

    // Function to check if passwords match
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (!confirmPassword) {
            updateValidationMessage(confirmPasswordInput, "", true);
            return;
        }
        
        const doPasswordsMatch = password === confirmPassword;
        updateValidationMessage(
            confirmPasswordInput,
            doPasswordsMatch ? "Passwords match ✓" : "Passwords do not match",
            doPasswordsMatch
        );
    }

    // Event listener for confirm password input
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
});

// Add this CSS to your stylesheet
const style = document.createElement('style');
style.textContent = `
    .validation-message {
        font-size: 0.875rem;
        margin-top: 0.25rem;
        transition: all 0.2s ease;
    }

    .validation-message.invalid {
        color: #dc2626;
    }

    .validation-message.valid {
        color: #059669;
    }

    .invalid-input {
        border-color: #dc2626 !important;
    }

    .invalid-input:focus {
        box-shadow: 0 0 0 1px #dc2626 !important;
    }
`;
document.head.appendChild(style);