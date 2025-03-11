// password-reset-validation.js

document.addEventListener('DOMContentLoaded', function() {
    // Get password elements
    const newPasswordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    
    if (!newPasswordInput || !confirmPasswordInput) return;

    // Create validation message containers
    const newPasswordField = newPasswordInput.parentElement.parentElement;
    const confirmPasswordField = confirmPasswordInput.parentElement.parentElement;
    
    const passwordMessage = document.createElement('div');
    passwordMessage.className = 'validation-message';
    newPasswordField.appendChild(passwordMessage);
    
    const confirmMessage = document.createElement('div');
    confirmMessage.className = 'validation-message';
    confirmPasswordField.appendChild(confirmMessage);

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

    // Event listener for new password input
    newPasswordInput.addEventListener('input', function() {
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
        const password = newPasswordInput.value;
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

    // Toggle password visibility
    // window.togglePassword = function(inputId) {
    //     const input = document.getElementById(inputId);
    //     if (!input) return;
        
    //     const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    //     input.setAttribute('type', type);
        
    //     // Update toggle button icon
    //     const button = input.nextElementSibling;
    //     if (button && button.classList.contains('password-toggle')) {
    //         const svg = button.querySelector('svg');
    //         if (type === 'text') {
    //             svg.innerHTML = `
    //                 <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
    //                 <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
    //                 <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
    //             `;
    //         } else {
    //             svg.innerHTML = `
    //                 <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
    //                 <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
    //             `;
    //         }
    //     }
    // };

    // Form submission handling
    const passwordForm = document.getElementById('password-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate both passwords before submission
            const newPasswordErrors = validatePassword(newPasswordInput.value);
            const passwordsMatch = newPasswordInput.value === confirmPasswordInput.value;
            
            if (newPasswordErrors.length > 0 || !passwordsMatch) {
                // Show validation errors
                if (newPasswordErrors.length > 0) {
                    updateValidationMessage(
                        newPasswordInput,
                        `Password requires: ${newPasswordErrors.join(", ")}`,
                        false
                    );
                }
                
                if (!passwordsMatch) {
                    updateValidationMessage(
                        confirmPasswordInput,
                        "Passwords do not match",
                        false
                    );
                }
                
                return;
            }
            
            // If all validations pass, you can proceed with password reset
            // This would typically involve an AJAX request to your backend
            console.log('Password reset form submitted');
            
            // Here you would add your AJAX call to reset the password
            // For example:
            /*
            fetch('/api/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    password: newPasswordInput.value,
                    // Include any necessary tokens or identifiers
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to login page or show success message
                    window.location.href = '/signin?reset=success';
                } else {
                    // Show error message
                    alert(data.message || 'Password reset failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            });
            */
            
            // For demo purposes, simulate success after 1 second
            setTimeout(() => {
                alert('Password reset successful! Redirecting to login page...');
                window.location.href = '/signin';
            }, 1000);
        });
    }

    // Add CSS styles for validation messages
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
});