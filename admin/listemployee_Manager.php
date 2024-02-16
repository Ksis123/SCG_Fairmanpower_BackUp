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
                                    <a class="btn-back" href='listemployee_Create.php'>
                                        <i class="fa-solid fa-circle-left fa-xl"></i> |
                                    </a>
                                    <li class="breadcrumb-item"><a href="listemployee.php"><i class="fa-solid fa-people-group"></i> พนักงานทั้งหมด</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Create.php"> <i class="fa-solid fa-user-plus"></i> ข้อมูลพนักงานเบื้องต้น</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-user-tie"></i> ผู้จัดการ - Report-to</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-3">
                            <form method="post" action="listemployee_Manager.php" class="d-flex align-items-center">
                                <div class="form-group mt-2 mr-2 flex">
                                    <select name="selectedManager" id="managerSelect" class="form-control selectpicker">
                                        <option value="" disabled>ระบุ ผู้จัดการ</option>
                                        <option value="เลือกผู้จัดการทั้งหมด" selected>ผู้จัดการทั้งหมด</option>
                                        <?php
                                        // ดึงรายการทั้งหมดของ manager_card_id จากฐานข้อมูล
                                        $sql = "SELECT DISTINCT m.manager_card_id as m_id, em.prefix_thai as em_pre,                                        
                                            em.firstname_thai as em_fname,
                                            em.lastname_thai as em_lname 
                                            FROM manager m                                         
                                            INNER JOIN employee em ON m.manager_card_id = em.card_id";
                                        $result = sqlsrv_query($conn, $sql);

                                        if ($result === false) {
                                            die(print_r(sqlsrv_errors(), true));
                                        }

                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                            echo "<option value='" . $row['m_id'] . "'>" . $row['em_pre'] . ' ' . $row['em_fname'] . ' ' . $row['em_lname'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" value="แสดงข้อมูล" class="btn btn-primary ">

                            </form>
                        </div>

                        <div class="col-md-7 col-sm-7 text-right">
                            <button class="createdemp-btn" onclick="location.href='listemployee_Manager_Add.php'"> + เพิ่มรายชื่อลูกน้องใหม่ </button>
                        </div>
                    </div>


                    <div class="wizard-content">
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th >รายชื่อลูกน้อง</th>
                                    <th class="datatable-nosort"> ▶ </th>
                                    <th >ชื่อผู้จัดการ</th>
                                    <th >Cost-center Organization</th>
                                    <th >Report-to</th>
                                    <th >Cost-center Payment</th>
                                    <th class="datatable-nosort">แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // ตรวจสอบว่ามีการส่งค่าผ่าน POST หรือไม่
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $selectedManager = $_POST['selectedManager'];

                                    if ($selectedManager == 'เลือกผู้จัดการทั้งหมด') {

                                         // กรณี เลือก ผู้จัดการทั้งหมด แสดงรายชื่อลูกน้องทั้งหมด
                                       
                                        $sql = "SELECT 
                                            m.manager_id as m_id,
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
                                            em.cost_center_organization_id as em_org,
                                            cos_em.cost_center_code as cos_org,
                                            sm.name_thai as m_section, 
                                            dm.name_thai as m_department, 
                                            e.prefix_thai as e_pre,
                                            e.firstname_thai as e_fname, 
                                            e.lastname_thai as e_lname,  
                                            e.scg_employee_id as e_scg_id,
                                            e.employee_image as e_img,
                                            e.employee_email as e_email,
                                            p.permission_id as p_id,
                                            p.name as p_name,
                                            pm.permission_id as pm_id,
                                            pm.name as pm_name,
                                            rt.report_to_card_id as r_id,
                                            ert.prefix_thai as r_pre,                                        
                                            ert.firstname_thai as r_fname,
                                            ert.lastname_thai as r_lname,
                                            ert.employee_image as r_img,                                        
                                            ert.employee_email as r_email,
                                            ert.cost_center_organization_id as rcos_id,
                                            cos_rt.cost_center_code as r_org
                                            FROM manager m
                                            INNER JOIN employee e ON m.card_id = e.card_id
                                            INNER JOIN employee em ON m.manager_card_id = em.card_id
                                            INNER JOIN cost_center cos_e ON cos_e.cost_center_id = e.cost_center_organization_id
                                            INNER JOIN section sm ON sm.section_id = cos_e.section_id
                                            INNER JOIN department dm ON dm.department_id = sm.department_id
                                            INNER JOIN cost_center cos_em ON cos_em.cost_center_id = em.cost_center_organization_id
                                            INNER JOIN permission p ON p.permission_id = e.permission_id
                                            INNER JOIN permission pm ON pm.permission_id = em.permission_id
                                
                                            LEFT JOIN report_to rt ON rt.card_id = m.card_id
                                            LEFT JOIN employee ert ON ert.card_id = rt.report_to_card_id
                                            LEFT JOIN cost_center cos_rt ON cos_rt.cost_center_id = ert.cost_center_organization_id
                                            LEFT JOIN section rsm ON rsm.section_id = cos_rt.section_id
                                            LEFT JOIN department rdm ON rdm.department_id = rsm.department_id
                                            LEFT JOIN permission r_pm ON r_pm.permission_id = ert.permission_id";
                                    } else {

                                        // กรณี เลือก ผู้จัดการ ตามชื่อ แสดงรายชื่อลูกน้องทั้งหมดของ ผู้จัดการคนนั้น
                                        $sql = "SELECT 
                                            m.manager_id as m_id,
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
                                            em.cost_center_organization_id as em_org,
                                            cos_em.cost_center_code as cos_org,
                                            sm.name_thai as m_section, 
                                            dm.name_thai as m_department, 
                                            e.prefix_thai as e_pre,
                                            e.firstname_thai as e_fname, 
                                            e.lastname_thai as e_lname,  
                                            e.scg_employee_id as e_scg_id,
                                            e.employee_image as e_img,
                                            e.employee_email as e_email,
                                            p.permission_id as p_id,
                                            p.name as p_name,
                                            pm.permission_id as pm_id,
                                            pm.name as pm_name,
                                            rt.report_to_card_id as r_id,
                                            ert.prefix_thai as r_pre,                                        
                                            ert.firstname_thai as r_fname,
                                            ert.lastname_thai as r_lname,
                                            ert.employee_image as r_img,                                        
                                            ert.employee_email as r_email,
                                            ert.cost_center_organization_id as rcos_id,
                                            cos_rt.cost_center_code as r_org
                                            FROM manager m
                                            INNER JOIN employee e ON m.card_id = e.card_id
                                            INNER JOIN employee em ON m.manager_card_id = em.card_id
                                            INNER JOIN cost_center cos_e ON cos_e.cost_center_id = e.cost_center_organization_id
                                            INNER JOIN section sm ON sm.section_id = cos_e.section_id
                                            INNER JOIN department dm ON dm.department_id = sm.department_id
                                            INNER JOIN cost_center cos_em ON cos_em.cost_center_id = em.cost_center_organization_id
                                            INNER JOIN permission p ON p.permission_id = e.permission_id
                                            INNER JOIN permission pm ON pm.permission_id = em.permission_id
                                
                                            LEFT JOIN report_to rt ON rt.card_id = m.card_id
                                            LEFT JOIN employee ert ON ert.card_id = rt.report_to_card_id
                                            LEFT JOIN cost_center cos_rt ON cos_rt.cost_center_id = ert.cost_center_organization_id
                                            LEFT JOIN section rsm ON rsm.section_id = cos_rt.section_id
                                            LEFT JOIN department rdm ON rdm.department_id = rsm.department_id
                                            LEFT JOIN permission r_pm ON r_pm.permission_id = ert.permission_id
                                            WHERE m.manager_card_id = ?";

                                        $params = array($selectedManager);
                                    }
                                } else {

                                    // กรณี ไม่ได้เลือก ผู้จัดการ แสดงรายชื่อลูกน้องทั้งหมด
                                    $sql = "SELECT 
                                        m.manager_id as m_id,
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
                                        em.cost_center_organization_id as em_org,
                                        cos_em.cost_center_code as cos_org,
                                        sm.name_thai as m_section, 
                                        dm.name_thai as m_department, 
                                        e.prefix_thai as e_pre,
                                        e.firstname_thai as e_fname, 
                                        e.lastname_thai as e_lname,  
                                        e.scg_employee_id as e_scg_id,
                                        e.employee_image as e_img,
                                        e.employee_email as e_email,
                                        p.permission_id as p_id,
                                        p.name as p_name,
                                        pm.permission_id as pm_id,
                                        pm.name as pm_name,
                                        rt.report_to_card_id as r_id,
                                        ert.prefix_thai as r_pre,                                        
                                        ert.firstname_thai as r_fname,
                                        ert.lastname_thai as r_lname,
                                        ert.employee_image as r_img,                                        
                                        ert.employee_email as r_email,
                                        ert.cost_center_organization_id as rcos_id,
                                        cos_rt.cost_center_code as r_org
                                        FROM manager m
                                        INNER JOIN employee e ON m.card_id = e.card_id
                                        INNER JOIN employee em ON m.manager_card_id = em.card_id
                                        INNER JOIN cost_center cos_e ON cos_e.cost_center_id = e.cost_center_organization_id
                                        INNER JOIN section sm ON sm.section_id = cos_e.section_id
                                        INNER JOIN department dm ON dm.department_id = sm.department_id
                                        INNER JOIN cost_center cos_em ON cos_em.cost_center_id = em.cost_center_organization_id
                                        INNER JOIN permission p ON p.permission_id = e.permission_id
                                        INNER JOIN permission pm ON pm.permission_id = em.permission_id
                                
                                        LEFT JOIN report_to rt ON rt.card_id = m.card_id
                                        LEFT JOIN employee ert ON ert.card_id = rt.report_to_card_id
                                        LEFT JOIN cost_center cos_rt ON cos_rt.cost_center_id = ert.cost_center_organization_id
                                        LEFT JOIN section rsm ON rsm.section_id = cos_rt.section_id
                                        LEFT JOIN department rdm ON rdm.department_id = rsm.department_id
                                        LEFT JOIN permission r_pm ON r_pm.permission_id = ert.permission_id";

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

                                    echo "<td><div class='row'>",
                                    "<div class='pl-2 pr-1'>",
                                    '<img src="' . (!empty($row['e_img']) ? '../admin/uploads_img/' . $row['e_img'] : '../asset/img/admin.png') . '" class="border-radius-100 shadow" width="40" height="40" style="max-width: 100%; max-height: 100%;">',
                                    "</div>",
                                    "<div><b>" . '  ' . $row["e_pre"] . '  ' . $row["e_fname"] . ' ' . $row["e_lname"] . " </b><br/>", "<a class ='text-primary'>" . $row["e_email"] . " </a><br/>";
                                    echo "<td><i class='fa-solid fa-arrow-right-arrow-left'></i></td>";



                                    echo "<td><div class='row'>",
                                    "<div class='pr-2'>",
                                    '<img src="' . (!empty($row['em_img']) ? '../admin/uploads_img/' . $row['em_img'] : '../asset/img/admin.png') . '" class="border-radius-100 shadow" width="40" height="40" >',
                                    "</div>",
                                    "<div><b>" . '  ' . $row["em_pre"] . '  ' . $row["em_fname"] . ' ' . $row["em_lname"] . " </b><br/>", "<a class ='text-primary'>" . $row["em_email"] . " </a><br/>";
                                    echo "<td>" . $row["cos_org"] . "</td>";

                                    echo "<td><div class='row'>",
                                    "<div class='pr-2'>",
                                    '<img src="' . (!empty($row['r_img']) ? '../admin/uploads_img/' . $row['r_img'] : '../asset/img/admin.png') . '" class="border-radius-100 shadow" width="40" height="40" >',
                                    "</div>",
                                    "<div><b>" . '  ' . $row["r_pre"] . '  ' . $row["r_fname"] . ' ' . $row["r_lname"] . " </b><br/>", "<a class ='text-primary'>" . $row["r_email"] . " </a><br/>";
                                    echo "<td>" . $row["r_org"] . "</td>";


                                    echo '<td><div class="flex">';
                                    echo '<button type="button" class="edit-btn_Org" onclick="editmanager(\'' . $row['m_id'] . '\');">',

                                    '<i class="fa-solid fa-pencil"></i>',
                                    '</button></div></td>';
                                    echo '</button>';
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

    <!-- js -->
    <?php include('../admin/include/scripts.php') ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ดึงค่า selectedManager ที่ถูกส่งมาจาก PHP
            var selectedManager = '<?php echo isset($selectedManager) ? $selectedManager : ""; ?>';

            // กำหนดค่า selectedManager ใน <select>
            document.getElementById('managerSelect').value = selectedManager;
        });
    </script>
    <script>
        $(document).ready(function() {
            // ตัวเลือก: จัดการเหตุการณ์เปิด modal เพื่อดำเนินการเพิ่มเติม
            $('#addManagerModal').on('shown.bs.modal', function() {
                // รหัสที่จะทำงานเมื่อ modal เปิด
            });
        });
    </script>

    <script>
        function editmanager(mangerid, reporttoid) {
            // ส่งค่า m_id ไปยังหน้า listemployee_Manager_Edit.php
            window.location.href = 'listemployee_Manager_Edit.php?m_id=' + mangerid;
        }
    </script>

</body>

</html>