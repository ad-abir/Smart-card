// email-validation.js

document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    if (!emailInput) return; // Exit if email input doesn't exist
    
    // Create validation message container
    const validationMessage = document.createElement('div');
    validationMessage.className = 'validation-message';
    emailInput.parentElement.appendChild(validationMessage);

    // Email validation patterns
    const patterns = {
        format: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        minLocalLength: 2,
        maxEmailLength: 254,
        validTLD: /\.[a-zA-Z]{2,}$/,
        validSpecialChars: /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@/,
        noConsecutiveSpecials: /^(?!.*[.!#$%&'*+/=?^_`{|}~-]{2})/,
        noDotIssues: /^[^.].*[^.]$/
    };

    function validateEmail(email) {
        const errors = [];
        
        // Check if empty
        if (!email) {
            errors.push("Email is required");
            return errors;
        }

        // Check basic format
        if (!patterns.format.test(email)) {
            errors.push("Invalid email format");
            return errors;
        }

        // Split email into local and domain parts
        const [localPart, domain] = email.split('@');

        // Check local part length
        if (localPart.length < patterns.minLocalLength) {
            errors.push("Username is too short");
        }

        // Check total email length
        if (email.length > patterns.maxEmailLength) {
            errors.push("Email is too long");
        }

        // Check TLD validity
        if (!patterns.validTLD.test(email)) {
            errors.push("Invalid domain extension");
        }

        // Check for valid special characters
        if (!patterns.validSpecialChars.test(email)) {
            errors.push("Contains invalid characters");
        }

        // Check for consecutive special characters
        if (!patterns.noConsecutiveSpecials.test(localPart)) {
            errors.push("Cannot contain consecutive special characters");
        }

        // Check for dot issues
        if (!patterns.noDotIssues.test(localPart)) {
            errors.push("Cannot begin or end with a dot");
        }

        // Check domain specific rules
        if (domain) {
            // Check for valid domain format
            if (!/^[a-zA-Z0-9][a-zA-Z0-9.-]*\.[a-zA-Z]{2,}$/.test(domain)) {
                errors.push("Invalid domain format");
            }
            
            // Check for consecutive dots in domain
            if (domain.includes('..')) {
                errors.push("Domain cannot contain consecutive dots");
            }
        }

        return errors;
    }

    function updateValidationMessage(input, errors) {
        const messageDiv = input.parentElement.querySelector('.validation-message');
        
        if (errors.length === 0) {
            messageDiv.textContent = "Valid email address ✓";
            messageDiv.className = 'validation-message valid';
            input.classList.remove('invalid-input');
        } else {
            messageDiv.textContent = errors[0]; // Show first error
            messageDiv.className = 'validation-message invalid';
            input.classList.add('invalid-input');
        }
    }

    // Real-time validation
    emailInput.addEventListener('input', function() {
        const errors = validateEmail(this.value.trim());
        updateValidationMessage(this, errors);
    });

    // Validation on blur
    emailInput.addEventListener('blur', function() {
        if (this.value.trim()) {
            const errors = validateEmail(this.value.trim());
            updateValidationMessage(this, errors);
        }
    });

    // Add styles
    if (!document.querySelector('#email-validation-styles')) {
        const style = document.createElement('style');
        style.id = 'email-validation-styles';
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
    }
});