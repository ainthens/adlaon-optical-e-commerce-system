<?php
    require_once "conn.php";
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $error = "";
        $sql = "SELECT id, full_name, role, password, img_path FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        if ($user) 
        {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role']= $user['role'];
                $_SESSION['img_path'] = $user['img_path'];
                $_SESSION['password'] = $user['passoword'];
                if($user['role'] == "user"){
                    header("Location: index.php");
                    exit();
                }
                else if($user['role'] == "admin")
                {
                    header("Location: admin.php");
                    exit();
                }

                
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    }
        /*  Users:
            paoloperalta246@gmail.com | cherryberry      | id: 1
            robbjullian369@gmail.com  | mangopythonbomb  | id: 2
            alysonculala@gmail.com    | jppogi           | id: 3
            admin@gmail.com           | july302005       | id: 7
            eddie@gmail.com           | lovesarbor       | id: 14
        */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>AdlaonOptical - Login</title>
        <link rel="stylesheet" href="form_style.css">
        <link rel="icon" type="image/png" href="favicon.png">
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

    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="logos/product-logo.png" alt="Adlaon Optical Logo" width="100">
            </div>
            <h1>Welcome Back</h1>
            
            <form method="POST" action="login.php">
                <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="login-btn" name="login">Log In</button>
                <a href="forgot-password.php" class="forgot-password">Forgot password?</a>
            </form>
            
            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Adlaon Optical. All rights reserved.
    </footer>
    </body>
</html>