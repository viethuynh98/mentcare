<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/showRecords.css">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="../image/logo.jpg" rel="icon">
    <title>Home Page</title>

</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex justify-content-between">

            <div id="logo">
                <h1><a href="./interface.php">Mental Health<span>Care</span></a></h1>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="./interface.php">Home</a></li>
                    <li><a class="nav-link scrollto active" href="./showRecords.php">Patient Record</a></li>
                    <!-- <li><a class="nav-link scrollto" href="./form_02.php">Prescription</a></li> -->
                    <li><a href="./log_out.php">Log Out</a></li>
                </ul>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
    <!-- <h1>Patient Records</h1> -->
    <h2>Patient Information</h2>
    <div class="form">
        <form action="" method="GET">
            <input type="text" name="patient_id" placeholder="  Enter ID_Patient" required>
            <button type="submit">Search</button>
        </form>
    </div>
</body>

</html>
<?php
include('FormularyMedication.php');
session_start();
// echo "<h1>Patient Records</h1>";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $showPatientInfo = true; // Biến kiểm tra để xác định có hiển thị thông tin bệnh nhân hay không

    if (isset($_SESSION['email'])) {
        $rows = $new_object->getStaffID($_SESSION['email']);
        foreach ($rows as $row) {
            $doctor_id = $row['staff_id'];
        }
    } else {
        $doctor_id = "DT01";
        // echo $doctor_id;
    }

    if (isset($_GET['patient_id'])) {
        $patient_id = $_GET['patient_id'];

        if ($patient_id) {
            $patient_records = $new_object->getPatientRecords($patient_id);

            if ($patient_records) {
                // Hiển thị thông tin bệnh nhân nếu có tham số patient_id
                echo '<div class="full_infor_of_patient">';
                echo '<div class="record">';
                echo '<table>';
                echo '<tr>';
                echo '<th>Visit Date</th>';
                echo '<th>Diagnose</th>';
                echo '<th>Treatment</th>';
                echo '<th>Details</th>';
                echo '</tr>';
                foreach ($patient_records as $record) {
                    echo '<tr>';
                    echo '<td>' . $record['visit_date'] . '</td>';
                    echo '<td>' . $record['diagnose'] . '</td>';
                    echo '<td>' . $record['treatment'] . '</td>';
                    echo '<td id = "btn"><a href="?patient_id=' . $patient_id . '&mh_id=' . $record["mh_id"] . '">Detail</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
                echo '<button><a href="./form_02.php?patient_id=' . $patient_id . '&&doctor_id=' . $doctor_id . '">New Prescription</a></button>';
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
        echo "<div class = 'ok'>";
        $prescription_details = $new_object->getPrescriptionDetails($mh_id);
        echo '<table>';
        echo '<tr>';
        echo '<th>Drug</th>';
        echo '<th>Dose</th>';
        echo '<th>Frequency</th>';
        echo '<th>Quantity</th>';
        echo '<th>Note</th>';
        foreach ($prescription_details as $prescription_detail) {
            echo '<tr>';
            echo '<td>' . $prescription_detail['name'] . '</td>';
            echo '<td>' . $prescription_detail['dose'] . '</td>';
            echo '<td>' . $prescription_detail['frequency'] . '</td>';
            echo '<td>' . $prescription_detail['quantity'] . '</td>';
            echo '<td>' . $prescription_detail['note'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo "</div>";
        echo '<button><a href="./form_02.php?patient_id=' . $patient_id . '&mh_id=' . $record["mh_id"] . '&doctor_id=' . $doctor_id . '">Reissue Prescription</a></button>';
        echo '</div>';
    }

    // Hiển thị phần else khi cần
    if ($showPatientInfo) {
        $patient_records = $new_object->showPatientRecords();
        echo '<div class="full_infor_of_patient">';
        echo '<div class="record">';
        echo '<table>';
        echo '<tr>';
        echo '<th>Visit Date</th>';
        echo '<th>Diagnose</th>';
        echo '<th>Treatment</th>';
        echo '<th>Details</th>';
        echo '</tr>';
        foreach ($patient_records as $record) {
            echo '<tr>';
            echo '<td>' . $record['visit_date'] . '</td>';
            echo '<td>' . $record['diagnose'] . '</td>';
            echo '<td>' . $record['treatment'] . '</td>';
            echo '<td id = "btn"><a href="?patient_id=' . $record['patient_id'] . '&mh_id=' . $record["mh_id"] . '&doctor_id=' . $record['staff_id'] . '">Detail</a></td>';
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