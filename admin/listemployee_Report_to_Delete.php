<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_report_to'])) {
        $report_id_to_delete = $_POST['report_id_to_delete'];

        // ทำการลบข้อมูลจากตาราง employee โดยใช้ card_id
        $sqlDelete = "DELETE FROM report_to WHERE report_to_id = '$report_id_to_delete'";
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
