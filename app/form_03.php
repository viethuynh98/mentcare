<?php
include('FormularyMedication.php');

// Biến flag để theo dõi trạng thái hiển thị form
$showDrugNameForm = true;
$showDetailsForm = false; // Thêm biến để kiểm tra hiển thị form chi tiết
$showPrescriptionForm = false; // Biến để kiểm tra hiển thị form lưu giá trị tạm thời

// Kết quả kiểm tra giá trị thuốc
$resultMessage = "";

// Mảng lưu giá trị tạm thời
$prescriptionValues = [];

// Kiểm tra xem biểu mẫu đã được gửi đi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $drug_name = $_POST["drug_name"];

  // Tạo đối tượng FormularyMedication_DB_Test
  $new_object = new \App\FormularyMedication_DB_Test('localhost', 'root', '', 'mentcare_db');

  // Kiểm tra xem thuốc có trong cơ sở dữ liệu hay không
  if ($new_object->checkDrugExistence($drug_name)) {
    // Nếu có, ẩn form nhập tên thuốc
    $showDrugNameForm = false;
    $showDetailsForm = true;
    if (isset($_POST['unit'])) {
      // Xử lý khi form chi tiết được gửi đi
      $unit = $_POST["unit"];
      $dose = $_POST["dose"];
      $frequency = $_POST["frequency"];
      $treatment_days = $_POST["treatment_days"];

      // Gọi hàm formulary_medication và lưu kết quả
      $resultMessage = $new_object->formulary_medication($drug_name, $dose, $frequency);

      // Nếu kết quả là "Your prescription is ready"
      if ($resultMessage == "Your prescription is ready") {
        // Hiển thị nút submit để lưu giá trị vào mảng tạm thời
        $showPrescriptionForm = true;

        // Lưu giá trị vào mảng tạm thời
        $prescriptionValues[] = [
          'drug_name' => $drug_name,
          'unit' => $unit,
          'dose' => $dose,
          'frequency' => $frequency,
          'treatment_days' => $treatment_days,
        ];
      }
    }
  } else {
    // Nếu không, yêu cầu người dùng nhập lại
    $resultMessage = "<p>Drug not found. Please enter a valid drug name.</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulary Medication Form</title>
  <style>
    /* CSS như trước */

    #prescription-values {
      margin-top: 20px;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script>
    $(document).ready(function () {
      var prescriptionValuesDiv = $("#prescription-values");
      var prescriptionForm = $("#prescription-form");

      // Hiển thị các giá trị tạm thời
      <?php foreach ($prescriptionValues as $value) : ?>
        var drugInfo = "Drug: <?php echo $value['drug_name']; ?>, Unit: <?php echo $value['unit']; ?>, Dose: <?php echo $value['dose']; ?>, Frequency: <?php echo $value['frequency']; ?>, Treatment Days: <?php echo $value['treatment_days']; ?>";
        var listItem = "<li>" + drugInfo + "</li>";
        prescriptionValuesDiv.append(listItem);
      <?php endforeach; ?>
    });
  </script>
</head>

<body>

  <!-- Biểu mẫu nhập liệu -->
  <?php if ($showDrugNameForm || $showDetailsForm) : ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="prescription-form">
      <label for="drug_name">Drug Name:</label>
      <input type="text" name="drug_name" id="drug_name" autocomplete="off" required>
      <br>
      <div id="suggestions"></div>
      <br>

      <!-- Các trường nhập liệu cho thuốc -->
      <label for="unit">Unit:</label>
      <input type="text" name="unit" id="unit" required><br>

      <label for="dose">Dose:</label>
      <input type="number" name="dose" id="dose" required><br>

      <label for="frequency">Frequency:</label>
      <input type="number" name="frequency" id="frequency" required><br>

      <label for="treatment_days">Treatment Days:</label>
      <input type="number" name="treatment_days" id="treatment_days" required><br>

      <!-- Nút "Submit" -->
      <button type="submit" id="submit-button" style="display: none;">Submit</button>
    </form>

    <!-- Danh sách thuốc -->
    <ul id="prescription-values" style="display: none;"></ul>
  <?php endif; ?>

  <!-- Hiển thị kết quả và form chi tiết -->
  <?php if (!empty($resultMessage) || $showDetailsForm) : ?>
    <?php echo $resultMessage; ?>

    <?php if ($showDetailsForm) : ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="unit">Unit:</label>
        <input type="text" name="unit" value="<?php echo isset($_POST['unit']) ? $_POST['unit'] : ''; ?>" required><br>

        <label for="dose">Dose:</label>
        <input type="number" name="dose" value="<?php echo isset($_POST['dose']) ? $_POST['dose'] : ''; ?>" required><br>

        <label for="frequency">Frequency:</label>
        <input type="number" name="frequency" value="<?php echo isset($_POST['frequency']) ? $_POST['frequency'] : ''; ?>" required><br>

        <label for="treatment_days">Treatment Days:</label>
        <input type="number" name="treatment_days" value="<?php echo isset($_POST['treatment_days']) ? $_POST['treatment_days'] : ''; ?>" required><br>

        <input type="hidden" name="drug_name" value="<?php echo $drug_name; ?>">
        <input type="submit" value="Submit">
      </form>
    <?php endif; ?>
  <?php endif; ?>

</body>

</html>
