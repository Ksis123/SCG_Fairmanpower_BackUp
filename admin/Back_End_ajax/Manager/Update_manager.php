<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $manager_id = $_POST['manager_id']; // primary
    $card_id = $_POST['card_id'];
    $manager_card_id = $_POST['manager_card_id'];

    $old_manager_name = $_POST['old_manager_name']; 
    $edit_manager_card_id = $_POST['edit_manager_card_id']; 
    $edit_time = $_POST['edit_time']; 
    $edit_detail = $_POST['edit_detail']; 

    // UPDATE manager SET edit_manager_card_id = 'รหัสบัตรประชาชนหัวหน้า', old_manager_name = manager_card_id FROM manager WHERE card_id  = 'รหัสบัตรประชาชนพนักงานที่จะเปลี่ยน';
    // UPDATE manager SET manager_card_id = edit_manager_card_id FROM manager WHERE card_id  = 'รหัสบัตรประชาชนพนักงานที่จะเปลี่ยน';

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sqlUpdate =   "UPDATE manager SET 
                    edit_manager_card_id = ?, 
                    edit_time = ?, 
                    edit_detail = ?, 
                    old_manager_name = ? 
                    FROM manager WHERE card_id  = ?
                    UPDATE manager SET 
                    manager_card_id = ? 
                    FROM manager WHERE card_id  = ?";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sqlUpdate, array(
        &$edit_manager_card_id,
        &$edit_time,
        &$edit_detail,
        &$manager_card_id,
        &$card_id,
        &$edit_manager_card_id,
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
