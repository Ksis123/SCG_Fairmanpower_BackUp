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
                                    <li class="breadcrumb-item"><a><i class="fa-solid fa-user-plus"></i> ข้อมูลพนักงานเบื้องต้น</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-user-tie"></i> ผู้จัดการ - Report-to</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="wizard-content">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h5"> แบบฟอร์มระบุพนักงานให้ ผู้จัดการ <i class="fa-solid fa-pen-nib"></i></h4>
                                    <p class="mb-20"></p>
                                </div>
                            </div>
                        </div>
                        <form method="post" id="insert_manager">
                            <section>
                                <div class="row">
                                    <!-- select พนักงาน -->
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-100">
                                            <b class="card-header"><i class="fa-solid fa-user-gear fa-xl" style="color: #7d7d7d"></i> พนักงานใต้บังคับบัญชา </b>
                                            <div class="card-body">
                                                <select name="employee" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected>เลือกพนักงาน</option>
                                                    <?php
                                                    $sql = "SELECT * FROM employee WHERE permission_id = 4 AND card_id NOT IN (SELECT card_id FROM manager)";
 
                                                    $result = sqlsrv_query($conn, $sql);

                                                    if ($result === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    if ($result) {
                                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['card_id'] . "'>" . $row['scg_employee_id'] . ' : ' . $row['prefix_thai'] . '' . $row['firstname_thai'] . ' ' . $row['lastname_thai'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- select ผู้จัดการ -->
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-40">
                                            <b class="card-header"> <i class="fa-solid fa-user-tie fa-xl" style="color: #7d7d7d"></i> ผู้จัดการ Organization </b>
                                            <div class="card-body">
                                                <select name="manager" class="form-control selectpicker no-arrow" data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected>เลือกผู้จัดการ</option>
                                                    <?php
                                                    $sql = "SELECT 
                                                    em.card_id as em_id,                                        
                                                    em.prefix_thai as em_pre,                                        
                                                    em.firstname_thai as em_fname,
                                                    em.lastname_thai as em_lname,
                                                    em.scg_employee_id as em_scg_id,
                                                    em.employee_image as em_img, 
                                                    em.employee_email as em_email,
                                                    em.cost_center_organization_id as em_org,
                                                    cos_em.cost_center_code as cos_org,
                                                    sm.name_thai as m_section, 
                                                    dm.name_thai as m_department 
                                                    FROM employee em
                                                    INNER JOIN cost_center cos_em ON cos_em.cost_center_id = em.cost_center_organization_id
                                                    INNER JOIN section sm ON sm.section_id = cos_em.section_id
                                                    INNER JOIN department dm ON dm.department_id = sm.department_id
                                                    WHERE permission_id = 2";

                                                    $result = sqlsrv_query($conn, $sql);

                                                    if ($result === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    if ($result) {
                                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['em_id'] . "'>" . $row['em_pre'] . '' . $row['em_fname'] . ' ' . $row['em_lname'] . ' : ' . $row['cos_org'] . ' ' . $row['m_department'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-30">
                                    <div class="col-md-12 col-sm-2 text-right">
                                        <div>
                                            <button class="btn btn-primary" onclick="insert_mangerForm(event);">บันทึกรายชื่อลูกน้องใหม่</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                        <!-- script -->
                        <script>
                            function insert_mangerForm(event) {
                                event.preventDefault();
                                console.log("INSERT Manager Form send!");
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "green-swal",
                                        cancelButton: "delete-swal"
                                    },
                                    buttonsStyling: false
                                });

                                swalWithBootstrapButtons.fire({
                                    title: 'ยืนยันการเลือก ผู้จัดการท่านนี้',
                                    text: 'พนักงานจะถูกบันทึกเป็นรายชื่อลูกน้องใหม่ มีผลทันที ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formData = $('#insert_manager').serialize();
                                        console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                        $.ajax({
                                            type: "POST",
                                            url: "Back_End_ajax/Manager/Add_manger.php",
                                            data: formData,
                                            dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                            success: function(response) {
                                                console.log(response);
                                                if (response.status === 'success') {
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'success',
                                                        title: 'บันทึกรายชื่อลูกน้องใหม่ให้ ผู้จัดการ สำเร็จ!',
                                                        text: 'ข้อมูลรายชื่อพนักงานถูกบันทึกเรียบร้อย',
                                                    }).then(() => {
                                                        location.reload();
                                                    });

                                                } else {
                                                    // แสดงข้อความ error ที่ได้จาก server
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'error',
                                                        title: 'เกิดข้อผิดพลาด!',
                                                        text: response.message || 'ไม่สามารถบันทึกข้อมูลได้',
                                                    });
                                                }
                                            },
                                            error: function(xhr, textStatus, errorThrown) {
                                                console.log(xhr, textStatus, errorThrown);
                                                // แสดงข้อความ error ที่ได้จาก AJAX request
                                                swalWithBootstrapButtons.fire({
                                                    icon: 'error',
                                                    title: 'เกิดข้อผิดพลาด!',

                                                    text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        </script>
                        <hr />
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h5">แบบฟอร์มระบุ Report-to ให้พนักงาน</h4>
                                    <p class="mb-20"></p>
                                </div>
                            </div>
                        </div>
                        <form method="post" id="insert_reportto">
                            <section>
                                <div class="row">
                                    <!-- select พนักงาน -->
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-100">
                                            <b class="card-header"><i class="fa-solid fa-user-clock fa-xl" style="color: #7d7d7d"></i> พนักงานใต้บังคับบัญชา </b>
                                            <div class="card-body">
                                                <select name="employee" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected>เลือกพนักงาน</option>
                                                    <?php
                                                    $sql = "SELECT * FROM employee WHERE permission_id = 4 AND card_id NOT IN (SELECT card_id FROM report_to)";

                                                    $result = sqlsrv_query($conn, $sql);

                                                    if ($result === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    if ($result) {
                                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['card_id'] . "'>" . $row['scg_employee_id'] . ' : ' . $row['prefix_thai'] . '' . $row['firstname_thai'] . ' ' . $row['lastname_thai'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- select report-to -->
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-40">
                                            <b class="card-header"> <i class="fa-solid fa-user-tie fa-xl" style="color: #7d7d7d"></i> Report-to Organization </b>
                                            <div class="card-body">
                                                <select name="manager" class="form-control selectpicker " data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected>เลือก Report-to</option>
                                                    <?php
                                                    $sql = "SELECT 
                                                    em.card_id as em_id,                                        
                                                    em.prefix_thai as em_pre,                                        
                                                    em.firstname_thai as em_fname,
                                                    em.lastname_thai as em_lname,
                                                    em.scg_employee_id as em_scg_id,
                                                    em.employee_image as em_img, 
                                                    em.employee_email as em_email,
                                                    em.cost_center_organization_id as em_org,
                                                    cos_em.cost_center_code as cos_org,
                                                    sm.name_thai as m_section, 
                                                    dm.name_thai as m_department 
                                                    FROM employee em
                                                    INNER JOIN cost_center cos_em ON cos_em.cost_center_id = em.cost_center_organization_id
                                                    INNER JOIN section sm ON sm.section_id = cos_em.section_id
                                                    INNER JOIN department dm ON dm.department_id = sm.department_id
                                                    WHERE permission_id = 2";

                                                    $result = sqlsrv_query($conn, $sql);

                                                    if ($result === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    if ($result) {
                                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['em_id'] . "'>" . $row['em_pre'] . '' . $row['em_fname'] . ' ' . $row['em_lname'] . ' : ' . $row['cos_org'] . ' ' . $row['m_department'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-30">
                                    <div class="col-md-12 col-sm-2 text-right">
                                        <div>
                                            <button class="btn btn-primary" onclick="insert_reporttoForm(event);">บันทึก Report-to</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                        <!-- script -->
                        <script>
                            function insert_reporttoForm(event) {
                                event.preventDefault();
                                console.log("INSERT Report-to Form send!");
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "green-swal",
                                        cancelButton: "delete-swal"
                                    },
                                    buttonsStyling: false
                                });

                                swalWithBootstrapButtons.fire({
                                    title: 'ยืนยันการมอบหมาย Report-to',
                                    text: 'พนักงานจะถูกรายงานโดย Report-to ตามที่ระบุ ',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formData = $('#insert_reportto').serialize();
                                        console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                        $.ajax({
                                            type: "POST",
                                            url: "Back_End_ajax/Manager/Add_report_to.php",
                                            data: formData,
                                            dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                            success: function(response) {
                                                console.log(response);
                                                if (response.status === 'success') {
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'success',
                                                        title: 'บันทึกรายชื่อลูกน้องให้ Report-to สำเร็จ!',
                                                        text: 'ข้อมูลรายชื่อลูกน้องถูกบันทึกเรียบร้อย',
                                                    }).then(() => {
                                                        location.reload();
                                                    });

                                                } else {
                                                    // แสดงข้อความ error ที่ได้จาก server
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'error',
                                                        title: 'เกิดข้อผิดพลาด!',
                                                        text: response.message || 'ไม่สามารถบันทึกข้อมูลได้',
                                                    });
                                                }
                                            },
                                            error: function(xhr, textStatus, errorThrown) {
                                                console.log(xhr, textStatus, errorThrown);
                                                // แสดงข้อความ error ที่ได้จาก AJAX request
                                                swalWithBootstrapButtons.fire({
                                                    icon: 'error',
                                                    title: 'เกิดข้อผิดพลาด!',
                                                    text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../admin/include/footer.php') ?>
    </div>
    </div>
    <!-- js -->
    <?php include('../admin/include/scripts.php') ?>


</body>

</html>