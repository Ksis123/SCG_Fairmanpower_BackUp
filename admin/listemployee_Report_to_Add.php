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
                                    <li class="breadcrumb-item"><a><i class="fa-solid fa-user-tie"></i> ผู้จัดการ</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-people-arrows"></i> report-to</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="wizard-content">
                        <div class="col-md-2 col-sm-2">
                            <div class="pt-10 pb-20">
                                <a class="btn-back" href='listemployee_Report_to.php'><i class="fa-solid fa-circle-left fa-xl"> </i> ย้อนกลับ </a>
                            </div>
                        </div>
                        <!-- Your HTML -->
                        <form method="post" action="listemployee_Report_to_Add.php">
                            <section>
                                <div class="row">
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-40">
                                            <p class="card-header" style="color: #000">ผู้จัดการ</p>
                                            <div class="card-body">
                                                <select name="manager" class="custom-select form-control select2" required="true" autocomplete="off">
                                                    <option value="" disabled selected>เลือกผู้จัดการ</option>
                                                    <?php
                                                    $sql = "SELECT * FROM employee WHERE permission_id = 2";

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

                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-40">
                                            <p class="card-header" style="color: #000">พนักงาน</p>
                                            <div class="card-body">
                                                <select name="employee" class="custom-select form-control select2" required="true" autocomplete="off">
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
                                </div>
                                <div class="row pt-30">
                                    <div class="col-md-12 col-sm-2 text-right">
                                        <div>
                                            <button class="btn btn-primary" name="add_staff">บันทึกรายชื่อลูกน้องใหม่</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>

                        <!-- Initialize select2 -->
                        <script>
                            $(document).ready(function() {
                                $('.select2').select2();
                            });
                        </script>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            // ดึงข้อมูลจากฟอร์ม
                            $managerCardId = $_POST['manager'];
                            $employeeCardId = $_POST['employee'];

                            // เตรียมคำสั่ง SQL สำหรับ INSERT ข้อมูล
                            $sql = "INSERT INTO report_to (report_to_card_id, card_id) VALUES (?, ?)";

                            // กำหนดค่าพารามิเตอร์
                            $params = array($managerCardId, $employeeCardId);

                            // ทำการ execute คำสั่ง SQL
                            $stmt = sqlsrv_query($conn, $sql, $params);

                            // ตรวจสอบการทำงานของคำสั่ง SQL
                            if ($stmt === false) {
                                die(print_r(sqlsrv_errors(), true));
                            }

                            // ส่งคำตอบกลับ
                            echo '<script type="text/javascript">
                                                const swalWithBootstrapButtons = Swal.mixin({
                                                    customClass: {
                                                        confirmButton: "green-swal",
                                                        cancelButton: "edit-swal"
                                                    },
                                                    buttonsStyling: false
                                                });
                                                swalWithBootstrapButtons.fire({
                                                    icon: "success",
                                                    title: "บันทึกข้อมูล Report-to ใหม่ เรียบร้อยแล้ว ",
                                                    text: "อีกสักครู่ ...ระบบจะทำการรีเฟส",
                                                    confirmButtonText: "ตกลง",
                                                    confirmButtonColor: "#ffffff",

                                                })
                                            </script>';
                            echo "<meta http-equiv='refresh' content='2;URL=listemployee_Report_to_Add.php'/>";
                            exit();
                        }
                        ?>
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