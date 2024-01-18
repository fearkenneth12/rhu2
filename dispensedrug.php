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
                    <h4>Dispense Drug to Patient</h4>
                </div>
            </div>
        </div>

        <div class="row card mx-0">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="display" >
                        <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th> Name</th>
                            <th>prescription</th>
                            <th>Medical History</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-dark">
                        <?php
                        $sql = "SELECT p.id,patientname,prescription,patientsMedicalHist FROM patient p JOIN prescription ps ON p.id=ps.patient";
                        if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            $i=1;
                            while($row = $result->fetch()){
                        ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['patientname']; ?></td>
                                    <td><?php echo $row['prescription']; ?></td>
                                    <td><?php echo $row['patientsMedicalHist']; ?></td>

                                    <td>
                                        <a href='dispence.php?id=<?php echo $row['id']; ?>' title='Dispense drugs to patient' class="badge badge-success"><span class='icon-eye'></span></a>
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
