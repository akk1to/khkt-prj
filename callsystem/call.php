<?php

define('ACCESS_TOKEN', 'eyJjdHkiOiJzdHJpbmdlZS1hcGk7dj0xIiwidHlwIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJqdGkiOiJTSy4wLjZNajVnQ0NNMEdFUEp0NjlmcTdvUTM0d0NvRVlCU2ZmLTE3MzA3OTIyMTIiLCJpc3MiOiJTSy4wLjZNajVnQ0NNMEdFUEp0NjlmcTdvUTM0d0NvRVlCU2ZmIiwiZXhwIjoxNzMzMzg0MjEyLCJyZXN0X2FwaSI6dHJ1ZX0.8BMKj26kwjHGmn2l3zqMRDJb_pPr1qtp8E-G3AZezvk');

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$inputbtn = validate_input(($_POST['phone']));
	$content = validate_input(($_POST['content']));
}

function requestHTTP($url, $data, $headers) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 3,
		CURLOPT_TIMEOUT => 5,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $data,
		CURLOPT_HTTPHEADER => $headers,
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

function call($fromNumber, $toNumber, $text, $eventUrl, $customField = []){
	$url = 'https://api.stringee.com/v1/call2/callout';
	$data = json_encode([
	    "from" => [
	    	"type" => "external",
	    	"number" => $fromNumber,
	    	"alias" => "CallSystem"
	    ],
	    "to" => [
	    	[
	    		"type" => "external",
	    		"number" => $toNumber,
	    		"alias" => "Parents"
	    	]
	    ],
	    "actions" => [
	    	[
	    		"action" => "talk",
	    		"text" => $text,
	    		"bargeIn" => "true"
	    	],
	    	[
	    		"action" => "input",
	    		"eventUrl" => $eventUrl,
	    		"submitOnHash" => "true",
	    		"timeout" => "15",
	    		"maxDigits" => "2",
	    		"customField" => $customField
	    	]
	    ]
	]);
	$headers = array(
		'X-STRINGEE-AUTH: ' . ACCESS_TOKEN,
		'Accept: application/json',
		'Content-Type: application/json',
	);
	return requestHTTP($url, $data, $headers);
};

$fromNumber = '842871053741';
$toNumber = $inputbtn;
$text = $content;
$eventUrl = 'http://localhost/callsystem/webhook/index.php';
$customField = [
	'userId' => '1234'
];

echo json_last_error_msg(); // In ra lỗi JSON nếu có
echo "\n";

// In JSON để kiểm tra
echo "Generated JSON:\n";

$response = call($fromNumber, $toNumber, $text, $eventUrl, $customField);

echo $response;

?>