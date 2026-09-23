<?php
    // sleep(20);
    require_once __DIR__.'/_classes/reactions.php';
    require_once __DIR__.'/_classes/_resutils.php';

    // sleep(6);
    $links = new Reaction();
    $res = $links->dftres;

	$data = file_get_contents('php://input');
	$p_data = json_decode($data, true);
	$_rlg(['post' => $_POST]);
	$_rlg(['post' => $p_data]);
	$newcat = null;

	$_msg('adding reaction');
	$we_good = !isset($p_data['type']);
	// $reslt = true;

	if($we_good){
		$_msg('invalid reaction');
	} else {
		$_msg('adding reaction');
		$typ = isset($p_data['type']) ? $p_data['type'] : 'nada';
		$loc = isset($p_data['loc']) ? $p_data['loc'] : '??';
		$rec = [
			'type' => $typ,
			'project' => $loc,
		];

		$links->add_one($p_data);

		// $newcat = $links->get_all()->latest()->first();
		$newcat = $p_data;
		$reslt = true;
		$_msg("$typ added");
	}

    $res['sendme'] = $newcat;
    $res['result'] = $reslt;
    $res['message'] = $msg;

    echo json_encode($res);
?>
