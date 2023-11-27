<?php
include('FormularyMedication.php');

session_start();
// Biến flag để theo dõi trạng thái hiển thị form
$showDrugNameForm = true;
$showDetailsForm = false; // Thêm biến để kiểm tra hiển thị form chi tiết
$showPrescriptionForm = false; // Biến để kiểm tra hiển thị form lưu giá trị tạm thời
$showAddIntoPrescriptionBtn = false; // Biến để kiểm tra hiển thị nút "Add Into Prescription"
$showAnotherDrugBtn = false; // Biến để kiểm tra hiển thị nút "Add Another Drug" và "Done"


$resultMessage = "";

if (!isset($_SESSION['prescriptionValues'])) {
  $_SESSION['prescriptionValues'] = [];
}


// Kiểm tra xem biểu mẫu đã được gửi đi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["Done"])) {
    session_destroy();
  } else if (isset($_POST["add_another_drug"])) {
    $showDrugNameForm = true;
    $showAnotherDrugBtn = false;
  } else if (isset($_POST['add_into_prescription'])) {
    $add_into_prescription = $_POST['add_into_prescription'];

    // Lưu giá trị vào mảng tạm thời
    $newPrescription = [
      'drug_name' => $_POST["drug_name"],
      'unit' => $_POST["unit"],
      'dose' => $_POST["dose"],
      'frequency' => $_POST["frequency"],
      'treatment_days' => $_POST["treatment_days"],
    ];

    $_SESSION['prescriptionValues'][] = $newPrescription;

    foreach ($_SESSION['prescriptionValues'] as $index => $prescription) {
      echo "Index: " . $index . "<br>";
      echo "Drug Name: " . $prescription['drug_name'] . "<br>";
      echo "Unit: " . $prescription['unit'] . "<br>";
      echo "Dose: " . $prescription['dose'] . "<br>";
      echo "Frequency: " . $prescription['frequency'] . "<br>";
      echo "Treatment Days: " . $prescription['treatment_days'] . "<br>";
      echo "-------------------------<br>";
    }
    // }
    //-----------------------------------

    $showDrugNameForm = false;
    $showPrescriptionForm = true; // Hiển thị danh sách thuốc
    $showAnotherDrugBtn = true; // Hiển thị nút "Add Another Drug"
    $showDetailsForm = false; // Ẩn form chi tiết
    $showAddIntoPrescriptionBtn = false; // Biến để kiểm tra hiển thị nút "Add Into Prescription"

  } else if (isset($_POST['drug_name'])) {
    $drug_name = $_POST["drug_name"];
    // Tạo đối tượng FormularyMedication_DB_Test

    // Kiểm tra xem thuốc có trong cơ sở dữ liệu hay không
    if ($new_object->checkDrugExistence($drug_name)) {
      // Nếu có, ẩn form nhập tên thuốc
      $showDrugNameForm = false;
      $showDetailsForm = true;

      //--------------------------------
      // hien thi chi tiet thuoc de bac si tham khao:
      $drugDetail = $new_object->getDrugDetails($drug_name);
      if ($drugDetail) {
        echo "Detail: TRUE";
      }
      foreach ($drugDetail as $row) {
        $min_dose = $row['min_dose_per_use'];
        $max_dose = $row['max_dose_per_use'];
        $frequency_max = $row['frequency_max'];
        $unit = $row['unit'];
        $form = $row['form'];
      }
      // -------------------------------

      if (isset($_POST['dose'])) {
        // Xử lý khi form chi tiết được gửi đi
        $dose = $_POST["dose"];
        $frequency = $_POST["frequency"];
        $treatment_days = $_POST["treatment_days"];

        // Gọi hàm formulary_medication và lưu kết quả
        $resultMessage = $new_object->formulary_medication($drug_name, $dose, $frequency);

        // Hiển thị form chi tiết và giữ nguyên các giá trị đã nhập
        if ($resultMessage == "Your prescription is ready") {
          // Hiển thị nút "Add Into Prescription"
          $showAddIntoPrescriptionBtn = true;
        }
      }
    } else {
      // Nếu không, yêu cầu người dùng nhập lại
      $resultMessage = "<p>Drug not found. Please enter a valid drug name.</p>";
    }
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
    #suggestions {
      max-height: 100px;
      /* Đặt chiều cao tối đa của danh sách gợi ý */
      overflow-y: auto;
      /* Thêm thanh cuộn khi nội dung vượt quá kích thước */
      position: absolute;
      width: calc(10% - 20px);
      /* Đặt chiều rộng phù hợp với phần điền tên thuốc và thêm khoảng trắng 10px */
      margin-top: 5px;
      margin-left: 85px;
      /* Thêm khoảng trắng phía trên danh sách gợi ý */
      background-color: #fff;
      /* Nền trắng */
    }

    .suggestion {
      padding: 8px;
      cursor: pointer;
      border-bottom: 1px solid #ddd;
    }

    #prescription-values {
      margin-top: 20px;
    }
  </style>


  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script>
    $(document).ready(function() {
      var drugNameInput = $("#drug_name");
      var suggestionsDiv = $("#suggestions");

      drugNameInput.on("input", function() {
        var input = $(this).val();
        // console.log("Input: ", input);
        if (input.length >= 1) {
          $.ajax({
            type: "POST",
            url: "getSuggestions.php",
            data: {
              input: input
            },
            success: function(response) {
              suggestionsDiv.html(response);
              adjustSuggestionsWidth(); // Cập nhật chiều rộng của phần gợi ý
            }
          });
        } else {
          suggestionsDiv.html("");
        }
      });

      // Xử lý khi chọn gợi ý
      $(document).on("click", ".suggestion", function() {
        var selectedDrug = $(this).text();
        drugNameInput.val(selectedDrug);
        suggestionsDiv.html("");
      });

      // Hàm để cập nhật chiều rộng của phần gợi ý
      function adjustSuggestionsWidth() {
        var drugNameInputWidth = drugNameInput.outerWidth();
        suggestionsDiv.width(drugNameInputWidth);
      }

    });
  </script>
