<?php
	require_once __DIR__.'/_model.php';

	class Link extends Model{
		public function __construct(){
			$this->init('links');
		}
	}
?>