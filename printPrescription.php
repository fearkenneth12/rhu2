<?php
include 'config.php';

// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {

    // Prepare a select statement
    $sql = "SELECT patient.*, prescription.* FROM patient 
            INNER JOIN prescription ON patient.id = prescription.patient 
            WHERE prescription.id = :id;";  // Use :id as a placeholder in the query

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);  // Bind the parameter using :id

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use a while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $name = $row["patientname"];
                $address = $row["address"];
                $gender = $row['gender'];
                $history = $row['patientsMedicalHist'];
                $pres = $row['prescription'];
            } else {
                // URL doesn't contain a valid id parameter. Redirect to the error page
                echo '<script>alert("Invalid Request.")</script>';
                exit();
            }
        } else {
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
            //            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
} else {
    // URL doesn't contain an id parameter. Redirect to the error page
    echo '<script>alert("Invalid Request.")</script>';
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit Santa Maria, Laguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
        }

        header {
            margin-top: 50px;
            text-align: center;
        }

        #clinic-name {
            font-weight: bold;
            font-size: 14px;
        }

        #content {
            margin-left: 50px;
            text-align: left;
            margin-top: 50px;
        }

        #signature {
            margin-top: 90px;
            margin-left: 50px;
            text-align: center;
        }

        #footer {
            margin-top: 40px;
            bottom: 20px;
            margin-left: 50px;
            text-align: center;
        }
    </style>
</head>
<body onload="print()" onafterprint="window.close()">

<header>
    <img id="logo" src="images/rural.jpg" alt="Logo" style="border-radius: 50%;">
    <div id="clinic-name" style="text-align: center;margin-top: 20px">
        <h2>Rural Health Unit Santa Maria, Laguna</h2>
        <h3 style="letter-spacing: .2em;font-weight: bolder">Prescription</h3>
    </div>
</header>

<div id="content">
    <p>Name: &nbsp;&nbsp;<b><?=strtoupper($name)?></b></p>
    <p>Address: &nbsp;&nbsp;<b><?=ucwords($address)?></b></p>
    <p>Sex: &nbsp;&nbsp; <b><?=strtoupper($gender)?></b></p>
    <p >Medical History: &nbsp;&nbsp; <b><?=$history?></b></p>
</div>
<div style="margin-top: 50px;margin-bottom: 20px;margin-left: 70px;">
    <p><b>Prescription</b></p>
    <br>
    <span style="align-content: center"><?=$pres?></span>
    <br>
</div>

<div id="signature">
    <p>_____________________</p>
    <b>Signature </b>
</div>

<div id="footer">
    <p>&copy; 2023 Rural Health Unit Santa Maria, Laguna</p>
</div>

</body>
</html>
