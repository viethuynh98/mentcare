<?php
include('FormularyMedication.php');


// Kiểm tra xem biểu mẫu đã được gửi đi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug_name = $_POST["drug_name"];
    $dose = $_POST["dose"];
    $frequency = $_POST["frequency"];

    // Tạo đối tượng FormularyMedication

    // Gọi hàm formulary_medication và hiển thị kết quả
    $result = $new_object->formulary_medication($drug_name, $dose, $frequency);
    echo "<p>Result: $result</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulary Medication Form</title>
</head>

<body>

    <!-- Biểu mẫu nhập liệu -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="drug_name">Drug Name:</label>
        <input type="text" name="drug_name" required><br>

        <label for="dose">Dose:</label>
        <input type="number" name="dose" required><br>

        <label for="frequency">Frequency:</label>
        <input type="number" name="frequency" required><br>
        
        <input type="submit" value="Submit">
    </form>

</body>

</html>