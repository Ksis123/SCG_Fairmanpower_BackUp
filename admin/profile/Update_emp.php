<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $card_id = $_POST['card_id']; // เพื่อรับค่า card_id
    $person_id = isset($_POST['person_id']) ? $_POST['person_id'] : null;
    $personnel_number = isset($_POST['personnel_number']) ? $_POST['personnel_number'] : null;
    $prefix_thai = isset($_POST['prefix_thai']) ? $_POST['prefix_thai'] : null;
    $firstname_thai = isset($_POST['firstname_thai']) ? $_POST['firstname_thai'] : null;
    $lastname_thai = isset($_POST['lastname_thai']) ? $_POST['lastname_thai'] : null;
    $nickname_thai = isset($_POST['nickname_thai']) ? $_POST['nickname_thai'] : null;
    $prefix_eng = isset($_POST['prefix_eng']) ? $_POST['prefix_eng'] : null;
    $firstname_eng = isset($_POST['firstname_eng']) ? $_POST['firstname_eng'] : null;
    $lastname_eng = isset($_POST['lastname_eng']) ? $_POST['lastname_eng'] : null;
    $nickname_eng = isset($_POST['nickname_eng']) ? $_POST['nickname_eng'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $birth_date = isset($_POST['birth_date']) ? $_POST['birth_date'] : null;
    $blood_type = isset($_POST['blood_type']) ? $_POST['blood_type'] : null;
    $marital_status = isset($_POST['marital_status']) ? $_POST['marital_status'] : null;
    $nation = isset($_POST['nation']) ? $_POST['nation'] : null;
    $ethnicity = isset($_POST['ethnicity']) ? $_POST['ethnicity'] : null;
    $religion = isset($_POST['religion']) ? $_POST['religion'] : null;
    $employee_email = isset($_POST['employee_email']) ? $_POST['employee_email'] : null;
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : null;
    $social_security_id = isset($_POST['social_security_id']) ? $_POST['social_security_id'] : null;
    $tax_id = isset($_POST['tax_id']) ? $_POST['tax_id'] : null;
    $outside_equivalent_year = isset($_POST['outside_equivalent_year']) ? $_POST['outside_equivalent_year'] : null;
    $outside_equivalent_month = isset($_POST['outside_equivalent_month']) ? $_POST['outside_equivalent_month'] : null;

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
        &$outside_equivalent_year,
        &$outside_equivalent_month,
        &$card_id
    ));

    // ทำการ execute prepared statement
    $result = sqlsrv_execute($stmt);

    // ตรวจสอบสถานะการ execute
    if ($result === false) {
        $errors = sqlsrv_errors();
        echo json_encode(array('status' => 'error'));
        exit();
    } else {
        echo json_encode(array('status' => 'success'));
        exit();
    }
}
