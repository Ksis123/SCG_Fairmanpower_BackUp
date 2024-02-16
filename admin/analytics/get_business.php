<?php
session_start();
require_once('../../config/connection.php');
header('Content-Type: application/json');

$sql = "SELECT business_id, name_eng FROM business";
$stmt = sqlsrv_query($conn, $sql);

$businesses = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $businesses[] = $row;
}

echo json_encode($businesses);
?>