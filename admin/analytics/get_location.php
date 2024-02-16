<?php
session_start();
require_once('../../config/connection.php');

header('Content-Type: application/json');

// ตรวจสอบว่ามีการส่ง division_id มาหรือไม่
if(isset($_GET['companyId']) && !empty($_GET['companyId'])) {
    $companyId = $_GET['companyId'];
    // กรองข้อมูล department ตาม division_id ที่รับมา
    $sql = "SELECT location_id, name_eng FROM location WHERE company_id = ?";
    $params = array($companyId);
} else {
    // ถ้าไม่มี division_id มา ก็เลือกข้อมูล department ทั้งหมด
    $sql = "SELECT location_id, name_eng FROM location";
    $params = array();
}

$stmt = sqlsrv_query($conn, $sql, $params);

$locations = array();
if($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $locations[] = $row;
    }
    echo json_encode($locations);
} else {
    die(print_r(sqlsrv_errors(), true));
}
?>



