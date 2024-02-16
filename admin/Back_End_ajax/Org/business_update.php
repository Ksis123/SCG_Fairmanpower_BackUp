<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $business_id = $_POST['business_id'];
    $nameTH = $_POST['name_thai'];
    $nameENG = $_POST['name_eng'];

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sql = "UPDATE business SET 
    name_thai = ?,
    name_eng = ?
    WHERE business_id = ?";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sql, array(
        &$nameTH,
        &$nameENG,
        &$business_id

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
