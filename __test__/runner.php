<?php
class TestRunner {
	private $totalTest = 0;
	private $pass = 0;

	function testInfo($expected, $result){
		$this->totalTest++;
		$this->hoiEcho("Running... Test No. $this->totalTest");

		if($result == $expected){
			$this->pass++;
		}else{
			$this->hoiEcho("Fail at $this->totalTest");
		}
	}
	
	function summary(){
		$this->hoiEcho("Summary pass/total: $this->pass/$this->totalTest");
	}

	function hoiEcho($msg){
		$lineFeed = PHP_EOL;
		if(is_bool($msg)){
			$msg = $msg ? "TRUE" : "FALSE";
		}
		echo "$msg$lineFeed";
	}
}