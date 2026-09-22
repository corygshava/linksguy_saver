<?php
	require_once __DIR__.'/_model.php';

	class Category extends Model{
		public $fillable = [
			'caption',
			'url',
			'image_link',
			'created_at',
			'updated_at',
			'category_id',
		];

		public function __construct(){
			$this->init('categories');
		}

		public function links(){
			return null;
		}
	}
?>
