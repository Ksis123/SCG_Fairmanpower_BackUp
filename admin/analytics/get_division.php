<?php
session_start();
require_once('../../config/connection.php');

header('Content-Type: application/json');

// ตรวจสอบว่ามีการส่ง division_id มาหรือไม่
if(isset($_GET['locationId']) && !empty($_GET['locationId'])) {
    $locationId = $_GET['locationId'];
    // กรองข้อมูล department ตาม division_id ที่รับมา
    $sql = "SELECT division_id, name_eng FROM division WHERE location_id = ?";
    $params = array($locationId);
} else {
    // ถ้าไม่มี division_id มา ก็เลือกข้อมูล department ทั้งหมด
    $sql = "SELECT division_id, name_eng FROM division";
    $params = array();
}

$stmt = sqlsrv_query($conn, $sql, $params);

$divisions = array();
if($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $divisions[] = $row;
    }
    echo json_encode($divisions);
} else {
    die(print_r(sqlsrv_errors(), true));
}
?>



