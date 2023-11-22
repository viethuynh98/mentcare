<?php

namespace App;
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
