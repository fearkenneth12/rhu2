<?php
include 'header.php';
include 'sidebar.php';
require_once 'config.php';
?>
<div class="content-body">
    <div class="container-fluid">

        <!--            user header-->
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Drug Stock</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="adddrugstock.php" class="btn btn-primary btn-sm"><span class='icon-plus mx-2'></span>Add New stock details</a>
            </div>
        </div>

        <div class="row card mx-0">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="display" >
                        <thead>
                        <tr>
                            <th>Drug ID</th>
                            <th>Drug Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Stocked on</th>
                            <th>Expires on</th>
                        </tr>
                        </thead>
                        <tbody class="text-dark">
                        <?php
                            //SELECT `drugID`, `drugName`, `drugCategory`, `description` FROM `drug` WHERE 1
                            //SELECT `catID`, `catName`, `descr` FROM `category` WHERE 1
                            //SELECT `drug`, `stockqty`, `stockedDate`, `expiryDate` FROM `pharmacy` WHERE 1
                            $sql = "SELECT * FROM drug d JOIN category c ON d.drugCategory = c.catID LEFT JOIN pharmacy p ON d.drugID = p.drug";
                            if($result = $pdo->query($sql)){
                                if($result->rowCount() > 0){
                                      $i=1;
                                        while($row = $result->fetch()){
                                    ?>
                                     <tr>
                                                <td><?php echo $row['drugID']; ?></td>
                                                <td><?php echo $row['drugName']; ?></td>
                                                <td><?php echo $row['catName']; ?></td>
                                                <td><?php
                                                $qty =   $row['stockqty'];
                                                if(!empty($qty)){
                                                    echo  $qty;
                                                }else{
                                                    echo '<code>--</code>';
                                                }
                                                ?></td>
                                                <td><?php
                                                $stockedDate =   $row['stockedDate'];
                                                if(!empty($stockedDate)){
                                                    echo  $stockedDate;
                                                }else{
                                                    echo '<code>--</code>';
                                                }
                                                 ?></td>
                                                <td><?php
                                                 $expiryDate =   $row['expiryDate'];
                                                 if(!empty($expiryDate)){
                                                     echo  $expiryDate;
                                                 }else{
                                                     echo '<code>--</code>';
                                                 }
                                                  ?></td>
                                            </tr>
                                    <?php
                                    $i++;
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
include 'footer.php';
?>
