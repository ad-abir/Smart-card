<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Panel</title>
    <link rel="stylesheet" href="../assets/styles/index.css">

    <script src="assets/js/password-utils.js"></script>
    <script src="assets/js/password-validation.js"></script>
    <script src="assets/js/email-validation.js" defer></script>
    <script src="assets/js/form-validation.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Create an Account</h1>
            <!-- <p>Start your 30-day free trial. No credit card required.</p> -->
        </div>

        <form action="../code.php" method="POST">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="john@example.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="password-field">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" name="register_btn" class="btn">Sign Up</button>

            <div class="divider">
                <span>Or continue with</span>
            </div>

            <script src="https://accounts.google.com/gsi/client" async></script>
            <div id="g_id_onload"
                data-client_id="YOUR_GOOGLE_CLIENT_ID"
                data-login_uri="https://your.domain/your_login_endpoint"
                data-auto_prompt="false">
            </div>
            <div class="g_id_signin"
                data-type="standard"
                data-size="large"
                data-theme="outline"
                data-text="signup_with"
                data-shape="rectangular"
                data-logo_alignment="left">
            </div>

            <div class="footer">
                Already have an account? <a href="/signin">Sign in</a>
            </div>

            <input type="hidden" name="userEmail" value="">
        </form>
    </div>
</body>
</html>