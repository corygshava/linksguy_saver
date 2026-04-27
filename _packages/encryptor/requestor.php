<?php
	header("Content-Type: application/json");

	// Allow only POST requests
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	    http_response_code(405); // Method Not Allowed
	    echo json_encode(["error" => "Only POST method is allowed"]);
	    exit;
	}

	// try{
		// Expected fields
		$required = ["text", "offset", "slt", "op"];
		$data = [];

		// Validate input
		foreach ($required as $field) {
		    if (!isset($_POST[$field]) && $_POST[$field] === "") {
		        http_response_code(400); // Bad Request
		        echo json_encode(["error" => "Missing field: $field"]);
		        exit;
		    }
		    $data[$field] = $_POST[$field];
		}

		// Sanitize basic inputs
		$text   = trim($data["text"]);
		$offset = (int) $data["offset"];
		$slt    = trim($data["slt"]);
		$chunks = (int) (isset($_POST['chunks']) ? $_POST['chunks'] : 4);
		$op     = strtolower(trim($data["op"]));

		$finres = "";

		// load encryptor code
		include __DIR__.'/main.php';

		// Decide operation
		if ($op === "encrypt") {
			$finres = Enc::encryptme($text,$offset,$slt,$chunks);
		    $response = ["status" => "success", "message" => "$finres"];
		} elseif ($op === "decrypt") {
			$finres = Enc::decryptme($text,$offset,$slt);
		    $response = ["status" => "success", "message" => "$finres"];
		} else {
		    http_response_code(400);
		    $response = ["error" => "Invalid operation"];
		}

		echo json_encode($response);
		exit();
	// } catch(Exception $e){
		$response = ["error" => "Error: $e"];
		echo json_encode($response);
	// }
?>