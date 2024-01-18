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
                    <h4>List of Patients Details</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="addpatient.php" class="btn btn-primary btn-sm"><span class='icon-plus mx-2'></span>New Patient</a>
            </div>
        </div>

        <div class="row card mx-0">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="display" >
                        <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Mobile</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-dark">
                        <?php
                        $sql = "SELECT * FROM patient";
                        if($result = $pdo->query($sql)){
                            if($result->rowCount() > 0){
                                while($row = $result->fetch()){
                                    ?>
                                    <tr>
                                        <td><?=$row['id']?></td>
                                        <td><?=$row['patientname']?></td>
                                        <td><?=$row['address']?></td>
                                        <td><?=$row['dob']?></td>
                                        <td><?=$row['gender']?></td>
                                        <td><?=$row['mobile']?></td>
                                        <td>
                                            <a href="readpatient.php?id=<?=$row['id']?>" title='View Record' class="badge badge-rounded badge-success"><span class='icon-eye'></span></a>
                                            <a href="updatepatient.php?id=<?=$row['id'] ?>" title='Update Record' class="badge badge-rounded badge-primary"><span class='icon-pencil'></span></a>
                                            <a href="deletepatient.php?id=<?=$row['id'] ?>" title='Remove Record' class="badge badge-rounded badge-danger"><span class='icon-trash'></span></a>
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
include 'footer.php';
?>
