<?php include('../head/include/header.php') ?>

<body>
    <?php include('../head/include/navbar.php') ?>
    <?php include('../head/include/sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="pd-20 card-box mb-30">
                    <div class="row">
                        <h2 class="p-3 h4 text-blue">
                            <i class="fa-solid fa-people-roof fa-lg"></i>
                            | พนักงานใต้บังคับบัญชาทั้งหมดของ
                            <b style="color: #2bc1c4"><?php echo 'คุณ' . $row['firstname_thai'] . ' ' . $row['lastname_thai'] ?></b>
                            <br />
                        </h2>
                    </div>
                    <div class="wizard-content">
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th >ลำดับ</th>
                                    <th >ตำแหน่ง</th>
                                    <th >รายชื่อลูกน้อง</th>
                                    <th >ประเภท</th>
                                    <th >สังกัดแผนก</th>
                                    <th class="datatable-nosort">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT m.manager_card_id AS ManagerCardID, m.card_id AS e_cardid, 
                                        e_m.prefix_thai AS e_pre, e_m.firstname_thai AS e_fname, e_m.lastname_thai AS e_lname,  e_m.scg_employee_id AS e_scg_id, e_m.employee_image AS e_img, e_m.phone_number AS e_phone,
                                        p.permission_id AS p_id, p.name AS p_name,
                                        cm.name_thai as contracts, 
								        se.name_thai as e_section, de.name_thai as e_department 
                                        FROM manager m                                        
                                        INNER JOIN employee e_m ON m.card_id = e_m.card_id
                                        INNER JOIN permission p ON p.permission_id = e_m.permission_id
                                        INNER JOIN cost_center ce ON ce.cost_center_id = e_m.cost_center_organization_id
                                        INNER JOIN section se ON se.section_id = ce.section_id
                                        INNER JOIN department de ON de.department_id = se.department_id
                                        INNER JOIN contract_type cm ON cm.contract_type_id = e_m.contract_type_id
                                        WHERE m.manager_card_id = $card_id

                                        UNION ALL

                                        SELECT r.report_to_card_id, r.card_id,
                                        e_rep.prefix_thai,e_rep.firstname_thai, e_rep.lastname_thai, e_rep.scg_employee_id, e_rep.employee_image, e_rep.phone_number,
                                        p_r.permission_id, p_r.name,
                                        ctr.name_thai, 
								        sr.name_thai, dr.name_thai
                                        FROM report_to r
                                        INNER JOIN employee e_rep ON r.card_id = e_rep.card_id
                                        INNER JOIN permission p_r ON p_r.permission_id = e_rep.permission_id
                                        INNER JOIN cost_center cr ON cr.cost_center_id = e_rep.cost_center_organization_id
                                        INNER JOIN section sr ON sr.section_id = cr.section_id
                                        INNER JOIN department dr ON dr.department_id = sr.department_id
                                        INNER JOIN contract_type ctr ON ctr.contract_type_id = e_rep.contract_type_id
                                        WHERE r.report_to_card_id IN (SELECT manager_card_id FROM manager)";
                                
                                $m_sql = "SELECT DISTINCT
                                ManagerCardID,
                                SubordinateID
                                 FROM (
                                SELECT 
                                    m.manager_card_id AS 'ManagerCardID',
                                    emp_m.card_id AS 'SubordinateID'
                                FROM
                                    manager m
                                INNER JOIN employee e ON e.card_id = m.manager_card_id
                                INNER JOIN employee emp_m ON emp_m.card_id = m.card_id
                                WHERE m.manager_card_id = $card_id
                            
                                UNION ALL
                            
                                SELECT 
                                    m.manager_card_id,
                                    emp_r.card_id
                                FROM
                                    manager m
                                INNER JOIN report_to r ON r.report_to_card_id = m.manager_card_id
                                INNER JOIN employee emp_r ON emp_r.card_id = r.card_id
                                WHERE m.manager_card_id = $card_id
                            ) AS CombinedResults";

                                $params = array();
                                $stmt = sqlsrv_query($conn, $sql, $params);

                                if ($stmt === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }
                                $i = 1;
                                $totalRows = 0;

                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $i++ . "</td>";
                                    echo "<td><div class='permission-" . $row["p_id"] . "'><b>" . $row["p_name"] . "</b></div></td>";
                                    echo "<td><div class='row'>",
                                    "<div>",
                                    '<img src="' . (!empty($row['e_img']) ? '../admin/uploads_img/' . $row['e_img'] : '../asset/img/admin.png') . '" class="border-radius-100 shadow" width="40" height="40" alt="">',
                                    "</div>",
                                    "<div><label>" . '  ' . $row["e_pre"] . '  ' . $row["e_fname"] . ' ' . $row["e_lname"] . " </label><br/>", "<a class ='text-primary'><i class='fa-solid fa-phone fa-sm' style='color: #1FBAC0;'></i>" . '  ' . $row["e_phone"] . " </a><br/>";
                                    echo "<td>" . $row["contracts"] . "</td>";
                                    echo "<td><a>" . $row["e_department"] . "</a><br><a>" . ' ' . $row["e_section"] . " </a></td>";
                                    echo '<td><button type="button" class="edit-btn_Org">',
                                    '<i class="fa-solid fa-address-card"></i>',
                                    '</button></td>';
                                    echo "</tr>";
                                    $totalRows++;
                                }
                                ?>
                            </tbody>
                            <p class='text-primary h4'> พนักงานใต้บังคับบัญชาทั้งหมด : <?php echo $totalRows  ?> คน</p>

                        </table>
                    </div>
                </div>
            </div>
            <?php include('../head/include/footer.php') ?>
        </div>
    </div>
    <!-- js -->
    <?php include('../head/include/scripts.php') ?>

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