<?php
// Include config file
include 'header.php';
include  'sidebar.php';
// Process delete operation after confirmation
//if(isset($_POST["btnDelete"])){
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";

    // Prepare a delete statement
    $sql = "DELETE FROM patient WHERE id = :id";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            echo '<script>window.open("patients.php","_self")</script>';
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        echo '<script>alert("Invalid Request.");window.open("patients.php","_self")</script>';
        exit();
    }
}
//}
?>
    <div class="content-body">
        <div class="container-fluid align-content-center">

            <div class="col-xl-4 col-xxl-6 col-lg-12 col-sm-6 my-auto mx-auto mt-3" >
                <div class="card text-center">
                    <div class="card-header">
                        <h5 class="card-title">Delete Record</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p class="card-text text-dark">Are you sure you want to delete this record?</p>
                        <div class="flex">
                            <button type="submit" name="btnDelete"class="btn btn-danger">Yes</button>
                            <a href="patients.php" class="btn btn-primary">No</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div
<?php include 'footer.php';?>