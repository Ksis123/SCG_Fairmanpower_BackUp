<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $company_id = $_POST['company_id'];
    $orgid = $_POST['organization_id'];
    $nameTH = $_POST['name_thai'];
    $nameENG = $_POST['name_eng'];

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sql = "INSERT INTO company (organization_id, company_id, name_thai, name_eng) VALUES (?, ?, ?, ?)";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sql, array(
        &$orgid,
        &$company_id,
        &$nameTH,
        &$nameENG
    ));

    // ทำการ execute prepared statement
    $result = sqlsrv_execute($stmt);

    // ตรวจสอบสถานะการ execute
    if ($result === false) {
        $errors = sqlsrv_errors();
        echo json_encode(array('status' => 'error', 'message' => 'รหัส Company ถูกใช้ไปแล้ว กรุณาเปลี่ยน '));
        exit();
    } else {
        echo json_encode(array('status' => 'success'));
        exit();
    }
}
