<?php
    require_once __DIR__.'/functions.php';

    // echo 'wot';

    $ww = [];
    $res = '??';
    $in = file_get_contents('php://input');
    $input = $in == '' ? [] : json_decode($in,true);

    $ww[] = "loaded functions and passed data";

    if(isset($_GET['where']) || isset($_POST['where']) || isset($input['where'])){
        $res = $_GET['where'] ?? ($_POST['where'] ?? $input['where']);
    }

    $ww[] = ['res' => $res];

    $timest = date('d-m-y h:i:s');
    $resource = $res;
    $logstring = "[{$timest}] -> user accessed: $resource";
    $path = __DIR__.'/../_datazone/visits_2.json';

    $rss = update_json($path,$logstring);
    $ww[] = ['rss_result' => $rss];

    if(!$rss){
        $ww["result"] = "successfully failed";
    } else {
        $ww["result"] = "wirked";
    }

    echo json_encode($ww,JSON_PRETTY_PRINT);
?>