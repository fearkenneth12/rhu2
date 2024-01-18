<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    // Prepare a select statement
    $sql = "SELECT * FROM drug d JOIN category c on d.drugCategory = c.catID WHERE d.drugID = :id";

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
                $drugID = $row["drugID"];
                $drugName = $row["drugName"];
                $catName = $row["catName"];
                $description = $row['description'];
                $drugCategory = $row['drugCategory'];
            } else{
                echo '<script>alert("Invalid Request.")</script>';
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    echo '<script>alert("Invalid Request.")</script>';
    // URL doesn't contain id parameter. Redirect to error page
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
                    <h4>Drug ID: <b class="text-danger"><?php echo $row["drugID"]; ?></b></h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Information</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                        <div class="form-group row ">
                            <label class="col-sm-2 col-form-label text-dark">Drug Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="drugname" class="form-control" value="<?php echo $drugName; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-2 col-form-label text-dark">Category</label>
                            <div class="col-sm-10">
                                <input type="text" name="drugname" class="form-control" value="<?php echo $catName; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-dark" >Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" name="descr" class="form-control" readonly><?php echo $description; ?> </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <a href="drugslist.php" class="btn btn-primary" ><span class="icon-arrow-left mx-2"></span>Back</a>
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
