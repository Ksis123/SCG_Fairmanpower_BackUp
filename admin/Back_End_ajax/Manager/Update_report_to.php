<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $report_to_id = $_POST['report_to_id']; // primary
    $card_id = $_POST['r_card_id'];
    $report_to_card_id = $_POST['report_to_card_id'];

    $old_report_to_name = $_POST['old_report_to_name'];
    $edit_report_to_card_id = $_POST['edit_report_to_card_id'];
    $edit_time = $_POST['edit_time'];
    $edit_detail = $_POST['edit_detail'];

    // UPDATE report_to SET edit_report_to_card_id = 'รหัสบัตรประชาชนคนที่จะรายงาน', old_report_to_name = report_to_card_id FROM report_to WHERE card_id = 'รหัสบัตรประชาชนพนักงานที่จะเปลี่ยน';
    // UPDATE report_to SET report_to_card_id = edit_report_to_card_id FROM report_to WHERE card_id = 'รหัสบัตรประชาชนพนักงานที่จะเปลี่ยน'; 

    $sqlUpdate = "UPDATE report_to SET 
                    edit_report_to_card_id = ?,
                    edit_time = ?, 
                    edit_detail = ?,  
                    old_report_to_name = ? 
                    FROM report_to WHERE report_to.card_id = ?
                    UPDATE report_to SET 
                    report_to_card_id = ? 
                    FROM report_to WHERE report_to.card_id = ?";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sqlUpdate, array(
        &$edit_report_to_card_id,
        &$edit_time,
        &$edit_detail,
        &$report_to_card_id,
        &$card_id,
        &$edit_report_to_card_id,
        &$card_id
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
