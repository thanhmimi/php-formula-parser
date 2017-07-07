<?php
require_once "../formula-parser.php";
require_once "../calculator.php";
require_once "./runner.php";
/**
 * Test setup
 */
// Fake some variable
$totalVoid           = 10;
$totalWithVoid       = 12;
$totalDiscount       = 13;
$totalAdjustment     = 14;
$totalGSTWithoutVoid = 15;
// calculator
$c = new Calculator;
// test runner
$r = new TestRunner;


/**
 * Basic test
 */
$formula = "TOTAL_VOID - TOTAL_DISCOUNT";
$expected  = 0;

$fp = new FormulaParser($formula, ["GST"]);
foreach($fp->variables() as $variable){
    $camelVar = $fp->camelCase($variable);
    $formula  = str_replace($variable, $$camelVar, $formula);
}

$result  = $c->calculate($formula);
$r->testInfo($expected, $result);


/**
 * V1
 */
$formula  = "TOTAL_VOID - TOTAL_WITH_VOID * (TOTAL_DISCOUNT - TOTAL_GST_WITHOUT_VOID )";
$expected = $totalVoid - $totalWithVoid * ($totalDiscount - $totalGSTWithoutVoid);

$fp = new FormulaParser($formula, ["GST"]);
foreach($fp->variables() as $variable){
    $camelVar = $fp->camelCase($variable);
    $formula  = str_replace($variable, $$camelVar, $formula);
}

$result  = $c->calculate($formula);
$r->testInfo($expected, $result);





// Summary test
$r->summary();
