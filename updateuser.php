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
        $sql = "SELECT id FROM user WHERE email = :username and id != {$_GET['id']}";

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
    if(!empty($_POST["password"]) || !empty($_POST["confirm_password"])){
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
        if(!empty($password)){
            $sql = "UPDATE user set names=:names,
                                         email=:email,
                                         password=:password,
                                         gender=:gender,
                                         mobile=:mobile,
                                         userrole=:userrole 
                                        where id = {$_GET['id']} ";
        }else{
            $sql = "UPDATE user set names=:names,
                                         email=:email,
                                         gender=:gender,
                                         mobile=:mobile,
                                         userrole=:userrole 
                                        where id = {$_GET['id']} ";
        }

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":names", $param_names, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            if(!empty($password))
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
                echo '<meta content="1" http-equiv="refresh" />';
            } else{
                echo '<script>alert("Something went wrong. Please try again later.")</script>';
//                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }


}
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);

    // Prepare a select statement
    $sql = "SELECT * FROM user WHERE id = :id";
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $names = $row["names"];
                $username = $row["email"];
                $gender = $row["gender"];
                $mobile = $row["mobile"];
                $userrole = $row["userrole"];
            } else{
                // URL doesn't contain valid id. Redirect to error page
                echo '<script>alert("Invalid Request.")</script>';
//                header("location: error.php");
                exit();
            }

        } else{
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
//            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
}  else{
    // URL doesn't contain id parameter. Redirect to error page
    echo '<script>alert("Invalid Request.");window.open("updateuser.php","_self")</script>';
//    header("location: error.php");
    exit();
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
                    <h4>Update Patients Details</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="userlist.php" class="btn btn-primary btn-sm"><span class='icon-arrow-left mx-2'></span>Back</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Please edit the input values and submit to update the record.</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="" method="post">
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
                                    <option >Choose Gender....</option>
                                    <option value="male" <?php echo $gender == 'male' ? 'selected' : '' ?>>Male</option>
                                    <option value="female" <?php echo $gender == 'female' ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Mobile</label>
                            <div class="col-sm-10">
                                <input type="text" name="mobile" class="form-control" value="<?php echo $mobile; ?>">
                                <small class="help-block text-danger"><?php echo $mobile_err;?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Role</label>
                            <div class="col-sm-10">
                                <select name="role" class="form-control">
                                    <option value="1" <?php echo $userrole ==1 ? 'selected' : '' ?>>Admin</option>
                                    <option value="2" <?php echo $userrole ==2 ? 'selected' : '' ?>>Doctor</option>
                                    <option value="3" <?php echo $userrole ==3 ? 'selected' : '' ?>>Receptionist</option>
                                    <option value="4" <?php echo $userrole ==4 ? 'selected' : '' ?>>Pharmacist</option>
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
