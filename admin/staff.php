<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Manage Staff Page</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("location:login.php");
    }
    ?>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "./templates/sidebar.php"; ?>

            <div class="col main-content">
                <div class="row">
                    <div class="col-10">
                        <h2>Staff</h2>
                    </div>
                    <div class="col-2">
                        <a href="#" data-toggle="modal" data-target="#add_staff_modal"
                            class="btn btn-primary btn-sm">Add Staff</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Staff Name</th>
                                <th>Staff Email</th>
                                <th>Phone Number</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="staff_list">
                            <?php
                            include_once 'database.php';
                            $result = mysqli_query($conn, "SELECT * FROM staff");

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $id = $row['staff_id']; ?>
                            <tr>
                                <td><?php echo $row['staff_id']; ?></td>
                                <td><?php echo $row['staff_name']; ?></td>
                                <td><?php echo $row['staff_email']; ?></td>
                                <td><?php echo $row['staff_phone']; ?></td>
                                <td><?php echo $row['salary']; ?></td>
                                <td>
                                    <button onclick="openEditModal(<?php echo $id; ?>)"
                                        class="btn btn-primary btn-sm">Edit Staff</button>
                                    <button onclick="openDeleteModal(<?php echo $id; ?>)"
                                        class="btn btn-danger btn-sm">Delete Staff</button>
                                </td>
                            </tr>

                            <!-- Delete Staff Modal -->
                            <div class="modal fade" id="delete_staff_modal<?php echo $id; ?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Staff</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="insert_data.php" method="post">
                                                <h4>Are you sure you want to delete staff with ID "<?php echo $id; ?>"?
                                                </h4>
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <input type="submit" name="deletestaff" value="OK"
                                                    class="btn btn-primary">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Staff Modal -->
                            <div class="modal fade" id="edit_staff_modal<?php echo $id; ?>" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Staff</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="insert_data.php" method="post">
                                                <div class="form-group">
                                                    <label>Staff Name</label>
                                                    <input type="hidden" name="e_id" value="<?php echo $id; ?>">
                                                    <input class="form-control" name="edit_staff_name"
                                                        value="<?php echo $row['staff_name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Staff Email</label>
                                                    <input class="form-control" name="edit_staff_email"
                                                        value="<?php echo $row['staff_email']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input type="text" class="form-control"
                                                        name="edit_staff_phone_number"
                                                        value="<?php echo $row['staff_phone']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Salary</label>
                                                    <input type="number" class="form-control" name="edit_salary"
                                                        value="<?php echo $row['salary']; ?>">
                                                </div>
                                                <input type="submit" name="updatestaff" value="Update"
                                                    class="btn btn-primary">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="add_staff_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enter Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="staffform" action="insert_data.php" method="post" onsubmit="return validateStaffForm()">
                        <div class="form-group">
                            <label>Staff Name</label>
                            <input class="form-control" name="staff_name" id="staff_name" placeholder="Staff name">
                        </div>
                        <div class="form-group">
                            <label>Staff Email</label>
                            <input class="form-control" name="staff_email" id="staff_email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="staff_phone_number" id="staff_phone_number"
                                placeholder="Phone number">
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="number" name="salary" id="salary" class="form-control"
                                placeholder="Enter Salary">
                        </div>
                        <input type="hidden" name="add_staff" value="1">
                        <input type="submit" name="add_staff" class="btn btn-primary add-product" value="Add Staff">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    function openEditModal(id) {
        $('#edit_staff_modal' + id).modal('show');
    }

    function openDeleteModal(id) {
        $('#delete_staff_modal' + id).modal('show');
    }

    function validateStaffForm() {
        var name = document.staffform.staff_name.value;
        var email = document.staffform.staff_email.value;
        var phone = document.staffform.staff_phone_number.value;
        var salary = document.staffform.salary.value;

        if (name == "") {
            alert("Staff name is required");
            return false;
        } else if (email == "") {
            alert("Email is required");
            return false;
        } else if (phone == "") {
            alert("Phone number is required");
            return false;
        } else if (salary == "") {
            alert("Salary is required");
            return false;
        }
        return true;
    }
    </script>

    <?php include_once("./templates/footer.php"); ?>
</body>

</html>