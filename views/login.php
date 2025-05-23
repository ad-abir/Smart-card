<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signin Panel</title>
        <link rel="stylesheet" href="../assets/styles/signin.css">
    </head>
    <body>
        <div class="container">
            <h1 class="title">Sign In</h1>
            
            <?php if (isset($error)): ?>
                <div class="notification error" style="display: block; position: relative; transform: none; left: 0; margin-bottom: 20px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="notification success" style="display: block; position: relative; transform: none; left: 0; margin-bottom: 20px;">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
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
                data-text="sign_in_with"
                data-shape="rectangular"
                data-logo_alignment="left">
            </div>
            <div class="divider">
                <span>or</span>
            </div>
            <form id="authenticationForm" action="../services/auth_check.php" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
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
                <button type="submit" class="submit-btn" id="submitBtn">Sign In</button>
                <div class="links">
                    <a href="/forgot_pass">Forgot your password?</a>
                </div>
                <div class="account-prompt">
                    Don't have an account? <a href="/">Sign up</a>
                </div>
            </form>
        </div>
        
        <script src="../assets/js/password-utils.js"></script>
        <script src="../assets/js/form-validation.js"></script>
    </body>
</html>