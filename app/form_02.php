<?php
include('FormularyMedication.php');

// Biến flag để theo dõi trạng thái hiển thị form
$showDrugNameForm = true;
$showDetailsForm = false; // Thêm biến để kiểm tra hiển thị form chi tiết

// Kết quả kiểm tra giá trị thuốc
$resultMessage = "";

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

      // Hiển thị form chi tiết và giữ nguyên các giá trị đã nhập

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

    .suggestion:last-child {
      border-bottom: none;
      /* Loại bỏ đường viền dưới của phần tử cuối cùng */
    }
  </style>


  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script>
  $(document).ready(function() {
    var drugNameInput = $("#drug_name");
    var suggestionsDiv = $("#suggestions");

    drugNameInput.on("input", function() {
      var input = $(this).val();
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