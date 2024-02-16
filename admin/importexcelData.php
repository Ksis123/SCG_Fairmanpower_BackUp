<?php
// Include your database connection file here
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

require_once('C:\xampp\htdocs\SCG_Fairmanpower\vendor\autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if (in_array($file_ext, $allowed_ext)) {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "1";
        foreach ($data as $row) {

            if ($count > 1) {
                $card_id = $row[0]; // Primary Key A
                $person_id = $row[1]; // B
                $personnel_number = $row[2];  // C
                $scg_employee_id = $row[3]; // D
                $prefix_thai = $row[4]; // E
                $firstname_thai = $row[5]; // F
                $lastname_thai = $row[6]; // G
                $prefix_eng = $row[7]; // H
                $firstname_eng = $row[8]; // I
                $lastname_eng = $row[9]; // J
                $nickname_thai = $row[10]; // K
                $nickname_eng = $row[11]; // L
                $gender = $row[12]; // M
                $birth_date = $row[13]; // N
                $blood_type = $row[14]; // O
                $marital_status = $row[15]; // P
                $nation = $row[16]; // Q
                $ethnicity = $row[17]; // R
                $religion = $row[18]; // S
                $phone_number = $row[19]; // T
                $employee_email = $row[20]; // U
                $social_security_id = $row[21]; // V
                $tax_id = $row[22]; // W
                $scg_hiring_date = $row[23]; // X
                $probation_date_start = $row[24]; // Y
                $probation_period = $row[25]; // Z
                $retired_date = $row[26]; // AA
                $termination_date = $row[27]; // AB
                $ext_interview = $row[28]; // AC
                $termination_reason = $row[29]; // AD
                $contract_type_String = $row[30]; // AE
                $contract_type_Array = explode('-', $contract_type_String);
                $contract_type_id = trim($contract_type_Array[0]);

                $cost_center_payment_String = $row[33]; // AH
                $cost_center_payment_Array = explode('_', $cost_center_payment_String);
                $cost_center_payment_id = trim($cost_center_payment_Array[0]);

                $cost_center_organization_String = $row[34]; // AI
                $cost_center_organization_Array = explode('_', $cost_center_organization_String);
                $cost_center_organization_id = trim($cost_center_organization_Array[0]);

                $work_per_day = $row[35]; // AJ
                $outside_equivalent_year = $row[36]; // AK
                $outside_equivalent_month = $row[37]; // AL
                $employment_status = $row[38]; // AM
                $bank_name = $row[39]; // AN
                $bank_branch_name = $row[40]; // AO
                $back_account_id = $row[41]; // AP

                $permissionString = $row[42]; // AQ
                $permissionArray = explode('-', $permissionString);
                $permission_id = trim($permissionArray[0]);

                $employee_type = $row[43]; // AR
                $employee_type = $row[45]; // AT

                $prevQuery = "SELECT * FROM employee WHERE card_id = '$card_id'";
                $prevResult = sqlsrv_query($conn, $prevQuery);

                if (sqlsrv_has_rows($prevResult)) {
                    $updateQuery = "UPDATE employee SET card_id = '" . $card_id . "', person_id = '" . $person_id . "', personnel_number = '" . $personnel_number . "',
                    scg_employee_id = '" . $scg_employee_id . "', prefix_thai = '" . $prefix_thai . "', firstname_thai = '" . $firstname_thai . "', lastname_thai = '" . $lastname_thai . "', 
                    prefix_eng = '" . $prefix_eng . "', firstname_eng = '" . $firstname_eng . "', lastname_eng = '" . $lastname_eng . "', nickname_thai = '" . $nickname_thai . "', nickname_eng = '" . $nickname_eng . "', 
                    gender = '" . $gender . "', birth_date = '" . $birth_date . "', blood_type = '" . $blood_type . "', marital_status = '" . $marital_status . "', nation = '" . $nation . "', ethnicity = '" . $ethnicity . "',
                    religion = '" . $religion . "', phone_number = '" . $phone_number . "', employee_email = '" . $employee_email . "', social_security_id = '" . $social_security_id . "', 
                    tax_id = '" . $tax_id . "',
                    scg_hiring_date = '" . $scg_hiring_date . "', probation_date_start = '" . $probation_date_start . "', probation_period = '" . $probation_period . "', 
                    retired_date = '" . $retired_date . "', termination_date = '" . $termination_date . "',
                    ext_interview = '" . $ext_interview . "', termination_reason = '" . $termination_reason . "', contract_type_id = '" . $contract_type_id . "', cost_center_payment_id = '" . $cost_center_payment_id . "', 
                    cost_center_organization_id = '" . $cost_center_organization_id . "',
                    work_per_day = '" . $work_per_day . "', outside_equivalent_year = '" . $outside_equivalent_year . "', outside_equivalent_month = '" . $outside_equivalent_month . "', 
                    employment_status = '" . $employment_status . "', bank_name = '" . $bank_name . "',
                    bank_branch_name = '" . $bank_branch_name . "', back_account_id = '" . $back_account_id . "', permission_id = '" . $permission_id . "' WHERE card_id = '" . $card_id . "'";
                    sqlsrv_query($conn, $updateQuery);
                } else {
                    $insertQuery = "INSERT INTO employee 
                        (card_id, person_id, personnel_number, scg_employee_id,
                        prefix_thai, firstname_thai, lastname_thai,
                        prefix_eng, firstname_eng, lastname_eng,
                        nickname_thai, nickname_eng,
                        gender, birth_date, blood_type, marital_status,
                        nation, ethnicity, religion, phone_number,
                        employee_email, social_security_id, tax_id,
                        scg_hiring_date, probation_date_start, probation_period,
                        retired_date, termination_date, ext_interview, termination_reason,
                        contract_type_id, cost_center_payment_id, cost_center_organization_id, 
                        work_per_day, outside_equivalent_year, outside_equivalent_month, employment_status,
                        bank_name, bank_branch_name, back_account_id,
                        permission_id) 
                        VALUES ('$card_id', '$person_id', '$personnel_number','$scg_employee_id' ,
                                        '$prefix_thai', '$firstname_thai', '$lastname_thai', 
                                        '$prefix_eng', '$firstname_eng', '$lastname_eng',
                                        '$nickname_thai', '$nickname_eng',
                                        '$gender', '$birth_date', '$blood_type', '$marital_status', 
                                        '$nation', '$ethnicity', '$religion', '$phone_number',
                                        '$employee_email', '$social_security_id', '$tax_id', 
                                        '$scg_hiring_date', '$probation_date_start', '$probation_period',
                                        '$retired_date', '$termination_date', '$ext_interview', '$termination_reason',
                                        '$contract_type_id', '$cost_center_payment_id', '$cost_center_organization_id', 
                                        '$work_per_day', '$outside_equivalent_year', '$outside_equivalent_month', '$employment_status',                    
                                        '$bank_name', '$bank_branch_name', '$back_account_id',  
                                        '$permission_id')";
                    sqlsrv_query($conn, $insertQuery);
                }
            } else {
                $count = 2;
            }
        }
        echo json_encode(array('status' => 'success'));
        exit();
    } else {
        $errors = sqlsrv_errors();
        echo json_encode(array('status' => 'error', 'message' => 'Database error: ' . $errors[0]['message']));
        exit();
    }
}
