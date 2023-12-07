<?php

use PHPUnit\Framework\TestCase;

class FormularyMedicationTest extends TestCase
{
    public function testDoseOutsideRange_min()
    {
        $execute = new App\FormularyMedication('localhost', 'root', '', 'mentcare_db');
        $result = $execute->formulary_medication("Citalopram", 1, 3, 12);
        $this->assertEquals($result, "<h5>Single dose is too low.</h5>");
    }

    public function testDoseOutsideRange_max()
    {
        $execute = new App\FormularyMedication('localhost', 'root', '', 'mentcare_db');
        $result = $execute->formulary_medication("Venlafaxine", 4, 4, 16);
        $this->assertEquals($result, "<h5>Single dose is too high.</h5>");
    }

    public function testTotalDoseOutsideRange_max()
    {
        $execute = new App\FormularyMedication('localhost', 'root', '', 'mentcare_db');
        $result = $execute->formulary_medication("Paroxetine", 3, 4, 24);
        $this->assertEquals($result, "<h5>Frequency is too high.</h5>");
    }

    public function testTotalDoseOutsideRange_min()
    {
        $execute = new App\FormularyMedication('localhost', 'root', '', 'mentcare_db');
        $result = $execute->formulary_medication("Sertraline", 2, 0, 14);
        $this->assertEquals($result, "<h5>Frequency is too low.</h5>");
    }

    public function testPrescriptionReady()
    {
        $execute = new App\FormularyMedication('localhost', 'root', '', 'mentcare_db');
        $result = $execute->formulary_medication("Antipsychotics", 4, 2, 16);
        $this->assertEquals($result, "<h5>Your prescription is ready</h5>");
    }

    // public function testPrescription($expectedResult, $actualResult) {
    //     $this->assertEquals($expectedResult, $actualResult);
    // }

    // public function prescriptionData() {
    //     $data = file('prescription_data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    //     $testCases = [];
    //     foreach ($data as $line) {
    //         list($expectedResult, $actualResult) = explode(' ', $line, 2);
    //         $testCases[] = [$expectedResult, $actualResult];
    //     }

    //     return $testCases;
    // }
}
