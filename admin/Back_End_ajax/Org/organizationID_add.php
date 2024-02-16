<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $selectedValue = $_POST['sub_business_id'];
    $orgid = $_POST['organization_id'];

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sql = "INSERT INTO organization (sub_business_id, organization_id) VALUES (?, ?)";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sql, array(
        &$selectedValue,
        &$orgid

    ));

    // ทำการ execute prepared statement
    $result = sqlsrv_execute($stmt);

    // ตรวจสอบสถานะการ execute
    if ($result === false) {
        $errors = sqlsrv_errors();
        echo json_encode(array('status' => 'error', 'message' => 'หมายเลขถูกใช้ในระบบไปแล้ว กรุณาเปลี่ยนหมายเลขใหม่'));
        exit();
    } else {
        echo json_encode(array('status' => 'success'));
        exit();
    }
}
