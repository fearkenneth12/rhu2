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
                    <h4>List of Available Drugs Category</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="addcategory.php" class="btn btn-primary btn-sm"><span class='icon-plus mx-2'></span>Add New Drug Category details</a>
            </div>
        </div>

        <div class="row card mx-0">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="display" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-dark">
                        <?php
                        $sql = "SELECT * FROM  category ";
                        if($result = $pdo->query($sql)){
                            if($result->rowCount() > 0){
                                $i=1;
                                while($row = $result->fetch()){
                                    ?>
                                    <tr>
                                        <td> <?php echo $i;?> </td>
                                        <td> <?php echo $row['catName']; ?> </td>
                                        <td> <?php echo $row['descr'] ; ?> </td>
                                        <td>
                                            <a href='updatecategory.php?id=<?php echo $row['catID']; ?>' title='Update Record' class="badge badge-primary"><span class='icon-pencil'></span></a>
                                            <a href='deletecategory.php?id=<?php echo $row['catID']; ?>' title='Delete Record' class="badge badge-danger"><span class='icon-trash'></span></a>
                                        </td>
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
