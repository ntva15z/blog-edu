<?php include "classes/Session.php";?>
<?php include "config/config.php"?>
<?php include "db/Database.php"?>
<?php include "classes/format.php"?>
<?php
$db =new Database();
$format = new Format();
Session::checkLogin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

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

            $username = mysqli_real_escape_string($db->link, $username);
            $password = md5(mysqli_real_escape_string($db->link, $password));

            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 2";
            $result = $db->select($query);
            if ($result != false){
                $value = mysqli_fetch_array($result);
                $row = mysqli_num_rows($result);
                if ($row > 0){
                        Session::set("login", true);
                        Session::set("username", $value['username']);
                        Session::set("userid", $value['id']);
                        header('location: index.php');
                }else{
                    echo "<span style='color:red;font-size:18px;'>No result found</span>";
                }
            }else{
                echo "<span style='color:red;font-size:18px;'>Username and Password did not match</span>";
            }
        }
    ?>
    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="login-lib/images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Register new account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="your_name" placeholder="Username" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="your_pass" placeholder="Password" />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>