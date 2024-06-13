<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie Ticket Booking System</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <!-- Include Owl Carousel Theme CSS (optional) -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>


    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="  text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
</head>

<body>

    <!-- ==========Preloader========== -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ==========Preloader========== -->
    <!-- ==========Overlay========== -->
    <div class="overlay"></div>
    <a href="#0" class="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- ==========Overlay========== -->

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <a href="login.html">Sign in</a>

            </div>

        </div>

        <div id="mobile-menu-wrap"></div>

    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <!-- <div id="headerTop" class="header__top">
        <div class="container">

        </div>
    </div> -->
    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7"></div>
                <?php
            include_once "Database.php";
            if (isset($_SESSION['uname'])) {
                $uname = $_SESSION['uname'];
                $result = mysqli_query($conn,"SELECT * FROM user WHERE username ='".$uname."'");
            ?>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            <!-- <?php 
                            // if (mysqli_num_rows($result) > 0) {
                            //     while($row = mysqli_fetch_array($result)) {
                            //         if($row['image'] == ''){
                            //             echo '<img src="image/img_avatar.png" alt="Avatar" class="avatar">';
                            //         } else {
                            ?>
                                <img src="admin/image/<?php echo $row["image"]; ?>" alt="Avatar" class="avatar">
                            <?php
                            //         }
                            //     }
                            // }
                            ?> -->
                            <span>Hii <?php echo $_SESSION['uname'];?></span>
                            <a href="logout.php"> Logout</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
            ?>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            <a href="login_form.php">Sign in</a>
                            <a href="register_form.php">Register</a>
                        </div>
                    </div>
                </div>
                <?php  
            }
            ?>
            </div>
            <div class="header-wrapper">
                <div class="logo">
                    <a href="index.php">
                        <img src="img/logo.png" alt="logo">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="index.php" class="active">Home</a>
                    </li>
                    <li>
                        <a href="allmovie.php">Movies</a>
                    </li>
                    <li>
                        <a href="about.php">Events</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <!-- <li class="header-button pr-0">
                    <a href="sign-up.html">join us</a>
                </li> -->
                </ul>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>

    <!-- Header Section End -->