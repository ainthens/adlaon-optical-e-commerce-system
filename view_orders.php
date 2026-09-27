<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        $userFullName = $_SESSION['full_name'];
        $userFirstName = explode(" ", $userFullName)[0];
        $role = $_SESSION['role'];
        if($role == "admin")
        {
            header("Location: admin.html");
            exit();
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
    <title>View Orders - Adlaon Optical</title>
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
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#services">Services</a></li>
                <li><a href="index.php#eyewear">Eyewear</a></li>
                <li><a href="index.php#contact">Contact</a></li>
                <li><a href="index.php#booking" class="appointment-btn">Book Appointment</a></li>
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
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <main class="orders-main">
        <div class="container">
            <br>
            <h2>Your Orders</h2>
            <br>
            <div class="orders-cards-list">
                <?php
                include('conn.php');
                $sql = "SELECT order_id, SUM(total_amount) as overall_total, MAX(order_date) as new_order_date, status FROM orders WHERE user_id = $user_id GROUP BY order_id, status ORDER BY new_order_date DESC";
                $result = mysqli_query($conn,$sql);
                if ($result && mysqli_num_rows($result) > 0){
                            
                    while ($row = mysqli_fetch_assoc($result)){
                        echo '<div class="order-card landscape-order-card">
                                <div class="order-card-content">
                                    <div class="order-card-header">
                                        <span class="order-id">Order #'. $row['order_id'].'</span>
                                        <span class="order-status '.$row['status'].'">'.$row['status'].'</span>
                                    </div>
                                    <div class="order-card-body">
                                        <div class="order-products">';
                                        $sql2 = "SELECT product_title, quantity, product_price FROM orders WHERE user_id = $user_id and order_id = ".$row['order_id'];
                                        $result2 = mysqli_query($conn,$sql2);
                                        if($result2 && mysqli_num_rows($result2) > 0){
                                            while($row2 = mysqli_fetch_assoc($result2)){
                                                echo '<div class="order-product-row">
                                                        <span class="product-name">'.$row2['product_title'].'</span>
                                                        <span class="product-qty">x'.$row2['quantity'].'</span>
                                                        <span class="product-price">₱'.$row2['product_price'].'</span>
                                                      </div>';
                                            }
                                        }
                                    echo '</div>
                                        <div class="order-total-row">
                                            <span>Total:</span>
                                            <span class="order-total">₱'.$row["overall_total"].'</span>
                                        </div>
                                        </div>
                                            <div class="order-card-footer">
                                                <span class="order-date">Ordered: '.$row['new_order_date'].'</span>';
                                                
                                                if($row['status'] == "Shipped Out"){
                                                    echo '<a href="#" id = "received-btn" class="order-received-btn" data-order-id = '.$row['order_id'].'>Mark as Received</a>';
                                                } else if($row['status'] == "Pending" || $row['status'] == "Accepted"){
                                                    echo '<a href="#" id= "cancel-btn" class="order-received-btn" data-order-id = '.$row['order_id'].'>Cancel Order</a>';
                                                }
                                               
                                            echo '</div>
                                        </div>
                                    </div>';
                            }
                        }
                        ?>
                        <script src ="script.js"></script>
                        <script src ="received_item.js"></script>
    </div>
</body>
</html>