<?php
include 'header.php';
include 'sidebar.php';
$level = $_SESSION["userrole"];
require_once 'config.php';
?>
    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">

<!--            user header-->
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Users</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php
                if ($level == 1 ){
                    ?>
<!--                admin-->
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-user text-primary border-success"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Admin</div>
                                <div class="stat-digit">
                                    <?php
                                    // Assuming $pdo is your PDO connection object
                                    $query = "SELECT * FROM user WHERE userrole = 1";
                                    $stmt = $pdo->query($query);

                                    // Fetch all rows and get the row count
                                    $result = $stmt->fetchAll();
                                    echo count($result);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                doctor-->
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-user text-primary border-primary"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Doctor</div>
                                <div class="stat-digit">
                                    <?php
                                    // Assuming $pdo is your PDO connection object
                                    $query = "SELECT * FROM user WHERE userrole = 2";
                                    $stmt = $pdo->query($query);

                                    // Fetch all rows and get the row count
                                    $result = $stmt->fetchAll();
                                    echo count($result);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                pharmacist-->
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-user text-primary border-dark"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Pharmacist</div>
                                <div class="stat-digit">
                                    <?php
                                    // Assuming $pdo is your PDO connection object
                                    $query = "SELECT * FROM user WHERE userrole = 4";
                                    $stmt = $pdo->query($query);

                                    // Fetch all rows and get the row count
                                    $result = $stmt->fetchAll();
                                    echo count($result);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                patient-->
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-user text-primary border-info"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Receptionist</div>
                                <div class="stat-digit">
                                    <?php
                                    // Assuming $pdo is your PDO connection object
                                    $query = "SELECT * FROM user WHERE userrole = 3";
                                    $stmt = $pdo->query($query);

                                    // Fetch all rows and get the row count
                                    $result = $stmt->fetchAll();
                                    echo count($result);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
<!--                patient-->
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-user text-primary border-info"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Patient</div>
                                <div class="stat-digit">
                                    <?php
                                    // Assuming $pdo is your PDO connection object
                                    $query = "SELECT * FROM patient ";
                                    $stmt = $pdo->query($query);

                                    // Fetch all rows and get the row count
                                    $result = $stmt->fetchAll();
                                    echo count($result);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<!--            drugs-->

            <?php
            if($level !=3){
                ?>
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Drugs</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class=" col-md-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-view-list text-primary border-danger"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Number of Expired Drugs</div>
                                <div class="stat-digit">
                                    <?php
                                    $sql = "SELECT COUNT(*) as expiDrugs FROM pharmacy WHERE stockqty!=0 and expiryDate <= CURDATE()";
                                    if($result = $pdo->query($sql)){
                                        if($result->rowCount()>0){
                                            while($row = $result->fetch()){
                                                if ($row['expiDrugs']==0 || $row['expiDrugs']==null){
                                                    echo 0;
                                                }else{
                                                    echo $row['expiDrugs'];
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-view-list text-primary border-dark"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Number of Out of Stock Drugs</div>
                                <div class="stat-digit">
                                    <?php
                                    $sqlOut = "SELECT COUNT(*) as outStockDrugs FROM pharmacy WHERE stockqty = 0 ";
                                    if($resultOut = $pdo->query($sqlOut)){
                                        if($resultOut->rowCount()>0){
                                            while($rowo = $resultOut->fetch()){
                                                if ($rowo['outStockDrugs']==0 || $rowo['outStockDrugs']==null){
                                                    echo 0;
                                                }else {
                                                    echo $rowo['outStockDrugs'];
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Drug status list</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive-sm">
                                    <table id="example" class="display " >
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Specification</th>
                                            <th>Qty</th>
                                            <th>Expiration Date</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-dark">
                                        <?php
                                        $sql = "SELECT drug.*, pharmacy.* FROM pharmacy INNER JOIN drug ON pharmacy.drug = drug.drugID ORDER BY stockqty DESC";

                                        if ($result = $pdo->query($sql)) {
                                            if ($result->rowCount() > 0) {
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                    <tr>
                                                        <td><?=$row['drugID']?></td>
                                                        <td><?= ucwords($row['drugName']) ?></td>
                                                        <td><?= ucwords($row['description']) ?></td>
                                                        <td><?= $row['stockqty'] ?></td>
                                                        <td><?= date("Y M-d", strtotime($row['expiryDate'])) ?></td>
                                                        <td>
                                                            <?php
                                                            if ($row['stockqty'] == 0) {
                                                                echo '<span class="badge badge-info">Out of Stock</span>';
                                                            } elseif (strtotime($row['expiryDate']) <= strtotime(date("Y-m-d"))) {
                                                                echo '<span class="badge badge-danger">Expired</span>';
                                                            }else{
                                                                echo '<span class="badge badge-success">In Stock</span>';
                                                            }
                                                            ?>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            if ($level != 3){
            ?>
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Drugs in Pharmacy</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class=" col-md-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-list-ol text-primary border-success"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Stocked Drugs</div>
                                <div class="stat-digit">
                                    <?php
                                    $sql = "SELECT count(drug) as no, SUM(stockqty) as totalstock  FROM pharmacy WHERE stockqty > 0 AND expiryDate >= CURDATE() ";
                                    if($result = $pdo->query($sql)){
                                        if($result->rowCount()>0){
                                            while($row = $result->fetch()) {
                                                if ($row['no'] == null || $row['no'] == 0) {
                                                    echo 0;
                                                } else {
                                                    echo $row['no'];
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-6">
                    <div class="card">
                        <div class="stat-widget-one card-body">
                            <div class="stat-icon d-inline-block">
                                <i class="ti-list-ol text-primary border-primary"></i>
                            </div>
                            <div class="stat-content d-inline-block">
                                <div class="stat-text">Total Stock</div>
                                <div class="stat-digit">
                                    <?php
                                    $sql = "SELECT count(drug) as no, SUM(stockqty) as totalstock  FROM pharmacy WHERE stockqty > 0 AND expiryDate >= CURDATE() ";
                                    if($result = $pdo->query($sql)){
                                        if($result->rowCount()>0){
                                            while($row = $result->fetch()){
                                                if ($row['totalstock']==null || $row['totalstock']==0){
                                                    echo  0;
                                                }else{
                                                    echo $row['totalstock'];
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->

        <?php
include 'footer.php';
?>