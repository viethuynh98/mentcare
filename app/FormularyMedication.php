<?php

namespace App;

class FormularyMedication_DB_Test
{
    private $db;

    public function __construct($host, $username, $password, $database)
    {
        // Kết nối đến cơ sở dữ liệu
        try {
            $this->db = new \PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function db_connection($host, $username, $password, $database)
    {
        // Kết nối đến cơ sở dữ liệu
        try {
            $this->db = new \PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function checkDrugExistence($drug_name)
    {
        $stmt = $this->db->prepare("SELECT name FROM drug WHERE name = ?");
        $stmt->execute([$drug_name]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    public function getDrugSuggestions($input)
    {
        $stmt = $this->db->prepare("SELECT name FROM drug WHERE name LIKE :input LIMIT 5");
        $stmt->execute([':input' => "$input%"]);
        $suggestions = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        return $suggestions;
    }

    public function getDrugDetails($drug_name)
    {
        $stmt = $this->db->prepare("SELECT * FROM drug WHERE name LIKE :drug_name");
        $stmt->execute([':drug_name' => "$drug_name"]);
        // $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getPrescriptionDetails($mh_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM prescription_detail JOIN drug on drug.drug_id = prescription_detail.drug_id WHERE prescription_id in (SELECT prescription_id FROM prescription WHERE mh_id = :mh_id)");
        $stmt->execute([':mh_id' => "$mh_id"]);
        // $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getPatientRecords($patient_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM medicalhistory WHERE patient_id = :patient_id");
        $stmt->execute([':patient_id' => "$patient_id"]);
        // $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getStaffID($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email_address = :email");
        $stmt->execute([':email' => "$email"]);
        // $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $result = $stmt->fetchAll();

        return $result;
    }

    // 
    public function showPatientRecords()
    {
        $stmt = $this->db->prepare("SELECT * FROM medicalhistory");
        $stmt->execute();
        // $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $result = $stmt->fetchAll();

        return $result;
    }
    //

    public function get_mh_detail($mh_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM medicalhistory WHERE mh_id = :mh_id");
        $stmt->execute([':mh_id' => "$mh_id"]);
        // $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $result = $stmt->fetchAll();

        return $result;
    }


    public static function showPrescriptionDetails($prescriptions)
    {
        echo '<table>';
        echo '<th>Drug Name</th>';
        echo '<th>Unit</th>';
        echo '<th>Dose</th>';
        echo '<th>Frequency</th>';
        echo '<th>Quantity</th>';
        echo '<th>Delete</th>';
        foreach ($prescriptions as $index => $prescription) {
            echo '<tr>';
            echo '<td>' . $prescription['drug_name'] . '</td>';
            echo '<td>' . $prescription['unit'] . '</td>';
            echo '<td>' . $prescription['dose'] . '</td>';
            echo '<td>' . $prescription['frequency'] . '</td>';
            echo '<td>' . $prescription['quantity'] . '</td>';
            echo '<td>';
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            echo '<input type="hidden" name="index" value="' . $index . '">';
            // echo '<input type="submit" name="delete" value="Delete">';
            echo '<button class = "delete" type="submit" name="delete" value="Delete">Delete</button>';
            // <button type="submit" class="btn btn-default" value="add_another_drug">Add</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    public static function showPrescriptionDetails_02($prescriptions)
    {
        echo '<table>';
        echo '<th>Drug Name</th>';
        echo '<th>Unit</th>';
        echo '<th>Dose</th>';
        echo '<th>Frequency</th>';
        echo '<th>Quantity</th>';
        foreach ($prescriptions as $index => $prescription) {
            echo '<tr>';
            echo '<td>' . $prescription['drug_name'] . '</td>';
            echo '<td>' . $prescription['unit'] . '</td>';
            echo '<td>' . $prescription['dose'] . '</td>';
            echo '<td>' . $prescription['frequency'] . '</td>';
            echo '<td>' . $prescription['quantity'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    public function insert_into_db($pt_id, $dr_id, $diagnose, $treatment, $note, $prescriptions)
    {
        $currentDate = date("Y-m-d H:i:s");
        $stmt = $this->db->prepare(
            "INSERT INTO medicalHistory (`visit_date`, `diagnose`, `treatment`, `patient_id`, `staff_id`)
            VALUES ('$currentDate', '$diagnose', '$treatment', '$pt_id', '$dr_id');
        "
        );
        $stmt->execute();
        $stmt = $this->db->prepare(
            "INSERT INTO prescription (`mh_id`, `note`)
             VALUES (LAST_INSERT_ID(), '$note');
        "
        );
        $stmt->execute();
        foreach ($prescriptions as $index => $prescription) {
            $stmt = $this->db->prepare(
                "INSERT INTO prescription_detail(dose, frequency, quantity, note, drug_id, prescription_id)
                VALUES (:dose, :frequency, :quantity, :note, :drug_id, LAST_INSERT_ID())"
            );

            // Bind các giá trị từ mảng $prescription vào statement
            $stmt->bindParam(':dose', $prescription['dose']);
            $stmt->bindParam(':frequency', $prescription['frequency']);
            $stmt->bindParam(':quantity', $prescription['quantity']);
            $stmt->bindParam(':note', $prescription['note']);
            $stmt->bindParam(':drug_id', $prescription['drug_id']);

            // Thực thi câu lệnh SQL
            $stmt->execute();
        }
        // return $result;
    }

    public static function check_integer_value($value)
    {
        if (is_int($value)) {
            return true;
        } else {
            return false;
        }
    }

    public static function check_quantity($quantity, $dose_per_day)
    {
        if (($quantity % $dose_per_day) != 0) {
            return false;
        } else {
            return true;
        }
    }

    public function formulary_medication($drug_name, $dose, $frequency, $quantity)
    {
        // Lấy thông tin từ cơ sở dữ liệu
        $stmt = $this->db->prepare("SELECT min_dose_per_use, max_dose_per_use, frequency_max FROM drug WHERE name = ?");
        $stmt->execute([$drug_name]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            // Lấy thông tin từ kết quả truy vấn
            $min_dose = $row['min_dose_per_use'];
            $max_dose = $row['max_dose_per_use'];
            $frequency_max = $row['frequency_max'];

            $total_dose = $dose * $frequency;
            $max_dose_per_day = $max_dose * $frequency_max;

            if ($dose < $min_dose) {
                return "<h5>Single dose is too low.</h5>";
            }
            if ($dose > $max_dose) {
                return "<h5>Single dose is too high.</h5>";
            }
            if ($frequency <= 0) {
                return "<h5>Frequency is too low.</h5>";
            }
            if ($frequency > $frequency_max) {
                return "<h5>Frequency is too high.</h5>";
            }
            if (!FormularyMedication_DB_Test::check_quantity($quantity, $total_dose)) {
                return "<h5>Please enter the appropriate medicine quantity.</h5>";
            }
            // không cần thiết:
            if ($total_dose > $max_dose_per_day) {
                return 'Total dose is too high';
            }
            return "<h5>Your prescription is ready</h5>";
        }
    }
}


class FormularyMedication
{
    private $formulary;

    public function __construct()
    {
        // dose_min - dose_max - frequency_max - stock
        $this->formulary = array(
            "DrugA" => array(1, 3, 3, 500),
            "DrugB" => array(2, 3, 3, 700),
            "DrugC" => array(1, 3, 3, 980),
            "DrugD" => array(2, 3, 3, 1200),
            "DrugE" => array(2, 3, 3, 1500),
            "DrugF" => array(1, 3, 3, 0),
        );
    }

    public function formulary_medication($drug_name, $dose, $frequency)
    {
        if (array_key_exists($drug_name, $this->formulary)) {
            list($min_dose, $max_dose, $frequency_max_per_day) = $this->formulary[$drug_name];
            $max_dose_per_day = $max_dose * $frequency_max_per_day;
            $dose_per_day = $dose * $frequency;
            if ($dose < $min_dose) {
                return "Single dose is too low.";
            }
            if ($dose > $max_dose) {
                return "Single dose is too high.";
            }
            // if ($quantity > $stock)
            if ($frequency <= 0) {
                return "Frequency is too low.";
            }
            if ($frequency > $frequency_max_per_day) {
                return "Frequency is too high.";
            }
            // không cần thiết:
            if ($dose_per_day > $max_dose_per_day) {
                return 'Total dose is too high';
            }
            return "Your prescription is ready";
        }
    }
}


$new_object = new FormularyMedication_DB_Test('localhost', 'root', '', 'mentcare_db');
// $new_object->db_connection();
