<?php
	require_once __DIR__.'/_model.php';

	class Reaction extends Model{
		public $fillable = [
			'type',
		];

		public function __construct(){
			$this->init('reactions');
		}
	}
?>
