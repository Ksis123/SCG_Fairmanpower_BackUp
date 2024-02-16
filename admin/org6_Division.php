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
                                <h3>ข้อมูลโครงสร้างองค์กร : Division</h3>
                                <p class="text-primary">โครงสร้างทั้ง 9 ลำดับขั้นจะเริ่มเรียงจากซ้าย-ขวาเสมอ

                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item "><a href="org1_Business_unit.php">Business Unit</a></li>
                                    <li class="breadcrumb-item"><a href="org2_Sub_Business_unit.php">Sub-business-unit</a></li>
                                    <li class="breadcrumb-item"><a href="org3_Organizaion.php">Organization-ID</a></li>
                                    <li class="breadcrumb-item"><a href="org4_Company.php">Company </a></li>
                                    <li class="breadcrumb-item"><a href="org5_Location.php">Location</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Division</li>
                                    <li class="breadcrumb-item"><a href="org7_Department.php">Department</a></li>
                                    <li class="breadcrumb-item"><a href="org8_Section.php">Section</a></li>
                                    <li class="breadcrumb-item"><a href="org9_Costcenter.php">Cost-Center</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-50-p">
                            <section>
                                <form method="post" id="insert_division">
                                    <div class="row">
                                        <div class="col-sm-3  col-md-3">
                                            <div class="form-group">
                                                <label>ชื่อ Location (สำนักงาน)</label>
                                                <select name="location_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected> ระบุ Location (สำนักงาน) </option>
                                                    <?php
                                                    // สร้าง options สำหรับ dropdown 2
                                                    $sqlDropdown6 = "SELECT * FROM location";
                                                    $resultDropdown6 = sqlsrv_query($conn, $sqlDropdown6);

                                                    // เช็ค error
                                                    if ($resultDropdown6 === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }

                                                    if ($resultDropdown6) {
                                                        while ($row = sqlsrv_fetch_array($resultDropdown6, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['location_id'] . "'>" . $row['name_eng'] . ' : ' . $row['name'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3  col-md-3">
                                            <div class="form-group">
                                                <label>ชื่อ Division (TH)</label>
                                                <input name="name_thai" type="text" class="form-control" required="true" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-sm-3  col-md-3">
                                            <div class="form-group">
                                                <label>ชื่อ Division (ENG)</label>
                                                <input name="name_eng" type="text" class="form-control" required="true" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-sm-2  col-md-2 pt-30 text-right">
                                            <div class="dropdown">
                                                <button class="btn btn-primary" onclick="insert_Division_Form(event);">เพิ่ม Division</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                <!-- script -->
                                <script>
                                    function insert_Division_Form(event) {
                                        event.preventDefault();
                                        console.log("INSERT Division Form send!");
                                        const swalWithBootstrapButtons = Swal.mixin({
                                            customClass: {
                                                confirmButton: "green-swal",
                                                cancelButton: "delete-swal"
                                            },
                                            buttonsStyling: false
                                        });
                                        swalWithBootstrapButtons.fire({
                                            title: 'ยืนยันการเพิ่ม Division',
                                            text: 'Division จะถูกเพิ่มลงฐานข้อมูลในระบบ',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'ใช่ ,ยืนยัน',
                                            cancelButtonText: 'ยกเลิก',
                                        }).then((response) => {
                                            if (response.isConfirmed) {
                                                var formData = $('#insert_division').serialize();
                                                console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป
                                                $.ajax({
                                                    type: "POST",
                                                    url: "Back_End_ajax/Org/division_add.php",
                                                    data: formData,
                                                    dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                                    success: function(response) {
                                                        console.log(response);
                                                        if (response.status === 'success') {
                                                            const Toast = Swal.mixin({
                                                                toast: true,
                                                                position: "top-end",
                                                                showConfirmButton: false,
                                                                timer: 1200,
                                                                timerProgressBar: true,
                                                                didOpen: (toast) => {
                                                                    toast.onmouseenter = Swal.stopTimer;
                                                                    toast.onmouseleave = Swal.resumeTimer;
                                                                }
                                                            });
                                                            Toast.fire({
                                                                icon: "success",
                                                                title: "เพิ่ม Division สำเร็จ"
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
                            </section>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <div class="row" style="justify-content: space-between; align-items: center;">
                                <div class="col-md-3 col-sm-1 text-left">
                                </div>
                                <div class="col-md-3 col-sm-1 text-right">
                                    <a class="btn-back" href='org5_Location.php'>
                                        <i class="fa-solid fa-circle-left fa-xl">
                                        </i>
                                    </a>
                                    <a class="btn-back" href='org7_Department.php'>
                                        <i class="fa-solid fa-circle-right fa-xl"></i>
                                    </a>
                                </div>
                            </div>
                            <h2 class="h4 text-blue">รายการ Division ทั้งหมดในระบบ</h2>
                            <p class="text-danger">* หมายเหตุ : หากต้องการลบ Division จะต้องลบ Department (แผนก) ที่เกี่ยวข้องก่อนเสมอ</p>

                            <div class="pb-20">
                                <table class="data-table table stripe hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>Location</th>
                                            <th>Division (TH)</th>
                                            <th>Division (ENG)</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // เตรียมคำสั่ง SQL
                                        $sql6 = "SELECT dv.division_id, dv.name_thai, dv.name_eng, dv.location_id, lo.name, lo.name_eng as lo_eng FROM division dv JOIN location lo ON dv.location_id = lo.location_id";
                                        $params6 = array();
                                        $i = 1;
                                        // ดึงข้อมูลจากฐานข้อมูล
                                        $stmt6 = sqlsrv_query($conn, $sql6, $params6);
                                        // ตรวจสอบการทำงานของคำสั่ง SQL
                                        if ($stmt6 === false) {
                                            die(print_r(sqlsrv_errors(), true));
                                        }

                                        // แสดงผลลัพธ์ในรูปแบบของตาราง HTML
                                        while ($row = sqlsrv_fetch_array($stmt6, SQLSRV_FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . $i++ . "</td>";
                                            echo "<td>" . $row["lo_eng"] . ' ' . $row["name"] . "</td>";
                                            echo "<td>" . $row["name_thai"] . "</td>";
                                            echo "<td>" . $row["name_eng"] . "</td>";

                                            echo '<td><div class="flex">',
                                            '<button type="button" name="delete_division" class="delete-btn_Org" onclick="confirmDelete_Division(\'' . $row['division_id'] . '\');"><i class="fa-solid fa-trash-can"></i></button>';

                                            echo '<button type="button" class="edit-btn_Org" onclick="openEdit_Division_Modal(\'' . $row['division_id'] . '\', \'' . $row['location_id'] . '\', \'' . $row['name_thai'] . '\', \'' . $row['name_eng'] . '\');">',
                                            '<i class="fa-solid fa-pencil"></i>',
                                            '</button></div></td>';
                                            echo "</tr>";
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal START -->
                    <div class="modal fade" id="editDivisionModal" tabindex="-1" role="dialog" aria-labelledby="editDivisionModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDivisionModalLabel">แก้ไขข้อมูล Division</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for editing Division data -->
                                    <form id="update_division" method="post">
                                        <input name="division_id" type="hidden" id="editDivisionIdInput">
                                        <div class="form-group">
                                            <label for="editLocation">ชื่อ Location (สำนักงาน)</label>
                                            <select name="location_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off" id="editLocation">
                                                <?php
                                                // สร้าง options สำหรับ dropdown 2
                                                $sqlDropdown = "SELECT * FROM location";
                                                $resultDropdown = sqlsrv_query($conn, $sqlDropdown);

                                                // เช็ค error
                                                if ($resultDropdown === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }

                                                if ($resultDropdown) {
                                                    while ($row = sqlsrv_fetch_array($resultDropdown, SQLSRV_FETCH_ASSOC)) {
                                                        echo "<option value='"  . $row['location_id'] . "'>" . $row['name_eng'] .  ' ' . $row['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editDivisionNameThai">ชื่อ Division (TH)</label>
                                            <input type="text" class="form-control" id="editDivisionNameThai" name="name_thai" required autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="editDivisionNameEng">ชื่อ Division (ENG)</label>
                                            <input type="text" class="form-control" id="editDivisionNameEng" name="name_eng" required autocomplete="off">
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-primary" onclick="update_divisionForm(event);">บันทึกการแก้ไข</button>

                                        </div>
                                    </form>
                                    <!-- script -->
                                    <script>
                                        function update_divisionForm(event) {
                                            event.preventDefault();
                                            console.log("UPDATE division Form send!");
                                            const swalWithBootstrapButtons = Swal.mixin({
                                                customClass: {
                                                    confirmButton: "green-swal",
                                                    cancelButton: "delete-swal"
                                                },
                                                buttonsStyling: false
                                            });
                                            swalWithBootstrapButtons.fire({
                                                title: 'ยืนยันแก้ไข Division ',
                                                text: 'Division จะถูกแก้ไขใหม่ตามที่ระบุ',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'ใช่ ,ยืนยัน',
                                                cancelButtonText: 'ยกเลิก',
                                            }).then((response) => {
                                                if (response.isConfirmed) {
                                                    var formData = $('#update_division').serialize();
                                                    console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "Back_End_ajax/Org/division_update.php",
                                                        data: formData,
                                                        dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                                        success: function(response) {
                                                            console.log(response);
                                                            if (response.status === 'success') {
                                                                swalWithBootstrapButtons.fire({
                                                                    icon: 'success',
                                                                    title: 'แก้ไข Division สำเร็จ!',
                                                                    text: 'ข้อมูล Division ถูกแก้ไขเรียบร้อย',
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
                    <!-- Modal End -->
                </div>

            </div>

            <?php include('../admin/include/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

    <?php include('../admin/include/scripts.php') ?>
</body>

</html>