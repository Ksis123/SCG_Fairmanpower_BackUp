<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $card_id = $_POST['card_id']; // 
    $person_id = $_POST['person_id']; // 23 input
    $personnel_number = $_POST['personnel_number'];
    $prefix_thai = $_POST['prefix_thai'];
    $firstname_thai = $_POST['firstname_thai'];
    $lastname_thai = $_POST['lastname_thai'];
    $nickname_thai = $_POST['nickname_thai'];
    $prefix_eng = $_POST['prefix_eng'];
    $firstname_eng = $_POST['firstname_eng'];
    $lastname_eng = $_POST['lastname_eng'];
    $nickname_eng = $_POST['nickname_eng'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $blood_type = $_POST['blood_type'];
    $marital_status = $_POST['marital_status'];
    $employee_email = $_POST['employee_email'];
    $phone_number = $_POST['phone_number'];
    $social_security_id = $_POST['social_security_id'];
    $nation = $_POST['nation'];
    $ethnicity = $_POST['ethnicity'];
    $religion = $_POST['religion'];
    $tax_id = $_POST['tax_id'];
    $bank_name = $_POST['bank_name'];
    $bank_branch_name = $_POST['bank_branch_name'];
    $back_account_id = $_POST['back_account_id'];
    $work_per_day = $_POST['work_per_day'];
    $outside_equivalent_year = $_POST['outside_equivalent_year'];
    $outside_equivalent_month = $_POST['outside_equivalent_month'];

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sqlUpdate = "UPDATE employee SET 
                    person_id = ?, 
                    personnel_number = ?,
                    prefix_thai = ?, 
                    firstname_thai = ?, 
                    lastname_thai = ?, 
                    nickname_thai = ?,
                    prefix_eng = ?, 
                    firstname_eng = ?, 
                    lastname_eng = ?, 
                    nickname_eng = ?,  
                    gender = ?, 
                    birth_date = ?, 
                    blood_type = ?, 
                    marital_status = ?, 
                    nation = ?, 
                    ethnicity = ?, 
                    religion = ?, 
                    tax_id = ?,
                    employee_email = ?, 
                    phone_number = ?, 
                    social_security_id = ?,
                    bank_name = ?,
                    bank_branch_name =?,
                    back_account_id = ?,
                    work_per_day = ?,
                    outside_equivalent_year = ?, 
                    outside_equivalent_month = ?
                    WHERE card_id = ?";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sqlUpdate, array(
        &$person_id,
        &$personnel_number,
        &$prefix_thai,
        &$firstname_thai,
        &$lastname_thai,
        &$nickname_thai,
        &$prefix_eng,
        &$firstname_eng,
        &$lastname_eng,
        &$nickname_eng,
        &$gender,
        &$birth_date,
        &$blood_type,
        &$marital_status,
        &$nation,
        &$ethnicity,
        &$religion,
        &$tax_id,
        &$employee_email,
        &$phone_number,                   
        &$social_security_id,
        &$bank_name,
        &$bank_branch_name,
        &$back_account_id,
        &$work_per_day,
        &$outside_equivalent_year,
        &$outside_equivalent_month,
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
