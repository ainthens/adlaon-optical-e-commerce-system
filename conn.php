<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AdlaonOptical - Login</title>
        <link rel="icon" type="image/png" href="favicon.png">
    </head>
    <body>
        <?php
            $servername = "localhost";
            $user = "root";
            $password = "";
            $dbname = "web_final_project";
            $conn = mysqli_connect($servername, $user, $password, $dbname);
            if (!$conn) {
                die("Connection Failed :(".mysqli_connect_error());
            }
        ?>
    </body>
</html>