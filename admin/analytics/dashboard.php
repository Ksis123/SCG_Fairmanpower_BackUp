<?php
session_start(); // เรียกใช้ session_start() ก่อนที่จะใช้ session
// require_once('C:\xampp\htdocs\dashboard analytics\config\connection.php');

require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php'); //ตรวจสอบว่ามี Session 'line_id' หรือไม่ และค่าของ 'line_id' ไม่เป็นค่าว่าง
$date2 = new DateTime();
$date2->setTimezone(new DateTimeZone('Asia/Bangkok'));

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
    $sql2 = "SELECT *,
	permission.name as permission, permission.permission_id as permissionID, contract_type.name_eng as contracts, contract_type.name_thai as contract_th,
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

    <style>
        .flex {
            display: flex;
        }
    </style>



    <!DOCTYPE html>
    <html>

    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8">
        <title>SCG | Fair Manpower</title>

        <!-- Site favicon -->
        <link rel="icon" type="image/ico" href="../favicon.ico">

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="../../vendors/styles/core.css">
        <link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-steps/jquery.steps.css">
        <link rel="stylesheet" type="text/css" href="../../vendors/styles/style.css">

        <script src="../asset/plugins/sweetalert2-11.10.1/jquery-3.7.1.min.js"></script>
        <script src="../asset/plugins/sweetalert2-11.10.1/sweetalert2.all.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        
        <!-- Chagan Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&family=Inter:wght@600&family=Noto+Sans+Thai:wght@500&display=swap" rel="stylesheet">
        <style>
            .flex {
                display: flex;
            }
        </style>

    </head>

<body>
    <?php include('../analytics/include/navbar.php') ?>
    <?php include('../analytics/include/sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="title pb-20">
                <h2 class="h3 mb-0">Darshboard Data Analytics</h2>
            </div>
            <div class="card-box pd-20 height-100-p mb-30">
                <h4 class="font-20 weight-500 mb-10 text-capitalize">
                    SCG : Fair Manpower ยินดีให้บริการ <h4 class="weight-600 font-15 text-primary"></h4>
                </h4>
                <p class="font-18 max-width-1000">* หมายเหตุ ข้อมูลอัพเดต ณ วันที่ <?php echo $date2->format("D, d M Y") ?>
                <p class="font-18 max-width-800 text-danger">พรใดๆ ที่ว่าดีในโลกนี้ ขอมาอวยชัยให้คนดี จงมีแต่ความสุขตลอดกาล</p>
                </p>
            </div>
            <div class="card-box pd-20 height-100-p mb-30">
                <h4 class="font-20 weight-500 mb-10 text-capitalize">
                    เลือกหัวข้อ Analytics ที่สนใจ <h4 class="weight-600 font-15 text-primary"></h4>
                </h4>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" id="dropdownMenuInput" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        SELECT
                    </button>
                    <ul class="dropdown-menu" id="dropdownMenuList">
                        <li><a class="dropdown-item" href="OT.php">วิเคราะห์ข้อมูลการทำ OT</a></li>
                        <li><a class="dropdown-item" href="OT36Hours.php">การทำ OT เกิน 36 ชั่วโมงต่อสัปดาห์</a></li>
                        <li><a class="dropdown-item" href="filter.php">Test Filter</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php include('../analytics/include/footer.php') ?>
    </div>

    <!-- js -->
    <?php include('../../admin/include/scripts.php') ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdown = document.getElementById('dropdownMenuInput');
            var menu = document.getElementById('dropdownMenuList');

            dropdown.addEventListener('click', function(event) {
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
                event.stopPropagation();
            });

            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && !menu.contains(e.target)) {
                    menu.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>