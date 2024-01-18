<?php
require_once "config.php";
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo '<meta content="1;dashboard.php" http-equiv="refresh" />';
    //header("location: welcome.php");
    exit;
}


// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your email.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        //SELECT `id`, `names`, `email`, `password`, `gender`, `mobile`, `image`, `userrole`, `isActive` FROM `user` WHERE 1
        $sql = "SELECT id, names, email, password,userrole,image FROM user WHERE email = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            //$stmt->bindParam(":isActive", $param_isActive, PDO::PARAM_INT);

            // Set parameters
            $param_username = trim($_POST["username"]);
            //$param_username = 1;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $username = $row["email"];
                        $fnames = $row["names"];
                        $userrole = $row["userrole"];
                        $image = $row["image"];
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            //session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["names"] = $fnames;
                            $_SESSION["image"] = $image;
                            $_SESSION["userrole"] = $userrole;
                            $_SESSION["email"] = $username;

                            // Redirect user to welcome page
                            echo '<meta content="1;dashboard.php" http-equiv="refresh" />';
                            //header("location: welcome.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Rural Health Unit Stock Management System </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/rural.jpg">
    <link href="./css/style.css" rel="stylesheet">

    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h3 class="text-center mb-4 text-dark font-weight-bold">Rural Health Unit Stock Management System</h3>
                                    <h4 class="text-center">Login</h4>
                                    <p class="text-center mb-4">Please fill in your credentials to login.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-center ">
                                                <img src="./images/rural.jpg" alt="Logo" class="img-fluid rounded-circle" style="width: 200px; height: 200px; border-radius: 50%;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add a shadow */">
                                            </div>
                                         </div>
                                        <div class="col-md-6">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                                    <label class="text-dark"><strong>Email</strong></label>
                                                    <input type="email" class="form-control" value="" autofocus name="username">
                                                    <small class="help-block text-danger"><?php echo $username_err; ?></small>
                                                </div>
                                                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                                    <label class="text-dark"><strong>Password</strong></label>
                                                    <input type="password" class="form-control" name="password">
                                                    <small class="help-block text-danger"><?php echo $password_err; ?></small>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="new-account mt-5 text-center mb-0">
                                        <footer>&copy; <?php echo date("Y"); ?> Rural Health Unit Stock Management System. All rights reserved.</footer>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>

</body>

</html>