<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';

$drugname = $drugQty = $expiryDate = "";
$drugname_err = $drugQty_err = $expiryDate_err = "";
$stockqty = 0;
$isNewEntry = true;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $stockqty = trim($_POST["drugQty"]);
    // Validate username
    if(empty(trim($_POST["drugQty"]))){
        $drugQty_err = "Please enter drug Quantity.";
    } else{
        // Prepare a select statement
        $sql = "SELECT stockqty FROM pharmacy WHERE drug = :drugname";
        //SELECT `drug`, `stockqty`, `stockedDate`, `expiryDate` FROM `pharmacy` WHERE 1

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":drugname", $param_drugname, PDO::PARAM_STR);

            // Set parameters
            $param_drugname = trim($_POST["drugname"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    //$stmt = $pdo->query($query );
                    $row = $stmt->fetch();
                    $stockqty += $row['stockqty'];
                    $isNewEntry = false;
                } else{
                    $isNewEntry = true;
                    //$stockqty = trim($_POST["drugQty"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate description
    if(empty(trim($_POST["expiryDate"]))){
        $expiryDate_err = "Please provide the expiry Date.";
    } else{
        $expiryDate = trim($_POST["expiryDate"]);
    }
    $drugname = trim($_POST["drugname"]);

    // Check input errors before inserting in database
    if(empty($drugname_err) && empty($descr_err)){

        $sql = "";
        if($isNewEntry){
            $sql = "INSERT INTO pharmacy(drug, stockqty,stockedDate, expiryDate) VALUES (:drug, :stockqty,:stockedDate, :expiryDate)";
        }else{
            $sql = "UPDATE pharmacy SET stockqty=:stockqty, stockedDate=:stockedDate, expiryDate=:expiryDate WHERE drug=:drug";
        }
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":drug", $param_drugID, PDO::PARAM_INT);
            $stmt->bindParam(":stockqty", $param_stockqty, PDO::PARAM_STR);
            $stmt->bindParam(":stockedDate", $param_stockedDate);
            $stmt->bindParam(":expiryDate", $param_expiryDate);

            // Set parameters

            $param_drugID = $drugname;
            $param_stockqty = $stockqty;
            $param_stockedDate = date("Y-m-d");
            $param_expiryDate = date($expiryDate);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo '<meta content="1;drugstocklist.php" http-equiv="refresh" />';
            } else{
                echo "Something went wrong. Please try again later.";
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
                    <h4>Capture Drug Details</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Please fill this form to capture drug details.</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group row <?php echo (!empty($drugname_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Drug</label>
                            <div class="col-sm-10">
                                <select name="drugname" id="drugname" class="form-control">
                                    <?php
                                    $query = "SELECT * FROM  drug";
                                    $stmt = $pdo->query($query );
                                    foreach ($stmt as $row) {
                                        echo "<option value='{$row['drugID']}'>{$row['drugName']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($drugQty_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Quantity</label>
                            <div class="col-sm-10">
                                <input type="number" name="drugQty" class="form-control" value="<?php echo $drugQty; ?>">
                                <small class="help-block text-danger"><?php echo $drugQty_err; ?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($expiryDate_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark" >Expiry Date</label>
                            <div class="col-sm-10">
                                <input type="date" name="expiryDate" class="form-control" value="<?php echo $expiryDate; ?>">
                                <small class="help-block text-danger"><?php echo $expiryDate_err; ?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Stock">
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
