<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    // Prepare a select statement
    $sql = "SELECT s.id as id, names, email, password, gender, mobile, image, userrole, isActive,r.id as roleID, role, descr FROM user s JOIN role r on s.userrole=r.id  WHERE s.id = :id";

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
                $name = $row["names"];
                $address = $row["email"];
                $role = $row['role'];
                $gender = $row['gender'];
                $mobile = $row['mobile'];
                $image = $row['image'];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                echo '<script>alert("Invalid Request.")</script>';
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
    // URL doesn't contain id parameter. Redirect to error page
    echo '<script>alert("Invalid Request.")</script>';
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
                    <?php
                    if ($_SESSION['id']==1){
                        ?>
                        <a href="userlist.php" class="btn btn-primary btn-sm"><span class='icon-arrow-left mx-2'></span>Back</a>
                        <?php
                    }
                    ?>
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
                                    <img src="
                                    <?php
                                    if ($image!=null){
                                        echo "upload/".$image;
                                    }else{
                                        echo "upload/ava.jpg";
                                    }
                                    ?>
" class="img-fluid rounded-circle" alt="">
                                </div>
                            </div>
                            <div class="profile-info">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8">
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-4 border-right-1 prf-col">
                                                <div class="profile-name">
                                                    <h4 class="text-primary"><?php echo ucwords($name); ?></h4>
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
                <div class="col-lg-12">
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
                                                        <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-9"><span><?php echo $address; ?> </span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Gender: <span class="pull-right">:</span></h5>
                                                    </div>
                                                    <div class="col-9"><span><?php echo ucwords($gender); ?> </span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-3">
                                                        <h5 class="f-w-500">Role <span class="pull-right">:</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-9"><span><?=$role;?></span>
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