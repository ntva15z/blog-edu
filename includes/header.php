<?php include "classes/Session.php";?>
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
    <meta charset="utf-8">
    <title>Study IELTS - Online Education Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
</head>
<body>

    <!-- Topbar Start -->
    <div class="container-fluid bg-dark">
        <div class="row py-2 px-lg-5">
            <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center text-white">
                    <small><i class="fa fa-phone-alt mr-2"></i>+012 345 6789</small>
                    <small class="px-3">|</small>
                    <small><i class="fa fa-envelope mr-2"></i>info@example.com</small>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-white px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-white pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.php" class="navbar-brand ml-lg-3">
                <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-book-reader mr-3"></i>Study IELTS</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="index.php#courses" class="nav-item nav-link">Toeic Reading</a>
                    <a href="index.php#courses" class="nav-item nav-link">Toeic Writing</a>
                    <a href="about.php" class="nav-item nav-link">About Us</a>
                </div>
                <?php if (!Session::isLogin()) :?>
                    <a href="login.php" class="btn btn-primary py-2 px-4 d-none d-lg-block mr-3">Login</a>
                    <a href="register.php" class="btn btn-primary py-2 px-4 d-none d-lg-block">Register</a>
                <?php else :?>
                    <?php
                        if (isset($_GET['action']) && $_GET['action'] == 'logout'){
                            Session::destroy();
                        }
                    ?>
                    <a href="?action=logout" class="btn btn-primary py-2 px-4 d-none d-lg-block mr-3">Logout</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center my-5 py-5">
            <h1 class="text-white display-1 mb-5"><?php echo !empty($pageTitle) ? $pageTitle : 'Education Courses' ?></h1>
            <div class="mx-auto mb-5" style="width: 100%; max-width: 600px;">
                <form action="search_results.php" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control border-light" name="keyword" style="padding: 30px 25px;" placeholder="Keyword">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary px-4 px-lg-5">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Header End -->
