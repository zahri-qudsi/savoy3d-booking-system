<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Customer Page</title>

    <?php session_start();
    if (!isset($_SESSION['admin'])) {
        header("location:login.php");
    }
    ?>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>

    <div class="container-fluid">
        <div class="row">

            <?php include "./templates/sidebar.php"; ?>

            <div class="row">
                <div class="col-10">
                    <h2>Movie Booking</h2>
                </div>
                <div class="col-2">
                    <button data-toggle="modal" data-target="#add_customer_modal" class="btn btn-primary btn-sm">Add
                        Booking</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Name</th>
                            <th>Movie</th>
                            <th>Theater</th>
                            <th>Show Time</th>
                            <th>Seat</th>
                            <th>Price</th>
                            <th>Payment Date</th>
                            <th>Booking Date</th>
                            <th>Reference Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="customer_list">
                        <?php
                        include_once 'database.php';

                        // Adjust the SQL query to use proper foreign keys
                        $query = "
                SELECT 
                    b.booking_ID, 
                    u.username, 
                    b.movie_name, 
                    t.theater, 
                    b.show_time, 
                    b.seats, 
                    b.price, 
                    b.payment_date, 
                    b.booking_date, 
                    b.reference 
                FROM booking b 
                INNER JOIN users u ON b.u_id = u.id 
                INNER JOIN theatres t ON b.show_time = t.show_time
            ";

                        $result = mysqli_query($conn, $query);

                        // Check for SQL errors
                        if (!$result) {
                            echo "Error executing query: " . mysqli_error($conn);
                        } else {
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['booking_ID']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['movie_name']; ?></td>
                            <td><?php echo $row['theater']; ?></td>
                            <td><?php echo $row['show_time']; ?></td>
                            <td><?php echo $row['seats']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['payment_date']; ?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td><?php echo $row['reference']; ?></td>
                            <td><button data-toggle="modal" type="button"
                                    data-target="#edit_booking_modal_<?php echo $row['booking_ID']; ?>"
                                    class="btn btn-primary btn-sm">Edit Booking</button></td>
                            <td><button data-toggle="modal" type="button"
                                    data-target="#delete_booking_modal_<?php echo $row['booking_ID']; ?>"
                                    class="btn btn-danger btn-sm">Delete Booking</button></td>
                        </tr>
                        <!-- Edit Booking Modal -->
                        <div class="modal fade" id="edit_booking_modal_<?php echo $row['booking_ID']; ?>" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Booking</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit_booking_form_<?php echo $row['booking_ID']; ?>"
                                            action="update_booking.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="e_booking_ID"
                                                value="<?php echo $row['booking_ID']; ?>">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label>Username</label>
                                                    <select class="form-control" name="edit_username_id">
                                                        <option value="<?php echo $row['username']; ?>" selected>
                                                            <?php echo $row['username']; ?></option>
                                                        <?php
                                $result = mysqli_query($conn, "SELECT * FROM users");
                                if (mysqli_num_rows($result) > 0) {
                                    while ($user_row = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $user_row['id'] . '">' . $user_row['username'] . '</option>';
                                    }
                                }
                                ?>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Movie</label>
                                                        <select class="form-control" name="edit_movie_id">
                                                            <option value="<?php echo $row['movie_name']; ?>" selected>
                                                                <?php echo $row['movie_name']; ?></option>
                                                            <?php
                                    $result = mysqli_query($conn, "SELECT * FROM movies WHERE action='running'");
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($movie_row = mysqli_fetch_array($result)) {
                                            echo '<option value="' . $movie_row['id'] . '">' . $movie_row['movie_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Theater 1</label>
                                                        <?php
                                $result = mysqli_query($conn, "SELECT * FROM theatres WHERE theater = '1'");
                                if (mysqli_num_rows($result) > 0) {
                                    while ($fatch = mysqli_fetch_array($result)) {
                                        $checked = '';
                                        if (in_array($fatch['show_time'], explode(',', $row['show_time']))) {
                                            $checked = 'checked';
                                        }
                                ?>
                                                        <div>
                                                            <font size="2"><?php echo $fatch['show_time']; ?></font>
                                                            <input type="checkbox" name="edit_show_time[]"
                                                                value="<?php echo $fatch['show_time']; ?>"
                                                                <?php echo $checked; ?>>
                                                        </div>
                                                        <?php
                                    }
                                }
                                ?>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Theater 2</label>
                                                        <?php
                                $result = mysqli_query($conn, "SELECT * FROM theatres WHERE theater = '2'");
                                if (mysqli_num_rows($result) > 0) {
                                    while ($fatch = mysqli_fetch_array($result)) {
                                        $checked = '';
                                        if (in_array($fatch['show_time'], explode(',', $row['show_time']))) {
                                            $checked = 'checked';
                                        }
                                ?>
                                                        <div>
                                                            <font size="2"><?php echo $fatch['show_time']; ?></font>
                                                            <input type="checkbox" name="edit_show_time[]"
                                                                value="<?php echo $fatch['show_time']; ?>"
                                                                <?php echo $checked; ?>>
                                                        </div>
                                                        <?php
                                    }
                                }
                                ?>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Seats</label>
                                                        <input type="text" name="edit_seats" class="form-control"
                                                            value="<?php echo $row['seats']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Total Seat</label>
                                                        <input type="number" name="edit_totalseats" class="form-control"
                                                            value="<?php echo isset($row['totalseats']) ? $row['totalseats'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Price</label>
                                                        <input type="text" name="edit_price" class="form-control"
                                                            value="<?php echo $row['price']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Payment Date</label>
                                                        <input type="date" name="edit_payment_date" class="form-control"
                                                            value="<?php echo $row['payment_date']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Booking Date</label>
                                                        <input type="date" name="edit_booking_date" class="form-control"
                                                            value="<?php echo $row['booking_date']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Card Name</label>
                                                        <input type="text" name="edit_card_name" class="form-control"
                                                            value="<?php echo isset($row['card_name']) ? $row['card_name'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Card Number</label>
                                                        <input type="text" name="edit_card_number" class="form-control"
                                                            value="<?php echo isset($row['card_number']) ? $row['card_number'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Expiration Date</label>
                                                        <input type="month" name="edit_ex_date" class="form-control"
                                                            value="<?php echo isset($row['exp_date']) ? $row['exp_date'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>CVV</label>
                                                        <input type="text" name="edit_cvv" class="form-control"
                                                            value="<?php echo isset($row['cvv']) ? $row['cvv'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Reference Number</label>
                                                        <input type="text" name="edit_reference_number"
                                                            class="form-control"
                                                            value="<?php echo isset($row['reference']) ? $row['reference'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <input type="submit" class="btn btn-primary" name="updatebooking"
                                                        value="Update Booking">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Delete Booking Modal -->
                        <div class="modal fade" id="delete_booking_modal_<?php echo $row['booking_ID']; ?>"
                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Booking</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this booking?</p>
                                        <form action="add_movie.php" method="post">
                                            <input type="hidden" name="d_booking_ID"
                                                value="<?php echo $row['booking_ID']; ?>">
                                            <button type="submit" class="btn btn-danger"
                                                name="deletebooking">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                                }
                            } else {
                                echo "<tr><td colspan='10'>No records found.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>


            </main>
        </div>
    </div>

    <!-- Add customers Modal start -->
    <div class="modal fade" id="add_customer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="myform" id="insert_booking" action="insert_data.php" method="post"
                        enctype="multipart/form-data" onsubmit="return validateform()">
                        <div class="row">
                            <div class="col-12">
                                <label>Username</label>
                                <select class="form-control" name="username_id">
                                    <option value="">Select Username</option>
                                    <?php
                                $result = mysqli_query($conn, "SELECT * FROM users");
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
                                    }
                                }
                                ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Movie</label>
                                    <select class="form-control" name="movie_id">
                                        <option value="">Select Movie</option>
                                        <?php
                                    $result = mysqli_query($conn, "SELECT * FROM movies WHERE action='running'");
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo '<option value="' . $row['id'] . '">' . $row['movie_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Theater 1</label>
                                    <?php
                                $result = mysqli_query($conn, "SELECT * FROM theatres WHERE theater = '1'");
                                if (mysqli_num_rows($result) > 0) {
                                    while ($fatch = mysqli_fetch_array($result)) {
                                ?>
                                    <font size="2"><?php echo $fatch['show_time']; ?></font>
                                    <input type="checkbox" name="show[]" id="show"
                                        value="<?php echo $fatch['show_time']; ?>">
                                    <?php
                                    }
                                }
                                ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Theater 2</label>
                                    <?php
                                $result = mysqli_query($conn, "SELECT * FROM theatres WHERE theater = '2'");
                                if (mysqli_num_rows($result) > 0) {
                                    while ($fatch = mysqli_fetch_array($result)) {
                                ?>
                                    <font size="2"><?php echo $fatch['show_time']; ?></font>
                                    <input type="checkbox" name="show[]" id="show"
                                        value="<?php echo $fatch['show_time']; ?>">
                                    <?php
                                    }
                                }
                                ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Seats</label>
                                    <input type="text" name="seat" class="form-control" placeholder="Enter Seats">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Total Seat</label>
                                    <input type="number" name="totalseat" class="form-control"
                                        placeholder="Enter Total Seat">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" name="price" class="form-control" placeholder="Enter Price">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Payment Date</label>
                                    <input type="date" name="payment_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Booking Date</label>
                                    <input type="date" name="booking_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Card Name</label>
                                    <input type="text" name="card_name" class="form-control"
                                        placeholder="Enter Card Name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" name="card_number" class="form-control"
                                        placeholder="Enter Card Number">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Expiration Date</label>
                                    <input type="month" name="ex_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" name="cvv" class="form-control" placeholder="Enter CVV">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Reference Number</label>
                                    <input type="text" name="reference_number" class="form-control"
                                        placeholder="Enter Reference Number">
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="submit" name="addbooking" class="btn btn-primary add-product"
                                    value="Add Booking">
                            </div>
                        </div>
                    </form>
                    <div id="preview"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add customers Modal end -->






    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <?php include_once("./templates/footer.php"); ?>

    <script>
    function validateform() {
        var username_id = document.myform.username_id.value;
        var movie_id = document.myform.movie_id.value;
        var show_time = document.myform.show_time.value;
        var theatre = document.myform.theatre.value;
        var seat = document.myform.seat.value;
        var totalseat = document.myform.totalseat.value;
        var price = document.myform.price.value;
        var payment_date = document.myform.payment_date.value;
        var booking_date = document.myform.booking_date.value;
        var card_name = document.myform.card_name.value;
        var card_number = document.myform.card_number.value;
        var ex_date = document.myform.ex_date.value;
        var cvv = document.myform.cvv.value;
        var reference_number = document.myform.reference_number.value;

        if (username_id == "") {
            alert("Require username");
            return false;
        } else if (movie_id == "") {
            alert("Require Movie");
            return false;
        } else if (show_time == "") {
            alert("Require Show Time");
            return false;
        } else if (theatre == "") {
            alert("Require Theatre");
            return false;
        } else if (seat == "") {
            alert("Require Seat");
            return false;
        } else if (totalseat == "") {
            alert("Require Total Seat");
            return false;
        } else if (price == "") {
            alert("Require Price");
            return false;
        } else if (payment_date == "") {
            alert("Require Payment Date");
            return false;
        } else if (booking_date == "") {
            alert("Require Booking Date");
            return false;
        } else if (card_name == "") {
            alert("Require Card Name");
            return false;
        } else if (card_number == "") {
            alert("Require Card Number");
            return false;
        } else if (ex_date == "") {
            alert("Require Expiration Date");
            return false;
        } else if (cvv == "") {
            alert("Require CVV");
            return false;
        } else if (reference_number == "") {
            alert("Require Reference Number");
            return false;
        }
    }
    </script>
    </body>

</html>