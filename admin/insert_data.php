<?php
include_once("Database.php");

// Function to redirect with a script
function redirect($url) {
    echo "<script> window.location.href='$url'; </script>";
    exit;
}

// Add Movie
if (isset($_POST['submit'])) {
    $movie_name = mysqli_real_escape_string($conn, $_POST['movie_name']);
    $directer_name = mysqli_real_escape_string($conn, $_POST['directer_name']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $tailer = mysqli_real_escape_string($conn, $_POST['tailer']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    $decription = mysqli_real_escape_string($conn, $_POST['decription']);
    $show = mysqli_real_escape_string($conn, implode(',', $_POST['show']));
    $filename = $_FILES['img']['name'];

    $location = 'image/' . $filename;
    $file_extension = strtolower(pathinfo($location, PATHINFO_EXTENSION));
    $image_ext = array('jpg', 'png', 'jpeg', 'gif');

    $response = 0;
    if (in_array($file_extension, $image_ext)) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $location)) {
            $response = $location;
        }
    }

    if ($response) {
        $status = 1;
        $insert_record = mysqli_query($conn, "INSERT INTO movies (`movie_name`, `director`, `release_date`, `category`, `language`, `youtube_link`, `action`, `description`, `show`, `image`, `status`) VALUES ('$movie_name', '$directer_name', '$release_date', '$category', '$language', '$tailer', '$action', '$decription', '$show', '$filename', '$status')");
        if (!$insert_record) {
            echo "Unsuccessful: " . mysqli_error($conn);
        } else {
            redirect('Add-movie.php');
        }
    } else {
        echo "Image upload failed.";
    }
}

