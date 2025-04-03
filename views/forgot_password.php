<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../assets/styles/forgot_pass.css">

    <script src="../assets/js/form_switch.js" defer></script>
    <script src="../assets/js/resend.js" defer></script>
    <script src="../assets/js/email-validation.js" defer></script>
    <script src="../assets/js/pass-validation.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="progress-bar">
            <div class="progress-step active" id="step1-progress"></div>
            <div class="progress-step" id="step2-progress"></div>
            <div class="progress-step" id="step3-progress"></div>
        </div>

        <!-- Step 1: Email -->
        <div class="step active" id="step1">
            <h1 class="title">Forgot Password</h1>
            <p class="subtitle">Enter your email address and we'll send you a verification code</p>
            
            <form id="email-form" action="../services/email.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <button type="submit" class="submit-btn">Send Verification Code</button>
            </form>
            
            <div class="links">
                <a href="/signin">Back to Login</a>
            </div>
        </div>

        <!-- Step 2: Verification Code -->
        <div class="step" id="step2">
            <h1 class="title">Enter Verification Code</h1>
            <p class="subtitle">We've sent a 6-digit code to your email</p>
            
            <form id="verification-form">
                <div class="form-group">
                    <label for="verification-code">Verification Code</label>
                    <div class="verification-code">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Verify Code</button>
                <button type="button" class="back-btn" onclick="goToStep(1)">Back</button>
            </form>
            
            <div class="links">
                <a href="#" class="resend-link">Resend Code</a>
            </div>
        </div>

        <!-- Step 3: New Password -->
        <div class="step" id="step3">
            <h1 class="title">Reset Password</h1>
            <p class="subtitle">Create a new password for your account</p>
            
            <form id="password-form">
                <div class="form-group">
                    <label for="new-password">New Password</label>
                    <div class="password-field">
                        <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('new-password')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <div class="password-field">
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirm-password')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Reset Password</button>
                <button type="button" class="back-btn" onclick="goToStep(2)">Back</button>
            </form>
        </div>
    </div>
</body>
</html>