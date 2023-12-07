<?php
include('FormularyMedication.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input = $_POST["input"];

  // Tạo đối tượng FormularyMedication_DB_Test
  $new_object = new \App\FormularyMedication('localhost', 'root', '', 'mentcare_db');

  // Lấy danh sách gợi ý từ cơ sở dữ liệu
  $suggestions = $new_object->getDrugSuggestions($input);

  // Hiển thị danh sách gợi ý
  foreach ($suggestions as $suggestion) {
    echo "<div class='suggestion'>$suggestion</div>";
  }
}
?>
