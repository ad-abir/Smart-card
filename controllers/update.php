<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Smart Card Dashboard</title>
    <link rel="stylesheet" href="assets/styles/update.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <?php include 'includes/navbar.php'; ?>

        <!-- Main Content -->
        <div class="update-container">
            <h1>Update Your Profile</h1>
            <form class="update-form" action="update_profile.php" method="POST" enctype="multipart/form-data">
                <!-- Basic Information Section -->
                <div class="form-card">
                    <div class="card-header">
                        <i class="fas fa-user-circle"></i>
                        <h2>Basic Information</h2>
                    </div>
                    <div class="form-fields">
                        <div class="field-group">
                            <label for="photo">Profile Photo</label>
                            <div class="photo-upload">
                                <div class="preview-container">
                                    <img src="" alt="Profile Preview" id="photoPreview" class="profile-preview">
                                    <div class="overlay">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                </div>
                                <div class="upload-controls">
                                    <input type="file" id="photo" name="photo" accept="image/png, image/jpeg, image/jpg" class="hidden-input">
                                    <label for="photo" class="btn secondary">
                                        <i class="fas fa-upload"></i> Choose Photo
                                    </label>
                                    <small class="file-info">Max size: 25MB (JPG, JPEG, PNG)</small>
                                </div>
                            </div>
                        </div>
                        <div class="field-group">
                            <label for="fullName">Full Name <span class="required">*</span></label>
                            <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required>
                        </div>
                        <div class="field-group">
                            <label for="jobTitle">Job Title <span class="required">*</span></label>
                            <input type="text" id="jobTitle" name="jobTitle" placeholder="Enter your job title" required>
                        </div>
                        <div class="field-group">
                            <label for="companyName">Company Name <span class="required">*</span></label>
                            <input type="text" id="companyName" name="companyName" placeholder="Enter company name" required>
                        </div>
                    </div>
                </div>

                <!-- Contact Details Section -->
                <div class="form-card">
                    <div class="card-header">
                        <i class="fas fa-address-card"></i>
                        <h2>Contact Details</h2>
                    </div>
                    <div class="form-fields">
                        <div class="field-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>
                        <div class="field-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                        </div>
                        <div class="field-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" placeholder="Enter your address" rows="3"></textarea>
                        </div>
                        <div class="field-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" placeholder="Enter your website URL">
                        </div>
                    </div>
                </div>

                <!-- Social Media Links Section -->
                <div class="form-card">
                    <div class="card-header">
                        <i class="fas fa-share-alt"></i>
                        <h2>Social Media Links</h2>
                    </div>
                    <div class="form-fields social-fields">
                        <div class="field-group">
                            <label for="linkedin"><i class="fab fa-linkedin"></i> LinkedIn</label>
                            <input type="url" id="linkedin" name="linkedin" placeholder="Enter LinkedIn profile URL">
                        </div>
                        <div class="field-group">
                            <label for="github"><i class="fab fa-github"></i> GitHub</label>
                            <input type="url" id="github" name="github" placeholder="Enter GitHub profile URL">
                        </div>
                        <div class="field-group">
                            <label for="instagram"><i class="fab fa-instagram"></i> Instagram</label>
                            <input type="url" id="instagram" name="instagram" placeholder="Enter Instagram profile URL">
                        </div>
                        <div class="field-group">
                            <label for="facebook"><i class="fab fa-facebook"></i> Facebook</label>
                            <input type="url" id="facebook" name="facebook" placeholder="Enter Facebook profile URL">
                        </div>
                    </div>
                </div>

                <!-- Additional Business Info Section -->
                <div class="form-card">
                    <div class="card-header">
                        <i class="fas fa-briefcase"></i>
                        <h2>Additional Business Info</h2>
                    </div>
                    <div class="form-fields">
                        <div class="field-group">
                            <label for="portfolio">Portfolio/Work Samples</label>
                            <input type="url" id="portfolio" name="portfolio" placeholder="Enter portfolio URL">
                        </div>
                        <div class="field-group">
                            <label for="calendly">Calendly Link</label>
                            <input type="url" id="calendly" name="calendly" placeholder="Enter Calendly URL">
                        </div>
                        <div class="field-group">
                            <label for="reviews">Review Platform Links</label>
                            <div class="review-links">
                                <input type="url" name="google_reviews" placeholder="Google Reviews URL">
                                <input type="url" name="trustpilot" placeholder="Trustpilot URL">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn secondary" onclick="window.location.href='dashboard.php'">Cancel</button>
                    <button type="submit" class="btn primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/image-preview.js"></script>
</body>
</html>