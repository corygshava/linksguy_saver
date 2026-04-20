<?php
    require_once __DIR__.'/functions.php';

    $res = '??';
    $in = file_get_contents('php://input');
    $input = $in == '' ? [] : json_decode($in,true);

    if(isset($_GET['res']) || isset($_POST['res']) || isset($input['res'])){
        $res = $_GET['res'] ?? ($_POST['res'] ?? $input['res']);
    }

    $timest = date('d-m-y h:i:s');
    $resource = $res;
    $logstring = "[{$timest}] -> user accessed: $resource";
    $path = __DIR__.'/../_datazone/visits.json';

    $rss = update_json($path,$logstring);

    if(!$rss){
        $ww = ["result" => "successfully failed"];
    } else {
        $ww = ["result" => "wirked"];
    }

    echo json_encode($ww);
?>