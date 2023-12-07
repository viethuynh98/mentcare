<?php
include('FormularyMedication.php');
session_start();
$resultMessage = "";
echo "<h1>Prescription</h1>";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  session_destroy();
  session_start();
  // Biến flag để theo dõi trạng thái hiển thị form
  $_SESSION['showDrugNameForm'] = true;
  $_SESSION['showDetailsForm'] = false;
  $_SESSION['showAddIntoPrescriptionBtn'] = false;
  $_SESSION['showAnotherDrugBtn'] = false;
  $_SESSION['prevent_page_load'] = true;
  $_SESSION['show_notes'] = true;
  // echo "asdasdasdsadasd";
  $_SESSION['patient_id'] = $_GET["patient_id"];
  $_SESSION['doctor_id'] = $_GET["doctor_id"];
  echo $_SESSION['patient_id'];
  echo $_SESSION['doctor_id'];
  if (isset($_GET["mh_id"])) {
    $mh_id = $_GET["mh_id"];
    $prescription_details = $new_object->getPrescriptionDetails($mh_id);

    foreach ($prescription_details as $prescription_detail) {
      $newPrescription = [
        'drug_name' => $prescription_detail["name"],
        'unit' => $prescription_detail["unit"],
        'dose' => $prescription_detail["dose"],
        'frequency' => $prescription_detail["frequency"],
        'quantity' => $prescription_detail["quantity"],
      ];
      $_SESSION['prescriptionValues'][] = $newPrescription;
    }
    $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
  }
}
if (!isset($_SESSION['prescriptionValues'])) {
  // Biến flag để theo dõi trạng thái hiển thị form
  $_SESSION['showDrugNameForm'] = true;
  $_SESSION['showDetailsForm'] = false;
  $_SESSION['showAddIntoPrescriptionBtn'] = false;
  $_SESSION['showAnotherDrugBtn'] = false;
  $_SESSION['prevent_page_load'] = true;
  $_SESSION['prescriptionValues'] = [];
  $_SESSION['show_notes'] = true;
  // echo "fdsfdsfdsfdfdsfdsfdsfd";
}
// Kiểm tra xem biểu mẫu đã được gửi đi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["delete"])) {
    $indexToDelete = $_POST["index"];
    // Xoá thành phần thuốc tại $indexToDelete
    unset($_SESSION['prescriptionValues'][$indexToDelete]);
    // Đặt lại các chỉ mục mảng để tránh các lỗ hổng
    $_SESSION['prescriptionValues'] = array_values($_SESSION['prescriptionValues']);
    echo '<div class = "showPrescriptionDetails">';
    $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
    echo '</div>';
  }
  if (isset($_POST["Done"])) {
    echo $_SESSION['patient_id'];
    echo $_SESSION['doctor_id'];
    session_destroy();
  } else if (isset($_POST["add_another_drug"])) {
    $_SESSION['showDrugNameForm'] = true;
    $_SESSION['showAnotherDrugBtn'] = false;
    $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
  } else if (isset($_POST['add_into_prescription'])) {
    if ($_SESSION['prevent_page_load']) {
      $newPrescription = [
        'drug_name' => $_POST["drug_name"],
        'unit' => $_POST["unit"],
        'dose' => $_POST["dose"],
        'frequency' => $_POST["frequency"],
        'quantity' => $_POST["quantity"],
      ];
      $_SESSION['prescriptionValues'][] = $newPrescription;
      $_SESSION['prevent_page_load'] = false;
    }
    //   // Loại thuốc đã tồn tại, thông báo lỗi hoặc xử lý theo ý muốn
    echo "<div class = 'showPrescriptionDetails'>";
    $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
    echo "</div>";
    //-----------------------------------

    $_SESSION['showDrugNameForm'] = false;
    $_SESSION['showDetailsForm'] = false;
    $_SESSION['showAddIntoPrescriptionBtn'] = false;
    $_SESSION['showAnotherDrugBtn'] = true;
  } else if (isset($_POST['drug_name'])) {
    $_SESSION['prevent_page_load'] = true;
    $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
    $drug_name = $_POST["drug_name"];

    // Kiểm tra xem loại thuốc đã tồn tại trong đơn thuốc hay chưa
    $drugNameExists = false;
    foreach ($_SESSION['prescriptionValues'] as $prescription) {
      if ($prescription['drug_name'] === $drug_name) {
        $drugNameExists = true;
        break;
      }
    }
    if ($drugNameExists) {
      $resultMessage = "<h6>Error: Drug already exists in the prescription.</h6>";
    } else // Kiểm tra xem thuốc có trong cơ sở dữ liệu hay không
      if ($new_object->checkDrugExistence($drug_name)) {
        // Nếu có, ẩn form nhập tên thuốc
        $_SESSION['showDrugNameForm'] = false;
        $_SESSION['showDetailsForm'] = true;

        //--------------------------------
        // hien thi chi tiet thuoc de bac si tham khao:
        $drugDetail = $new_object->getDrugDetails($drug_name);
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
          $quantity = $_POST["quantity"];

          // Gọi hàm formulary_medication và lưu kết quả
          $resultMessage = $new_object->formulary_medication($drug_name, $dose, $frequency);

          // Hiển thị form chi tiết và giữ nguyên các giá trị đã nhập
          if ($resultMessage == "<h5>Your prescription is ready</h5>") {
            // Hiển thị nút "Add Into Prescription"
            $_SESSION['showAddIntoPrescriptionBtn'] = true;
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../CSS/form_02.css">
  <title>Formulary Medication Form</title>



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
  <div class="showDrugNameForm">
    <?php if ($_SESSION['showDrugNameForm']) : ?>
      <div class="check_drug">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <input type="text" class="form-control" name="drug_name" placeholder="Enter Drug Name" id="drug_name" autocomplete="off" required>
          </div>
          <div id="suggestions"></div>
          <div id="btn" class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Check Drug</button>
          </div>
        </form>
      </div>
    <?php endif; ?>

    <!-- Hiển thị kết quả và form chi tiết -->
    <?php if (!empty($resultMessage) || $_SESSION['showDetailsForm']) : ?>
      <?php echo $resultMessage; ?>

      <?php if ($_SESSION['showDetailsForm']) : ?>
        <!-- <form method="post" action=" ./form.php"> -->
        <div class="info_drug">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label class="control-label" for="email">Unit:</label>
                  <input type="text" id="email" class="form-control" value="<?php echo $unit . " mg"; ?>" name="email" required>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label class="control-label" for="email">Dose: <?php echo "(" . $min_dose . "-" . $max_dose . ") " . $form; ?></label>
                  <input type="number" class="form-control" value="<?php echo isset($_POST['dose']) ? $_POST['dose'] : ''; ?>" name="dose" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label class="control-label" for="pwd">Frequency: <?php echo "(max = " . $frequency_max . " times a day)" ?></label>
                  <input type="number" class="form-control" value="<?php echo isset($_POST['frequency']) ? $_POST['frequency'] : ''; ?>" name="frequency" required>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label class="control-label" for="email">Quantity:</label>
                  <input type="text" class="form-control" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>" name="quantity" required>
                </div>
              </div>
            </div>
            <input type="hidden" name="drug_name" value="<?php echo $drug_name; ?>">
            <div class="form-group">
              <div id="btn" class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Submit</button>
              </div>
            </div>
          </form>
        </div>

      <?php endif; ?>
    <?php endif; ?>

    <!-- add_into_prescription -->
    <?php if ($_SESSION['showAddIntoPrescriptionBtn']) : ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="drug_name" value="<?php echo $drug_name; ?>">
        <input type="hidden" name="unit" value="<?php echo $unit; ?>">
        <input type="hidden" name="dose" value="<?php echo $dose; ?>">
        <input type="hidden" name="frequency" value="<?php echo $frequency; ?>">
        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
        <div id="btn" class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default" name="add_into_prescription">Add_Into_Prescription</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
  <?php if ($_SESSION['showAnotherDrugBtn']) : ?>
    <div class="form">
      <!-- Nút "Add Another Drug" và "Done" -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="add_another_drug" value="add_another_drug">
        <!-- <input type="submit" value="add_another_drug"> <br> -->
        <div id="btn1" class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default" value="add_another_drug">Add</button>
        </div>
      </form>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="Done" value="Done">
        <!-- <input type="submit" value="Done"> -->
        <div id="btn1" class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default" value="Done">Done</button>
        </div>
      </form>
    </div>
  <?php endif; ?>
  <?php if ($_SESSION['show_notes']) : ?>
    <div class="form">
      <!-- Nút "Add Another Drug" và "Done" -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <textarea name="note" id="" cols="30" rows="5"></textarea>
      </form>
    </div>
  <?php endif; ?>
</body>

</html>