// Update Movie
if (isset($_POST['updatemovie'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);
    $edit_movie_name = mysqli_real_escape_string($conn, $_POST['edit_movie_name']);
    $edit_directer_name = mysqli_real_escape_string($conn, $_POST['edit_directer_name']);
    $edit_category = mysqli_real_escape_string($conn, $_POST['edit_category']);
    $edit_language = mysqli_real_escape_string($conn, $_POST['edit_language']);
    $tailer = mysqli_real_escape_string($conn, $_POST['edit_tailer']);
    $action = mysqli_real_escape_string($conn, $_POST['edit_action']);
    $decription = mysqli_real_escape_string($conn, $_POST['decription']);
    $edit_show = mysqli_real_escape_string($conn, implode(',', $_POST['show']));
    $edit_old_image = mysqli_real_escape_string($conn, $_POST['old_image']);
    $edit_filename = $_FILES['edit_img']['name'];

    $image = $edit_old_image; // Default to old image
    if ($edit_filename != '') {
        $image = $edit_filename;
        $location = 'image/' . $image;
        $file_extension = strtolower(pathinfo($location, PATHINFO_EXTENSION));
        $image_ext = array('jpg', 'png', 'jpeg', 'gif');

        if (in_array($file_extension, $image_ext)) {
            if (!move_uploaded_file($_FILES['edit_img']['tmp_name'], $location)) {
                echo "Image upload failed.";
                exit;
            }
        } else {
            echo "Invalid image format.";
            exit;
        }
    }

    $update_query = "
        UPDATE `movies` 
        SET `movie_name` = '$edit_movie_name', 
            `director` = '$edit_directer_name', 
            `category` = '$edit_category', 
            `language` = '$edit_language', 
            `youtube_link` = '$tailer', 
            `action` = '$action', 
            `description` = '$decription', 
            `show` = '$edit_show', 
            `image` = '$image' 
        WHERE `id` = '$e_id'
    ";

    $insert_record = mysqli_query($conn, $update_query);
    if (!$insert_record) {
        echo "Unsuccessful: " . mysqli_error($conn);
    } else {
        redirect('Add-movie.php');
    }
}

// Delete Movie
if (isset($_POST['deletemovie'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = mysqli_query($conn, "DELETE FROM movies WHERE id=$id");
    redirect('Add-movie.php');
}

// Add Show
if (isset($_POST['addshow'])) {
    $theater = mysqli_real_escape_string($conn, $_POST['theater_name']);
    $show = mysqli_real_escape_string($conn, $_POST['show']);

    $status = 1;
    $insert_record = mysqli_query($conn, "INSERT INTO theatres (`show_time`, `theater`) VALUES ('$show', '$theater')");
    if (!$insert_record) {
        echo "Insert Unsuccessful: " . mysqli_error($conn);
    } else {
        redirect('Theater_and_show.php');
    }
}

// Update Show Time
if (isset($_POST['updatetime'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);
    $edit_screen = mysqli_real_escape_string($conn, $_POST['edit_screen']);
    $edit_time = mysqli_real_escape_string($conn, $_POST['edit_time']);

    $update_query = "UPDATE `theatres` SET `theater` = '$edit_screen', `show_time` = '$edit_time' WHERE `id` = '$e_id'";
    $update_record = mysqli_query($conn, $update_query);
    if (!$update_record) {
        echo "Unsuccessful: " . mysqli_error($conn);
    } else {
        redirect('Theater_and_show.php');
    }
}

// Delete Show Time
if (isset($_POST['deletetime'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = mysqli_query($conn, "DELETE FROM theatres WHERE id=$id");
    redirect('Theater_and_show.php');
}

// Add Feedback
if (isset($_POST['add_feedback'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $massage = mysqli_real_escape_string($conn, $_POST['massage']);

    $status = 1;
    $insert_record = mysqli_query($conn, "INSERT INTO feedback (`user_name`, `user_email`, `message`) VALUES ('$name', '$email', '$massage')");
    if (!$insert_record) {
        echo "Insert Unsuccessful: " . mysqli_error($conn);
    } else {
        redirect('feedback.php');
    }
}

// Update Feedback
if (isset($_POST['updatefeedback'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);
    $edit_feedback_name = mysqli_real_escape_string($conn, $_POST['edit_feedback_name']);
    $edit_feedback_email = mysqli_real_escape_string($conn, $_POST['edit_feedback_email']);
    $edit_feedback_massage = mysqli_real_escape_string($conn, $_POST['edit_feedback_massage']);

    $update_record = mysqli_query($conn, "UPDATE `feedback` SET `user_name` = '$edit_feedback_name', `user_email` = '$edit_feedback_email', `message` = '$edit_feedback_massage' WHERE `feedback_id` = '$e_id'");
    if (!$update_record) {
        echo "Update Unsuccessful: " . mysqli_error($conn);
    } else {
        redirect('feedback.php');
    }
}

// Delete Feedback
if (isset($_POST['deletefeedback'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = mysqli_query($conn, "DELETE FROM feedback WHERE feedback_id=$id");
    redirect('feedback.php');
}

// Add User
if (isset($_POST['add_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the SQL statement
    $insert_record = mysqli_query($conn, "INSERT INTO users (username, email, phone, password) VALUES ('$username', '$email', '$mobile', '$hashed_password')");
    if (!$insert_record) {
        echo "Insert Unsuccessful: " . mysqli_error($conn);
    } else {
        redirect('users.php');
    }
}

// Update User
if (isset($_POST['updateusers'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);
    $edit_Username = mysqli_real_escape_string($conn, $_POST['edit_username']);
    $edit_email = mysqli_real_escape_string($conn, $_POST['edit_email']);
    $edit_mobile = mysqli_real_escape_string($conn, $_POST['edit_mobile']);
    $edit_password = mysqli_real_escape_string($conn, $_POST['edit_password']);

    $update_record = mysqli_query($conn, "UPDATE `users` SET `username` = '$edit_Username', `email` = '$edit_email', `phone` = '$edit_mobile', `password` = '$edit_password' WHERE `id` = '$e_id'");
    if (!$update_record) {
        echo "Update Unsuccessful: " . mysqli_error($conn);
    } else {
        redirect('users.php');
    }
}

// Delete User
if (isset($_POST['deleteuser'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    redirect('users.php');
}

if (isset($_POST['addbooking'])) {
    $username_id = mysqli_real_escape_string($conn, $_POST['username_id']);
    $movie_id = mysqli_real_escape_string($conn, $_POST['movie_id']);
    $seat = mysqli_real_escape_string($conn, $_POST['seat']);
    $totalseat = mysqli_real_escape_string($conn, $_POST['totalseat']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
    $card_name = mysqli_real_escape_string($conn, $_POST['card_name']);
    $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
    $ex_date = mysqli_real_escape_string($conn, $_POST['ex_date']);
    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);

    // Fetch username
    $username_query = mysqli_query($conn, "SELECT username FROM users WHERE id = '$username_id'");
    if (!$username_query || mysqli_num_rows($username_query) == 0) {
        echo "Error fetching username: " . mysqli_error($conn);
        exit;
    }
    $username_row = mysqli_fetch_assoc($username_query);
    $username = $username_row['username'];

    // Fetch movie name
    $movie_query = mysqli_query($conn, "SELECT movie_name FROM movies WHERE id = '$movie_id'");
    if (!$movie_query || mysqli_num_rows($movie_query) == 0) {
        echo "Error fetching movie name for movie_id: $movie_id - " . mysqli_error($conn);
        exit;
    }
    $movie_row = mysqli_fetch_assoc($movie_query);
    $movie_name = $movie_row['movie_name'];

    // Retrieve selected show times from checkboxes
    $selected_show_times = isset($_POST['show']) ? $_POST['show'] : array();

    // Combine selected show times into a single string separated by commas
    $show_times_str = implode(",", $selected_show_times);

    // Insert record
    $insert_record = mysqli_query($conn, "
    INSERT INTO booking 
    (u_id, movie_ID, movie_name, show_time, seats, totalseats, price, payment_date, booking_date, card_name, card_number, exp_date, cvv, reference) 
    VALUES (
        '$username_id',
        '$movie_id',
        '$movie_name',
        '$show_times_str',  -- Insert selected show times
        '$seat',
        '$totalseat',
        '$price',
        '$payment_date',
        '$booking_date',
        '$card_name',
        '$card_number',
        '$ex_date',
        '$cvv',
        '$reference_number'
    )
    ");

    if (!$insert_record) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>window.location.href = 'booking.php'</script>";
    }
}



// Update booking
if (isset($_POST['updatebooking'])) {
    $booking_ID = mysqli_real_escape_string($conn, $_POST['e_booking_ID']);
    $username_id = mysqli_real_escape_string($conn, $_POST['edit_username_id']);
    $movie_id = mysqli_real_escape_string($conn, $_POST['edit_movie_id']);
    $seats = mysqli_real_escape_string($conn, $_POST['edit_seats']);
    $totalseats = mysqli_real_escape_string($conn, $_POST['edit_totalseats']);
    $price = mysqli_real_escape_string($conn, $_POST['edit_price']);
    $payment_date = mysqli_real_escape_string($conn, $_POST['edit_payment_date']);
    $booking_date = mysqli_real_escape_string($conn, $_POST['edit_booking_date']);
    $card_name = mysqli_real_escape_string($conn, $_POST['edit_card_name']);
    $card_number = mysqli_real_escape_string($conn, $_POST['edit_card_number']);
    $ex_date = mysqli_real_escape_string($conn, $_POST['edit_ex_date']);
    $cvv = mysqli_real_escape_string($conn, $_POST['edit_cvv']);
    $reference_number = mysqli_real_escape_string($conn, $_POST['edit_reference_number']);

    // Combine selected show times into a single string separated by commas
    $selected_show_times = isset($_POST['edit_show_time']) ? $_POST['edit_show_time'] : array();
    $show_times_str = implode(",", $selected_show_times);

    // Update record
    $update_record = mysqli_query($conn, "
        UPDATE booking SET
        user_ID = '$username_id',
        movie_ID = '$movie_id',
        show_time = '$show_times_str',
        seats = '$seats',
        totalseats = '$totalseats',
        price = '$price',
        payment_date = '$payment_date',
        booking_date = '$booking_date',
        card_name = '$card_name',
        card_number = '$card_number',
        ex_date = '$ex_date',
        cvv = '$cvv',
        reference_number = '$reference_number'
        WHERE booking_ID = '$booking_ID'
    ");

    if (!$update_record) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<script>window.location.href = 'booking.php'</script>";
    }
}


// Delete booking
if (isset($_POST['deletebooking'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['d_booking_ID']);

    // Delete record
    $delete_record = mysqli_query($conn, "DELETE FROM booking WHERE booking_ID = '$booking_id'");

    if (!$delete_record) {
        echo "Delete Unsuccessful: " . mysqli_error($conn);
    } else {
        echo "<script> window.location.href = 'booking.php' </script>";
    }
}

//Add Staff
if (isset($_POST['add_staff'])) {
    $staff_name = mysqli_real_escape_string($conn, $_POST['staff_name']);
    $staff_email = mysqli_real_escape_string($conn, $_POST['staff_email']);
    $staff_phone_number = mysqli_real_escape_string($conn, $_POST['staff_phone_number']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    $insert_record = mysqli_query($conn, "INSERT INTO staff (staff_name, staff_email, staff_phone, salary) VALUES ('" . $staff_name . "','" . $staff_email . "','" . $staff_phone_number . "','" . $salary . "')");
    if (!$insert_record) {
        echo "Insert Unsuccessful";
    } else {
        echo "<script> window.location.href = 'staff.php' </script>";
    }
}


//Edit Staff
if (isset($_POST['updatestaff'])) {
    $e_id = mysqli_real_escape_string($conn, $_POST['e_id']);
    $edit_staff_name = mysqli_real_escape_string($conn, $_POST['edit_staff_name']);
    $edit_staff_email = mysqli_real_escape_string($conn, $_POST['edit_staff_email']);
    $edit_staff_phone_number = mysqli_real_escape_string($conn, $_POST['edit_staff_phone_number']);
    $edit_salary = mysqli_real_escape_string($conn, $_POST['edit_salary']);

    $update_record = mysqli_query($conn, "UPDATE staff SET staff_name = '$edit_staff_name', staff_email = '$edit_staff_email', staff_phone = '$edit_staff_phone_number', salary = '$edit_salary' WHERE staff_id = '$e_id'");

    if (!$update_record) {
        echo "Update Unsuccessful";
    } else {
        echo "<script> window.location.href = 'staff.php'</script>";
    }
}


//Delete Staff

if (isset($_POST['deletestaff'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $sql = mysqli_query($conn, "DELETE FROM staff WHERE staff_id = $id");
    
    echo "<script> window.location.href = 'staff.php' </script>";
}