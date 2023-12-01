<?php
include('FormularyMedication.php');
session_start();
echo "<h1>Patient Records</h1>";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $showPatientInfo = true; // Biến kiểm tra để xác định có hiển thị thông tin bệnh nhân hay không

    if (isset($_GET['patient_id'])) {
        $patient_id = $_GET['patient_id'];

        if ($patient_id) {
            $patient_records = $new_object->getPatientRecords($patient_id);

            if ($patient_records) {
                // Hiển thị thông tin bệnh nhân nếu có tham số patient_id
                echo '<div class="full_infor_of_patient">';
                echo '<div class="record">';
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
                echo '<button><a href="./form_02.php">New Prescription</a></button>';
                echo '</div>';
            } else {
                echo "No records found for the patient.";
            }

            $showPatientInfo = false; // Không hiển thị phần else
        } else {
            echo "Patient ID is not provided.";
        }
    }

    if (isset($_GET['mh_id'])) {
        // Hiển thị chi tiết đơn thuốc nếu có tham số mh_id
        $mh_id = $_GET['mh_id'];
        echo '<div class="detail">';
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
        echo '<button><a href="./form_02.php?mh_id=' . $mh_id . '">Reissue Prescription</a></button>';
        echo '</div>';
    }

    // Hiển thị phần else khi cần
    if ($showPatientInfo) {
        $patient_records = $new_object->showPatientRecords();
        echo '<div class="full_infor_of_patient">';
        echo '<div class="record">';
        echo "<h2>Patient Information</h2>";
        echo "<h4>Medical History</h4>";
        echo '<table>';
        echo '<tr>';
        echo '<th>Record</th>';
        echo '<th>Details</th>';
        echo '</tr>';
        // Hiển thị thông tin bệnh nhân ở đây nếu không có tham số patient_id
        foreach ($patient_records as $record) {
            echo '<tr>';
            echo "<td>Visit Date: " . $record['visit_date'] . "<br>" .
                "Diagnose: " . $record['diagnose'] . "<br>" .
                "Treatment: " . $record['treatment'] . "<br>" .
                "</td>";
            echo '<td><a href="?mh_id=' . $record["mh_id"] . '">Detail</a></td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
    }

    echo '</div>';
} else {
    // Hiển thị phần else khi không phải là GET request
    // Code cho trường hợp không phải là GET request
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/showRecords.css">
    <title>Document</title>
</head>

<body>
    <div class="form">
        <form action="" method="GET">
            <input type="text" name="patient_id" placeholder="  Enter ID_Patient" required>
            <button type="submit">Search</button>
        </form>
    </div>
</body>

</html>