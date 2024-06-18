<?php
// /xampp/htdocs/PDMS/webcalls.php

include 'db/db_functions.php';

$shopCode = 2;
$month = 3;
$years = [2003, 2004, 2005];

$data = getCumulativeDelays($shopCode, $month, $years);

header('Content-Type: application/json');
echo json_encode($data);
?>
