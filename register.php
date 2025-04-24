<?php include "classes/Session.php";
Session::checkLogin();

?>
<?php include "config/config.php"?>
<?php include "db/Database.php"?>
<?php include "classes/format.php"?>
<?php
$db =new Database();
$format = new Format();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="login-lib/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="login-lib/css/style.css">
</head>

<body>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $username = $format->validation($_POST['username']) ;
            $password = $format->validation(md5($_POST['password']));
            $rePassword = $format->validation(md5($_POST['re_password']));

            $username = mysqli_real_escape_string($db->link, $username);
            $password = mysqli_real_escape_string($db->link, $password);
            $rePassword = mysqli_real_escape_string($db->link, $rePassword);

            if (empty($username) || empty($password)) {
                echo "<span style='color:red;font-size:18px;'>Username already exists.</span>";
            } else {
                // check unique username
                $findUser = "SELECT * FROM users WHERE username = '$username'";
                $findUser = $db->select($findUser);
                if ($findUser){
                    echo "<span style='color:red;font-size:18px;'>Username already exists.</span>";
                } else if ($password != $rePassword) {
                    echo "<span style='color:red;font-size:18px;'>Password and confirm password do not match.</span>";
                } else {
                    $hashedPassword = md5($password);
                    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', 2)";
                    $result = $db->crate($query);
                    if ($result){
                        header('location: login.php');
                    }else{
                        echo "<span style='color:red;font-size:18px;'>Server Error!</span>";
                    }
                }
            }
        }
    ?>
    <div class="main">
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Register</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="name" placeholder="Your Name" />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_password" id="re_pass" placeholder="Repeat your password" />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="login-lib/images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">Go to Login</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>