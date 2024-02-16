
<?php

require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

// รับค่า assessment_id จาก request

$assessmentId = $_POST['assessment_id'];

// สร้าง query สำหรับลบข้อมูล
$sql = "DELETE FROM assessment WHERE assessment_id = ?";

// สร้าง statement
$stmt = sqlsrv_prepare($conn, $sql, array($assessmentId));

// ทำการ execute statement
if (sqlsrv_execute($stmt)) {
} else {
    echo "Error deleting record: " . print_r(sqlsrv_errors(), true);
}

?>