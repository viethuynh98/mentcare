<?php
include('FormularyMedication.php');
session_start();
echo "<h1>Patient Records</h1>";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['patient_id'])) {
        $patient_id = $_GET['patient_id'];

        if ($patient_id) {

            $patient_records = $new_object->getPatientRecords($patient_id);

            if ($patient_records) {
                echo '<div class = "full">';
                echo '<div class = "record">';
                echo "<h2>Patient Information</h2>";
                echo "<h4>Medical History</h4>";
                echo '<table>';
                echo '<tr>';
                echo '<th>Record</th>';
                echo '<th>Details</th>';
                echo '</tr>';
                foreach ($patient_records as $record) {
                    echo '<tr>';
                    echo "<td>Visit Date: " . $record['visit_date'] . "<br>" .
                        "Diagnose: " . $record['diagnose'] . "<br>" .
                        "Treatment: " . $record['treatment'] . "<br>" .
                        "</td>";
                    echo '<td><a href="?patient_id=' . $patient_id . '&mh_id=' . $record["mh_id"] . '">Detail</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '<button><a href = "./form_02.php">New</a></button>';
                echo '</div>';
            } else {
                echo "No records found for the patient.";
            }
        } else {
            echo "Patient ID is not provided.";
        }
    }

    if (isset($_GET['mh_id'])) {
        $mh_id = $_GET['mh_id'];
        echo '<div class = "detail">';
        echo "<h2>Prescription Records</h2>";
        $prescription_details = $new_object->getPrescriptionDetails($mh_id);
        foreach ($prescription_details as $prescription_detail) {
            echo "Drug: " . $prescription_detail['name'] . "<br>";
            echo "Dose: " . $prescription_detail['dose'] . "<br>";
            echo "Frequency: " . $prescription_detail['frequency'] . "<br>";
            echo "Quantity: " . $prescription_detail['quantity'] . "<br>";
            echo "Note: " . $prescription_detail['note'] . "<br>";
            echo "<hr>";
        }
        echo '<button><a href="./form_02.php?mh_id=' . $mh_id . '">New</a></button>';
        echo '</div>';
    }
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
            margin: auto;
        }

        table {
            border-radius: 10px;
        }

        tr:nth-child(even) {
            background-color: #dfe6ea;
        }

        h1 {
            text-align: center;
            color: blue;
        }

        .full {
            /* border: 2px solid red; */
            display: flex;
            /* justify-content: space-around; */
            margin-top: 15vh;
        }

        .record {
            width: 45vw;
            /* border: 2px solid red; */

        }

        .record table {
            width: 100%;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.6);
            font-size: 1em;
            line-height: 1.4;
            margin-bottom: 4vh;
        }

        .record h2,
        h4 {
            text-align: center;
        }

        .record a {
            text-decoration: none;
            color: black;
            font-weight: 400;
            width: 15vh;
            padding: 1.5vh 0;

        }

        .record a:hover {
            text-decoration: underline;
            /* color: lightslategrey; */
        }

        .record button {
            display: flex;
            justify-content: center;
            margin: 0 auto;
            /* border: 1px solid black; */
            border-radius: 10px;
            background-color: lightblue;
            font-size: 2.5vh;
        }

        .detail {
            width: 45vw;
            margin: auto;
            /* float: right; */
            /* border: 2px solid red; */
        }

        .detail h2 {
            margin-bottom: 9vh;
            text-align: center;
        }

        .detail button {
            display: flex;
            justify-content: center;
            margin: 0 auto;
            /* border: 1px solid black; */
            border-radius: 10px;
            background-color: lightblue;
            font-size: 2.5vh;
        }

        .detail a {
            text-decoration: none;
            color: black;
            font-weight: 400;
            width: 15vh;
            padding: 1.5vh 0;

        }

        .form {
            position: absolute;
            top: 12vh;
            left: 5vh;
        }
    </style>
</head>

<body>
    <div class="form">
        <form action="" method="GET">
            <input type="text" name="patient_id" placeholder="Enter ID_Patient" required>
            <button type="submit">Search</button>
        </form>
    </div>
</body>

</html>