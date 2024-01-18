<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}


// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if(isset($_POST["btnUpdatePict"])){

    $name = $_FILES['file']['name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){
        // Prepare an update statement
        $sql = "UPDATE user SET image = :image WHERE id = :id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":image", $param_image, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_image = $name;
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Upload file
                move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
                $_SESSION["image"]=$name;

                echo '<script>window.open("dashboard.php","_self")</script>';
                // image updated successfully.Redirect to dashboard page
//                header("location: dashboard.php");
                exit();
            } else{
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
//                echo "Oops! Something went wrong. Please try again later.";
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
                    <h4>Update Picture</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Select picture to update</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group row <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label class="col-sm-2 col-form-label text-dark">Upload</label>
                            <div class="col-sm-10">
                                <input type="file" name="file" class="form-control" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="submit" name="btnUpdatePict" class="btn btn-primary" value="Submit">
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
