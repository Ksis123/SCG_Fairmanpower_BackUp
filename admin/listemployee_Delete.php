<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_employee'])) {
        $card_id_to_delete = $_POST['card_id_to_delete'];

        // ทำการลบข้อมูลจากตาราง employee โดยใช้ card_id
        $sqlDelete = "DELETE FROM employee WHERE card_id = '$card_id_to_delete'";
        $stmtDelete = sqlsrv_query($conn, $sqlDelete);

        if ($stmtDelete === false) {
            $errors = sqlsrv_errors();
            echo json_encode(array('status' => 'error', 'message' => 'Database error: ' . $errors[0]['message']));
            exit();
        } else {
            // ส่งค่ากลับเพื่อให้ JavaScript ทำงาน (ถูกใช้ใน SweetAlert2)
            echo json_encode(array('status' => 'success'));
            exit();
        }
    }
}
