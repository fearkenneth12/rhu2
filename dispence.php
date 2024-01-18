<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';


// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = $mobile_err = $dob_err = "";


$sqlx = "SELECT * FROM drug d JOIN category c on d.drugCategory = c.catID JOIN pharmacy p ON d.drugID=p.drug WHERE p.stockqty>0";
$resultx = $pdo->query($sqlx);

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    try{
        // Get hidden input value
        $id = $_POST["id"];
        $patientID = trim($_POST['patientID']);
        $prescrID = trim($_POST['prescrID']);
        //$drugIDS = array();
        if(!empty($_POST['chk'])) {
            $chk = $_POST['chk'];
            $oldQty = $_POST['oldQty'];
            $currStkQty = $_POST['presQty'];
            $patientID = trim($_POST['patientID']);
            $prescrID = trim($_POST['prescrID']);
            $newStkQty = 0;


            $sql = "INSERT INTO dispense(patient, drug, prescrRef,qtyGiven, dateofDisp) VALUES (:patient, :XDrug, :prescrRef,:qtyGiven, :dateofDisp)";
            $stmt = $pdo->prepare($sql);
            $sql2 = "UPDATE pharmacy SET stockqty=:newstockqty WHERE drug=:XDrug";
            $stmt2 = $pdo->prepare($sql2);

            // $sp=0;
            foreach($chk as $sp => $v){
                $oldQty[$sp] =  $oldQty[$sp] > 0 ? $oldQty[$sp] : 0;
                $currStkQty[$sp] =  $currStkQty[$sp] > 0 ? $currStkQty[$sp] : 0;
                $data[] = ["DrugID" => $chk[$sp],  "oldQty" => $oldQty[$sp], "presQty" => $currStkQty[$sp]];
                //for each Loop to display checkbox items.



                // Set parameters
                $param_idDrug = $chk[$sp];
                $param_patient = $patientID;
                $param_prescrRef =  $prescrID;
                $param_dateofDisp = date("Y-m-d");
                // echo $oldQty[$sp] ." - ". $currStkQty[$sp];
                if($oldQty[$sp] == $currStkQty[$sp]){
                    $param_newstockqty = (int)($oldQty[$sp] - $currStkQty[$sp]);
                    $param_qtyGiven =  $oldQty[$sp];
                    //$param_qtyGiven =  $currStkQty[$sp];
                }else if($oldQty[$sp] < $currStkQty[$sp]){
                    $param_qtyGiven =  0;
                    $param_newstockqty = (int)($oldQty[$sp]);
                }else if($oldQty[$sp] > $currStkQty[$sp]){
                    $param_qtyGiven =  $currStkQty[$sp];
                    $param_newstockqty = (int)($oldQty[$sp] - $currStkQty[$sp]);
                }
                else{
                    $param_newstockqty = 0;
                    $param_qtyGiven =  0;
                }

                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":XDrug", $param_idDrug);
                $stmt->bindParam(":patient", $param_patient);
                $stmt->bindParam(":prescrRef", $param_prescrRef);
                $stmt->bindParam(":qtyGiven", $param_qtyGiven);
                $stmt->bindParam(":dateofDisp", $param_dateofDisp);

                $stmt2->bindParam(":XDrug", $param_idDrug);
                $stmt2->bindParam(":newstockqty", $param_newstockqty);
                // echo $sp;
                // echo "<pre>";
                // var_dump($_POST);
                // echo "</pre>";
                // echo  $oldQty[$sp] ." - ". $currStkQty[$sp] ;
                // echo  $param_newstockqty ;
                // echo "UPDATE pharmacy SET stockqty=$param_newstockqty WHERE drug=$param_idDrug";

                $stmt->execute();
                $stmt2->execute();
                // $sp++;
            }
            echo'<meta content="1;dispence.php?id='.$_POST["id"].'" http-equiv="refresh" />';
            exit;

        }
    }catch(Exception $e){
        //An exception has occured, which means that one of our database queries failed. Print out the error message.
        echo $e->getMessage();

    }
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement

        $sql = "SELECT ps.id as prescrID, patientname,p.id as id,gender,dob,mobile,address,dateofpres,prescription,patientsMedicalHist FROM patient p JOIN prescription ps ON p.id=ps.patient WHERE p.id = :id";
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
                    $patientID = $row["id"];
                    $name = $row["patientname"];
                    $address = $row["address"];
                    $dob = $row['dob'];
                    $gender = $row['gender'];
                    $mobile = $row['mobile'];
                    $prescrID = $row['prescrID'];
                    $prescription = $row['prescription'];
                    $patientsMedicalHist = $row['patientsMedicalHist'];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    echo '<script>alert("Invalid Request.")</script>';
