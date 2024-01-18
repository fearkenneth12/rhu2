<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';

// Define variables and initialize with empty values
$catname = $descr = "";
$catname_err = $descr_err  = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_name = trim($_POST["catname"]);
    if(empty($input_name)){
        $catname_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $catname_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate address address
    $input_descr = trim($_POST["descr"]);
    if(empty($input_descr)){
        $descr_err = "Please enter an descr.";
    } else{
        $descr = $input_descr;
    }

    // Check input errors before inserting in database
    if(empty($catname_err) && empty($descr_err)){
        // Prepare an update statement
        //UPDATE `category` SET `catID`=[value-1],`catName`=[value-2],`descr`=[value-3] WHERE 1
        $sql = "UPDATE category SET catName=:catName, descr=:descr WHERE catID=:id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":catName", $param_name);
            $stmt->bindParam(":descr", $param_descr);
            $stmt->bindParam(":id", $param_id);

            // Set parameters
            $param_name = $name;
            $param_descr = $descr;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
//                header("location: catslist.php");
                echo '<script>window.open("catslist.php","_self")</script>';
                exit();
            } else{
                echo '<script>alert("Something went wrong. Please try again later.")</script>';
//                echo "Something went wrong. Please try again later.";
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
        $sql = "SELECT * FROM category WHERE catID = :id";
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
                    $catName = $row["catName"];
                    $descr = $row["descr"];
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
                    <h4>Update Category Details</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Please edit the input values and submit to update the record.</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group row <?php echo (!empty($catname_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Category Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="catname" class="form-control" value="<?php echo $catname; ?>" autofocus>
                                <small class="help-block text-danger"><?php echo $catname_err; ?></small>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($descr_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark" >Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" name="descr" class="form-control" value="<?php echo $descr; ?>"></textarea>
                                <small class="help-block text-danger"><?php echo $descr_err; ?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Update">
                                <a href="catslist.php" class="btn btn-default" >Cancel</a>
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
