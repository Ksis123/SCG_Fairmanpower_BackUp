<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $section_id = $_POST['section_id'];
    $cost_center_code = $_POST['cost_center_code'];

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sql = "INSERT INTO cost_center (section_id, cost_center_code) VALUES (?, ?)";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sql, array(
        &$section_id,
        &$cost_center_code
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