//                    header("location: error.php");
                    exit();
                }

            } else{
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
//                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);

        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        echo '<script>alert("Invalid Request.")</script>';
//        header("location: error.php");
        exit();
    }
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
                    <h4>Capture Patients Dispensed Drug Details</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <a href="dispensedrug.php" class="btn btn-primary btn-sm"><span class='icon-arrow-left mx-2'></span>Back</a>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <input type="hidden" name="patientID" class="form-control" value="<?php echo $patientID; ?>">
                        <input type="hidden" name="prescrID" class="form-control" value="<?php echo $prescrID; ?>">

                        <div class="profile-blog border-bottom-1 pb-1">
                            <div class="profile-personal-info pt-2 border-bottom-1 pb-5">
                                <h4 class="text-primary mb-4">Personal Information</h4>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                        </h5>
                                    </div>
                                    <div class="col-8"><span><?php echo ucwords($name); ?></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <h5 class="f-w-500">Address <span class="pull-right">:</span>
                                        </h5>
                                    </div>
                                    <div class="col-8"><span><?php echo $address; ?> </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <h5 class="f-w-500">DoB <span class="pull-right">:</span></h5>
                                    </div>
                                    <div class="col-8"><span><?php echo $dob; ?> </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <h5 class="f-w-500">Age <span class="pull-right">:</span>
                                        </h5>
                                    </div>
                                    <div class="col-8"><span>
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
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <h5 class="f-w-500">Mobile <span class="pull-right">:</span></h5>
                                    </div>
                                    <div class="col-8"><span><?php echo $mobile; ?> </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <h5 class="f-w-500">Gender <span class="pull-right">:</span></h5>
                                    </div>
                                    <div class="col-8"><span><?php echo $gender; ?> </span>
                                    </div>
                                </div>
                                <hr>
                                <?php
                                if (empty($row["prescription"])){
                                    echo ' <div class="alert alert-info text-center">Patient has no prescriptions yet.</div>';
                                }else{
                                    ?>
                                    <div class="profile-blog pt-3 border-bottom-1 pb-1">
                                        <h5 class="text-primary d-inline">Prescription</h5>
                                        <hr>
                                        <h6>Doctor Prescription</h6>
                                        <p><?php echo ucwords($row["prescription"]); ?></p>
                                    </div>
                                    <div class="profile-interest mt-4 pb-2 border-bottom-1">
                                        <h5 class="text-primary d-inline">Patient Medical History</h5>
                                        <hr>
                                        <p><?php echo ucwords($row["patientsMedicalHist"]); ?></p>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link active show">Selection</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="about-me" class="tab-pane fade active show">
                                        <div class="profile-personal-info pt-5 border-bottom-1 pb-5">
                                            <?php
                                            if($resultx){
                                                if($resultx->rowCount() > 0){
                                            ?>
                                                    <div class="table-responsive-sm">
                                                        <table id="example" class="display" >
                                                            <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Drug ID</th>
                                                                <th>Name</th>
                                                                <th>Category</th>
                                                                <th>Instock</th>
                                                                <th>Prescribed</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="text-dark">
                                                            <?php
                                                            $ix=1;
                                                            while($rowx = $resultx->fetch()){
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="chk[<?php echo $ix ?>]" value="<?php echo $rowx['drugID']; ?>">
                                                                    </td>
                                                                    <td><?php echo $rowx['drugID']; ?> </td>
                                                                    <td><?php echo $rowx['drugName']; ?></td>
                                                                    <td><?php echo $rowx['catName']; ?></td>
                                                                    <td> <?php echo $rowx['stockqty']; ?></td>
                                                                    <td>
                                                                        <input type="text" name="presQty[<?php echo $ix ?>]" max="<?php echo $rowx['stockqty']; ?>" value=""/>
                                                                        <input type="hidden" name="oldQty[<?php echo $ix ?>]" value="<?php echo $rowx['stockqty']; ?>"/>
                                                                        <input type="hidden" name="newStockQty[<?php echo $ix ?>]" value=""/>
                                                                    </td>

                                                                </tr>
                                                                <?php
                                                                $ix++;
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            <?php
                                                }  // Free result set
                                                unset($resultx);
                                                ?>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                        <input type="submit" class="btn btn-primary" value="Dispense">
                                        <a href="dispensedrug.php" class="btn btn-default">Cancel</a>
                                            <?php
                                            }else{
                                                echo '<div class="alert alert-info text-center">No drugs to dispense, please restock.</div>';
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    </form>
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
