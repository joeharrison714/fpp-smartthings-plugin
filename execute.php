<?php
include_once "/opt/fpp/www/config.php";
include_once "st-common.php";

$action = $argv[1];
$name = $argv[2];
logEntry( "Action: " . $action . "  Name: " . $name);

if (strlen($action) == 0){
	throw new Exception('No action specified.');
}

if (strlen($name) == 0){
	throw new Exception('No name specified.');
}

executeAction($action, $name);

function executeAction($action, $name){

	$verb = "GET";
	$path = "";
	if ($action == "on"){
		$verb = "PUT";
		$path = "/switches/on/" . urlencode($name);
	}
	elseif ($action == "off"){
		$verb = "PUT";
		$path = "/switches/off/" . urlencode($name);
	}
	elseif ($action == "toggle"){
		$verb = "PUT";
		$path = "/switches/toggle/" . urlencode($name);
	}
	elseif ($action == "routine"){
		$routines = getRoutines();

		$theId = "";
	
		logEntry("Searching for routine " . $name);
		foreach($routines as $item) {
			$label = $item->label;
			$id = $item->id;
	
			if (strcasecmp($name, $label) == 0) {
				$theId = $id;
				logEntry("Found routine with id " . $id);
				break;
			}
		}
		if (strlen($theId) > 0){
			$verb = "POST";
			$path = "/routines/" . urlencode($theId);
		}
	}
	else{
		throw new Exception('Unknown action.');
	}

	callEndpoint($path, $verb);

}

?>