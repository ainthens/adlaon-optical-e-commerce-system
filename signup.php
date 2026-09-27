<?php
    require_once "conn.php";

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $errors = [];
    $success = "";

    if (isset($_POST["submit"])) {
        $fullName = trim($_POST["fullName"]);
        $email = trim($_POST["signupEmail"]);
        $phone = trim($_POST["phone"]);
        $address = trim($_POST["signupAddress"]);
        $password = $_POST["signupPassword"];
        $confirmPassword = $_POST["confirmPassword"];
        $role = "user";

        // Validations
        if (empty($fullName) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirmPassword)) {
            $errors[] = "All fields are required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (strlen($password) < 5) {
    $errors[] = "Password must be at least 5 characters.";
}

       if (strlen($password) > 75) {
    $errors[] = "Password must not exceed 75 characters.";
}

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }
       //only letters and spaces
       if (!preg_match("/^[a-zA-Z ]*$/", $fullName)) {
    $errors[] = "Full name should only contain letters and spaces.";
}

       // exactly 11 digits
       if (!preg_match("/^[0-9]{11}$/", $phone)) {
    $errors[] = "Phone number must be exactly 11 digits.";
}

        // Check if email already exists
        if (empty($errors)) {
            $checkEmailQuery = "SELECT id FROM users WHERE email = ?";
            $stmt = mysqli_prepare($conn, $checkEmailQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $errors[] = "Email already registered.";
                }

                mysqli_stmt_close($stmt);
            } else {
                $errors[] = "Database error: " . mysqli_error($conn);
            }
        }

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (full_name, email, phone_number, password, role, address, img_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            $default = "eyewear/default.jpg";

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssss", $fullName, $email, $phone, $hashedPassword, $role, $address, $default);
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Account created! <a href='login.php'>Log in</a>";
                } else {
                    $errors[] = "Failed to create account. Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $errors[] = "SQL error: " . mysqli_error($conn);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdlaonOptical - Sign up</title>
    <link rel="stylesheet" href="form_style.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ebf4ff 0%, #d3e0ff 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: linear-gradient(90deg, #09176E 0%, #174BD2 100%);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 40px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 30px;
            font-weight: 500;
        }

        .signup-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .signup-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            text-align: center;
        }

        .signup-logo {
            margin-bottom: 10px;
        }

        h1 {
            color: #09176E;
            margin-bottom: 25px;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s;
        }

        input:focus {
            border-color: #174BD2;
            outline: none;
        }

        .signup-btn {
            background: linear-gradient(90deg, #09176E 0%, #174BD2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .signup-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(23, 75, 210, 0.3);
        }

        .login-link {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #174BD2;
            text-decoration: none;
            font-weight: 500;
        }

        footer {
            background-color: #09176E;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 14px;
        }

        .success, .error {
            text-align: left;
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #721c24;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo-container">
            <a href="index.php">
                <img src="logos/AdlaonLogo-nobg.svg" alt="Adlaon Optical Logo" class="logo">
            </a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
        </div>
    </nav>

    <div class="signup-container">
        <div class="signup-card">
            <div class="signup-logo">
                <img src="logos/product-logo.png" alt="Adlaon Optical Logo" width="100px">
            </div>
            <h1>Create an Account</h1>
            
            <form method="POST" action="signup.php">
                <?php if (!empty($success)): ?>
                    <div class="success"><?= $success ?></div>
                <?php endif; ?>
                
                <?php foreach ($errors as $error): ?>
                    <div class="error"><?= $error ?></div>
                <?php endforeach; ?>
                
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" required>
                </div>
                
                <div class="form-group">
                    <label for="signupEmail">Email Address</label>
                    <input type="email" id="signupEmail" name="signupEmail" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                   <input type="tel" id="phone" name="phone" required pattern="[0-9]{11}" maxlength="11" minlength="11" title="Phone number must be exactly 11 digits.">
                </div>

                <div class="form-group">
                    <label for="signupAddress">Address</label>
                    <input type="text" id="signupAddress" name="signupAddress" required>
                </div>
                
                <div class="form-group">
                    <label for="signupPassword">Password</label>
                    <input type="password" id="signupPassword" name="signupPassword" required>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                
                <button type="submit" class="signup-btn" name="submit">Sign Up</button>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="login.php">Log in</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Adlaon Optical. All rights reserved.
    </footer>
</body>
</html>