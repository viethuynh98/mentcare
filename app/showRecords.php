<?php
// Include your class definition
include('FormularyMedication.php');

// Start the session (if not started already)
session_start();

// Assuming you have an instance of FormularyMedication_DB_Test

// Get the patient ID from the URL parameter (you may need to adjust this based on your system)
// $patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : null;
$patient_id = 1;

// Check if a patient ID is provided
if ($patient_id) {
    // Get patient records
    $patient_records = $new_object->getPatientRecords($patient_id);

    // Check if there are records for the patient
    if ($patient_records) {
        // Display patient information and medical history
        echo "<h1>Patient Records</h1>";
        echo "<h2>Patient Information</h2>";
        // Display patient information from the $patient_records array

        echo "<h2>Medical History</h2>";
        foreach ($patient_records as $record) {
            // Display medical history details
            echo "Visit Date: " . $record['visit_date'] . "<br>";
            echo "Diagnose: " . $record['diagnose'] . "<br>";
            echo "Treatment: " . $record['treatment'] . "<br>";
            echo "<hr>";
        }

        // Display prescription information
        echo "<h2>Prescription Records</h2>";

        // Assuming you have a function to get prescriptions based on the medical history ID
        foreach ($patient_records as $record) {
            $prescription_details = $new_object->getPrescriptionDetails($record['mh_id']);
            
            // Display prescription details
            echo "<h3>Prescription for Visit Date: " . $record['visit_date'] . "</h3>";
            
            foreach ($prescription_details as $prescription_detail) {
                // Display prescription detail information
                echo "Drug: " . $prescription_detail['name'] . "<br>";
                echo "Dose: " . $prescription_detail['dose'] . "<br>";
                echo "Frequency: " . $prescription_detail['frequency'] . "<br>";
                echo "Quantity: " . $prescription_detail['quantity'] . "<br>";
                echo "Note: " . $prescription_detail['note'] . "<br>";
                echo "<hr>";
            }
        }
    } else {
        echo "No records found for the patient.";
    }
} else {
    echo "Patient ID is not provided.";
}
?>
