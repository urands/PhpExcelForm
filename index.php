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
?><!DOCTYPE html><html>
<head>
	<meta charset="utf-8">
	<title>PhpExcelForm</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script src="https://yastatic.net/jquery/3.1.1/jquery.min.js"></script>	
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>	

	<style type="text/css" media="screen">
		

	</style>
</head>
<body>

 <div class="container"> 
 	<div class="navbar-header"> 
 		<button aria-controls="bs-navbar" aria-expanded="false" class="collapsed navbar-toggle" data-target="#bs-navbar" data-toggle="collapse" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> <a href="../" class="navbar-brand">Finmodel</a> 
 	</div>
 	<nav class="collapse navbar-collapse" > 
 		<ul class="nav navbar-nav"> 
 			<li> <a href="../getting-started/">Модель</a> </li> 

 		</ul> 
 		<ul class="nav navbar-nav navbar-right"> 
 			<li><a href="http://themes.getbootstrap.com" onclick="ga(&quot;send&quot;,&quot;event&quot;,&quot;Navbar&quot;,&quot;Community links&quot;,&quot;Themes&quot;)">Логин</a></li> 
 		</ul> 
 	</nav> 
 </div> 
	


<div class="container">
<div class="row">
<div class="col-md-12"><div class="bs-example">
<?php
	//$test->testJsonTemplate(__DIR__.'/tests/data/JsonTemplate');

	$test->testSample(__DIR__.'/tests/data/finmodel/');


?>
</div>
</div><div class="col-md-12">Right</div>
</div>
</div>
</body>
</html>
