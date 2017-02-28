<?php

	require_once __DIR__ . '/tests/bootstrap.php';



	use PhpExcelForm\PhpExcelFormTests\SampleTest;

	$helper = new \PhpOffice\PhpSpreadsheet\Helper\Sample();
	if (!defined('EOL')) {
	    define('EOL', $helper->isCli() ? PHP_EOL : '<br />');
	}

	// Return to the caller script when runs by CLI
	if ($helper->isCli()) {
	    return;
	}



	$test = new SampleTest();



	//$test->testJsonTemplate(__DIR__.'/tests/data/JsonTemplate');

	$test->testSample(__DIR__.'/tests/data/SampleTest');