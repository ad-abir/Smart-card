<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Card - Smart Card Dashboard</title>
    <link rel="stylesheet" href="../assets/styles/preview.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- <script src="../assets/js/update-form-validation.js" defer></script> -->
     <script src="../assets/js/preview.js" defer></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <?php include __DIR__ . '/../includes/navbar.php'; ?>

        <!-- Main Content -->
        <div class="preview-container">
            <div class="preview-header">
                <h1>Card Preview</h1>
                <div class="preview-actions">
                    <button class="btn secondary" onclick="window.location.href='/update'">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                    <button class="btn primary" onclick="downloadCard()">
                        <i class="fas fa-download"></i> Download Card
                    </button>
                    <button class="btn primary" onclick="shareCard()">
                        <i class="fas fa-share"></i> Share Card
                    </button>
                </div>
            </div>

            <!-- Smart Card Display -->
            <div class="card-wrapper">
                <div class="smart-card">
                    <!-- Card Header -->
                    <div class="card-header">
                        <div class="profile-section">
                            <div class="profile-photo">
                                <img src="/api/placeholder/120/120" alt="Profile Photo" id="cardProfilePhoto">
                                <div class="photo-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="basic-info">
                                <h2 class="full-name">John Doe</h2>
                                <p class="job-title">Software Developer</p>
                                <p class="company">Tech Solutions Inc.</p>
                                <p class="bio">Passionate developer creating innovative solutions</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card-section">
                        <h3><i class="fas fa-address-card"></i> Contact Information</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <label>Phone</label>
                                    <a href="tel:+1234567890" class="contact-link">+123 456 7890</a>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fab fa-whatsapp"></i>
                                <div>
                                    <label>WhatsApp</label>
                                    <a href="https://wa.me/1234567890" class="contact-link">+123 456 7890</a>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <label>Email</label>
                                    <a href="mailto:john@example.com" class="contact-link">john@example.com</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="card-section">
                        <h3><i class="fas fa-map-marker-alt"></i> Addresses</h3>
                        <div class="address-grid">
                            <div class="address-item">
                                <div class="address-header">
                                    <i class="fas fa-home"></i>
                                    <label>Home Address</label>
                                </div>
                                <p class="address-text">123 Main Street, City, State 12345</p>
                                <a href="#" class="map-link">
                                    <i class="fas fa-external-link-alt"></i> View on Maps
                                </a>
                            </div>
                            <div class="address-item">
                                <div class="address-header">
                                    <i class="fas fa-building"></i>
                                    <label>Office Address</label>
                                </div>
                                <p class="address-text">456 Business Ave, Corporate City, State 67890</p>
                                <a href="#" class="map-link">
                                    <i class="fas fa-external-link-alt"></i> View on Maps
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Websites -->
                    <div class="card-section">
                        <h3><i class="fas fa-globe"></i> Websites</h3>
                        <div class="website-grid">
                            <div class="website-item">
                                <i class="fas fa-briefcase"></i>
                                <div>
                                    <label>Office Website</label>
                                    <a href="https://company.com" class="website-link" target="_blank">company.com</a>
                                </div>
                            </div>
                            <div class="website-item">
                                <i class="fas fa-user-tie"></i>
                                <div>
                                    <label>Personal Website</label>
                                    <a href="https://johndoe.com" class="website-link" target="_blank">johndoe.com</a>
                                </div>
                            </div>
                            <div class="website-item">
                                <i class="fas fa-folder-open"></i>
                                <div>
                                    <label>Portfolio</label>
                                    <a href="https://portfolio.com" class="website-link" target="_blank">portfolio.com</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="card-section">
                        <h3><i class="fas fa-share-alt"></i> Social Media</h3>
                        <div class="social-grid">
                            <a href="https://linkedin.com/in/johndoe" class="social-link linkedin" target="_blank">
                                <i class="fab fa-linkedin"></i>
                                <span>LinkedIn</span>
                            </a>
                            <a href="https://github.com/johndoe" class="social-link github" target="_blank">
                                <i class="fab fa-github"></i>
                                <span>GitHub</span>
                            </a>
                            <a href="https://instagram.com/johndoe" class="social-link instagram" target="_blank">
                                <i class="fab fa-instagram"></i>
                                <span>Instagram</span>
                            </a>
                            <a href="https://facebook.com/johndoe" class="social-link facebook" target="_blank">
                                <i class="fab fa-facebook"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="https://snapchat.com/add/johndoe" class="social-link snapchat" target="_blank">
                                <i class="fab fa-snapchat"></i>
                                <span>Snapchat</span>
                            </a>
                            <a href="https://youtube.com/johndoe" class="social-link youtube" target="_blank">
                                <i class="fab fa-youtube"></i>
                                <span>YouTube</span>
                            </a>
                        </div>
                    </div>

                    <!-- QR Code Section -->
                    <div class="card-section qr-section">
                        <h3><i class="fas fa-qrcode"></i> Quick Access</h3>
                        <div class="qr-container">
                            <div class="qr-placeholder">
                                <i class="fas fa-qrcode"></i>
                                <p>QR Code</p>
                            </div>
                            <p class="qr-text">Scan to save contact</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>