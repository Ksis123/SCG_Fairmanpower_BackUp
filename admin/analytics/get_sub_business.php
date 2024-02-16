<?php
session_start();
require_once('../../config/connection.php');

header('Content-Type: application/json');

if(isset($_GET['businessId']) && !empty($_GET['businessId'])) {
    $businessId = $_GET['businessId'];
    $sql = "SELECT sub_business_id,name_eng FROM sub_business WHERE business_id = ?";
    $params = array($businessId);
} else {
    // ถ้าไม่มี division_id มา ก็เลือกข้อมูล department ทั้งหมด
    $sql = "SELECT sub_business_id,name_eng FROM sub_business";
    $params = array();
}

$stmt = sqlsrv_query($conn, $sql, $params);

$sub_businesses = array();
if($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $sub_businesses[] = $row;
    }
    echo json_encode($sub_businesses);
} else {
    die(print_r(sqlsrv_errors(), true));
}
?>

