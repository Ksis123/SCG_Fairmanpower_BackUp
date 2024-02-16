<?php
session_start(); // เรียกใช้ session_start() ก่อนที่จะใช้ session

require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

// ตรวจสอบว่ามี Session 'line_id' หรือไม่ และค่าของ 'line_id' ไม่เป็นค่าว่าง
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

    // ส่วนการค้นหา manager ที่มี $card_id เป็นลูกน้องอยู่แล้วในฐานข้อมูล
    $msql = "SELECT m.manager_id as m_id,  
    m.manager_card_id as em_id,                                                                       
    m.edit_time,                                                                         
    m.edit_detail as em_detail,                                                                         
    m.card_id as e_id,                                                                        
    em.prefix_thai as em_pre,                                                                                                            
    em.firstname_thai as em_fname,                                                                       
    em.lastname_thai as em_lname,                                                                       
    em.scg_employee_id as em_scg_id,                                                                        
    em.employee_image as em_img,                                                                         
    em.employee_email as em_email,																		
    em.phone_number as em_phone,
    cost_center.cost_center_code as em_cost,																																																																		
    section.name_thai as section, 
    department.name_thai as department, 																		
    pm.permission_id as pm_id,                                    									
    pm.name as pm_name                                                                       
    FROM manager m                                                                        
    INNER JOIN employee e ON m.card_id = e.card_id                                                                       
    INNER JOIN employee em ON m.manager_card_id = em.card_id
    INNER JOIN cost_center ON cost_center.cost_center_id = em.cost_center_organization_id
    INNER JOIN section ON section.section_id = cost_center.section_id
    INNER JOIN department ON department.department_id = section.department_id
    INNER JOIN permission p ON p.permission_id = e.permission_id
    INNER JOIN permission pm ON pm.permission_id = em.permission_id
    WHERE m.card_id = ? ";
    $mparams = array($card_id);
    $mstmt = sqlsrv_query($conn, $msql, $mparams);

    if ($mstmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $manger = sqlsrv_fetch_array($mstmt, SQLSRV_FETCH_ASSOC);

    // ส่วนการค้นหา report-to ที่มี $card_id เป็นลูกน้องอยู่แล้วในฐานข้อมูล
    $r_sql = "SELECT m.report_to_id as m_id,  
        m.report_to_card_id as em_id,                                                                       
        m.edit_time,                                                                         
        m.edit_detail as em_detail,                                                                         
        m.card_id as e_id,                                                                        
        em.prefix_thai as em_pre,                                                                                                            
        em.firstname_thai as em_fname,                                                                       
        em.lastname_thai as em_lname,                                                                       
        em.scg_employee_id as em_scg_id,                                                                        
        em.employee_image as em_img,                                                                         
        em.employee_email as em_email,																		
        em.phone_number as em_phone,
        cost_center.cost_center_code as em_cost,																																																																		
        section.name_thai as section, 
        department.name_thai as department, 																		
        pm.permission_id as pm_id,                                    									
        pm.name as pm_name                                                                       
        FROM report_to m                                                                        
        INNER JOIN employee e ON m.card_id = e.card_id                                                                       
        INNER JOIN employee em ON m.report_to_card_id = em.card_id
        INNER JOIN cost_center ON cost_center.cost_center_id = em.cost_center_organization_id
        INNER JOIN section ON section.section_id = cost_center.section_id
        INNER JOIN department ON department.department_id = section.department_id
        INNER JOIN permission p ON p.permission_id = e.permission_id
        INNER JOIN permission pm ON pm.permission_id = em.permission_id
        WHERE m.card_id = ? ";
    $r_params = array($card_id);
    $r_stmt = sqlsrv_query($conn, $r_sql, $r_params);

    if ($r_stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if (sqlsrv_has_rows($r_stmt)) {
        $r_port = sqlsrv_fetch_array($r_stmt, SQLSRV_FETCH_ASSOC);
        // ประมวลผลข้อมูลที่ได้รับ
    } else {
        // กรณีไม่พบข้อมูล
        $r_port = array();  // กำหนดค่าเป็น array ว่างหรือตามที่คุณต้องการ
    }

    // ส่วนคำสั่ง SQL ควรตรงกับโครงสร้างของตารางในฐานข้อมูล
    $sql2 = "SELECT *,
permission.name as permission, permission.permission_id as permissionID, contract_type.name_eng as contracts, contract_type.name_thai as contract_th,
section.name_thai as section, department.name_thai as department 

FROM employee
INNER JOIN cost_center ON cost_center.cost_center_id = employee.cost_center_organization_id
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

    // ตรวจสอบว่ามีข้อมูลในตาราง employee_info หรือไม่
    $check_employee_info_sql = "SELECT * FROM employee_info WHERE card_id = ?";
    $check_employee_info_params = array($card_id);
    $check_employee_info_stmt = sqlsrv_query($conn, $check_employee_info_sql, $check_employee_info_params);

    if ($check_employee_info_stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $has_employee_info = sqlsrv_has_rows($check_employee_info_stmt);

    // ถ้าไม่มีข้อมูลในตาราง employee_info ให้ทำการ INSERT
    if (!$has_employee_info) {
        $insert_employee_info_sql = "INSERT INTO employee_info (card_id) VALUES (?)";
        $insert_employee_info_params = array($card_id); // แทนค่า $value1, $value2, ... ด้วยค่าที่ต้องการใส่
        $insert_employee_info_stmt = sqlsrv_query($conn, $insert_employee_info_sql, $insert_employee_info_params);

        if ($insert_employee_info_stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo "ข้อมูลถูกเพิ่มลงในตาราง employee_info";
    } else {
        echo "มีข้อมูลในตาราง employee_info แล้ว | ";
    }

    // ตรวจสอบว่ามีข้อมูลในตาราง education_info หรือไม่
    $check_education_info_sql = "SELECT * FROM education_info WHERE card_id = ?";
    $check_education_info_params = array($card_id);
    $check_education_info_stmt = sqlsrv_query($conn, $check_education_info_sql, $check_education_info_params);

    if ($check_education_info_stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $has_education_info = sqlsrv_has_rows($check_education_info_stmt);

    // ถ้าไม่มีข้อมูลในตาราง education_info ให้ทำการ INSERT
    if (!$has_education_info) {
        $insert_education_info_sql = "INSERT INTO education_info (card_id) VALUES (?)";
        $insert_education_info_params = array($card_id); // แทนค่า $value1, $value2, ... ด้วยค่าที่ต้องการใส่
        $insert_education_info_stmt = sqlsrv_query($conn, $insert_education_info_sql, $insert_education_info_params);

        if ($insert_education_info_stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo "ข้อมูลถูกเพิ่มลงในตาราง education_info";
    } else {
        echo "มีข้อมูลในตาราง education_info แล้ว ";
    }

    // ส่วนการค้นหา employee_info ที่มี $card_id อยู่แล้วในฐานข้อมูล
    $sql_info = "SELECT *
FROM employee_info e_info
INNER JOIN employee e ON e.card_id = e_info.card_id
WHERE e_info.card_id = ?";

    $e_params = array($card_id);
    $e_stmt = sqlsrv_query($conn, $sql_info, $e_params);

    if ($e_stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $e_info = sqlsrv_fetch_array($e_stmt, SQLSRV_FETCH_ASSOC);
    if ($e_info) {
    } else {
        // หากไม่พบข้อมูลที่ตรงกัน
        echo "ไม่พบข้อมูลที่ตรงกับ card_id: $card_id บน employee_info";
    }

    // ส่วนการค้นหา education_info ที่มี $card_id อยู่แล้วในฐานข้อมูล
    $sql_edu = "SELECT *
    FROM education_info e_edu
    INNER JOIN employee e ON e.card_id = e_edu.card_id
    WHERE e_edu.card_id = ?";

    $e_edu_params = array($card_id);
    $e_edu_stmt = sqlsrv_query($conn, $sql_edu, $e_edu_params);

    if ($e_edu_stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $e_edu = sqlsrv_fetch_array($e_edu_stmt, SQLSRV_FETCH_ASSOC);
    if ($e_edu) {
    } else {
        // หากไม่พบข้อมูลที่ตรงกัน
        echo "ไม่พบข้อมูลที่ตรงกับ card_id: $card_id";
    }

    $date2 = new DateTime();
    $date2->setTimezone(new DateTimeZone('Asia/Bangkok'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>SCG | Fair Manpower</title>

    <!-- Site favicon -->
    <link rel="icon" type="image/ico" href="../favicon.ico">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="../vendors/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/jquery-steps/jquery.steps.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css">

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
    <?php include('../admin/include/navbar.php') ?>
    <?php include('../admin/include/sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20">

            <div class="row">
                <div class="col-xl-3 col-lg-2 col-md-6 mb-10 title pb-20">
                    <h2 class="h3 mb-0">แบบประเมินทั้งหมด</h2>
                </div>
                <div class="col-xl-9 col-lg-2 col-md-6 mb-10">
                    <div class="text-right">
                        <button onclick="window.location.href = 'addquiz.php'" class='btn btn-primary'>เพิ่มแบบประเมิน</button>
                    </div>
                </div>
            </div>
            <div class="card-box pd-20 height-100-p mb-30">
                <!-- main start -->
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>ประเภทพนักงาน</th>
                            <th>วันที่เริ่มประเมิน</th>
                            <th>วันที่จบประเมิน</th>
                            <th class="datatable-nosort">แก้ไข/ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // เตรียมคำสั่ง SQL
                        $sql = "SELECT * FROM assessment asm
                            INNER JOIN contract_type ctt ON ctt.contract_type_id = asm.contract_type_id";
                        // ดึงข้อมูลจากฐานข้อมูล
                        $stmt = sqlsrv_query($conn, $sql);

                        // ตรวจสอบการทำงานของคำสั่ง SQL
                        if ($stmt === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        // แสดงผลลัพธ์ในรูปแบบของตาราง HTML
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

                            $time_start  = $row["date_start"]; // สร้างวัตถุ DateTime
                            $formattedDateStart = $time_start->format('Y-m-d');

                            $time_end  = $row["date_end"]; // สร้างวัตถุ DateTime
                            $formattedDateEnd =  $time_end->format('Y-m-d');
                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["name_thai"] . "</td>";
                            echo "<td>" . $formattedDateStart . "</td>";
                            echo "<td>"  . $formattedDateEnd .  "</td>";
                            echo "<td><button class='edit-btn_Org'><span class='checkmark'>✎</span></button>",
                            "<button id='deletebtn' class='delete-btn_Org'  style='display :none;' onclick='deleteRecord( " . $row['assessment_id'] . ")'></button> 
                        <button class='delete-btn_Org' onclick='showSweetAlert()'>
                        <span class='checkmark'>&#10008;</span>
                    </button> </td>";

                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
                <script>
                    // SweetAlert2 Popup
                    function showSweetAlert() {
                        console.log('showSweetAlert function is called'); // แสดงข้อความใน Console
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "green-swal",
                                cancelButton: "delete-swal"
                            },
                            buttonsStyling: false
                        });
                        swalWithBootstrapButtons.fire({
                            title: 'คำเตือน',
                            text: 'ถ้าคุณดำเนินการแล้วจะไม่สามารถแก้ไขได้ ต้องการดำเนินการต่อหรือไม่?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'ตกลง',
                            cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // ทำงานเมื่อผู้ใช้คลิก "ตกลง"
                                swalWithBootstrapButtons.fire('ดำเนินการสำเร็จ!', '', 'success').then(() => {
                                    // ส่ง form ไปยังหน้าปลายทาง
                                    document.getElementById('deletebtn').click(); // กำหนดค่าคลิกปุ่ม
                                });
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                // ทำงานเมื่อผู้ใช้คลิก "ยกเลิก"
                                swalWithBootstrapButtons.fire('การดำเนินการถูกยกเลิก', '', 'error')
                            }
                        });
                    }

                    function deleteRecord(assessmentId) {
                        // ส่ง request ไปยัง server เพื่อทำการลบข้อมูล
                        var xhr = new XMLHttpRequest();

                        // กำหนด method และ url ที่จะส่ง request ไป
                        xhr.open('POST', 'delete_assessment.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        // กำหนด callback function สำหรับการตอบสนองจาก server
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // ทำตามขั้นตอนที่คุณต้องการหลังจากลบข้อมูลสำเร็จ
                                alert('Record deleted successfully!');
                                // ตัวอย่าง: รีโหลดหน้าหลังจากลบข้อมูล
                                window.location.reload();
                            }
                        };

                        // ส่ง request พร้อมกับข้อมูลที่ต้องการส่งไปยัง server
                        xhr.send('action=delete&assessment_id=' + assessmentId);
                    }
                </script>

                <!-- main end -->

                <!-- <div class="btn-permiss">
                    <button onclick="window.location.href = 'emp_main.php'" class='btn-pm'>เปลี่ยนเป็นพนักงาน</button>
                </div> -->
                <!-- bottom Nav start -->
                <!-- <div class="navigation" id="bottomNav">
                    <button onclick="window.location.href = 'addmin_main.php'" class="nav-item button-48 active"><img src="../asset/img/evaluate/pencil.png" class="icon"> </button>
                    <button onclick="window.location.href = 'KPI.php'" class="nav-item button-48"><img src="../asset/img/evaluate/kpi.png" class="icon"></button>
                </div> -->

                <div class="profile-tab height-100-p pt-10">
                    <div class="tab height-100-p">
                        <div class="nav nav-tabs customtab" role="tablist">
                            <a class="nav-link active" href='addmin_main.php'><img src="../asset/img/evaluate/pencil.png" class="icon"></ฟ>
                                <a class="nav-link" href='KPI.php'><img src="../asset/img/evaluate/kpi.png" class="icon"></a>
                        </div>
                    </div>
                </div>

                <!-- bottom Nav end -->

            </div>
        </div>
        <?php include('../admin/include/footer.php') ?>
    </div>
    <?php include('../admin/include/scripts.php') ?>


</body>

</html>