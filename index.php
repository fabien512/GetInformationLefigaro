	<?php

	require_once("LeFigaroConnector.php");
	require_once("Article.php");
	
	/**
	 * Load a test function with a specified day (or specified month) and a keyword. Export the result as .xml file
	 * 
	 * */
	 

	function test() {
		$connector = new LeFigaroConnector(01,03,2013,'france');
		//$appel = $connector->loadArticles();
		$appel= $connector->loadMonthArticles();
		$connector->exportXml("articles");
		//echo $appel;
		// }
	}

	test();

	?>
