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

    <!-- search result -->
    <?php 
        $searchData = [];
        $categories = [];
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $keyword = $_GET['keyword'];
            if (!empty($keyword)) {
                $keyword = mysqli_real_escape_string($db->link, $keyword);
                
                $query = "SELECT * FROM documents where name like '%$keyword%' ORDER BY id DESC";
                $posts = $db->select($query);
                if ($posts){
                    while ($result = $posts->fetch_assoc()){
                        if (!in_array($result['category_id'], $categories)) {
                            $categories[] = $result['category_id'];
                        }
                        $searchData[] = $result;
                    }
                }
            }
        }
    ?>
    
    <?php if (count($categories)) :?>
        <div class="container-fluid px-0 py-5" id="courses">
            <!-- Courses Start -->
            <?php foreach ($categories as $categoryId) :?>
                <?php 
                    $query = "SELECT * FROM categories where id = '$categoryId'";
                    $category = $db->select($query);
                    if ($category) {
                        $category = mysqli_fetch_array($category);    
                    }
                ?>
                <div class="row mx-0 justify-content-center pt-5">
                    <div class="col-lg-6">
                        <div class="section-title text-center position-relative mb-4">
                            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2"><?php echo $category['name'] ?></h6>
                            <h1 class="display-4">Releases Courses</h1>
                        </div>
                    </div>
                </div>
                <div class="owl-carousel courses-carousel">
                    <?php 
                        $getPosts = [];
                        foreach($searchData as $item) {
                            if ($item['category_id'] == $categoryId) {
                                $getPosts[] = $item;
                            }
                        }
                    ?>
                    <?php foreach($getPosts as $item) :?>
                        <div class="courses-item position-relative">
                            <img class="img-fluid" src="<?php echo 'admin/'.$item['thumbnail'] ?>" alt="">
                            <div class="courses-text">
                                <h4 class="text-center text-white px-3"><?php echo $item['name'] ?></h4>
                                <div class="border-top w-100 mt-3">
                                    <div class="d-flex justify-content-between p-4">
                                        <span class="text-white"><i class="fa fa-user mr-2"></i>Jhon Doe</span>
                                        <span class="text-white"><i class="fa fa-star mr-2"></i>4.5</span>
                                    </div>
                                </div>
                                <div class="w-100 bg-white text-center p-4" >
                                    <a class="btn btn-primary" href="post_details.php?id=<?php echo $item['id'];?>">Course Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <!-- Courses End -->
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<?php include "includes/footer.php"; ?>