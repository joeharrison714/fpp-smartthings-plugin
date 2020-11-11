<?php
include_once "/opt/fpp/www/config.php";
include_once "st-common.php";

$routines = getRoutines();

$arr = [];
foreach($routines as $item) {
    $name = $item->label;
    $arr[] = $name;
}

header('Content-type: application/json');
echo json_encode($arr);

?>