</head>

<body>

  <!-- Biểu mẫu nhập liệu -->
  <?php if ($showDrugNameForm) : ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="drug_name">Drug Name:</label>
      <input type="text" name="drug_name" id="drug_name" autocomplete="off" required>
      <br>
      <div id="suggestions"></div>
      <br>
      <input type="submit" value="Check Drug">
    </form>
  <?php endif; ?>

  <!-- Hiển thị kết quả và form chi tiết -->
  <?php if (!empty($resultMessage) || $showDetailsForm) : ?>
    <?php echo $resultMessage; ?>

    <?php if ($showDetailsForm) : ?>
      <!-- <form method="post" action=" ./form.php"> -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="unit">Unit:</label> <?php echo $unit . " mg"; ?> <br>

        <label for="dose">Dose:</label> <?php echo "(" . $min_dose . "-" . $max_dose . ") " . $form; ?>
        <input type="number" name="dose" value="<?php echo isset($_POST['dose']) ? $_POST['dose'] : ''; ?>" required><br>

        <label for="frequency">Frequency:</label> <?php echo "(max = " . $frequency_max . " times a day)" ?>
        <input type="number" name="frequency" value="<?php echo isset($_POST['frequency']) ? $_POST['frequency'] : ''; ?>" required><br>

        <label for="treatment_days">Treatment Days:</label>
        <input type="number" name="treatment_days" value="<?php echo isset($_POST['treatment_days']) ? $_POST['treatment_days'] : ''; ?>" required><br>

        <input type="hidden" name="drug_name" value="<?php echo $drug_name; ?>">
        <input type="submit" value="Submit">
      </form>
    <?php endif; ?>
  <?php endif; ?>

  <!-- add_into_prescription -->
  <?php if ($showAddIntoPrescriptionBtn) : ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <input type="hidden" name="drug_name" value="<?php echo $drug_name; ?>">
      <input type="hidden" name="unit" value="<?php echo $unit; ?>">
      <input type="hidden" name="dose" value="<?php echo $dose; ?>">
      <input type="hidden" name="frequency" value="<?php echo $frequency; ?>">
      <input type="hidden" name="treatment_days" value="<?php echo $treatment_days; ?>">
      <input type="submit" name="add_into_prescription" value="add_into_prescription">
    </form>
  <?php endif; ?>

  <?php if ($showAnotherDrugBtn) : ?>
    <!-- Nút "Add Another Drug" và "Done" -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <input type="hidden" name="add_another_drug" value="add_another_drug">
      <input type="submit" value="add_another_drug"> <br>
    </form>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <input type="hidden" name="Done" value="Done">
      <input type="submit" value="Done">
    </form>
  <?php endif; ?>
</body>

</html>