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
        $stmt->execute([':input' => "%$input%"]);
        $suggestions = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        return $suggestions;
    }


    public function formulary_medication($drug_name, $dose, $frequency)
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
            // $max_treatment_days = $row['max_treatment_days'];
            // $stock = $row['stock'];

            $total_dose = $dose * $frequency;
            $max_dose_per_day = $max_dose * $frequency_max;

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
            if ($frequency > $frequency_max) {
                return "Frequency is too high.";
            }
            // không cần thiết:
            if ($total_dose > $max_dose_per_day) {
                return 'Total dose is too high';
            }
            return "Your prescription is ready";
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
