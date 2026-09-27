<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        $userFullName = $_SESSION['full_name'];
        $userFirstName = explode(" ", $userFullName)[0];
        $role = $_SESSION['role'];
        $password = $_SESSION['password'];
        if($role == "admin")
        {
            header("Location: admin.html");
            exit();
        }
        if (!preg_match("/^[a-zA-Z ]+$/", $fullName)) {
    $errors[] = "Full name should only contain letters and spaces.";
}
        if (!preg_match("/^[0-9]{11}$/", $phone)) {
    $errors[] = "Phone number must be exactly 11 digits and should not contain letters or special characters.";
}

    } else {
        $userFirstName = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adlaon Optical</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
    <nav class="navbar">
    <div class="container">
        <div class="logo">
            <a href="#home">
                <img src="logos/AdlaonLogo-nobg.svg" alt="Adlaon Optical" class="logo-img">
            </a>
        </div>
        <ul class="nav-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#eyewear">Eyewear</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#booking" class="appointment-btn">Book Appointment</a></li>
            <?php if (!$userFirstName): ?>
                <li><a href="login.php" class="login-btn">Log In</a></li>
                <li><a href="signup.php" class="signup-btn">Sign Up</a></li>
            <?php else: ?>
                <li class="profile-menu">
    <button type="button" class="profile-btn">
        <div class="profile-pic">
            <img src="<?php echo isset($_SESSION['img_path']) && $_SESSION['img_path'] ? $_SESSION['img_path'] : 'default-avatar.png'; ?>" alt="Profile Picture">
        </div>
        <span><?php echo $userFirstName; ?></span>
    </button>
    <div class="profile-modal">
        <div class="profile-header">
            <div class="profile-pic-large">
                <img src="<?php echo isset($_SESSION['img_path']) && $_SESSION['img_path'] ? $_SESSION['img_path'] : 'default-avatar.png'; ?>" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <h4><?php echo $userFullName; ?></h4>
                <p>Member since 2025</p>
            </div>
        </div>
        <ul class="profile-links">
            <li>
                <a href="edit_profile.php">
                    <img src="icons/profile-edit-icon.svg" alt="Edit Profile" class="menu-icon">
                    <span>Edit Profile</span>
                </a>
            </li>
            <li>
                <a href="view_orders.php">
                    <img src="icons/orders-icon.svg" alt="View Orders" class="menu-icon">
                    <span>View Orders</span>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="logout.php" class="logout-btn">
                    <img src="icons/logout-icon.svg" alt="Log Out" class="menu-icon">
                    <span>Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</li>
            <?php endif; ?>
        </ul>
        <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </div>
</nav>

    <div id="home" class="slideshow">
        <div class="wrapper">
            <img src="slideshow_media/slide-1.jpg" alt="Image 1">
            <img src="slideshow_media/slide-2.jpg" alt="Image 2">
            <img src="slideshow_media/slide-3.jpg" alt="Image 3">
        </div>
    
        <div class="hero-content">
            <h1>See The World Clearly</h1>
            <p>See clearly, feel confident, and express your unique style with our premium eyewear collection. Browse our latest designs and find your perfect fit today!</p>
            <div class="hero-buttons">
                <a href="#booking" class="btn btn-primary">Book an Eye Exam</a>
                <a href="#eyewear" class="btn btn-secondary">Browse Eyewear</a>
            </div>
        </div>
    </div>
    

    <section id="features" class="features">
        <div class="container">
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="icons/mdi_eye.svg" alt="Eye Exam Icon">
                    </div>
                    <h3>Comprehensive Eye Exams</h3>
                    <p>Our optometrists use advanced technology to provide thorough eye health evaluations.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="icons/fluent_glasses-16-regular.svg" alt="Designer Frames Icon">
                    </div>
                    <h3>Designer Frames</h3>
                    <p>Browse our collection of premium and designer frames to find your perfect style.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="icons/iconamoon_star-fill.svg" alt="Quality Lenses Icon">
                    </div>
                    <h3>Quality Lenses</h3>
                    <p>High-quality prescription lenses with various coating options for optimal vision.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="icons/mingcute_time-fill.svg" alt="Quick Service Icon">
                    </div>
                    <h3>Quick Service</h3>
                    <p>Fast turnaround times for prescriptions and repairs to get you seeing clearly sooner.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="container">
            <div class="section-header">
                <h2>About Us</h2>
                <p>Your vision is our priority</p>
            </div>
            <div class="about-content">
                <div class="about-image">
                    <img src="adlaon-interior-design-1.png" alt="Optical store interior">
                </div>
                <div class="about-text">
                    <h3>Your Trusted Eye Care Partner</h3>
                    <p>AdlaonOptical has been providing exceptional eye care services for over 20 years. Our team of experienced optometrists and opticians are dedicated to ensuring your eye health and helping you look your best.</p>
                    <p>We combine the latest in eye care technology with personalized attention to deliver the highest quality of care for patients of all ages.</p>
                    <div class="about-features">
                        <div class="about-feature">
                            <img src="icons/vaadin_check-circle.svg" alt="Check icon">
                            <span>Experienced Professionals</span>
                        </div>
                        <div class="about-feature">
                            <img src="icons/vaadin_check-circle.svg" alt="Check icon">
                            <span>Advanced Technology</span>
                        </div>
                        <div class="about-feature">
                            <img src="icons/vaadin_check-circle.svg" alt="Check icon">
                            <span>Personalized Care</span>
                        </div>
                        <div class="about-feature">
                            <img src="icons/vaadin_check-circle.svg" alt="Check icon">
                            <span>Family-Friendly Environment</span>
                        </div>
                    </div>                     
                    
                </div>
            </div>
        </div>
    </section>
    

    <section id="locations" class="locations">
        <div class="container">
          <h2 class="section-title">Where are we located?</h2>
          <p class="section-subtitle">Check our branches!</p>
            <br>
          <div class="branches-flex">
            <div class="branch-card">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3854.727299455355!2d120.89546339678954!3d14.952278800000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396555a6ed9346d%3A0x846f454426478540!2sAdlaon%20Optical%20(Super%208%20Grocery%20Warehouse)!5e0!3m2!1sen!2sph!4v1744721350074!5m2!1sen!2sph" allowfullscreen loading="lazy"></iframe>
              <h3>Baliuag Branch</h3>
              <p>Super 8 Grocery Warehouse</p>
            </div>
            <div class="branch-card">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3854.727299455355!2d120.89546339678954!3d14.952278800000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397aaaa366d8d81%3A0x353935cec6b505f6!2sAdlaon%20Optical%20Baliuag%20(Beside%20Cong.%20Pancho)%20Branch!5e0!3m2!1sen!2sph!4v1744721484729!5m2!1sen!2sph" allowfullscreen loading="lazy"></iframe>
              <h3>Baliuag Branch</h3>
              <p>Beside Cong. Pancho</p>
            </div>
            <div class="branch-card">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3857.5518913318483!2d120.8799308!3d14.794252199999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339652a6de79d241%3A0x5a2c5b9da13376b1!2sAdlaon%20Optical%20(Branch-3)!5e0!3m2!1sen!2sph!4v1744721516550!5m2!1sen!2sph" allowfullscreen loading="lazy"></iframe>
              <h3>Meycuayan Branch</h3>
              <p>32 G/F Aliw Complex, Mc Arthur Highway, Meycuayan, Bulacan</p>
            </div>
          </div>
        </div>
    </section>

    <section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Services</h2>
                <br>
                <p class="section-subtitle">Comprehensive eye care services tailored to meet your vision needs with precision and care.</p>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-image">
                        <img src="services_media/service-1.jpg" alt="Eye Examination">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Comprehensive Eye Exams</h3>
                        <p class="service-description">Thorough vision assessment and eye health evaluation using advanced diagnostic technology to detect vision problems and eye diseases early.</p>
                       
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-image">
                        <img src="services_media/service-2.jpg" alt="Eyewear Fitting">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Eyewear Fitting & Styling</h3>
                        <p class="service-description">Personalized frame selection and precise fitting services to ensure comfort, style, and optimal vision correction tailored to your unique face shape.</p>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-image">
                        <img src="services_media/service-3.jpg" alt="Contact Lens Consultation">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Contact Lens Consultation</h3>
                        <p class="service-description">Expert fitting and education for all types of contact lenses, including specialty lenses for astigmatism, multifocal needs, and hard-to-fit eyes.</p>

                    </div>
                </div>

                <div class="service-card">
                    <div class="service-image">
                        <img src="services_media/service-4.jpg" alt="Vision Therapy">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Vision Therapy</h3>
                        <p class="service-description">Customized treatment programs designed to improve visual skills and processing, addressing issues like lazy eye, crossed eyes, and visual processing disorders.</p>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-image">
                        <img src="services_media/service-5.jpg" alt="Eye Disease Management">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Eye Disease Management</h3>
                        <p class="service-description">Ongoing care for conditions like glaucoma, macular degeneration, and diabetic retinopathy, using advanced diagnostic tools and treatment protocols.</p>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-image">
                        <img src="services_media/service-6.jpg" alt="Emergency Eye Care">
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">Emergency Eye Care</h3>
                        <p class="service-description">Prompt attention for urgent eye issues such as injuries, infections, sudden vision changes, or eye pain, with same-day appointments available.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
      
    <section id="eyewear" class="eyewear-banner" id="eyewear-section">

        <img src="eyewear-bg1.png" alt="Stylish eyewear collection" class="banner-image">
        
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
        
        <div class="banner-content">
            <h2 class="banner-heading">See the world your way — with eyewear that gets you.</h2>
            <p class="banner-text">From everyday classics to trend-setting frames, we've got styles that keep up with your look and lifestyle. Comfortable fit, crystal-clear vision, and seriously good vibes — all in one pair.</p>
            <a href="eyewear.php" class="explore-btn">Explore eyewear</a>
        </div>
    </section>

    <section id="booking" class="booking-section">
        <img src="adlaon-interior-design.png" alt="Optical clinic background" class="bg-image">
        <div class="overlay"></div>
        
        <div class="booking-container">
            
            <div class="booking-content">
            <div class="adlaon-logo">
                <img src="logos/product-logo.png" alt="Adlaon Logo">
            </div>
                <h2 class="booking-title">Book Your Eye Examination</h2>
                <p class="booking-sub">Schedule an appointment with our expert optometrists for a comprehensive eye examination.</p>
                
                <ul class="benefits-list">
                    <li class="benefit-item">
                        <img src="icons/benefit-icon.svg" alt="Check" class="benefit-icon">
                        <span class="benefit-text">Convenient online booking</span>
                    </li>
                    <li class="benefit-item">
                        <img src="icons/benefit-icon.svg" alt="Check" class="benefit-icon">
                        <span class="benefit-text">Flexible appointment times</span>
                    </li>
                    <li class="benefit-item">
                        <img src="icons/benefit-icon.svg" alt="Check" class="benefit-icon">
                        <span class="benefit-text">Thorough eye health assessment</span>
                    </li>
                    <li class="benefit-item">
                        <img src="icons/benefit-icon.svg" alt="Check" class="benefit-icon">
                        <span class="benefit-text">Personalized eyewear recommendations</span>
                    </li>
                </ul>
            </div>
            
            <div class="booking-form-container">
                <form class="booking-form-containerppointmentForm">
                    <div class="form-group">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" id="fullName" name="fullName" requiredpattern="[A-Za-z ]+" 
       title="Full name should only contain letters and spaces.">

                    </div>
                    
                    <div class="form-group-booking">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group-booking">
                        <label for="phone" class="form-label">Phone Number</label>
                      <input type="tel" id="phone" name="phone" requiredpattern="[0-9]{11}" minlength="11" maxlength="11"title="Phone number must be exactly 11 digits.">

                    </div>
                    
                    <div class="form-row">
                        <div class="form-group-booking">
                            <label for="date" class="form-label">Preferred Date</label>
                            <input type="date" class="form-control" id="date" name="date" required min="">
                        </div>
                        
                        <div class="form-group-booking">
                            <label for="timeSlot" class="form-label">Preferred Time</label>
                            <div class="custom-select">
                                <select class="form-control" id="timeSlot" name="timeSlot" required>
                                    <option value="" disabled selected>Select a time</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Services Available</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="eyeExam" name="services[]" value="Comprehensive Eye Examination">
                                <label for="eyeExam">Comprehensive Eye Examination</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="glassesSelec" name="services[]" value="Eyewear Fitting & Styling">
                                <label for="glassesSelec">Eyewear Fitting & Styling</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="contactLens" name="services[]" value="Contact Lens Consultation">
                                <label for="contactLens">Contact Lens Consultation</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="followUp" name="services[]" value="Vision Therapy">
                                <label for="followUp">Vision Therapy</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="repair" name="services[]" value="Eye Disease Management">
                                <label for="repair">Eye Disease Management</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="repair" name="services[]" value="Emergency Eye Care">
                                <label for="repair">Emergency Eye Care</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes" class="form-label">Special Requests or Notes</label>
                        <textarea class="form-control" id="notes" name="notes" placeholder="Share any additional information or special requirements..."></textarea>
                    </div>
                    
                    <button type="submit" class="sched-btn">Schedule Appointment</button>
                </form>
            </div>
        </div>
    </section>

    
    <section class="contact-section" id="contact">
        <div class="deco-circle deco-circle-1"></div>
        <div class="deco-circle deco-circle-2"></div>
        
        <div class="contact-container">
            <div class="contact-header">
                <h2>Contact Us</h2>
                <p>We’d love to hear from you, whether you have questions or need to schedule an appointment.</p>
            </div>
            
            <div class="contact-grid">
                <!-- Email Card -->
                <div class="contact-card">
                    <div class="card-content">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <h3 class="card-title">Email Us</h3>
                        <p class="card-text">
                            adlaonopticals@gmail.com<br>
                            support@adlaonoptical.com
                        </p>
                    </div>
                </div>
                
                <!-- Phone Card -->
                <div class="contact-card">
                    <div class="card-content">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <h3 class="card-title">Call Us</h3>
                        <p class="card-text">
                            8123-4567<br>
                            Mobile: 0961-246-9245
                        </p>
                    </div>
                </div>
                
                <!-- Hours Card -->
                <div class="contact-card">
                    <div class="card-content">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <h3 class="card-title">Opening Hours</h3>
                        <p class="card-text">
                            Monday - Friday: 9:00 AM - 6:00 PM<br>
                            Saturday: 9:00 AM - 5:00 PM<br>
                            Sunday: Closed
                        </p>
                    </div>
                </div>
                
                <div class="contact-card social-card">
                    <div class="card-content">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        </div>
                        <h3 class="card-title">Connect With Us</h3>
                        <p class="card-text">
                            Follow us on social media for updates, promotions, and more.
                        </p>
                        <div class="social-links">
                        <a href="https://facebook.com/AdlaonOptical" target="_blank" class="social-link" aria-label="Facebook">
                            <img src="icons/fb-icon.svg" alt="Facebook" />
                        </a>
                        <a href="https://instagram.com/" target="_blank" class="social-link" aria-label="Instagram">
                            <img src="icons/ig-icon.svg" alt="Instagram" />
                        </a>
                        <a href="https://twitter.com/" target="_blank" class="social-link" aria-label="Twitter">
                            <img src="icons/x-icon.svg" alt="Twitter" />
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="adlaon-footer">
    <div class="footer-container">

        <div class="footer-top">
            <div class="footer-logo">
                <img src="logos/AdlaonLogo-nobg.svg" alt="AdlaonOptical Logo" class="logo-img">
            </div>
            
            <div class="footer-nav">
                <ul class="footer-menu">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#eyewear">Eyewear</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#booking" class="book-btn">Book Appointment</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-middle">
            <div class="footer-info">
                <div class="contact-block">
                    <h3>Contact Us</h3>
                    <div class="contact-item">
                        <img src="icons/location-icon.svg" alt="Location" class="footer-icon">
                        <p>Baliuag Branch Super 8 Grocery Warehouse</p>
                    </div>
                    <div class="contact-item">
                        <img src="icons/call-icon.svg" alt="Phone" class="footer-icon">
                        <p>(+63)961-2469-245</p>
                    </div>
                    <div class="contact-item">
                        <img src="icons/email-icon.svg" alt="Email" class="footer-icon">
                        <p>adlaonoptical@gmail.com</p>
                    </div>
                </div>
                
                <div class="hours-block">
                    <h3>Opening Hours</h3>
                    <div class="hours-container">
                        <div class="hours-item">
                            <span class="day">Monday - Friday</span>
                            <span class="time">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="hours-item">
                            <span class="day">Saturday</span>
                            <span class="time">9:00 AM - 4:00 PM</span>
                        </div>
                        <div class="hours-item">
                            <span class="day">Sunday</span>
                            <span class="time">Closed</span>
                        </div>
                    </div>
                </div>
                
                <div class="subscribe-block">
                    <h3>Subscribe to our deals and offers</h3>
                    <form class="subscribe-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/AdlaonOptical" aria-label="Facebook">
                            <img src="icons/fb-icon.svg" alt="Facebook" class="social-icon">
                        </a>
                        <a href="https://www.instagram.com/adlaonopticalofficial/" aria-label="Instagram">
                            <img src="icons/ig-icon.svg" alt="Instagram" class="social-icon">
                        </a>
                        <a href="#" aria-label="Twitter">
                            <img src="icons/x-icon.svg" alt="Twitter" class="social-icon">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy; 2025 AdlaonOptical. All Rights Reserved.</p>
            </div>
            <div class="footer-links">
                <a href="privacy.html">Privacy Policy</a>
                <a href="terms.html">Terms of Service</a>
                <a href="accessibility.html">Accessibility</a>
            </div>
        </div>
    </div>
    </footer>
    
    <script src="script.js"></script>
    <script src= "appointment.js"></script>
</body>
</html>