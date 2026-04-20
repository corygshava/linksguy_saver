<?php
	$hideechos = false;				// show echoes made by say()
	// $hideechos = true;			// comment this line to always show echos
	$mekecholog = true;				// keep a list of echoes called by say()
	$echolog = array();				// list of echoes

	// to be used for debug texts
	function say($what='nothing',$actor=''){
		global $hideechos;

		if (is_array($what) || is_object($what)) {
			$what = json_encode($what);
		}

		$echotext = $actor === '' ? "$what<br>" : "[$actor] -> $what<br>";
		$echotext = $echotext."\n";

		if($hideechos === false){
			echo $echotext;
		}

		global $mekecholog;
		if($mekecholog){
			global $echolog;
			array_push($echolog,$echotext);
		}
	}

	function say_silent($what='nothing',$actor="nobody"){
		global $mekecholog;

		if (is_array($what) || is_object($what)) {
			$what = json_encode($what);
		}

		$echotext = $actor === '' ? "$what<br>" : "[$actor] -> $what<br>";
		$echotext = $echotext."\n";

		if($mekecholog){
			global $echolog;
			array_push($echolog,$echotext);
		}
	}

	// prefered for html
	function writeme($what='',$actor='',$mydata=null){
		$what = $what !== '' ? $what : announce();

		$echotext = $actor === '' ? "$what" : "[$actor] -> $what<br>";
		echo $echotext.".m";

		global $mekecholog;
		if($mekecholog){
			global $echolog;
			array_push($echolog,$echotext);
		}
	}

	function announce($value='testing'){
		return "<div class=\"said\">$value</div>";
	}

	function mekresponse($msg,$state=false){
		return [
			"success" => $state,
			"result" => $msg,
			"message" => $msg
		];
	}
?>