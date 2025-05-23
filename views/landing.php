<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Card Dashboard</title>
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../includes/navbar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="welcome-section">
                <?= "<h1 class='welcome-message'>Welcome to the Dashboard, <span class='user-name'>" . htmlspecialchars($user_name) . "</span>!</h1>"; ?>
            </div>
            <!-- Dashboard Section -->
            <section id="dashboard" class="active-section">
                <h1>Dashboard</h1>
                <div class="dashboard-grid">
                    <div class="card stats">
                        <h3>Profile Views</h3>
                        <p class="number">1,234</p>
                        <p class="trend up">+12% this week</p>
                    </div>
                    <div class="card stats">
                        <h3>Contact Requests</h3>
                        <p class="number">56</p>
                        <p class="trend up">+5% this week</p>
                    </div>
                    <div class="card stats">
                        <h3>Website Clicks</h3>
                        <p class="number">789</p>
                        <p class="trend down">-3% this week</p>
                    </div>
                </div>
                
                <div class="quick-actions">
                    <h2>Quick Actions</h2>
                    <div class="action-buttons">
                        <button class="btn primary"><i class="fas fa-edit"></i> Update Profile</button>
                        <button class="btn secondary"><i class="fas fa-share"></i> Share Card</button>
                        <button class="btn secondary"><i class="fas fa-download"></i> Export Data</button>
                    </div>
                </div>
            </section>

            <!-- Update Section -->
            <section id="update" class="hidden">
                <h1>Update Profile</h1>
                <form class="update-form">
                    <div class="form-section">
                        <h2>Basic Information</h2>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label>Job Title</label>
                            <input type="text" placeholder="Enter your job title">
                        </div>
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" placeholder="Enter company name">
                        </div>
                        <div class="form-group">
                            <label>Profile Photo</label>
                            <input type="file" accept="image/*">
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Contact Details</h2>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" placeholder="Enter phone number">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" placeholder="Enter email address">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea placeholder="Enter your address"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input type="url" placeholder="Enter website URL">
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Social Media Links</h2>
                        <div class="form-group">
                            <label>LinkedIn</label>
                            <input type="url" placeholder="LinkedIn profile URL">
                        </div>
                        <div class="form-group">
                            <label>GitHub</label>
                            <input type="url" placeholder="GitHub profile URL">
                        </div>
                        <div class="form-group">
                            <label>Instagram</label>
                            <input type="url" placeholder="Instagram profile URL">
                        </div>
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="url" placeholder="Facebook profile URL">
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Additional Business Info</h2>
                        <div class="form-group">
                            <label>Portfolio Link</label>
                            <input type="url" placeholder="Portfolio URL">
                        </div>
                        <div class="form-group">
                            <label>Calendly Link</label>
                            <input type="url" placeholder="Calendly URL">
                        </div>
                    </div>

                    <button type="submit" class="btn primary">Save Changes</button>
                </form>
            </section>

            <!-- Preview Section -->
            <section id="preview" class="hidden">
                <h1>Card Preview</h1>
                <div class="preview-card">
                    <div class="card-header">
                        <img src="/api/placeholder/100/100" alt="Profile Photo" class="profile-photo">
                        <div class="card-header-info">
                            <h2>John Doe</h2>
                            <p class="job-title">Senior Developer</p>
                            <p class="company">Tech Solutions Inc.</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="contact-info">
                            <p><i class="fas fa-phone"></i> +1 234 567 890</p>
                            <p><i class="fas fa-envelope"></i> john@example.com</p>
                            <p><i class="fas fa-globe"></i> www.example.com</p>
                        </div>
                        <div class="social-links">
                            <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-github"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                        </div>
                        <div class="action-buttons">
                            <button class="btn primary"><i class="fas fa-phone"></i> Call Now</button>
                            <button class="btn secondary"><i class="fas fa-envelope"></i> Email Me</button>
                            <button class="btn secondary"><i class="fas fa-globe"></i> Visit Website</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Settings Section -->
            <section id="settings" class="hidden">
                <h1>Settings</h1>
                <div class="settings-container">
                    <div class="settings-group">
                        <h3>Account Settings</h3>
                        <div class="setting-item">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Enable Email Notifications</span>
                        </div>
                        <div class="setting-item">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <span>Make Profile Public</span>
                        </div>
                    </div>
                    <div class="settings-group">
                        <h3>Privacy Settings</h3>
                        <div class="setting-item">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Show Email Address</span>
                        </div>
                        <div class="setting-item">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                            <span>Show Phone Number</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>