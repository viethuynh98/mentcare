<?php
include('FormularyMedication.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['patient_id'])) {
        $patient_id = $_GET['patient_id'];

        if ($patient_id) {

            $patient_records = $new_object->getPatientRecords($patient_id);

            if ($patient_records) {
                echo "<h1>Patient Records</h1>";
                echo "<h2>Patient Information</h2>";

                echo "<h2>Medical History</h2>";

                echo '<table>';
                echo '<tr>';
                echo '<th>Record</th>';
                echo '<th>Detail</th>';
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
            } else {
                echo "No records found for the patient.";
            }
        } else {
            echo "Patient ID is not provided.";
        }
    }

    if (isset($_GET['mh_id'])) {
        $mh_id = $_GET['mh_id'];
        echo "<h2>Prescription Records</h2>";

        $prescription_details = $new_object->getPrescriptionDetails($mh_id);
        $prescriptionValues = [];
        foreach ($prescription_details as $prescription_detail) {
            // $newPrescription = [
            //     'drug_name' => $_POST["drug_name"],
            //     'unit' => $_POST["unit"],
            //     'dose' => $_POST["dose"],
            //     'frequency' => $_POST["frequency"],
            //     'quantity' => $_POST["quantity"],
            // ];
            $prescriptionValues[] = $newPrescription;
            echo "Drug: " . $prescription_detail['name'] . "<br>";
            echo "Dose: " . $prescription_detail['dose'] . "<br>";
            echo "Frequency: " . $prescription_detail['frequency'] . "<br>";
            echo "Quantity: " . $prescription_detail['quantity'] . "<br>";
            echo "Note: " . $prescription_detail['note'] . "<br>";
            echo "<hr>";
        }
    }
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
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="form">
        <form action="" method="GET">
            <input type="text" name="patient_id" placeholder="Enter ID_Patient" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>