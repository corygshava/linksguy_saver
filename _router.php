<?php
	// echo json_encode(['response' => "wot"]);
	// exit();

	if(!isset($_GET['rt'])){
		$res = ['error' => "invalid request"];
		exit();
	}

	$rt = $_GET['rt'];
	$fyl = __DIR__."/_datazone/$rt.json";
	$cont = $_GET;
	$isui = isset($_GET['isui']) ? $_GET['isui'] == 'true' : false;
	$isop = isset($_GET['isop']) ? $_GET['isop'] == 'true' : false;
	$isapi = isset($_GET['isapi']) ? $_GET['isapi'] == 'true' : false;
	$isdataop = isset($_GET['isdataop']) ? $_GET['isdataop'] == 'true' : false;
	$err = [];

	if($isui){
		$fyl = __DIR__."/pieces/{$rt}.php";

		if(is_file($fyl)){
			require_once $fyl;
		} else {
			$msg = "template <b class=\"themetxt\">$rt</b> not found";
			require_once __DIR__."/pieces/_error.php";
		}
		exit();
	}

	if($isop){
		$fyl = __DIR__."/_serverops/_op_{$rt}.php";
	}

	if($isapi){
		$fyl = __DIR__."/_serverops/_api_{$rt}.php";
	}

	if($isdataop){
		// echo 'made it to dataops selector';
		$fyl = __DIR__."/_serverops/_dataop_{$rt}.php";
	}

	$err[] = ['path' => $fyl];

	if(is_file($fyl)){
		$err[] = 'file found';

		if($isop || $isapi || $isdataop){
			require_once $fyl;
			exit();
		} else {
			$cont = json_decode(file_get_contents($fyl),true);
		}
	} else {
		$err[] = 'file not found';
		http_response_code(404);
		$cont = [
			"message" => "item not found",
			// "path" => $fyl,
		];
	}

	// $err[] = ['cont' => $cont];
	$err = ['cont' => $cont];
	echo json_encode($err, JSON_PRETTY_PRINT);
	exit();
?>
