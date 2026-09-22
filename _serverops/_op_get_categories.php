<?php
    // sleep(20);
    require_once __DIR__.'/_classes/category.php';
    require_once __DIR__.'/_classes/_resutils.php';

    // sleep(6);
    $links = new Category();
    $res = $links->dftres;
    $res['sendme'] = $links->get_all();

    $cats_send = $links->get();
    $res['runlog'][] = $links->mylogs;
    $search = isset($_GET['search']) ? $_GET['search'] : null;
	$_msg('gotten all categories');
	$reslt = true;

    if($search && false){
	// if($search){
        $clt = new Link();
        // $sort_a = (clone $clt)->where('client_contact','like',$search)->get();
        // $sort_b = (clone $clt)->where('client_name','like',$search)->get();
        // $merger = [...$sort_a,...$sort_b];

        $_rlg("merging the data");

		/*
        $_rlg([
            'sort_a' => $sort_a,
            'sort_b' => $sort_b,
            'merged' => $merger,
            'client data' => $links->data,
            'test_condition' => [] == null,
        ]);
		// */

        // $update_runlog();
        // $linkss = $links->latest()->assign_data($merger)->paginate();

        // $_rlg($links);
        // $_rlg($linkss);
    }

    $res['sendme'] = $cats_send;
    $res['result'] = $reslt;
    $res['message'] = $msg;

    echo json_encode($res);
?>
