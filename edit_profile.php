<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];        
        $userFullName = $_SESSION['full_name'];
        $password = $_SESSION['password'];
        $userFirstName = explode(" ", $userFullName)[0];
        $role = $_SESSION['role'];

        if ($role == "admin") {
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
    <title>My Profile | Adlaon Optical</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="edit_profile.css">
    <style>
        .modal {
            display: none;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        
        .modal-content {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            text-align: left;
            font-size: 16px;
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .modal-content label {
            font-weight: bold;
        }

        .modal-content input {
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .modal-content .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

    </style>
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
            <li><a href="index.php/about">About</a></li>
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

<?php
    include 'conn.php';    
    $query = $conn->prepare("SELECT full_name, email, phone_number, address, img_path FROM users WHERE id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $query->bind_result($full_name, $email, $phone, $address, $img_path);
    $query->fetch();
    $query->close();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    $newName = $_POST['full_name'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phone_number'];
    $newAddress = $_POST['address'];

    if (!empty($_FILES['profile_pic']['name'])) {
        $targetDir = "uploads/";
        $filename = basename($_FILES["profile_pic"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $filename;
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath);
    } else {
        $targetFilePath = $img_path;
    }

    $sql = "UPDATE users SET full_name = ?, email = ?, phone_number = ?, address = ?, img_path = ? WHERE id = ?";
    $update = $conn->prepare($sql);
    $update->bind_param("sssssi", $newName, $newEmail, $newPhone, $newAddress, $targetFilePath, $user_id);

    if ($update->execute()) {
        $_SESSION['full_name'] = $newName;
        $_SESSION['img_path'] = $targetFilePath;

        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                const modal = document.getElementById("successModal");
                modal.style.display = "flex";
            });
        </script>';
    } else {
        echo '<script>alert("Failed to update profile.");</script>';
    }

    $update->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $old_password=  $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    if(empty($old_password)){
        echo '<script>alert("Please fill out all password fields.");</script>';
    } 
    else if (empty($newPassword) || empty($confirmPassword)) {
        echo '<script>alert("Please fill out both password fields.");</script>';
    } elseif ($newPassword !== $confirmPassword) {
        echo '<script>alert("Passwords do not match.");</script>';
    } else{
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashedPasswordFromDB);
        $stmt->fetch();
        $stmt->close();
        if(!password_verify($old_password, $hashedPasswordFromDB)){
             echo '<script>alert("Old password is incorrect.");</script>';
        } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $user_id);

        if ($stmt->execute()) {
            echo '<script>alert("Password updated successfully.");</script>';
        } else {
            echo '<script>alert("Failed to update password.");</script>';
        }

        $stmt->close();
    }
    }
    
}
?>

<div class="profile-container">
    <h2>My Profile</h2>
    <form method="POST" enctype="multipart/form-data" class="profile-form">
        <div class="profile-picture-section">
            <img src="<?php echo $img_path ? $img_path : 'default-avatar.png'; ?>" alt="Profile Picture" class="profile-pic-preview" id="previewImg">
            <input type="file" name="profile_pic" id="profile_pic" accept="image/*" onchange="previewImage(event)">
        </div>

        <div class="form-fields">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label>Phone Number</label>
            <input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone); ?>" required>

            <label>Address</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
        </div>

        <div class="buttons" style="justify-content: flex-end; gap: 10px; margin-top: 20px;">
            <button type="button" class="btn-apply" onclick="openPasswordModal()">Change Password</button>
            <button type="submit" name="save_changes" class="btn-apply">Apply Changes</button>
            <a href="index.php" class="btn-back">Back</a>
        </div>
        
    </form>
</div>

<div id="successModal" class="modal">
  <div class="modal-content">
    <p>Update Changes Saved</p>
    <button onclick="redirectToHome()" style="margin-top: 15px; padding: 8px 16px; font-size: 16px;">OK</button>
  </div>
</div>

<div id="passwordModal" class="modal">
  <div class="modal-content">
    <form method="POST">
      <h3>Change Password</h3>
      <label>Old Password</label>
      <input type="password" name="old_password" required>

      <label>New Password</label>
      <input type="password" name="new_password" required>

      <label>Confirm New Password</label>
      <input type="password" name="confirm_password" required>

      <div class="buttons" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
  <button type="submit" name="update_password" class="btn-apply">Update</button>
  <button type="button" class="btn-back" onclick="closePasswordModal()">Back</button>
</div>

    </form>
  </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('previewImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function redirectToHome() {
        window.location.href = "index.php";
    }

    function openPasswordModal() {
        document.getElementById('passwordModal').style.display = 'flex';
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').style.display = 'none';
    }

</script>

<script src="script.js"></script>
</body>
</html>