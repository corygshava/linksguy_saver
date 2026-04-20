<?php
	if($_SERVER['REQUEST_METHOD'] !== 'POST'){
		$err = json_encode(['error' => 'invalid request method']);
		die($err);
	}
	
	require_once __DIR__.'/functions.php';
	$likespath = __DIR__.'/../_datazone/likes.json';
	
	$fl = new fl_();
	$dta = file_get_contents('php://input');
	$p = "?";
	
	if($dta == ''){
		$c = null;
	} else {
		$j = json_decode($dta,true);
		$c = $j['islike'] ?? null;
		$p = $j['page'] ?? '??';
	}

	// echo "found input: ".$dta."\n";
	// echo json_encode($c)."\n";

    $timest = date('d-m-y h:i:s');
	$act = $c === null ? 'like_erred' : ($c ? 'liked' : 'disliked');
	$logstring = "[{$timest}] -> [$p] page $act";
	$logpath = __DIR__.'/../_datazone/likeslog.json';
	// echo "$act";
	
    $rss = update_json($logpath,$logstring);
	// echo "logged like\n";
	
	// create likes.json if it doesnt exist
	$fl::c_file($likespath);
	
	// read likes.json
	$json = $fl::saferead($likespath,true,12);
	
	// update stuff
	$data = $json == '' ? [] : json_decode($json,true);
	
	$curlikes = $data['likes'] ?? 0;
	$curdislikes = $data['dislikes'] ?? 0;
	$curunks = $data['unknowns'] ?? 0;
	// echo "data parsed\n";
	
	if(empty($data)){
		$ndata = [
			"likes" => 0,
			"dislikes" => 0,
			"unknowns" => 0,
		];
		// echo "data is empty\n";
	} else {
		// echo "data is not empty\n";
		$ndata = [
			"likes" => $curlikes + ($c && $c != null ? 1 : 0),
			"dislikes" => $curdislikes + (!$c && $c != null ? 1 : 0),
			"unknowns" => $curunks + ($c === null ? 1 : 0),
		];
	}

	// save to likes.json
	$data = $ndata;
	$mareply = [
		"success" => true,
		"result" => true,
		"message" => $act.' saved successfully',
		"data" => $data,
	];

	// echo json_encode($mareply);

	$fl::safe_write_text($likespath,json_encode($data,JSON_PRETTY_PRINT),true,12);
	echo json_encode($mareply);
?>