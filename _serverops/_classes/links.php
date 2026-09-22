<?php
	require_once __DIR__.'/_model.php';
	require_once __DIR__.'/category.php';

	class Link extends Model{
		public $fillable = [
			'caption',
			'url',
			'image_link',
			'created_at',
			'updated_at',
			'category_id',
		];

		public function __construct(){
			$this->init('links');
		}

		// relations
			// format 'relation_name' => [datalake_name, class instance, local foreign key]
			// note that nothing has place holders and should be used very well otherwise it will throw an error
			public $relations = [
				'my_category' => ['categories', Category::class, 'category_id']
			];
	}
?>
