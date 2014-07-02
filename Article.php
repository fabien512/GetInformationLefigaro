<?php

class Article {
		private $_title;
		private	 $_extract;
		private $_author;
		private $_date;
		private $_url;
		
	function __construct($_title,$_extract, $_author, $_date, $_url ) {
		$this->title = $_title;
		$this->extract = $_extract;
		$this->author = $_author;
		$this->date = $_date;
		$this->url = $_url;	
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getExtract() {
		return $this->extract;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function setTitle($_title) {
		$this->title = $_title; 
	}
	
	public function setExtract($_extract) {
		$this->extract = $_extract;
	}
	
	public function setAuthor($_author) {
		$this->author = $_author;
	}
	
	public function setDate($_date) {
		$this->date = $_date;
	}
	
	public function setUrl($_url) {
		$this->url = $_url;
	}
}

?>
