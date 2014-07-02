	<?php

	require_once("LeFigaroConnector.php");
	require_once("Article.php");

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
