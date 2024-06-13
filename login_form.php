<html>

<head>
    <title> Login Page</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="site.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="css/login.css" type="text/css">
</head>

<body>
    <div class="wrapper">
        <form action="#" id="loginForm">
            <h2>Login</h2>
            <div class="input-field">
                <input type="text" id="username" required>
                <label>Enter your username</label>
                <p id="nameerror" class="error"></p>
            </div>
            <div class="input-field">
                <input type="password" id="password" required>
                <label>Enter your password</label>
                <p id="passerror" class="error"></p>
                <div id="msg" class="error"></div>
            </div>
            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember">
                    <p>Remember me</p>
                </label>
                <a href="forget_password.php">Forgot password?</a>
            </div>
            <button type="submit" id="login">Log In</button>
            <div class="register">
                <p>Don't have an account? <a href="register_form.php">Register</a></p>
            </div>
            <div class="admin-login">
                <p><a href="admin/login.php">Admin Login</a></p>
            </div>
        </form>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $("#loginForm").submit(function(event) {
            event.preventDefault();
            var username = $("#username").val().trim();
            var password = $("#password").val().trim();

            if (username == "") {
                $("#nameerror").html("<font color='red'>Name Required</font>");
                return false;
            } else {
                $("#nameerror").html("");
            }

            if (password == "") {
                $("#passerror").html("<font color='red'>Password Required</font>");
                return false;
            } else {
                $("#passerror").html("");
            }

            $.ajax({
                url: 'login.php',
                type: 'post',
                data: {
                    username: username,
                    password: password
                },
                success: function(response) {
                    if (response == 1) {
                        window.location = "index.php";
                    } else {
                        $("#msg").html(
                            "<font color='red'>Invalid Username or Password</font>");
                    }
                }
            });
        });
    });
    </script>

</body>

</html>