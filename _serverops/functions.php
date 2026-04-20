<?php

	require_once __DIR__.'/../_packages/loader.php';

	function update_json($path,$value=null,$unique = false){
		$fl = new fl_();

		// create json if it doesnt exist
		$fl::c_file($path);

		// read json
		$json = $fl->saferead($path,true,12);
		$json = $json == '' ? '[]' : $json;

		// update stuff (assumes its a list)
		$data = json_decode($json);

		if($unique){
			if(in_array($value,$data)){
				return false;
			}
		}
		$data[] = $value;

		// save to likes.json
		$res = $fl::safewrite_txt($path,json_encode($data, JSON_PRETTY_PRINT),true,12);
	}