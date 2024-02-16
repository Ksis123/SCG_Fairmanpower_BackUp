<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $employee_info_id = $_POST['employee_info_id'];
    $card_id = $_POST['card_id']; // เพื่อรับค่า 
    $employee_user = $_POST['employee_user']; // 23 input
    $business_email = $_POST['business_email'];
    $telephone_business = $_POST['telephone_business'];
    $address_no = $_POST['address_no'];
    $village_no = $_POST['village_no'];
    $street = $_POST['street'];
    $sub_district = $_POST['sub_district'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $postal_id = $_POST['postal_id'];
    $country = $_POST['country'];
    $telephone_home = $_POST['telephone_home'];
    $office_address = $_POST['office_address'];
    $spourse_firstname = $_POST['spourse_firstname'];
    $spourse_lastname = $_POST['spourse_lastname'];
    $number_of_child = $_POST['number_of_child'];
    $spourse_tax_id = $_POST['spourse_tax_id'];

    // คำสั่ง SQL ในรูปแบบของ prepared statement
    $sqlUpdate = "UPDATE employee_info SET 
                    card_id = ?, 
                    employee_user = ?,
                    business_email = ?, 
                    telephone_business = ?, 
                    address_no = ?, 
                    village_no = ?,
                    street = ?, 
                    sub_district = ?, 
                    district = ?, 
                    province = ?,  
                    postal_id = ?, 
                    country = ?, 
                    telephone_home = ?, 
                    office_address = ?, 
                    spourse_firstname = ?, 
                    spourse_lastname = ?, 
                    number_of_child = ?, 
                    spourse_tax_id = ?
                    WHERE employee_info_id = ?";
    // เตรียม prepared statement
    $stmt = sqlsrv_prepare($conn, $sqlUpdate, array(
        &$card_id,
        &$employee_user,
        &$business_email,
        &$telephone_business,
        &$address_no,
        &$village_no,
        &$street,
        &$sub_district,
        &$district,
        &$province,
        &$postal_id,
        &$country,
        &$telephone_home,
        &$office_address,
        &$spourse_firstname,
        &$spourse_lastname,
        &$number_of_child,
        &$spourse_tax_id,

        &$employee_info_id
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
