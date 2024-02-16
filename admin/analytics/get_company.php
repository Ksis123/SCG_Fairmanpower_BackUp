<?php
session_start();
require_once('../../config/connection.php');

header('Content-Type: application/json');

if(isset($_GET['organizationId']) && !empty($_GET['organizationId'])) {
    $organizationId = $_GET['organizationId'];
    $sql = "SELECT company_id, name_eng FROM company WHERE organization_id = ?";
    $params = array($organizationId);
} else {
    // ถ้าไม่มี division_id มา ก็เลือกข้อมูล department ทั้งหมด
    $sql = "SELECT company_id, name_eng FROM company";
    $params = array();
}

$stmt = sqlsrv_query($conn, $sql, $params);

$companys = array();
if($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $companys[] = $row;
    }
    echo json_encode($companys);
} else {
    die(print_r(sqlsrv_errors(), true));
}
?>



