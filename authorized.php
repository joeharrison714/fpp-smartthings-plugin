<?php
include_once "/opt/fpp/www/common.php"; //Alows use of FPP Functions
$pluginName = basename(dirname(__FILE__));
$pluginConfigFile = $settings['configDirectory'] ."/plugin." .$pluginName; //gets path to configuration files for plugin
    
if (file_exists($pluginConfigFile)) {
	$pluginSettings = parse_ini_file($pluginConfigFile);
}

$clientId = urldecode($pluginSettings['client_id']);
$clientSecret = urldecode($pluginSettings['client_secret']);

$code = $_GET["code"];

if (strlen($code) > 0){
	WriteSettingToFile("auth_code",urlencode($code),$pluginName);
}

$authorizedUrl = "http://" . $settings['HostName'] . "/plugin.php?plugin=" . $pluginName . "&page=authorized.php";
    
$postdata = http_build_query(
	array(
		'grant_type' => 'authorization_code',
		'code' => $code,
		'client_id' => $clientId,
		'client_secret' => $clientSecret,
		'redirect_uri' => $authorizedUrl
	)
);

$opts = array('http' =>
	array(
		'method'  => 'POST',
		'header'  => 'Content-Type: application/x-www-form-urlencoded',
		'content' => $postdata
	)
);

$context  = stream_context_create($opts);

$result = file_get_contents('https://graph.api.smartthings.com/oauth/token', false, $context);

$message = "Unknown";

if (strlen($result) < 1){
	$message = "Failed to authenticate with SmartThings";
}
else{
	$jsonResult = json_decode( $result );

	$accessToken = $jsonResult->access_token;
	$expiresIn = $jsonResult->expires_in;
	$tokenType = $jsonResult->token_type;

	WriteSettingToFile("access_token",urlencode($accessToken),$pluginName);
	WriteSettingToFile("expires_in",urlencode($expiresIn),$pluginName);
	WriteSettingToFile("token_type",urlencode($tokenType),$pluginName);

	$getEndpointsOptions = array('http' => array(
		'method'  => 'GET',
		'header' => 'Authorization: Bearer '.$accessToken
	));
	$getEndpointsContext  = stream_context_create($getEndpointsOptions);
	$getEndpointsResponse = file_get_contents("https://graph.api.smartthings.com/api/smartapps/endpoints", false, $getEndpointsContext);

	$success = false;

	if (strlen($getEndpointsResponse) < 1){
		$message = "Failed to get endpoints from SmartThings";
	}
	else{
		$getEndpointsJsonResult = json_decode( $getEndpointsResponse );

		$endpointUrl = $getEndpointsJsonResult[0]->uri;

		WriteSettingToFile("endpoint_url",urlencode($endpointUrl),$pluginName);

		$message = "Successfully authenticated with SmartThings. Please restart FPPD to use.";

		$success = true;
	}
}

?>


<!DOCTYPE html>
<html>
<head>

</head>
<body>
<div class="pluginBody" style="margin-left: 1em;">
	<div class="title">
		<h1>SmartThings Settings</h1>
		<h4></h4>
	</div>


<p>
<?
echo $message;
?>
</p>
<br />
<p>
<a href="/plugin.php?plugin=fpp-smartthings&page=smartthings.php">Return to plugin settings</a>
</p>

<script type="text/javascript">
$( document ).ready(function() {
    SetRestartFlag(2);
	<? if ($success) { echo "location.href = '/plugin.php?plugin=fpp-smartthings&page=smartthings.php';"; }  ?>
});
</script>

</body>
</html>