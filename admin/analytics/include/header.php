<?php
require_once('../../config/connection.php');
session_start(); // เรียกใช้ session_start() ก่อนที่จะใช้ session

if (
    isset($_SESSION['line_id'], $_SESSION['card_id'], $_SESSION['prefix_thai'], $_SESSION['firstname_thai'], $_SESSION['lastname_thai']) &&
    !empty($_SESSION['line_id']) && !empty($_SESSION['card_id']) && !empty($_SESSION['prefix_thai']) &&
    !empty($_SESSION['firstname_thai']) && !empty($_SESSION['lastname_thai'])
) {
    $line_id = $_SESSION['line_id'];
    $card_id = $_SESSION['card_id'];
    $prefix = $_SESSION['prefix_thai'];
    $fname = $_SESSION['firstname_thai'];
    $lname = $_SESSION['lastname_thai'];


    // ส่วนคำสั่ง SQL ควรตรงกับโครงสร้างของตารางในฐานข้อมูล
    $sql = "SELECT * FROM employee em WHERE em.card_id = ?";

    $sql2 = "SELECT scg_employee_id, person_id, personnel_number, prefix_thai, firstname_thai, lastname_thai, nickname_thai, prefix_eng, firstname_eng, lastname_eng, nickname_eng, gender, phone_number, employee_email,
	employee_image, birth_date,
	permission.name as permission, permission.permission_id as permissionID, contract_type.name_eng as contracts, 
	section.name_thai as section, department.name_thai as department 
	
	FROM employee
	INNER JOIN  cost_center ON cost_center.cost_center_id = employee.cost_center_organization_id
	INNER JOIN section ON section.section_id = cost_center.section_id
	INNER JOIN department ON department.department_id = section.department_id
	INNER JOIN permission ON permission.permission_id = employee.permission_id
	INNER JOIN contract_type ON contract_type.contract_type_id = employee.contract_type_id WHERE employee.card_id = ?";

    $params = array($card_id);
    $stmt = sqlsrv_query($conn, $sql2, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($row) {
    } else {
        // หากไม่พบข้อมูลที่ตรงกัน
        echo "ไม่พบข้อมูลที่ตรงกับ line_id: $line_id";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>SCG | Fair Manpower</title>

    <!-- Site favicon -->
    <link rel="icon" type="image/ico" href="../../favicon.ico">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../../vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-steps/jquery.steps.css">
    <link rel="stylesheet" type="text/css" href="../../vendors/styles/style.css">

    <script src="../../asset/plugins/sweetalert2-11.10.1/jquery-3.7.1.min.js"></script>
    <script src="../../asset/plugins/sweetalert2-11.10.1/sweetalert2.all.min.js"></script>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .flex {
            display: flex;
        }

        .card-box {
            width: 100%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .pd-ltr-20 {
            display: flex;
            justify-content: space-between;
            align-items: start;
        }

        /* .upper-box {
        flex-grow: 1; 
        flex-basis: calc(25% - 10px); 
        margin: 5px;
        padding: 10px;
        box-sizing: border-box;
        } */

        .lower-box {
            flex-grow: 2;
            flex-basis: calc(100%);
            margin: 5px;
            padding: 10px;
            box-sizing: border-box;
        }

        @media (min-width: 768px) {

            .upper-box,
            .lower-box {
                flex-basis: calc(50% - 20px);
                margin: 10px;
            }
        }

        .upper-box,
        .lower-box {
            width: 100vw;
            /* 100% of the viewport width */
        }

        .custom-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
            max-width: 18rem;
        }

        .custom-card .card-header,
        .custom-card .card-body {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .custom-card .card-title {
            margin: 0;
            font-size: 1.25rem;
        }

        .custom-card .card-title span {
            font-size: 2.5rem;
        }

        .custom-card .col-md-4 {
            flex: 0 0 auto;
            width: 33.33333%;
        }

        .custom-card .mb-3 {
            margin-bottom: 1rem;
        }

        .card-body-month {
            min-height: 65px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .form-control,
        .form-select {
            height: 35px;
            margin-bottom: 0.5rem;
            padding: 5px 10px;
        }

        .card-header-month {
            padding: 5px 10px;
            font-size: 14px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-label {
            flex-basis: 20%;
            text-align: right;
            margin-right: 10px;
        }

        .form-control-container,
        .form-control-container-month {
            flex-basis: 75%;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .custom-select,
        .form-control {
            width: 100%;
        }

        .submit-button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .bi-filter {
            cursor: pointer;
        }

        /* top5 */
        .table {
            width: 90%;
            margin: auto;
        }

        thead th {
            font-size: 14px;
        }

        tbody {
            font-size: 12px;
        }

        th,
        td {
            padding: 3px;
        }
        #barchart_material {
            background-color: #1C1D3A; 
            border: 2px solid #3E4080; 
            box-shadow: 2px 4px 5px #3E4080; 
        }

        #chart_div {
            background-color: #1C1D3A; 
            border: 2px solid #3E4080; 
            box-shadow: 2px 4px 5px #3E4080; 
        }

        #donutchart {
            background-color: #1C1D3A;
            border: 2px solid #3E4080;
            box-shadow: 2px 4px 5px #3E4080;
        }

        #detailchart {
            background-color: #1C1D3A;
            border: 2px solid #3E4080;
            box-shadow: 2px 4px 5px #3E4080;
        }
        
        .data-table2 td {
            border: 2px solid #757575;
            padding: 8px;
        }

    </style>



</head>