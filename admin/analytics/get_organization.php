<?php
session_start();
require_once('../../config/connection.php');

header('Content-Type: application/json');

// ตรวจสอบว่ามีการส่ง division_id มาหรือไม่
if(isset($_GET['sub_businessId']) && !empty($_GET['sub_businessId'])) {
    $sub_businessId = $_GET['sub_businessId'];
    // กรองข้อมูล department ตาม division_id ที่รับมา
    $sql = "SELECT organization_id FROM organization WHERE sub_business_id = ?";
    $params = array($sub_businessId);
} else {
    // ถ้าไม่มี division_id มา ก็เลือกข้อมูล department ทั้งหมด
    $sql = "SELECT organization_id FROM organization";
    $params = array();
}

$stmt = sqlsrv_query($conn, $sql, $params);

$organizations = array();
if($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $organizations[] = $row;
    }
    echo json_encode($organizations);
} else {
    die(print_r(sqlsrv_errors(), true));
}
?>

