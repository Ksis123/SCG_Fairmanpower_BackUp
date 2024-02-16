<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $education_info_id = $_POST['education_info_id']; // เพื่อรับค่า education_info_id
    $card_id = $_POST['card_id']; 
    $education_level_degree = $_POST['education_level_degree']; 
    $faculty_degree = $_POST['faculty_degree'];
    $major_degree = $_POST['major_degree'];
    $institute_degree = $_POST['institute_degree'];
    $country_degree = $_POST['country_degree'];
    $grade_degree = $_POST['grade_degree'];
    $year_acquired_degree = $_POST['year_acquired_degree'];

    // ตัวแปรที่มีค่า null
    $education_level_scholarship = $_POST['education_level_scholarship'] ?? null;
    $certificate_scholarship = $_POST['certificate_scholarship'] ?? null;
    $faculty_scholarship = $_POST['faculty_scholarship'] ?? null;
    $major_scholarship = $_POST['major_scholarship'] ?? null;
    $institute_scholarship = $_POST['institute_scholarship'] ?? null;
    $country_scholarship = $_POST['country_scholarship'] ?? null;
    $grade_scholarship = $_POST['grade_scholarship'] ?? null;
    $year_acquired_scholarship = $_POST['year_acquired_scholarship'] ?? null;

    $education_level_other1 = $_POST['education_level_other1'] ?? null;
    $certificate_other1 = $_POST['certificate_other1'] ?? null;
    $faculty_other1 = $_POST['faculty_other1'] ?? null;
    $major_other1 = $_POST['major_other1'] ?? null;
    $institute_other1 = $_POST['institute_other1'] ?? null;
    $country_other1 = $_POST['country_other1'] ?? null;
    $grade_other1 = $_POST['grade_other1'] ?? null;
    $year_acquired_other1 = $_POST['year_acquired_other1'] ?? null;

    $education_level_other2 = $_POST['education_level_other2'] ?? null;
    $certificate_other2 = $_POST['certificate_other2'] ?? null;
    $faculty_other2 = $_POST['faculty_other2'] ?? null;
    $major_other2 = $_POST['major_other2'] ?? null;
    $institute_other2 = $_POST['institute_other2'] ?? null;
    $country_other2 = $_POST['country_other2'] ?? null;
    $grade_other2 = $_POST['grade_other2'] ?? null;
    $year_acquired_other2 = $_POST['year_acquired_other2'] ?? null;

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sqlUpdate = "UPDATE education_info SET 
            card_id = ?,
            education_level_degree = ?,
            faculty_degree = ?,
            major_degree = ?,
            institute_degree = ?,
            country_degree = ?,
            grade_degree = ?,
            year_acquired_degree = ?,
            education_level_scholarship = ?,
            certificate_scholarship = ?,
            faculty_scholarship = ?,
            major_scholarship = ?,
            institute_scholarship = ?,
            country_scholarship = ?,
            grade_scholarship = ?,
            year_acquired_scholarship = ?,
            education_level_other1 = ?,
            certificate_other1 = ?,
            faculty_other1 = ?,
            major_other1 = ?,
            institute_other1 = ?,
            country_other1 = ?,
            grade_other1 = ?,
            year_acquired_other1 = ?,
            education_level_other2 = ?,
            certificate_other2 = ?,
            faculty_other2 = ?,
            major_other2 = ?,
            institute_other2 = ?,
            country_other2 = ?,
            grade_other2 = ?,
            year_acquired_other2 = ?
            WHERE card_id = ?";

    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sqlUpdate, array(
        &$card_id,
        &$education_level_degree,
        &$faculty_degree,
        &$major_degree,
        &$institute_degree,
        &$country_degree,
        &$grade_degree,
        &$year_acquired_degree,
        &$education_level_scholarship,
        &$certificate_scholarship,
        &$faculty_scholarship,
        &$major_scholarship,
        &$institute_scholarship,
        &$country_scholarship,
        &$grade_scholarship,
        &$year_acquired_scholarship,
        &$education_level_other1,
        &$certificate_other1,
        &$faculty_other1,
        &$major_other1,
        &$institute_other1,
        &$country_other1,
        &$grade_other1,
        &$year_acquired_other1,
        &$education_level_other2,
        &$certificate_other2,
        &$faculty_other2,
        &$major_other2,
        &$institute_other2,
        &$country_other2,
        &$grade_other2,
        &$year_acquired_other2,
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
