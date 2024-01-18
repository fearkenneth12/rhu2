<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';

// Define variables and initialize with empty values
$names = $username =$mobile = $password = $confirm_password = "";
$names_err = $username_err =$mobile_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE email = :username";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
//                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    // Validate names
    if(empty(trim($_POST["names"]))){
        $names_err = "Please provide user's names.";
    } else{
        $names = trim($_POST["names"]);
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO user(names, email, password, gender, mobile, userrole) VALUES (:names, :email, :password, :gender, :mobile, :userrole)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":names", $param_names, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":gender", $param_gender, PDO::PARAM_STR);
            $stmt->bindParam(":mobile", $param_mobile, PDO::PARAM_STR);
            $stmt->bindParam(":userrole", $param_role, PDO::PARAM_STR);

            // Set parameters
            $param_names = $names;
            $param_email = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_gender = trim($_POST["gender"]);
            $param_mobile = trim($_POST["mobile"]);
            $param_role = trim($_POST["role"]);



            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo '<meta content="1;userlist.php" http-equiv="refresh" />';
            } else{
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
//                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}

?>
<!--**********************************
           Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Register New User</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Please fill this form to create an account.</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="names" class="form-control" value="<?php echo $names; ?>" autofocus>
                                <small class="help-block text-danger"><?php echo $names_err; ?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="username" class="form-control" value="<?php echo $username; ?>">
                                <small class="help-block text-danger"><?php echo $username_err; ?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark" >Gender</label>
                            <div class="col-sm-10">
                                <select name="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Mobile</label>
                            <div class="col-sm-10">
                                <input type="text" name="mobile" class="form-control"><?php echo $mobile; ?>
                                <small class="help-block text-danger"><?php echo $mobile_err;?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Role</label>
                            <div class="col-sm-10">
                                <select name="role" class="form-control">
                                    <option value="1">Admin</option>
                                    <option value="2">Doctor</option>
                                    <option value="3">Receptionist</option>
                                    <option value="4">Pharmacist</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                                <small class="help-block text-danger"><?php echo $password_err; ?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                <small class="help-block text-danger"><?php echo $confirm_password_err; ?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <input type="reset" class="btn btn-default" value="Reset">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!--**********************************
      Content body end
  ***********************************-->
<?php
include 'footer.php';
?>
