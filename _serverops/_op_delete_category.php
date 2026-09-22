<?php
    // sleep(20);
    require_once __DIR__.'/_classes/category.php';
    require_once __DIR__.'/_classes/links.php';
    require_once __DIR__.'/_classes/_resutils.php';

    // sleep(6);
    $cats = new Category();
    $res = $cats->dftres;

	$data = file_get_contents('php://input');
	$p_data = json_decode($data, true);
	$_rlg(['post' => $_POST]);
	$_rlg(['post_file' => $p_data]);
	$newcat = null;

	$_msg('editing category');
	$_msg('checking availability');

	$f_cats = (clone $cats)->where('id','=',$p_data['id'])->get();
	$is_taken = count($f_cats) > 0;
	// $is_taken = false;
	// $reslt = true;

	if(!$is_taken){
		$_msg('category not found');
	} else {
		$_msg('deleting category');

		$c_id = $p_data['id'];
		$links = new Link();
		$links->use_as_is = true;
		$updates = $links->where('category_id','=',$c_id)->update(['category_id' => 0]);

		$cats->where('id','=',$p_data['id'])->delete();

		// $newcat = $cats->get_all()->latest()->first();
		$newcat = $p_data;
		$reslt = true;
		$_msg('category edited successfully');
	}

    $res['sendme'] = $newcat;
    $res['result'] = $reslt;
    $res['message'] = $msg;

    echo json_encode($res);
?>
