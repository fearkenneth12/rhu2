<?php
include "config.php";
session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
$level = $_SESSION["userrole"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Rural Health Unit Stock Management System </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/rural.jpg">
    <link rel="stylesheet" href="vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Datatable -->
    <link href="./vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="./css/style.css" rel="stylesheet">


</head>

<body>

<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <a href="dashboard.php" class="brand-logo">
            <img class="logo-abbr" src="images/rural.jpg" alt="" style="border-radius: 50%; width: 100%">
            <h6 class="text-white align-content-between mx-2 my-3 brand-title">
                <?php
                switch ($level){
                    case 1:
                        echo "Admin";
                        break;
                    case 2:
                        echo "Doctor";
                        break;
                    case 3:
                        echo "Receptionist";
                        break;
                    case 4:
                        echo "Pharmacist";
                        break;
                    default: echo "Undefined";
                }
                ?>
            </h6>
            <img class="logo-compact" src="images/rural.jpg" alt="" style="border-radius: 50%; width: 100%">
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <h5 class="font-weight-bold">Rural Health Unit Stock Management System</h5>
                    </div>
                    <ul class="navbar-nav header-right">
                        <li class="nav-item ">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <h6 class="my-auto">Hi, <b class="text-success"><?php echo htmlspecialchars(strtoupper($_SESSION["names"])); ?></b>. Welcome .</h6>
                            </a>
                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <a href="readuser.php?id=<?=$_SESSION["id"]?>" title="Show Profile">
                                <img src="
                                <?php
                                if ($_SESSION["image"]!=null){
                                    echo "upload/".$_SESSION["image"];
                                }
                                else{
                                    echo "upload/ava.jpg";
                                }
                                ?>"  class="img-fluid rounded-circle"></a>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->
