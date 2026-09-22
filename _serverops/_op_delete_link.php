<?php
    // sleep(20);
    require_once __DIR__.'/_classes/links.php';
    require_once __DIR__.'/_classes/_resutils.php';

    // sleep(6);
    $links = new Link();
    $res = $links->dftres;

	$data = file_get_contents('php://input');
	$p_data = json_decode($data, true);
	$_rlg(['post' => $_POST]);
	$_rlg(['post_file' => $p_data]);
	$newcat = null;

	$_msg('editing link');
	$_msg('checking availability');

	$cats = (clone $links)->where('id','=',$p_data['id'])->get();
	$is_taken = count($cats) > 0;
	// $is_taken = false;
	// $reslt = true;

	if(!$is_taken){
		$_msg('link not found');
	} else {
		$_msg('deleting link');
		$links->where('id','=',$p_data['id'])->delete();

		// $newcat = $links->get_all()->latest()->first();
		$newcat = $p_data;
		$reslt = true;
		$_msg('link edited successfully');
	}

    $res['sendme'] = $newcat;
    $res['result'] = $reslt;
    $res['message'] = $msg;

    echo json_encode($res);
?>
