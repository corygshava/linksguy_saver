<?php
	/**
	 * @author  Cornelius Shava
	 * @version 1.0, 2025-10-30 15:25:16
	 * @copyright (c) 2026 Coryg Productions
	 * 
	 * LastUpdate : 2026-01-06 13:17
	 * Email : itscorygproductions+qasavacoderdr@gmail.com
	 * File : loader.php
	 * 
	 * @description
	 *      So this is a loader for my packages, made such tht you dont just import everything but what you need
	 * @issues
	 *      none so far since its basically just a loader
	 * 
	*/

	require_once __DIR__.'/_includes/utils.php';

	class maloader{
		public static $allstuff = [
			"fileops" => __DIR__.'/fileops/main.php',
			"meklog" => __DIR__.'/_includes/meklog.php',
		];

		public static function load_package($pkg,$classname=null,&$instance=null){
			$exists = in_array($pkg,array_keys(self::$allstuff));

			if(!$exists){
				say('get fucked coz i aint got the goods');
				return false;
			}

			$pkgfile = $exists ? self::$allstuff[$pkg] : '';

			$classname = $classname == null ? $pkg : $classname;

			if(!file_exists($pkgfile)){
				say('>> the model doesnt seem to exist',"loadpackages");
			}

			if(!is_readable($pkgfile)){
				say('>> the model file is unreadable, check its permissions',"loadpackages");
			}

			require_once $pkgfile;
			say_silent("package loaded : ($pkg)","loadpackages");

			if($instance != null){
				if(class_exists($classname)){
					$instance = new $classname();
				} else {
					say(">> invalid classname given","loadpackages");
				}
			}
		}
	}
?>