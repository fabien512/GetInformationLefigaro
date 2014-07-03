<?php

class LeFigaroConnector {
	private $day;
	private $month;
	private	$year;
	private	$	keyword;
	public $tableOfArticles = array();
	
/**

* @param string $day for title newpspaper name
* @param string $month for header newpspaper file
* @param string $year for title newpspaper name
* @param string $keyword to apply for the research
*/
	function __construct($_day, $_month,$_year,$_keyword) {
		$this->day = $_day;
		$this->month = $_month;
		$this->year = $_year;
		$this->keyword = $_keyword;
	}
	
	public function getTableOfArticles(){
		return $this->tableOfArticles;
    }
	
	/**
Load articles with the specified keyword
*/
	public function loadArticles($limitinf = null, $limitsupp = null) {
		if ($this->day > 31 || $this->day < 1 || $this->year < 1944) {
		exit("Bad parameters");
		} else {
		$i=1;
		$url= 'http://recherche.lefigaro.fr/recherche/recherche.php?ecrivez='.$this->keyword.'&page=articles&date='.$this->year.'-'.$this->month.'-'.$this->day.'&typedate=dateprecise&next='.$i;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$resultat = curl_exec ($ch);
		curl_close($ch);
		libxml_use_internal_errors(true);
		$page = new DOMDocument();
		$page->loadHTML($resultat);
		

$finder = new DomXPath($page);
$classname="hfeed";
$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
$articles =  $nodes->length;

$metas = $page->getElementsByTagName('meta');
				$limitsupp = 0;
				for ($x = 0; $x < $metas->length; $x++)
				{
					$meta = $metas->item($x);
					if($meta->getAttribute('name') == 'totalResults')
						$limitsupp = $meta->getAttribute('content');
				}
	
		$limitinf = 0;
		
			while($articles>0 &&  $i > $limitinf && $i < intval($limitsupp))  {	
			
				$url= 'http://recherche.lefigaro.fr/recherche/recherche.php?ecrivez='.$this->keyword.'&page=articles&date='.$this->year.'-'.$this->month.'-'.$this->day.'&typedate=dateprecise&next='.$i;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$resultat = curl_exec ($ch);
				curl_close($ch);

				libxml_use_internal_errors(true);
				$page = new DOMDocument();
				$page->loadHTML($resultat);
				
				

				$finder = new DomXPath($page);
$classname="hfeed";
$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
				foreach($nodes as $article){
				
					 $titre = utf8_decode($article->getElementsByTagName('h3')->item(0)->nodeValue);
					$body_elements = $article->getElementsByTagName('p');
					$counter = 0;
					foreach($body_elements as $element){
					
					//summary
					if ($counter == 1) {
						$body = utf8_decode($element->nodeValue);
					} else if ($counter == 0) {
					$chaine1 = substr($element->nodeValue,strpos($element->nodeValue,'Créé le '));
					$chaine2 = substr($chaine1,strpos($chaine1,' le ')+3);
					$date = substr($chaine2,1,strpos($chaine2,'à')-1);
						}
						
					$counter++;
					
					}
					
					
					$myarticle = new Article($titre,$body,null,$date,null);
					$this->tableOfArticles[] =  $myarticle;
				}
				$i = $i + 20;
		}
		return count($this->tableOfArticles);
		}
	
	}
	
		/**
Load one month of articles
*/
	public function loadMonthArticles($limitinf = null, $limitsupp = null) {
	if ($this->year < 1944) {
		exit("Bad parameters");
		} else {
		 for ($j=1;$j<32;$j++) {
			$this->day = $j;
			$i=1;
			$url= 'http://recherche.lefigaro.fr/recherche/recherche.php?ecrivez='.$this->keyword.'&page=articles&date='.$this->year.'-'.$this->month.'-'.$this->day.'&typedate=dateprecise&next='.$i;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$resultat = curl_exec ($ch);
			curl_close($ch);
			libxml_use_internal_errors(true);
			$page = new DOMDocument();
			$page->loadHTML($resultat);
			

			$finder = new DomXPath($page);
			$classname="hfeed";
			$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
			$articles =  $nodes->length;

			$metas = $page->getElementsByTagName('meta');
			$limitsupp = 0;
			for ($x = 0; $x < $metas->length; $x++) {
				$meta = $metas->item($x);
				if($meta->getAttribute('name') == 'totalResults')
					$limitsupp = $meta->getAttribute('content');
			}
	
			$limitinf = 0;
		
			while($articles>0 &&  $i > $limitinf && $i < intval($limitsupp))  {	
			
				$url= 'http://recherche.lefigaro.fr/recherche/recherche.php?ecrivez='.$this->keyword.'&page=articles&date='.$this->year.'-'.$this->month.'-'.$this->day.'&typedate=dateprecise&next='.$i;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$resultat = curl_exec ($ch);
				curl_close($ch);

				libxml_use_internal_errors(true);
				$page = new DOMDocument();
				$page->loadHTML($resultat);
				
				

				$finder = new DomXPath($page);
				$classname="hfeed";
				$nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
				foreach($nodes as $article){
				
					 $titre = utf8_decode($article->getElementsByTagName('h3')->item(0)->nodeValue);
					$body_elements = $article->getElementsByTagName('p');
					$counter = 0;
					foreach($body_elements as $element){
					
					//summary
					if ($counter == 1) {
						$body = utf8_decode($element->nodeValue);
					} else if ($counter == 0) {
					$chaine1 = substr($element->nodeValue,strpos($element->nodeValue,'Créé le '));
					$chaine2 = substr($chaine1,strpos($chaine1,' le ')+3);
					$date = substr($chaine2,1,strpos($chaine2,'à')-1);
						}
						
					$counter++;
					
					}
					
					
					$myarticle = new Article($titre,$body,null,$date,null);
					$this->tableOfArticles[] =  $myarticle;
				}
				$i = $i + 20;
		}
		 }
		echo $this->day;
		return count($this->tableOfArticles);
		
		
		}
	}
	
	/**
	 * Export the file as a .xml file
	 * 
	 * */
	 
	function exportXml($fichier) {

		header("Content-Type: text/plain");
		header("Content-disposition: filename=".$fichier.".xml");
		// create doctype
		$dom = new DOMDocument("1.0");

		// display document in browser as plain text 
		// for readability purposes
		
		// create root element

		$root = $dom->createElement("articles");
		$dom->appendChild($root);
		foreach($this->tableOfArticles as $table) {
		// create child element
			$article = $dom->createElement("article");
			$root->appendChild($article);
			$title = $dom->createElement("title");
			$titleTrim = ltrim($table->title);
			$text = $dom->createCDATASection(rtrim($titleTrim));
			$title->appendChild($text);
			$article->appendChild($title);
			
			$date = $dom->createElement("date");
			$dateTrim = ltrim($table->date);
			$text = $dom->createTextNode(rtrim($dateTrim));
			$date->appendChild($text);
			$article->appendChild($date);
			
			$author = $dom->createElement("author");
			$text = $dom->createTextNode($table->author);
			$author->appendChild($text);
			$article->appendChild($author);
			
			$extract = $dom->createElement("extract");
			$extractTrim = ltrim($table->extract);
			$text = $dom->createCDATASection(rtrim($extractTrim));
			$extract->appendChild($text);
			$article->appendChild($extract);	
		}
		$order = $dom->save($fichier.".xml");
		echo ("The file has been created in the current directory");
		


	}

}


