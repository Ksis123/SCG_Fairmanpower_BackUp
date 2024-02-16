
<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $section_id = $_POST['section_id'];
    $department_id = $_POST['department_id'];
    $name_thai = $_POST['name_thai'];
    $name_eng = $_POST['name_eng'];

    // อัปเดตค่าของฟิลด์ department_id, name_thai, และ name_eng
    $sql = "UPDATE section SET 
                        department_id = ?, 
                        name_thai = ?, 
                        name_eng = ? 
                        WHERE section_id = ?";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sql, array(
        &$department_id,
        &$name_thai,
        &$name_eng,
        &$section_id

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
