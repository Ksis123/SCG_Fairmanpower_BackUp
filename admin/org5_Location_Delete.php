<?php
// ... โค้ดที่มีอยู่ในไฟล์
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_location'])) {
        $location_id = $_POST['location_id'];

        // ทำการลบข้อมูลจากตาราง business โดยใช้ business_id
        $sqlDelete = "DELETE FROM location WHERE location_id = '$location_id'";
        $stmtDelete = sqlsrv_query($conn, $sqlDelete);

        if ($stmtDelete === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            // ส่งค่ากลับเพื่อให้ JavaScript ทำงาน (ถูกใช้ใน SweetAlert2)
            echo json_encode(array('status' => 'success'));
            exit();
        }
    }
}