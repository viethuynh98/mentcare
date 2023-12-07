<?php
include('FormularyMedication.php');
include('libs/helper.php');
session_start();
$resultMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  session_destroy();
  session_start();
  // Biến flag để theo dõi trạng thái hiển thị form
  $_SESSION['showDrugNameForm'] = true;
  $_SESSION['showDetailsForm'] = false;
  $_SESSION['showAddIntoPrescriptionBtn'] = false;
  $_SESSION['showAnotherDrugBtn'] = false;
  $_SESSION['prevent_page_load'] = true;
  $_SESSION['show_notes'] = false;
  $_SESSION['show_diagnose'] = false;
  $_SESSION['note'] = "";
  $_SESSION['patient_id'] = $_GET['patient_id'];
  $_SESSION['doctor_id'] = $_GET['doctor_id'];
  if (isset($_GET["mh_id"])) {
    $mh_id = $_GET["mh_id"];
    $mh_details = $new_object->get_mh_detail($mh_id);
    foreach ($mh_details as $mh_detail) {
      $_SESSION['diagnose'] = $mh_detail["diagnose"];
      $_SESSION['treatment'] = $mh_detail["treatment"];
    }

    $prescription_details = $new_object->getPrescriptionDetails($mh_id);

    foreach ($prescription_details as $prescription_detail) {
      $newPrescription = [
        'drug_name' => $prescription_detail["name"],
        'unit' => $prescription_detail["unit"],
        'dose' => $prescription_detail["dose"],
        'frequency' => $prescription_detail["frequency"],
        'quantity' => $prescription_detail["quantity"],
        'drug_id' => $prescription_detail["drug_id"],
        'note' => $prescription_detail["note"],
      ];
      $_SESSION['prescriptionValues'][] = $newPrescription;
    }
    echo "<div class = showPrescriptionDetails2>";
    $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
    echo "</div>";
  }
}
if (!isset($_SESSION['prescriptionValues']) && !isset($_POST["Diagnose"])) {
  // Biến flag để theo dõi trạng thái hiển thị form
  $_SESSION['showDrugNameForm'] = false;
  $_SESSION['showDetailsForm'] = false;
  $_SESSION['showAddIntoPrescriptionBtn'] = false;
  $_SESSION['showAnotherDrugBtn'] = false;
  $_SESSION['prevent_page_load'] = true;
  $_SESSION['prescriptionValues'] = [];
  $_SESSION['show_notes'] = false;
  $_SESSION['show_diagnose'] = true;
  $_SESSION['note'] = "";
}
// Kiểm tra xem biểu mẫu đã được gửi đi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["Diagnose"])) {
    $_SESSION['show_diagnose'] = false;
    $_SESSION['showDrugNameForm'] = true;
    $_SESSION['diagnose'] = $_POST["Diagnose"];
    $_SESSION['treatment'] = $_POST["Treatment"];
  }
  if (isset($_POST["delete"])) {
    $indexToDelete = $_POST["index"];
    // Xoá thành phần thuốc tại $indexToDelete
    unset($_SESSION['prescriptionValues'][$indexToDelete]);
    // Đặt lại các chỉ mục mảng để tránh các lỗ hổng
    $_SESSION['prescriptionValues'] = array_values($_SESSION['prescriptionValues']);
    if (!$_SESSION['prescriptionValues'] && !$_SESSION['showDetailsForm']) {
      $_SESSION['showDrugNameForm'] = true;
    } else {
      echo "<div class = 'showPrescriptionDetails1'>";
      echo "<div class = 'show_table_infor'>";
      $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
      echo "</div>";
      if ($_SESSION['showAnotherDrugBtn']) {
        echo '<div class="form">';
        // Nút "Add Another Drug" và "Done"
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<input type="hidden" name="Done" value="Done">';
        echo '<div id="btn1" class="col-sm-offset-2 col-sm-10">';
        echo '<button type="submit" class="btn btn-default" value="Done">Done</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
      }
      echo "</div>";
    }
  }
  if ($_SESSION['show_notes']) {
    $_SESSION['note'] = $_POST['note'];
    $new_object->insert_into_db($_SESSION['patient_id'], $_SESSION['doctor_id'], $_SESSION['diagnose'], $_SESSION['treatment'], $_SESSION['note'], $_SESSION['prescriptionValues']);
    session_destroy();
    Helper::redirect(Helper::get_url('../mentcare/app/showRecords.php'));
  }
  if (isset($_POST["Done"])) {
    $_SESSION['showDrugNameForm'] = false;
    $_SESSION['show_notes'] = true;
    echo "<div class = 'showPrescriptionDetails2 ' >";
    $new_object->showPrescriptionDetails_02($_SESSION['prescriptionValues']);
    echo "</div>";
    // session_destroy();
  } else if (isset($_POST['add_into_prescription'])) {
    if ($_SESSION['prevent_page_load']) {
      $note = '';
      switch ($_POST["frequency"]) {
        case 1:
          $note = "Sáng " . $_POST["dose"] . " viên, " . $_POST["drug_note"];
          break;
        case 2:
          $note = "Sáng " . $_POST["dose"] . " viên, " . "Chiều " . $_POST["dose"] . " viên, " . $_POST["drug_note"];
          break;
        case 3:
          $note = "Sáng " . $_POST["dose"] . " viên, " . "Trưa " . $_POST["dose"] . " viên, " . "Chiều " . $_POST["dose"] . " viên, " . $_POST["drug_note"];
      }
      $newPrescription = [
        'drug_name' => $_POST["drug_name"],
        'unit' => $_POST["unit"],
        'dose' => $_POST["dose"],
        'frequency' => $_POST["frequency"],
        'quantity' => $_POST["quantity"],
        'drug_id' => $_POST["drug_id"],
        'note' => $note,
      ];
      $_SESSION['prescriptionValues'][] = $newPrescription;
      $_SESSION['prevent_page_load'] = false;
    }
    $_SESSION['showDrugNameForm'] = true;
    $_SESSION['showDetailsForm'] = false;
    $_SESSION['showAddIntoPrescriptionBtn'] = false;
    $_SESSION['showAnotherDrugBtn'] = true;
    echo "<div class = 'showPrescriptionDetails1'>";
    echo "<div class = 'show_table_infor'>";
    $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
    echo "</div>";
    if ($_SESSION['showAnotherDrugBtn']) {
      echo '<div class="form">';
      // Nút "Add Another Drug" và "Done"
      echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
      echo '<input type="hidden" name="Done" value="Done">';
      echo '<div id="btn1" class="col-sm-offset-2 col-sm-10">';
      echo '<button type="submit" class="btn btn-default" value="Done">Done</button>';
      echo '</div>';
      echo '</form>';
      echo '</div>';
    }
    echo "</div>";
  } else if (isset($_POST['drug_name'])) {
    $_SESSION['prevent_page_load'] = true;
    echo "<div class = 'showPrescriptionDetails2'>";
    $new_object->showPrescriptionDetails($_SESSION['prescriptionValues']);
    echo "</div>";
    $_SESSION['$drug_name'] = $_POST["drug_name"];
    $drug_name = $_SESSION['$drug_name'];

    $drugNameExists = false;
    foreach ($_SESSION['prescriptionValues'] as $prescription) {
      if ($prescription['drug_name'] === $_SESSION['$drug_name']) {
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
        // hien thi chi tiet thuoc de bac si tham khao:
        $drugDetail = $new_object->getDrugDetails($drug_name);
        // echo "asdfasdffffffffffffffffffffffffffffffffff";
        foreach ($drugDetail as $row) {
          $_SESSION['min_dose'] = $row['min_dose_per_use'];
          $_SESSION['max_dose'] = $row['max_dose_per_use'];
          $_SESSION['frequency_max'] = $row['frequency_max'];
          $_SESSION['unit'] = $row['unit'];
          $_SESSION['form'] = $row['form'];
          $_SESSION['drug_id'] = $row['drug_id'];
          $_SESSION['drug_note'] = $row['dosing_guide'];
        }
        if (isset($_POST['dose'])) {
          $dose = $_POST["dose"];
          $frequency = $_POST["frequency"];
          $quantity = $_POST["quantity"];
          // Gọi hàm formulary_medication và lưu kết quả
          $resultMessage = $new_object->formulary_medication($drug_name, $dose, $frequency, $quantity);
          // Hiển thị form chi tiết và giữ nguyên các giá trị đã nhập
          if ($resultMessage == "<h5>Your prescription is ready</h5>") {
            // Hiển thị nút "Add Into Prescription"
            $_SESSION['showAddIntoPrescriptionBtn'] = true;
          }
        }
      } else {
        // Nếu không, yêu cầu người dùng nhập lại
        $resultMessage = "<h6>Drug not found. Please enter a valid drug name.</h6>";
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
  <link rel="stylesheet" href="../css/form_02.css">
  <link rel="stylesheet" href="../css/style.css">
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
  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex justify-content-between">

      <div id="logo">
        <h1><a href="">Mental Health<span>Care</span></a></h1>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="./interface.php">Home</a></li>
          <li><a class="nav-link scrollto" href="./showRecords.php">Patient Record</a></li>
          <!-- <li><a class="nav-link scrollto active" href="./form_02.php">Prescription</a></li> -->
          <li><a href="./log_out.php">Log Out</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
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
                  <input type="text" id="email" class="form-control" value="<?php echo $_SESSION['unit'] . " mg"; ?>" name="email" required>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label class="control-label" for="email">Dose: <?php echo "(" . $_SESSION['min_dose'] . "-" . $_SESSION['max_dose'] . ") " . $_SESSION['form']; ?></label>
                  <input type="number" class="form-control" value="<?php echo isset($_POST['dose']) ? $_POST['dose'] : ''; ?>" name="dose" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label class="control-label" for="pwd">Frequency: <?php echo "(max = " . $_SESSION['frequency_max'] . " times a day)" ?></label>
                  <input type="number" class="form-control" value="<?php echo isset($_POST['frequency']) ? $_POST['frequency'] : ''; ?>" name="frequency" required>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label class="control-label" for="email">Quantity:</label>
                  <input type="number" class="form-control" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>" name="quantity" required>
                </div>
              </div>
            </div>
            <input type="hidden" name="drug_name" value="<?php echo $_SESSION['$drug_name']; ?>">
            <div class="form-group">
              <div id="btn" class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Check</button>
              </div>
            </div>
          </form>
        </div>

      <?php endif; ?>
    <?php endif; ?>

    <?php if ($_SESSION['showAddIntoPrescriptionBtn']) : ?>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="drug_name" value="<?php echo $drug_name; ?>">
        <input type="hidden" name="unit" value="<?php echo $_SESSION['unit']; ?>">
        <input type="hidden" name="dose" value="<?php echo $dose; ?>">
        <input type="hidden" name="frequency" value="<?php echo $frequency; ?>">
        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
        <input type="hidden" name="drug_id" value="<?php echo $_SESSION['drug_id']; ?>">
        <input type="hidden" name="drug_note" value="<?php echo $_SESSION['drug_note']; ?>">
        <div id="btn" class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default" name="add_into_prescription">Add_Into_Prescription</button>
        </div>
      </form>
    <?php endif; ?>
    <?php if ($_SESSION['show_notes']) : ?>
      <div class="note">
        <h4>Note for Patient</h4>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <textarea name="note" id="" style="width:48vw; height:6vh;"></textarea>
          <div id="btn1" class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" value="print">Print</button>
          </div>
        </form>
      </div>
    <?php endif; ?>
    <?php if ($_SESSION['show_diagnose']) : ?>
      <!-- <div class="showDrugNameForm"> -->
      <!-- Nút "Add Another Drug" và "Done" -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label class="control-label" for="pwd">Diagnose:</label>
              <input type="text" class="form-control" value="<?php echo isset($_POST['Diagnose']) ? $_POST['Diagnose'] : ''; ?>" name="Diagnose" required>
            </div>
          </div>

          <div class="col">
            <div class="form-group">
              <label class="control-label" for="email">Treatment:</label>
              <input type="text" class="form-control" value="<?php echo isset($_POST['Treatment']) ? $_POST['Treatment'] : ''; ?>" name="Treatment" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div id="btn" class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div>
      </form>
  </div>
<?php endif; ?>
<!-- </div> -->


</body>

</html>