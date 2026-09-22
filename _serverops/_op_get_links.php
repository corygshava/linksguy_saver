<?php
    // sleep(20);
    require_once __DIR__.'/_classes/links.php';
    require_once __DIR__.'/_classes/_resutils.php';

    // sleep(6);
    $links = new Link();
    $res = $links->dftres;
    // $res['sendme'] = $links->get_all();
    $search = isset($_GET['search']) ? $_GET['search'] : null;
    $cat_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

    $link_send = $links->latest()->with('my_category')->paginate($limit);
    $res['runlog'][] = $links->mylogs;
	$_msg('all links fetched');
	$reslt = true;

	// new instance for conditionals
	$clt = (clone $links);
	$clt->use_as_is = true;

	if($cat_id){
		$link_send = $clt->where('category_id','=',$cat_id)->with('my_category')->paginate($limit);
	}

    if($search){
		// if($search){
        $sort_a = (clone $clt)->where('link','like',$search)->with('my_category')->get();
        $sort_b = (clone $clt)->where('caption','like',$search)->with('my_category')->get();
        $merger = [...$sort_a,...$sort_b];

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
        $link_send = $links->latest()->assign_data($merger, true)->paginate($limit);

        // $_rlg($links);
        // $_rlg($linkss);
    }

	$_rlg(['model' => $links]);

    $res['sendme'] = $link_send;
    $res['result'] = $reslt;
    $res['message'] = $msg;

    echo json_encode($res);
?>
