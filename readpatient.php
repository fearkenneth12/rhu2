<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    // Prepare a select statement
    $sql = "SELECT * FROM patient p LEFT JOIN prescription ps ON p.id= ps.patient WHERE p.id = :id";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

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
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
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
                        <h4>Profile Information</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Patient ID: <b class="text-danger"><?php
                                    if (empty($row["patient"])){
                                        echo '<span class="badge badge-info">No ID</span>';
                                    }else {
                                        echo $row["patient"];
                                    }?></b></a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile">
                        <div class="profile-head">
                            <div class="photo-content">
                                <div class="cover-photo"></div>
                                <div class="profile-photo">
                                    <img src="upload/ava.jpg" class="img-fluid rounded-circle" alt="">
                                </div>
                            </div>
                            <div class="profile-info">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8">
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-4 border-right-1 prf-col">
                                                <div class="profile-name">
                                                    <h4 class="text-primary"><?php echo ucwords($name); ?></h4>
                                                    <p>Patient ID:  <b class="text-danger">
                                                            <?php
                                                            if (empty($row["patient"])){
                                                                echo '<span class="badge badge-info">No ID</span>';
                                                            }else {
                                                                echo $row["patient"];
                                                            }?>
                                                        </b></p>
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
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (empty($row["prescription"])){
                                echo ' <div class="alert alert-info text-center">Patient has no prescriptions yet.</div>';
                            }else{
                                ?>
                            <div class="profile-blog pt-3 border-bottom-1 pb-1">
                                <h5 class="text-primary d-inline">Prescription</h5>
                                <hr>
                                <h6>Prescription Details</h6>
                                <p><?php echo ucwords($row["prescription"]); ?></p>
                            </div>
                            <div class="profile-interest mt-4 pb-2 border-bottom-1">
                                <h5 class="text-primary d-inline">Medical History</h5>
                                <hr>
                                <p><?php echo ucwords($row["patientsMedicalHist"]); ?></p>
                            </div>
                                    <?php
                                    }
                                    ?>
                            <a href="patients.php" class="btn btn-primary"><i class="icon-arrow-left mx-2"></i>Back</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link active show">About Me</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="about-me" class="tab-pane fade active show">
                                            <div class="profile-personal-info pt-5 border-bottom-1 pb-5">
                                                <h4 class="text-primary mb-4">Personal Information</h4>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-9"><span><?php echo ucwords($name); ?></span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Address <span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-9"><span>e<?php echo $address; ?> </span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Date of Birth: <span class="pull-right">:</span></h5>
                                                    </div>
                                                    <div class="col-9"><span><?php echo $dob; ?> </span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Age <span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-9"><span>
                                                            <?php $dob=$row['dob'];
                                                            function ageCalculator($dob){
                                                                if(!empty($dob) && $dob != '0000-00-00'){
                                                                    $birthdate = new DateTime($dob);
                                                                    $today   = new DateTime('today');
                                                                    $age = $birthdate->diff($today)->y;
                                                                    return $age;

                                                                }else{
                                                                    return 0;
                                                                }
                                                            }
                                                            if(ageCalculator($dob)>0){
                                                                echo ageCalculator($dob).' Years old ';
                                                            }else{
                                                                echo '<i style="color:red;"> ---- </i>';
                                                            } ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Phone Number <span class="pull-right">:</span></h5>
                                                    </div>
                                                    <div class="col-9"><span><?php echo $mobile; ?> </span>
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
<?php include 'footer.php';?>