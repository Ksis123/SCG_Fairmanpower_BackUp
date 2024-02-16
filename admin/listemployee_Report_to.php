<?php include('../admin/include/header.php') ?>

<body>
    <?php include('../admin/include/navbar.php') ?>
    <?php include('../admin/include/sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h3>ข้อมูล ผู้จัดการของพนักงาน</h3>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation" class="pt-3">
                                <ol class="breadcrumb">
                                    <a class="btn-back" href='listemployee_Manager.php'>
                                        <i class="fa-solid fa-circle-left fa-xl"></i> |
                                    </a>
                                    <li class="breadcrumb-item"><a href="listemployee.php"><i class="fa-solid fa-people-group"></i> พนักงานทั้งหมด</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Create.php"><i class="fa-solid fa-user-plus"></i> ข้อมูลพนักงานเบื้องต้น</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Manager.php"><i class="fa-solid fa-user-tie"></i> ผู้จัดการ</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-people-arrows"></i> report-to</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 pb-2">
                            <form method="post" action="listemployee_Report_to.php">
                                <label for="managerSelect">เลือก Report_to:</label>
                                <select name="selectedManager" id="managerSelect" class="form-control">
                                    <?php
                                    // ดึงรายการทั้งหมดของ report_to_card_id จากฐานข้อมูล
                                    $sql = "SELECT DISTINCT m.report_to_card_id as m_id, em.prefix_thai as em_pre,                                        
                                            em.firstname_thai as em_fname,
                                            em.lastname_thai as em_lname 
                                            FROM report_to m                                         
                                            INNER JOIN employee em ON m.report_to_card_id = em.card_id";
                                    $result = sqlsrv_query($conn, $sql);

                                    if ($result === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }

                                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                        echo "<option value='" . $row['m_id'] . "'>" . $row['em_pre'] . '' . $row['em_fname'] . ' ' . $row['em_lname'] . "</option>";
                                    }
                                    ?>
                                </select>
                        </div>
                        <div class="pt-4">
                            <input type="submit" value="แสดงข้อมูล" class="btn btn-primary">
                            </form>
                        </div>
                        <div class="col-lg-7 col-md-1 col-sm-1 text-right pt-4">
                            <button class="createdemp-btn" onclick="location.href='listemployee_Report_to_Add.php'"> + เพิ่มรายชื่อลูกน้องใหม่ </button>
                        </div>
                    </div>


                    <div class="wizard-content">
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th class="datatable-nosort">ลำดับ</th>
                                    <th class="datatable-nosort">รายชื่อผู้จัดการ</th>
                                    <th class="datatable-nosort">ตำแหน่ง</th>
                                    <th ></th>
                                    <th class="datatable-nosort">รายชื่อลูกน้อง</th>
                                    <th class="datatable-nosort">ตำแหน่ง</th>
                                    <th class="datatable-nosort">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // ตรวจสอบว่ามีการส่งค่าผ่าน POST หรือไม่
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $selectedManager = $_POST['selectedManager'];

                                    // ดึงข้อมูลจากตารางโดยใช้ manager_card_id ที่ผู้ใช้เลือก
                                    $sql = "SELECT 
                                    m.report_to_id as m_id,
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
                                    e.prefix_thai as e_pre,
                                    e.firstname_thai as e_fname, 
                                    e.lastname_thai as e_lname,  
                                    e.scg_employee_id as e_scg_id,
                                    e.employee_image as e_img,
                                    e.employee_email as e_email,
                                    p.permission_id as p_id,
                                    p.name as p_name,
                                    pm.permission_id as pm_id,
                                    pm.name as pm_name
                                    FROM report_to m
                                    INNER JOIN employee e ON m.card_id = e.card_id
                                    INNER JOIN employee em ON m.report_to_card_id = em.card_id
                                    INNER JOIN permission p ON p.permission_id = e.permission_id
                                    INNER JOIN permission pm ON pm.permission_id = em.permission_id
                                    WHERE m.report_to_card_id = ? ";

                                    $params = array($selectedManager);
                                } else {
                                    // ถ้ายังไม่ได้เลือก report_to_card_id ใด ๆ ให้ดึงข้อมูลทั้งหมด
                                    $sql = "SELECT 
                                    m.report_to_id as m_id,
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
                                    e.prefix_thai as e_pre,
                                    e.firstname_thai as e_fname, 
                                    e.lastname_thai as e_lname,  
                                    e.scg_employee_id as e_scg_id,
                                    e.employee_image as e_img,
                                    e.employee_email as e_email,
                                    p.permission_id as p_id,
                                    p.name as p_name,
                                    pm.permission_id as pm_id,
                                    pm.name as pm_name
                                    FROM report_to m
                                    INNER JOIN employee e ON m.card_id = e.card_id
                                    INNER JOIN employee em ON m.report_to_card_id = em.card_id
                                    INNER JOIN permission p ON p.permission_id = e.permission_id
                                    INNER JOIN permission pm ON pm.permission_id = em.permission_id";
                                    $params = array();
                                }

                                // ดึงข้อมูลจากฐานข้อมูล
                                $stmt = sqlsrv_query($conn, $sql, $params);

                                if ($stmt === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }
                                $i = 1;

                                // แสดงผลลัพธ์ในรูปแบบของตาราง HTML
                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $i++ . "</td>";
                                    echo "<td><div class='row'>",
                                    "<div style= 'padding-right: 5px;'>",
                                    '<img src="' . (!empty($row['em_img']) ? '../admin/uploads_img/' . $row['em_img'] : '../asset/img/admin.png') . '" class="border-radius-100 shadow" width="40" height="40" alt="">',
                                    "</div>",
                                    "<div><b>" . '  ' . $row["em_pre"] . '  ' . $row["em_fname"] . ' ' . $row["em_lname"] . " </b><br/>", "<a class ='text-primary'>" . $row["em_email"] . " </a><br/>";
                                    echo "<td><div class='permission-" . $row["pm_id"] . "'><b>" . $row["pm_name"] . "</b></div></td>";

                                    echo "<td><i class='fa-solid fa-arrow-right-arrow-left'></i></td>";

                                    echo "<td><div class='row'>",
                                    "<div style= 'padding-right: 5px;'>",
                                    '<img src="' . (!empty($row['e_img']) ? '../admin/uploads_img/' . $row['e_img'] : '../asset/img/admin.png') . '" class="border-radius-100 shadow" width="40" height="40" alt="">',
                                    "</div>",
                                    "<div><b>" . '  ' . $row["e_pre"] . '  ' . $row["e_fname"] . ' ' . $row["e_lname"] . " </b><br/>", "<a class ='text-primary'>" . $row["e_email"] . " </a><br/>";
                                    echo "<td><div class='permission-" . $row["p_id"] . "'><b>" . $row["p_name"] . "</b></div></td>";

                                    echo '<td><div class="flex">',
                                    '<button type="button" name="delete_report_to" class="delete-btn_Org" onclick="deletereport_to(\'' . $row['m_id'] . '\');" ><i class="fa-solid fa-trash-can"></i></button>';

                                    echo '</div></td>';
                                    echo '</div></td>';
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <?php include('../admin/include/footer.php') ?>
        </div>
    </div>

    <!-- Modal Start -->
    <div class="modal fade" id="editManagerModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขรายชื่อลูกน้องใต้บังคับบัญชา</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing data -->
                    <form id="editForm" method="post" action="listemployee_Manager.php">
                        <input name="manager_id" type="hidden" id="editManagerInput">
                        <div class="row" style="justify-content: space-between; align-items: center;">
                            <div class="col-lg-6 mb-6">
                                <div class="card h-40">
                                    <p class="card-header" style="color: #000">ผู้จัดการ</p>
                                    <div class="card-body">
                                        <label for="editManager_card_id">เลือกผู้จัดการ</label>
                                        <select name="manager" class="custom-select form-control" autocomplete="off" required="true" id="editManager_card_id" disabled>
                                            <?php
                                            // ประกาศตัวแปร JavaScript สำหรับเก็บค่ารหัสผู้จัดการ
                                            echo "<script>var selectedManagerCardId;</script>";
                                            $sql = "SELECT * FROM employee WHERE permission_id = 2";
                                            $result = sqlsrv_query($conn, $sql);

                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='"  . $row['card_id'] . "'>" . $row['prefix_thai'] . '' . $row['firstname_thai'] . ' ' . $row['lastname_thai'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                        <script>
                                            // เมื่อเปลี่ยนแปลงค่าใน select
                                            $("#editManager_card_id").on("change", function() {
                                                // ดึงค่ารหัสผู้จัดการที่เลือก
                                                selectedManagerCardId = $(this).val();
                                            });

                                            // เมื่อทำการ submit ฟอร์ม
                                            $("#editForm").on("submit", function() {
                                                // นำค่ารหัสผู้จัดการมาใส่ในฟอร์ม
                                                $("#editManagerInput").val(selectedManagerCardId);
                                            });
                                        </script>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6 mb-6">
                                <div class="card h-40">
                                    <p class="card-header" style="color: #000">พนักงาน</p>
                                    <div class="card-body"> <label for="editCard_id">เลือกพนักงาน</label>
                                        <select name="employee" class="custom-select form-control" required="true" autocomplete="off" id="editCard_id">
                                            <?php
                                            $sql = "SELECT * FROM employee WHERE permission_id = 4";
                                            $result = sqlsrv_query($conn, $sql);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='"  . $row['card_id'] . "'>" . $row['prefix_thai'] . '' . $row['firstname_thai'] . ' ' . $row['lastname_thai'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-12">
                                <label for="editDivisionNameEng">* เหตุผลของการแก้ไข</label>
                                <textarea type="text" class="form-control" id="editDetail" name="edit_detail" required="true" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <label style="font-size:16px;"><b></b></label>
                                <div class="text-right">
                                    <button class="btn btn-primary" name="update_business">แก้ไขรายชื่อลูกน้องใหม่</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    // -- UPDATE Manager based on manager_id -->
                    if (isset($_POST['update_business'])) {
                        // ตรวจสอบว่ามีข้อมูลที่ต้องการ
                        $manager_id = $_POST['manager_id'];
                        $manager = $_POST['manager'];
                        $employee = $_POST['employee'];
                        $edit_detail = $_POST['edit_detail'];

                        // อัปเดตค่าของฟิลด์ manager_card_id, card_id, edit_detail
                        $sqlUpdate = "UPDATE manager SET manager_card_id = ?, card_id = ?, edit_detail = ? WHERE manager_id = ?";
                        $paramsUpdate = array($manager, $employee, $edit_detail, $manager_id);
                        $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsUpdate);

                        if ($stmtUpdate === false) {
                            die(print_r(sqlsrv_errors(), true));
                        } else {
                            echo '<script type="text/javascript">
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 980,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.onmouseenter = Swal.stopTimer;
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                            });
                                            Toast.fire({
                                                icon: "success",
                                                title: "แก้ไขข้อมูล ลูกน้อง สำเร็จ"
                                            });
                                        </script>';

                            echo "<meta http-equiv='refresh' content='1'>";
                            exit; // จบการทำงานของสคริปต์ทันทีหลังจาก redirect
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->

    <!-- js -->
    <?php include('../admin/include/scripts.php') ?>

    <script>
        $(document).ready(function() {
            // ตัวเลือก: จัดการเหตุการณ์เปิด modal เพื่อดำเนินการเพิ่มเติม
            $('#addManagerModal').on('shown.bs.modal', function() {
                // รหัสที่จะทำงานเมื่อ modal เปิด
            });
        });
    </script>

</body>

</html>