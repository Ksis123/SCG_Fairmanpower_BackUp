<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $location_id = $_POST['location_id'];
    $company_id = $_POST['company_id'];
    $location_name = $_POST['name_thai'];
    $location_name_eng = $_POST['name_eng'];

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sql = "UPDATE location SET 
    company_id = ?,
    name = ?,
    name_eng = ?
    WHERE location_id = ?";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sql, array(
        &$company_id,
        &$location_name,
        &$location_name_eng,
        &$location_id

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
