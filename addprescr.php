<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';

// Define variables and initialize with empty values
$patientname = $patientsMedicalHist = $prescription = "";
$patientname_err = $patientsMedicalHist_err = $prescription_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $patientsMedicalHist = trim($_POST["patientsMedicalHist"]);
    // Validate username
    if(empty(trim($_POST["patientsMedicalHist"]))){
        $patientsMedicalHist = "Please enter patients Medical History.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id,patient FROM prescription WHERE patient = :patientname";
        //SELECT `drug`, `stockqty`, `stockedDate`, `prescription` FROM `pharmacy` WHERE 1

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":patientname", $param_patientname, PDO::PARAM_STR);

            // Set parameters
            $param_patientname = trim($_POST["patientname"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    //echo "Oops! Something went wrong. Please try again later.";
                } else{
                    //$stockqty = trim($_POST["patientsMedicalHist"]);
                }
            } else{
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
//                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate description
    if(empty(trim($_POST["prescription"]))){
        $prescription_err = "Please provide the expiry Date.";
    } else{
        $prescription = trim($_POST["prescription"]);
    }
    $patientname = trim($_POST["patientname"]);

    // Check input errors before inserting in database
    if(empty($patientname_err) && empty($descr_err)){
        //SELECT `id`, `patient`, `dateofpres`, `prescription`, `patientsMedicalHist` FROM `prescription` WHERE 1
        $sql = "INSERT INTO prescription(patient, dateofpres,prescription, patientsMedicalHist) VALUES (:patient, :dateofpres,:prescription, :patientsMedicalHist)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":patient", $param_patient, PDO::PARAM_STR);
            $stmt->bindParam(":dateofpres", $param_dateofpres);
            $stmt->bindParam(":patientsMedicalHist", $param_patientsMedicalHist);
            $stmt->bindParam(":prescription", $param_prescription);

            // Set parameters

            $param_patient = $patientname;
            $param_dateofpres =  date("Y-m-d");
            $param_patientsMedicalHist =$patientsMedicalHist;
            $param_prescription = $prescription;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo '<meta content="1;dashboard.php" http-equiv="refresh" />';
            } else{
                echo '<script>alert("Something went wrong. Please try again later.")</script>';
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
                    <h4>Patients Prescription </h4>
                </div>
            </div>
        </div>

        <div class="card">

            <div class="card-body">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="#my-posts" data-toggle="tab" class="nav-link active show">New Prescription</a>
                                        </li>
                                        <li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link">Record</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="my-posts" class="tab-pane fade active show">
                                            <div class="my-post-content pt-3">
                                                <div class="basic-form">
                                                    <h6 class="mb-4">Please fill this form to capture prescription details.</h6>
                                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                                            <label class="col-sm-2 col-form-label text-dark">Patient Name</label>
                                                            <div class="col-sm-10">
                                                                <select name="patientname" id="patientname" class="form-control" autofocus required>
                                                                    <?php
                                                                    //SELECT `id`, `patientname`, `gender`, `dob`, `mobile`, `address` FROM `patient` WHERE 1
                                                                    $query = "SELECT * FROM  patient";
                                                                    $stmt = $pdo->query($query );
                                                                    foreach ($stmt as $row) {
                                                                        echo "<option value='{$row['id']}'>{$row['patientname']}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row <?php echo (!empty($patientsMedicalHist)) ? 'has-error' : ''; ?>">
                                                            <label class="col-sm-2 col-form-label text-dark">Patients Medical History</label>
                                                            <div class="col-sm-10">
                                                                <textarea type="text" name="patientsMedicalHist" class="form-control" value="<?php echo $patientsMedicalHist; ?>" required></textarea>
                                                                <small class="help-block text-danger"><?php echo $patientsMedicalHist; ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row <?php echo (!empty($prescription_err)) ? 'has-error' : ''; ?>">
                                                            <label class="col-sm-2 col-form-label text-dark">Prescription Details</label>
                                                            <div class="col-sm-10">
                                                                <textarea type="text" name="prescription" class="form-control" value="<?php echo $prescription; ?>" required></textarea>
                                                                <small class="help-block text-danger"><?php echo $prescription_err; ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-10">
                                                                <?php
                                                                if ($_SESSION["userrole"]!=2){
                                                                    ?>
                                                                    <input type="submit" class="btn btn-primary" value="Prescribe" disabled>
                                                                    <input type="reset" class="btn btn-default" value="Reset" disabled>
                                                                <?php
                                                                }else{
                                                                    ?>
                                                                    <input type="submit" class="btn btn-primary" value="Prescribe">
                                                                    <input type="reset" class="btn btn-default" value="Reset">
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="about-me" class="tab-pane fade">
                                            <div class="my-about-content pt-3">
                                                <div class="row card mx-0">
                                                    <div class="card-body">
                                                        <div class="table-responsive-sm table-sm">
                                                            <table id="example" class="display" >
                                                                <thead>
                                                                <tr>
                                                                    <th>Patient ID</th>
                                                                    <th>Name</th>
                                                                    <th>Address</th>
                                                                    <th>DOB</th>
                                                                    <th>Gender</th>
                                                                    <th>Medical History</th>
                                                                    <th>Prescription</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="text-dark">
                                                                <?php
                                                                $sql = "SELECT patient.*, prescription.* FROM patient inner join prescription on patient.id=prescription.patient;";
                                                                if($result = $pdo->query($sql)){
                                                                    if($result->rowCount() > 0){
                                                                        while($row = $result->fetch()){
                                                                            ?>
                                                                            <tr>
                                                                                <td><?=$row['patient']?></td>
                                                                                <td><?=$row['patientname']?></td>
                                                                                <td><?=$row['address']?></td>
                                                                                <td><?=$row['dob']?></td>
                                                                                <td><?=$row['gender']?></td>
                                                                                <td><?=$row['patientsMedicalHist']?></td>
                                                                                <td><?=$row['prescription']?></td>
                                                                                <td>
                                                                            <?php
                                                                            if ($_SESSION["userrole"]!=2){
                                                                                ?>
                                                                                    <a href="printPrescription.php?id=<?=$row['id']?>" target="_blank" title='Print Record' class="btn btn-secondary btn-sm disabled" ><span class='icon-printer'></span></a>
                                                                                <?php
                                                                            }else{
                                                                                ?>
                                                                                <a href="printPrescription.php?id=<?=$row['id']?>" target="_blank" title='Print Record' class="btn btn-secondary btn-sm" ><span class='icon-printer'></span></a>
                                                                                <?php
                                                                            }
                                                                                ?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
