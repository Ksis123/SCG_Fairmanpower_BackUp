<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $card_id = $_POST['card_id'];
    $person_id = isset($_POST['person_id']) ? $_POST['person_id'] : null;
    $personnel_number = isset($_POST['personnel_number']) ? $_POST['personnel_number'] : null;
    $scg_employee_id = isset($_POST['scg_employee_id']) ? $_POST['scg_employee_id'] : null;
    $prefix_thai = isset($_POST['prefix_thai']) ? $_POST['prefix_thai'] : null;
    $firstname_thai = isset($_POST['firstname_thai']) ? $_POST['firstname_thai'] : null;
    $lastname_thai = isset($_POST['lastname_thai']) ? $_POST['lastname_thai'] : null;
    $nickname_thai = isset($_POST['nickname_thai']) ? $_POST['nickname_thai'] : null;
    $prefix_eng = isset($_POST['prefix_eng']) ? $_POST['prefix_eng'] : null;
    $firstname_eng = isset($_POST['firstname_eng']) ? $_POST['firstname_eng'] : null;
    $lastname_eng = isset($_POST['lastname_eng']) ? $_POST['lastname_eng'] : null;
    $nickname_eng = isset($_POST['nickname_eng']) ? $_POST['nickname_eng'] : null;
    $birth_date = isset($_POST['birth_date']) ? $_POST['birth_date'] : null;
    $blood_type = isset($_POST['blood_type']) ? $_POST['blood_type'] : null;
    $marital_status = isset($_POST['marital_status']) ? $_POST['marital_status'] : null;
    $nation = isset($_POST['nation']) ? $_POST['nation'] : null;
    $ethnicity = isset($_POST['ethnicity']) ? $_POST['ethnicity'] : null;
    $religion = isset($_POST['religion']) ? $_POST['religion'] : null;
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : null;
    $social_security_id = isset($_POST['social_security_id']) ? $_POST['social_security_id'] : null;
    $tax_id = isset($_POST['tax_id']) ? $_POST['tax_id'] : null;
    $contract_type_id = isset($_POST['contract_type_id']) ? $_POST['contract_type_id'] : null;
    $permission_id = isset($_POST['permission_id']) ? $_POST['permission_id'] : null;
    $cost_center_organization_id = isset($_POST['cost_center_organization_id']) ? $_POST['cost_center_organization_id'] : null;
    $cost_center_payment_id = isset($_POST['cost_center_payment_id']) ? $_POST['cost_center_payment_id'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $employee_email = isset($_POST['employee_email']) ? $_POST['employee_email'] : null;
    $employment_status = isset($_POST['employment_status']) ? $_POST['employment_status'] : null;
    $scg_hiring_date = isset($_POST['scg_hiring_date']) ? $_POST['scg_hiring_date'] : null;
    $retired_date = isset($_POST['retired_date']) ? $_POST['retired_date'] : null;
    $termination_date = isset($_POST['termination_date']) ? $_POST['termination_date'] : null;
    $probation_date_start = isset($_POST['probation_date_start']) ? $_POST['probation_date_start'] : null;
    $probation_period = isset($_POST['probation_period']) ? $_POST['probation_period'] : null;
    $employee_type = isset($_POST['employee_type']) ? $_POST['employee_type'] : null;
    $work_format_code = isset($_POST['work_format_code']) ? $_POST['work_format_code'] : null;
    $bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : null;
    $bank_branch_name = isset($_POST['bank_branch_name']) ? $_POST['bank_branch_name'] : null;
    $back_account_id = isset($_POST['back_account_id']) ? $_POST['back_account_id'] : null;
    $work_per_day = isset($_POST['work_per_day']) ? $_POST['work_per_day'] : null;
    $outside_equivalent_year = isset($_POST['outside_equivalent_year']) ? $_POST['outside_equivalent_year'] : null;
    $outside_equivalent_month = isset($_POST['outside_equivalent_month']) ? $_POST['outside_equivalent_month'] : null;

    // ค่าไม่ว่าง ทำการ insert ข้อมูล
    $sqlUpdate = "UPDATE employee SET
    person_id = ?, 
    personnel_number = ?, 
    scg_employee_id = ?, 
    prefix_thai = ?, 
    firstname_thai = ?, 
    lastname_thai = ?, 
    nickname_thai = ?, 
    birth_date = ?,
    prefix_eng = ?, 
    firstname_eng = ?, 
    lastname_eng = ?, 
    nickname_eng = ?, 
    gender = ?,
    blood_type = ?, 
    marital_status = ?, 
    nation = ?, 
    ethnicity = ?, 
    religion = ?, 
    phone_number = ?,
    social_security_id = ?, 
    tax_id = ?, 
    contract_type_id = ?, 
    cost_center_organization_id = ?, 
    employee_email = ?, 
    permission_id = ? , 
    cost_center_payment_id = ?, 
    employment_status = ?, 
    probation_date_start = ?, 
    probation_period = ?, 
    scg_hiring_date = ?, 
    retired_date = ?, 
    termination_date = ?, 
    employee_type = ?, 
    work_format_code = ?, 
    bank_name = ?, 
    bank_branch_name = ?, 
    back_account_id = ?, 
    work_per_day = ?, 
    outside_equivalent_year = ?, 
    outside_equivalent_month = ?
    WHERE card_id = ?";

    $stmt = sqlsrv_prepare($conn, $sqlUpdate, array(
        &$person_id,
        &$personnel_number,
        &$scg_employee_id,
        &$prefix_thai,
        &$firstname_thai,
        &$lastname_thai,
        &$nickname_thai,
        &$birth_date,
        &$prefix_eng,
        &$firstname_eng,
        &$lastname_eng,
        &$nickname_eng,
        &$gender,
        &$blood_type,
        &$marital_status,
        &$nation,
        &$ethnicity,
        &$religion,
        &$phone_number,
        &$social_security_id,
        &$tax_id,
        &$contract_type_id,
        &$cost_center_organization_id,
        &$employee_email, 
        &$permission_id,
        &$cost_center_payment_id,
        &$employment_status,
        &$probation_date_start,
        &$probation_period,
        &$scg_hiring_date,
        &$retired_date,
        &$termination_date,
        &$employee_type,
        &$work_format_code,
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
