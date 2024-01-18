<?php
include 'header.php';
include  'sidebar.php';

require_once 'config.php';

// Define variables and initialize with empty values
$name = $address =$dob=$mobile= $gender = "";
$name_err = $address_err = $dob_err = $mobile_err = $gender_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";
    } else{
        $address = $input_address;
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

    // Validate salary
    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $gender_err = "Please select gender.";
    }
    /* elseif(!ctype_digit($input_gender)){
        $gender_err = "Please enter a positive integer value.";
    } */
    else{
        $gender = $input_gender;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // //SELECT `id`, `patientname`, `gender`, `dob`, `mobile`, `address` FROM `patient` WHERE 1

        // Prepare an insert statement
        $sql = "INSERT INTO patient (id,patientname, address,dob, mobile, gender) VALUES (:id,:name, :address,:dob, :mobile, :gender)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":address", $param_address);
            $stmt->bindParam(":dob", $param_dob);
            $stmt->bindParam(":mobile", $param_mobile);
            $stmt->bindParam(":gender", $param_gender);

            // Set parameters
            $param_id = trim($_POST["patientID"]);
            $param_name = $name;
            $param_address = $address;
            $param_dob = $dob;
            $param_mobile = $mobile;
            $param_gender = $gender;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                echo '<script>window.open("patients.php","_self")</script>';
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
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

        <!--            user header-->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Register new Patient</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Please fill this form and submit to add patient's record to the database.</h4>
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
                                <input name="mobile" class="form-control"><?php echo $mobile; ?>
                                <small class="help-block text-danger"><?php echo $mobile_err;?></small>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-2 col-form-label text-dark">Gender</label>
                            <div class="col-sm-10">
                                <select name="gender" class="form-control">
                                    <option >Choose Gender....</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <small class="help-block text-danger"><?php echo $gender_err;?></small>
                            </div>
                        </div>
                        <input type="hidden" name="patientID" class="form-control" value="<?php echo mt_rand(); ?>">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <button type="reset" class="btn btn-danger">Cancel</button>
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
