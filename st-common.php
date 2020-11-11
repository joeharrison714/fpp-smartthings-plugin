<?php
include_once "/opt/fpp/www/config.php";

$pluginName = basename(dirname(__FILE__));
$pluginPath = $settings['pluginDirectory']."/".$pluginName."/"; 

$logFile = $settings['logDirectory']."/".$pluginName."-execute.log";

$pluginConfigFile = $settings['configDirectory'] . "/plugin." .$pluginName;

if (file_exists($pluginConfigFile)) {
	$pluginSettings = parse_ini_file($pluginConfigFile);
}

function getSwitches(){
    $response = callEndpoint("/switches", "GET");
    $json = json_decode( $response );
    return $json;
}

function getRoutines(){
    $response = callEndpoint("/routines", "GET");
    $json = json_decode( $response );
    return $json;
}

function callEndpoint($path, $verb){
    global $pluginSettings;

	$accessToken = urldecode($pluginSettings['access_token']);
	$endpointUrl = urldecode($pluginSettings['endpoint_url']);

	if (strlen($accessToken) == 0){
		throw new Exception('SmartThings is not authenticated (No access token).');
	}
	
	if (strlen($endpointUrl) == 0){
		throw new Exception('SmartThings is not authenticated (No endpoint).');
	}

	$thisUrl = $endpointUrl . $path;

	#logEntry("Going to call " . $verb . " on " . $thisUrl);

	$options = array('http' => array(
		'method'  => $verb,
		'header' => 'Authorization: Bearer '.$accessToken
	));
	$context  = stream_context_create($options);
	$response = file_get_contents($thisUrl, false, $context);

    #logEntry("API Response: " . $response);
    return $response;
}

function logEntry($data) {

	global $logFile,$myPid;

	$data = $_SERVER['PHP_SELF']." : [".$myPid."] ".$data;
	
	$logWrite= fopen($logFile, "a") or die("Unable to open file!");
	fwrite($logWrite, date('Y-m-d h:i:s A',time()).": ".$data."\n");
	fclose($logWrite);
}

?>