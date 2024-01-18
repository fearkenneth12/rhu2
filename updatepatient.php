<?php
include 'header.php';
include 'sidebar.php';

// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = $mobile_err = $dob_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";
    } else{
        $address = $input_address;
    }


    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $gender_err = "Please enter the salary amount.";
    }
    /* elseif(!ctype_digit($input_gender)){
        $gender_err = "Please enter a positive integer value.";
    } */
    else{
        $gender = $input_gender;
    }

    $input_dob = trim($_POST['dob']);
    if(empty($input_dob)){
        $dob_err = "Please enter an address.";
    } else{
        $dob = $input_dob;
    }

    $input_mobile = trim($_POST['mobile']);
    if(empty($input_mobile)){
        $mobile_err = "Please enter an mobile number.";
    } else{
        $mobile = $input_mobile;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($gender_err)){
        // Prepare an update statement
        $sql = "UPDATE patient SET patientname=:name, address=:address, gender=:gender, dob=:dob, mobile=:mobile WHERE id=:id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":address", $param_address);
            $stmt->bindParam(":dob", $param_dob);
            $stmt->bindParam(":mobile", $param_mobile);
            $stmt->bindParam(":gender", $param_gender);
            $stmt->bindParam(":id", $param_id);

            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_gender = $gender;
            $param_mobile = $mobile;
            $param_dob = $dob;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                echo '<script>window.open("patients.php","_self")</script>';
                exit();
            } else{
                echo '<script>alert("Something went wrong. Please try again later.");window.open("patients.php","_self")</script>';
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM patient WHERE id = :id";
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
                    $name = $row["patientname"];
                    $address = $row["address"];
                    $dob = $row['dob'];
                    $gender = $row['gender'];
                    $mobile = $row['mobile'];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    echo '<script>alert("Invalid Request.");window.open("patients.php","_self")</script>';
                    exit();
                }

            } else{
                echo '<script>alert("Oops! Something went wrong. Please try again later.");window.open("patients.php","_self")</script>';
            }
        }

        // Close statement
        unset($stmt);

        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        echo '<script>alert("Invalid Request.");window.open("patients.php","_self")</script>';
        exit();
    }
}
?>
<div class="content-body">
    <div class="container-fluid">

        <!--            user header-->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Update Patients Details</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Please edit the input values and submit to update the record./h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group row <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" autofocus>
                                <small class="help-block text-danger"><?php echo $name_err;?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Address</label>
                            <div class="col-sm-10">
                                <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                                <small class="help-block text-danger"><?php echo $address_err;?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($dob_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark" >DOB</label>
                            <div class="col-sm-10">
                                <input type="date" name="dob" class="form-control datepicker" id='start_dt' value="<?php echo $dob; ?>">
                                <small class="help-block text-danger"><?php echo $dob_err;?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($mobile_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Mobile</label>
                            <div class="col-sm-10">
                                <input name="mobile" class="form-control" value="<?php echo $mobile; ?>">
                                <small class="help-block text-danger"><?php echo $mobile_err;?></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-2 col-form-label text-dark">Gender</label>
                            <div class="col-sm-10">
                                <select name="gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Update">
                                <a href="patients.php" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
include 'footer.php';
?>