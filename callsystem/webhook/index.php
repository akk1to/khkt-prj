<?php
	$json = file_get_contents('php://input');
	$data = json_decode($json, true);

	if(empty($data)) {
		http_response_code(400);
		echo json_encode(['error' => 'Invaild JSON, plase recheck data!']);
		exit;
	}

	$dtmf = $data['dtmf'] ?? null;
	$customField = json_decode($data['customField'], true);
	$userId = $customField['userId'] ?? null;

	$logMessage = date('d-m-Y H:i:s') . "RESPONSE: $dtmf, UserID: $userId \n";
	file_put_contents('log.txt', $logMessage, FILE_APPEND);

	http_response_code(200);
	echo json_encode(['success' => true]);
?>