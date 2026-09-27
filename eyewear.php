    <?php
        session_start();
        $userId = $_SESSION['user_id'] ?? null;


        $welcomeMessage = "";

        if (isset($_SESSION['full_name'])) {
            $fullName = $_SESSION['full_name'];
            $nameParts = explode(" ", $fullName);
            $welcomeName = $nameParts[0] . (isset($nameParts[1]) ? " " . $nameParts[1] : "");
            $welcomeMessage = "Welcome, $welcomeName!";
        }
        
        if (isset($_SESSION['user_id'])) {
            $userFullName = $_SESSION['full_name'];
            $userFirstName = explode(" ", $userFullName)[0];
        } else {
            $userFirstName = null;
        }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="eyewearstyless.css">
        
        <link rel="stylesheet" href="footer.css">
        <title>AdlaonOptical - Eyewear</title>
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
                    <li><a href="index.php" class="underline-hover">Home</a></li>
                    <li><a href="index.php#about" class="underline-hover">About</a></li>
                    <li><a href="index.php#services" class="underline-hover">Services</a></li>
                    <li><a href="index.php#eyewear" class="underline-hover">Eyewear</a></li>
                    <li><a href="index.php#contact" class="underline-hover">Contact</a></li>
                    <li><a href="index.php#booking" class="appointment-btn">Book Appointment</a></li>
                    <li>
                        <a href="#cart" class="cart-btn">
                            <img src="icons/cart-icon.svg" alt="Shopping Cart">
                            <?php
                            include('conn.php');
                            if($userId !== null){
                            $sql = "select COUNT(cart_item_id) as cart_count from cart WHERE user_id = ".$userId;
                            $result = mysqli_query($conn, $sql);
                            $cartCount = 0;
                            if ($result && $row = mysqli_fetch_assoc($result)) {
                                $cartCount = $row['cart_count'];
                            }
                            echo '<span class="cart-count">'.$cartCount.'</span>';
                             }
                            ?>   
                        </a>
                    </li>
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
        
    <div id="cart-container" class="cart-container">
        <div class="cart-header">
            <h3>Cart</h3>
            <button id="close-cart" class = "close-cart">x</button>
        </div>
    <div id="cart-items" class="cart-items">
        <?php
            include('conn.php');
            if($userId !== null){
            $sql = "
                SELECT c.cart_item_id, c.quantity,c.product_id ,c.product_price, p.title, p.image
                FROM cart c
                JOIN products p ON c.product_id = p.id
                WHERE c.user_id = $userId
            ";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) > 0)
            {
                
                while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="cart-item" data-product-id="' . intval($row['product_id']) . '">';
                echo '  <div class="cart-item-img">';
                echo '    <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '" width="50">';
                echo '  </div>';
                echo '  <div class="cart-item-info">';
                echo '    <p class="cart-item-title">' . htmlspecialchars($row['title']) . '</p>';
                echo '    <p class="cart-item-price" data-base-price="' . $row['product_price'] . '">₱' . number_format($row['product_price'], 2) . '</p>';
                echo '    <div class="cart-controls">';
                echo '      <button class="minus-item">-</button>';
                echo '      <p class="item-quantity">'. intval($row['quantity']) .'</p>';
                echo '      <button class="plus-item">+</button>';
                echo '      <button class="remove-item">Remove</button>';
                echo '    </div>';  // Close cart-controls div
                
                echo '  </div>';  // Close cart-item-info div
                echo '</div>';

                }
            } else {
                echo '<p>Your cart is empty.</p>';
            }
        }
        ?>
    
    </div>
    <div class="cart-footer">
      <div class="cart-total">
        <span>Total:</span>
        <span id="cart-total-amount">₱0.00</span>
      </div>
      <button id="checkout-btn" class="checkout-btn">Checkout</button>
    </div>
  </div>
  
  <div id="cart-overlay" class="cart-overlay"></div>
  
      
    <section id="products" class="eyewear-section">
        <div class="container">
            <div class="filter-container">
                <button class="filter-button active" data-filter="all">
                    <img src="icons/all-eyewear.svg" alt="All Eyewear" class="filter-icon active">
                    All Eyewear
                </button>
                <button class="filter-button" data-filter="eyeglasses">
                    <img src="icons/eyeglasses.svg" alt="Eyeglasses" class="filter-icon">
                    Eyeglasses
                </button>
                <button class="filter-button" data-filter="sunglasses">
                    <img src="icons/sunglasses.svg" alt="Sunglasses" class="filter-icon">
                    Sunglasses
                </button>
                <button class="filter-button" data-filter="sports">
                    <img src="icons/sports.svg" alt="Sports Eyewear" class="filter-icon">
                    Sports
                </button>
                <button class="filter-button" data-filter="kids">
                    <img src="icons/kids.svg" alt="Kids Eyewear" class="filter-icon">
                    Kids
                </button>
                <button class="filter-button" data-filter="reading">
                    <img src="icons/reading.svg" alt="Reading Glasses" class="">
                    Reading
                </button>
            </div>
            
            <div class="products-grid">
                
                
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

    <script>
        const currentUserId = <?php echo json_encode($userId); ?>;
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    </script>

    <script src="eyewearscript.js"></script>
    <script src="script.js"></script>
    <script src = "filter_eyewear.js"></script>
    
</body>
</html>