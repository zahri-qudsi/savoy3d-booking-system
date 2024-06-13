<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">

            <?php 

        $uri = $_SERVER['REQUEST_URI']; 
        $uriAr = explode("/", $uri);
        $page = end($uriAr);

        ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-home"></i>
                    Dashboard <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add-movie.php">
                    <i class="fas fa-film"></i>
                    Add Movie
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Theater_and_show.php">
                    <i class="fas fa-theater-masks"></i>
                    Theater And Show
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="booking.php">
                    <i class="fas fa-users"></i>
                    Bookings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Feedback.php">
                    <i class="fas fa-comment-alt"></i>
                    Feedback
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="staff.php">
                    <i class="fas fa-user-tie"></i>
                    Staff
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-user"></i>
                    Users
                </a>
            </li>
        </ul>
    </div>


</nav>


<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hello <?php echo $_SESSION["admin"]; ?></h1>
    </div>