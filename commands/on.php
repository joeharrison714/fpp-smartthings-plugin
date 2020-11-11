#!/usr/bin/php
<?php
include_once "/opt/fpp/www/common.php";
$upOne = realpath(dirname(__FILE__) . '/..');
$pluginName = basename($upOne);
$pluginPath = $settings['pluginDirectory']."/".$pluginName."/"; 

$logFile = $settings['logDirectory']."/".$pluginName."-action.log";
$pluginConfigFile = $settings['configDirectory'] . "/plugin." .$pluginName;
$pluginSettings = parse_ini_file($pluginConfigFile);

logEntry("Inside on.php");
$device = $argv[1];
logEntry( "Device " . $device);

function logEntry($data) {

	global $logFile,$myPid;

	$data = $_SERVER['PHP_SELF']." : [".$myPid."] ".$data;
	
	$logWrite= fopen($logFile, "a") or die("Unable to open file!");
	fwrite($logWrite, date('Y-m-d h:i:s A',time()).": ".$data."\n");
	fclose($logWrite);
}
?>