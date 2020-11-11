<?php
include_once "/opt/fpp/www/common.php"; //Alows use of FPP Functions
include_once "st-common.php";


if (strlen(urldecode($pluginSettings['client_id']))<1){
	WriteSettingToFile("client_id",urlencode(""),$pluginName);
}

if (strlen(urldecode($pluginSettings['client_secret']))<1){
	WriteSettingToFile("client_secret",urlencode(""),$pluginName);
}

$clientId = urldecode($pluginSettings['client_id']);
$clientSecret = urldecode($pluginSettings['client_secret']);

$goAuthUrl = "";
if (strlen($clientId) > 0 && strlen($clientSecret) > 0){
    $authorizedUrl = "http://" . $settings['HostName'] . "/plugin.php?plugin=" . $pluginName . "&page=authorized.php";
    $goAuthUrl = "https://graph.api.smartthings.com/oauth/authorize?response_type=code&scope=app&redirect_uri=" . urlencode($authorizedUrl) . "&client_id=" . $clientId;
}

$isConfigured = false;
$switches = NULL;
if (strlen($pluginSettings['access_token']) > 0 && strlen($pluginSettings['endpoint_url']) > 0)
{
	$switches = getSwitches();
	$routines = getRoutines();

	$isConfigured = true;
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

	<p>Press F1 for setup instructions</p>

<table cellspacing="5">


<tr>
	<th style="text-align: left">SmartApp Client ID</th>
<td>
<?
//function PrintSettingTextSaved($setting, $restart = 1, $reboot = 0, $maxlength = 32, $size = 32, $pluginName = "", $defaultValue = "", $callbackName = "", $changedFunction = "", $inputType = "text", $sData = Array())
	PrintSettingTextSaved("client_id", $restart = 0, $reboot = 0, $maxlength = 50, $size = 50, $pluginName = $pluginName, $defaultValue = "", $changedFunction = "authChanged");
?>
</td>
</tr>

<tr>
	<th style="text-align: left">SmartApp Client Secret</th>
<td>
<?
//function PrintSettingPasswordSaved($setting, $restart = 1, $reboot = 0, $maxlength = 32, $size = 32, $pluginName = "", $defaultValue = "", $callbackName = "", $changedFunction = "")
	PrintSettingPasswordSaved("client_secret", $restart = 0, $reboot = 0, $maxlength = 50, $size = 50, $pluginName = $pluginName, $defaultValue = "", $changedFunction = "authChanged");
?>
</td>
</tr>

<tr>

<td> </td>
<td>
<?
if (strlen($goAuthUrl) > 0){
echo "<a href='" . $goAuthUrl . "'>Configure SmartThings Access</a>";
}
?>
</td>

</table>


<?

if ($isConfigured){
?>
<p style="font-size: 16pt; font-weight: bold;">SmartThings commands should now be available throughout FPP. If they are not, try restarting FPPD.</p>
<h3>Test</h3>
<table>
<tr>
<th>Switch</th>
<th> </th>
<th> </th>
</tr>
<?
foreach($switches as $item) {
	$name = $item->name;
	$encname = str_replace("'", "''", $name);
	?>
	<tr>
	<td><?= $name ?></td>
	<td><button onclick='testOn("<?= $encname ?>")'>on</button></td>
	<td><button onclick='testOff("<?= $encname ?>")'>off</button></td>
	<td></td>
	</tr>
	<?
}
?>
</table>
<br /><br />
<table>
<tr>
<th>Routine</th>
<th> </th>
</tr>
<?
foreach($routines as $item) {
	$name = $item->label;
	$encname = str_replace("'", "\\'", $name);
	?>
	<tr>
	<td><?= $name ?></td>
	<td><button onclick="testRoutine('<?= $encname ?>')">execute</button></td>
	<td></td>
	</tr>
	<?
}
?>
</table>
<?
}
?>

<script type="text/javascript">
function authChanged(){
	location.reload(true);
}
function testOn(name){
	url = '/api/command/' + encodeURIComponent('SmartThings Device On') + '/' + encodeURIComponent(name);
	$.get( url, function( data ) {
		// no op
	});
}
function testOff(name){
	url = '/api/command/' + encodeURIComponent('SmartThings Device Off') + '/' + encodeURIComponent(name);
	$.get( url, function( data ) {
		// no op
	});
}
function testRoutine(name){
	url = '/api/command/' + encodeURIComponent('SmartThings Routine') + '/' + encodeURIComponent(name);
	$.get( url, function( data ) {
		// no op
	});
}
</script>


</body>
</html>