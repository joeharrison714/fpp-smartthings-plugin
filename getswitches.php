<?php
include_once "/opt/fpp/www/config.php";
include_once "st-common.php";

$switches = getSwitches();

$arr = [];
foreach($switches as $item) {
    $name = $item->name;
    $arr[] = $name;
}

header('Content-type: application/json');
echo json_encode($arr);

?>