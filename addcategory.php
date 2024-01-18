<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';

// Define variables and initialize with empty values
$catname = $descr = "";
$catname_err = $descr_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["catname"]))){
        $catname_err = "Please enter category name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT catID FROM category WHERE catName = :catname";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":catname", $param_catname, PDO::PARAM_STR);

            // Set parameters
            $param_catname = trim($_POST["catname"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $catnamee_err = "This category name is already exists.";
                } else{
                    $catname = trim($_POST["catname"]);
                }
            } else{
                echo '<script>alert("Something went wrong. Please try again later.")</script>';
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate cat name
    if(empty(trim($_POST["catname"]))){
        $catname_err = "Please enter a category name.";
    } else{
        $catname = trim($_POST["catname"]);
    }

    // Validate description
    if(empty(trim($_POST["descr"]))){
        $descr_err = "Please provide the category description.";
    } else{
        $descr = trim($_POST["descr"]);
    }

    // Check input errors before inserting in database
    if(empty($catname_err) && empty($descr_err)){

        // Prepare an insert statement
        //INSERT INTO `drug`(`drugID`, `drugName`, `catCategory`, `description`) VALUES ([value-1],[value-2],[value-3],[value-4])
        $sql = "INSERT INTO category(catName, descr) VALUES (:catName, :description)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":catName", $param_catName, PDO::PARAM_STR);
            $stmt->bindParam(":description", $param_description, PDO::PARAM_STR);

            // Set parameters
            $param_catName = $catname;
            $param_description = $descr;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo '<script>window.open("catslist.php","_self")</script>';
//                echo '<meta content="1;catslist.php" http-equiv="refresh" />';
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
                    <h4>Drug Category</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Please fill this form to capture drug category details.</h4>
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
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-primary" value="Add Category">
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
