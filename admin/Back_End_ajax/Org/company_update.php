<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $company_id = $_POST['company_id'];
    $organization_id = $_POST['organization_id'];
    $nameTH = $_POST['name_thai'];
    $nameENG = $_POST['name_eng'];

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sql = "UPDATE company SET 
            organization_id = ?,
            name_thai = ?,
            name_eng = ?
            WHERE company_id = ?";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sql, array(
        &$organization_id,
        &$nameTH,
        &$nameENG,
        &$company_id,

    ));

    // ทำการ execute prepared statement
    $result = sqlsrv_execute($stmt);

    // ตรวจสอบสถานะการ execute
    if ($result === false) {
        $errors = sqlsrv_errors();
        echo json_encode(array('status' => 'error', 'message' => 'Database error: ' . $errors[0]['message']));
        exit();
    } else {
        echo json_encode(array('status' => 'success'));
        exit();
    }
}
