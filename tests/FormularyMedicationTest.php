<?php

use PHPUnit\Framework\TestCase;

class FormularyMedicationTest extends TestCase
{
    public function testDoseOutsideRange_min()
    {
        $execute = new App\FormularyMedication();
        $result = $execute->formulary_medication("DrugB", 1, 3);
        $this->assertEquals($result, "Single dose is too low.");
    }

    public function testDoseOutsideRange_max()
    {
        $execute = new App\FormularyMedication();
        $result = $execute->formulary_medication("DrugB", 4, 3);
        $this->assertEquals($result, "Single dose is too high.");
    }

    public function testTotalDoseOutsideRange_max()
    {
        $execute = new App\FormularyMedication();
        $result = $execute->formulary_medication("DrugC", 2, 4);
        $this->assertEquals($result, "Frequency is too high.");
    }

    public function testTotalDoseOutsideRange_min()
    {
        $execute = new App\FormularyMedication();
        $result = $execute->formulary_medication("DrugC", 2, 0);
        $this->assertEquals($result, "Frequency is too low.");
    }

    public function testPrescriptionReady()
    {
        $execute = new App\FormularyMedication();
        $result = $execute->formulary_medication("DrugE", 2, 2);
        $this->assertEquals($result, "Your prescription is ready");
    }
}
