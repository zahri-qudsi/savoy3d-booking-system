<?php
    session_start();
    include("header.php");
?>

<!-- <div class="container">
   <img src=image/theatre_2.jpg alt="" class="image-resize" style="width: 100%; height: 400px; margin-bottom: 80px">
</div> -->
<!-- ==========Banner-Section========== -->
<div class="banner-section-wrapper">
    <div class="owl-carousel">
        <div class="item owl-carousel-image">
            <img src="image/furiosa.jpg" alt="" class="image-resize">
            <div class="banner-text">Furiosa</div>
        </div>
        <div class="item owl-carousel-image">
            <img src="image/imaginary.jpg" alt="" class="image-resize">
            <div class="banner-text">Imaginary</div>
        </div>
        <div class="item owl-carousel-image">
            <img src="image/bad-boys.jpg" alt="" class="image-resize">
            <div class="banner-text">Bad Boys</div>
        </div>
        <div class="item owl-carousel-image">
            <img src="image/fail-guy.jpg" alt="" class="image-resize">
            <div class="banner-text">Fail Guy</div>
        </div>
        <div class="item owl-carousel-image">
            <img src="image/kingdom-of-the-planet.jpg" alt="" class="image-resize">
            <div class="banner-text">Kingdom of the Planet</div>
        </div>
    </div>
</div>
<!-- ==========Banner-Section========== -->
<section class="movie-section padding-top padding-bottom">
  <div class="owl-carousel-now-showing">
      <div class="container">
          <h2>Now Showing</h2>
          <div class="owl-carousel owl-theme movie-carousel">
              <?php
          include_once 'Database.php';
          $result = mysqli_query($conn, "SELECT * FROM movies");

          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_array($result)) {
                  if ($row['action'] == "running") {
          ?>
              <div class="item">
                  <div class="running-movie">
                      <img src="admin/image/<?php echo $row['image']; ?>" alt="" class="image-resize2">
                      <div class="top-right">
                          <!-- <a data-toggle="modal" data-target="#tailer_modal<?php echo $row['id']; ?>">
                              <img src="img/icon/play.png">
                          </a> -->
                      </div>
                      <h5><b><?php echo $row['movie_name']; ?></b></h5>
                      <h6>
                          <center><?php echo $row['language']; ?></center>
                      </h6>
                      <a href="movie_details.php?pass=<?php echo $row['id']; ?>" class="btn btn-primary">Book Now</a>
                  </div>
              </div>

              <div class="modal fade" id="tailer_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <embed style="width: 820px; height: 450px;" src="<?php echo $row['you_tube_link']; ?>"></embed>
                      </div>
                  </div>
              </div>
              <?php
                  }
              }
          }
          ?>
          </div>
      </div>
  </div>
</section>

<div class="container">
    <h2>Upcoming Movies</h2>
    <div class="row">
        <?php
include_once 'Database.php';
$result = mysqli_query($conn,"SELECT * FROM add_movie");

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
      if($row['action']== "upcoming"){
    ?>
        <div class="image-box">
            <div class="col-lg-2 col-md-3 col-sm-6">

                <div class="card" style="width: 12rem;">
                    <img class="card-img-top image-resize4" src="admin/image/<?php echo $row['image']; ?> "
                        alt="Card image cap">

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['movie_name'];?></h5>
                        <p class="card-text">Director: <?php echo $row['directer'];?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
}
  }
}
?>

    </div>
</div>



<?php
   include("footer.php");
   ?>


<!-- Js Plugins -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery.nicescroll.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
<script src="js/custom.js"></script>

<!-- Include Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function() {
    $(".owl-carousel").owlCarousel({
        items: 1, // Number of items to display at a time
        loop: true, // Enable looping
        margin: 10, // Margin between items
        nav: false, // Enable navigation buttons
        dots: false // Enable pagination dots
        // speed: 1000 // Transition duration in milliseconds (1000ms = 1s)
    });
});
</script>

<script>
$('.movie-carousel').owlCarousel({
    loop: true,
    margin: 5, // Reduced margin to 5px
    nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 5
        },
        1000: {
            items: 8
        }
    }
})
</script>

</body>

</html>