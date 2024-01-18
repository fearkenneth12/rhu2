
<!--**********************************
           Sidebar start
 ***********************************-->
<?php
$level = $_SESSION["userrole"];
if ($level===1){//admin
?>
    <div class="quixnav">
        <div class="quixnav-scroll">
            <ul class="metismenu" id="menu">
                <li><a  href="dashboard.php" aria-expanded="false"><i class="icon icon-home"></i><span class="nav-text">Home</span></a></li>
                <li class="nav-label">Patients</li>
                <li><a  href="addpatient.php" aria-expanded="false"><i class="icon-book-open"></i><span class="nav-text">New Admission</span></a></li>
                <li><a  href="patients.php" aria-expanded="false"><i class="icon-list"></i><span class="nav-text">View List</span></a></li>
                <li class="nav-label">Users</li>
                <li><a  href="adduser.php" aria-expanded="false"><i class="icon-user-follow"></i><span class="nav-text">New User</span></a></li>
                <li><a  href="userlist.php" aria-expanded="false"><i class="icon-list"></i><span class="nav-text">User List</span></a></li>
                <li><a  href="photoupdate.php" aria-expanded="false"><i class="icon-picture"></i><span class="nav-text">Update Profile Photo</span></a></li>
                <li><a  href="resetpassword.php" aria-expanded="false"><i class="icon-key"></i><span class="nav-text">Password Reset</span></a></li>
                <li class="nav-label">Doctor</li>
                <li><a  href="addprescr.php" aria-expanded="false"><i class="icon-link"></i><span class="nav-text">Prescription</span></a></li>
                <li><a  href="drugstocklist.php" aria-expanded="false"><i class="icon-list"></i><span class="nav-text">Stock List</span></a></li>
                <li><a  href="dispensedrug.php" aria-expanded="false"><i class="icon-link"></i><span class="nav-text">Dispense</span></a></li>
                <li class="nav-label">Pharmacy</li>
                <li><a  href="drugstocklist1.php" aria-expanded="false"><i class="icon-list"></i><span class="nav-text">Stock List</span></a></li>
                <li><a  href="dispensedrug1.php" aria-expanded="false"><i class="icon-link"></i><span class="nav-text">Dispense</span></a></li>
                <li class="nav-label">Medics</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-plug"></i><span class="nav-text">Drug</span></a>
                    <ul aria-expanded="false">
                        <li><a href="adddrugstock.php">Add Stock</a></li>
                        <li><a href="adddrug.php">New Drug</a></li>
                        <li><a href="drugslist.php">Drug List</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-plug"></i><span class="nav-text">Category</span></a>
                    <ul aria-expanded="false">
                        <li><a href="addcategory.php">New Category</a></li>
                        <li><a href="catslist.php">Category List</a></li>
                    </ul>
                </li>
                <li><a href="logout.php" aria-expanded="false"><i class="icon icon-lock"></i><span class="nav-text">Sign Out</span></a></li>
            </ul>
        </div>
    </div>
<?php
}elseif ($level===2){//Doctor
    ?>
    <div class="quixnav">
        <div class="quixnav-scroll">
            <ul class="metismenu" id="menu">
                <li><a  href="dashboard.php" aria-expanded="false"><i class="icon icon-home"></i><span class="nav-text">Home</span></a></li>
                <li class="nav-label">Users</li>
                <li><a  href="photoupdate.php" aria-expanded="false"><i class="icon-picture"></i><span class="nav-text">Update Profile Photo</span></a></li>
                <li><a  href="resetpassword.php" aria-expanded="false"><i class="icon-key"></i><span class="nav-text">Password Reset</span></a></li>
                <li class="nav-label">Doctor</li>
                <li><a  href="addprescr.php" aria-expanded="false"><i class="icon-link"></i><span class="nav-text">Prescription</span></a></li>
                <li><a  href="drugstocklist.php" aria-expanded="false"><i class="icon-list"></i><span class="nav-text">Stock List</span></a></li>
                <li><a  href="dispensedrug.php" aria-expanded="false"><i class="icon-link"></i><span class="nav-text">Dispense</span></a></li>
                <li><a href="logout.php" aria-expanded="false"><i class="icon icon-lock"></i><span class="nav-text">Sign Out</span></a></li>
            </ul>
        </div>
    </div>
<?php
}
elseif ($level===3){//Receptionist
?>
    <div class="quixnav">
        <div class="quixnav-scroll">
            <ul class="metismenu" id="menu">
                <li><a  href="dashboard.php" aria-expanded="false"><i class="icon icon-home"></i><span class="nav-text">Home</span></a></li>
                <li class="nav-label">Patients</li>
                <li><a  href="addpatient.php" aria-expanded="false"><i class="icon-book-open"></i><span class="nav-text">New Admission</span></a></li>
                <li><a  href="patients.php" aria-expanded="false"><i class="icon-list"></i><span class="nav-text">View List</span></a></li>
                <li class="nav-label">Users</li>
                <li><a  href="photoupdate.php" aria-expanded="false"><i class="icon-picture"></i><span class="nav-text">Update Profile Photo</span></a></li>
                <li><a  href="resetpassword.php" aria-expanded="false"><i class="icon-key"></i><span class="nav-text">Password Reset</span></a></li>
                <li><a href="logout.php" aria-expanded="false"><i class="icon icon-lock"></i><span class="nav-text">Sign Out</span></a></li>
            </ul>
        </div>
    </div>
<?php
}
elseif ($level===4){//Pharmacist
    ?>
    <div class="quixnav">
        <div class="quixnav-scroll">
            <ul class="metismenu" id="menu">
                <li><a  href="dashboard.php" aria-expanded="false"><i class="icon icon-home"></i><span class="nav-text">Home</span></a></li>
                <li class="nav-label">Users</li>
                <li><a  href="photoupdate.php" aria-expanded="false"><i class="icon-picture"></i><span class="nav-text">Update Profile Photo</span></a></li>
                <li><a  href="resetpassword.php" aria-expanded="false"><i class="icon-key"></i><span class="nav-text">Password Reset</span></a></li>
                <li class="nav-label">Doctor</li>
                <li><a  href="addprescr.php" aria-expanded="false"><i class="icon-link"></i><span class="nav-text">Prescription</span></a></li>
                <li class="nav-label">Pharmacy</li>
                <li><a  href="drugstocklist1.php" aria-expanded="false"><i class="icon-list"></i><span class="nav-text">Stock List</span></a></li>
                <li><a  href="dispensedrug1.php" aria-expanded="false"><i class="icon-link"></i><span class="nav-text">Dispense</span></a></li>
                <li class="nav-label">Medics</li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-plug"></i><span class="nav-text">Drug</span></a>
                    <ul aria-expanded="false">
                        <li><a href="adddrugstock.php">Add Stock</a></li>
                        <li><a href="adddrug.php">New Drug</a></li>
                        <li><a href="drugslist.php">Drug List</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-plug"></i><span class="nav-text">Category</span></a>
                    <ul aria-expanded="false">
                        <li><a href="addcategory.php">New Category</a></li>
                        <li><a href="catslist.php">Category List</a></li>
                    </ul>
                </li>
                <li><a href="logout.php" aria-expanded="false"><i class="icon icon-lock"></i><span class="nav-text">Sign Out</span></a></li>
            </ul>
        </div>
    </div>
<?php
}
?>

<!--**********************************
    Sidebar end
***********************************-->
