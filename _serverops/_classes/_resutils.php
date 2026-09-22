<?php
    $msg = "";
    $res = !isset($res) ? ['runlog' => []] : $res;
	$reslt = false;

    $update_runlog = function($wot) use (&$res){
        $res['runlog'][] = $wot;
    };
    $update_msg = function($wot,$logit = true) use (&$msg,&$update_runlog){
        $msg = $wot;
        if($logit){
            $update_runlog($wot);
        }
    };
    $_msg = function($w,$l = true) use (&$update_msg){
        $update_msg($w,$l);
    };
    $_rlg = function($w) use (&$update_runlog){
        $update_runlog($w);
    };
?>
