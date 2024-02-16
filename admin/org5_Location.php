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
                                <h3>ข้อมูลโครงสร้างองค์กร : Location (สำนักงาน)</h3>
                                <p class="text-primary">โครงสร้างทั้ง 9 ลำดับขั้นจะเริ่มเรียงจากซ้าย-ขวาเสมอ

                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item "><a href="org1_Business_unit.php">Business Unit</a></li>
                                    <li class="breadcrumb-item"><a href="org2_Sub_Business_unit.php">Sub-business-unit</a></li>
                                    <li class="breadcrumb-item"><a href="org3_Organizaion.php">Organization-ID</a></li>
                                    <li class="breadcrumb-item"><a href="org4_Company.php">Company </a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Location</li>
                                    <li class="breadcrumb-item"><a href="org6_Division.php">Division</a></li>
                                    <li class="breadcrumb-item"><a href="org7_Department.php">Department</a></li>
                                    <li class="breadcrumb-item"><a href="org8_Section.php">Section</a></li>
                                    <li class="breadcrumb-item"><a href="org9_Costcenter.php">Cost-Center</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-9 col-md-6 col-sm-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <div class="row" style="justify-content: space-between; align-items: center;">
                                <div class="col-md-3 col-sm-1 text-left">
                                </div>
                                <div class="col-md-3 col-sm-1 text-right">
                                    <a class="btn-back" href='org4_Company.php'>
                                        <i class="fa-solid fa-circle-left fa-xl">
                                        </i>
                                    </a>
                                    <a class="btn-back" href='org6_Division.php'>
                                        <i class="fa-solid fa-circle-right fa-xl"></i>
                                    </a>
                                </div>
                            </div>
                            <h2 class="h4 text-blue">รายการ สำนักงาน ทั้งหมดในระบบ</h2>
                            <p class="text-danger">* หมายเหตุ : หากต้องการลบตำแหน่ง Location จะต้องลบ Division ที่เกี่ยวข้องก่อนเสมอ</p>

                            <div class="pb-20">
                                <table class="data-table table stripe hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>รหัส Company</th>
                                            <th>บริษัท</th>
                                            <th>Location</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // เตรียมคำสั่ง SQL
                                        $sql4 = "SELECT lo.company_id, lo.location_id, lo.name, lo.name_eng, com.company_id as com_id, com.name_thai as com_th, com.name_eng as com_eng
                                                 FROM location lo JOIN company com ON lo.company_id = com.company_id";

                                        $params4 = array();
                                        // ดึงข้อมูลจากฐานข้อมูล
                                        $stmt4 = sqlsrv_query($conn, $sql4, $params4);
                                        // ตรวจสอบการทำงานของคำสั่ง SQL
                                        if ($stmt4 === false) {
                                            die(print_r(sqlsrv_errors(), true));
                                        }

                                        // แสดงผลลัพธ์ในรูปแบบของตาราง HTML
                                        while ($row = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . $row["com_id"] . "</td>";
                                            echo "<td>" . $row["com_th"] . ' <br> ' . $row["com_eng"] . "</td>";
                                            echo "<td>" . $row["name_eng"] . ' ' . $row["name"] . "</td>";
                                            echo '<td><div class="flex">',
                                            '<button type="button" name="delete_location" class="delete-btn_Org" onclick="confirmDelete_Location(\'' . $row['location_id'] . '\');"><i class="fa-solid fa-trash-can"></i></button>';

                                            echo '<button type="button" class="edit-btn_Org" onclick="openEdit_Location_Modal(\'' . $row['location_id'] . '\', \'' . $row['company_id'] . '\', \'' . $row['name'] . '\', \'' . $row['name_eng'] . '\');">',
                                            '<i class="fa-solid fa-pencil"></i>',
                                            '</button></div></td>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Start -->
                    <div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog" aria-labelledby="editLocationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editLocationModalLabel">แก้ไขข้อมูล Location (สำนักงาน)</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for editing Location data -->
                                    <form id="update_location" method="post">
                                        <input name="location_id" type="hidden" id="editLocationIdInput">
                                        <div class="form-group">
                                            <label for="editCompany">ชื่อ company (บริษัท)</label>
                                            <select name="company_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off" id="editCompany">
                                                <?php
                                                // สร้าง options สำหรับ dropdown 2
                                                $sqlDropdown = "SELECT * FROM company";
                                                $resultDropdown = sqlsrv_query($conn, $sqlDropdown);

                                                // เช็ค error
                                                if ($resultDropdown === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }

                                                if ($resultDropdown) {
                                                    while ($row = sqlsrv_fetch_array($resultDropdown, SQLSRV_FETCH_ASSOC)) {
                                                        echo "<option value='"  . $row['company_id'] . "'>" . $row['company_id'] . ' : ' . $row['name_eng'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editLocationName">ชื่อ Location (TH)</label>
                                            <input type="text" class="form-control" id="editLocationName" oninput="this.value = this.value.toUpperCase()" name="name_thai" required autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="editLocationName">ชื่อ Location (ENG)</label>
                                            <input type="text" class="form-control" id="editLocationName_ENG" oninput="this.value = this.value.toUpperCase()" name="name_eng" required autocomplete="off">
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-primary" onclick="update_locationForm(event);">บันทึกการแก้ไข</button>
                                        </div>
                                    </form>
                                    <!-- script -->
                                    <script>
                                        function update_locationForm(event) {
                                            event.preventDefault();
                                            console.log("UPDATE location Form send!");
                                            const swalWithBootstrapButtons = Swal.mixin({
                                                customClass: {
                                                    confirmButton: "green-swal",
                                                    cancelButton: "delete-swal"
                                                },
                                                buttonsStyling: false
                                            });
                                            swalWithBootstrapButtons.fire({
                                                title: 'ยืนยันแก้ไข Location (สำนักงาน)',
                                                text: 'Location (สำนักงาน) จะถูกแก้ไขใหม่ตามที่ระบุ',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'ใช่ ,ยืนยัน',
                                                cancelButtonText: 'ยกเลิก',
                                            }).then((response) => {
                                                if (response.isConfirmed) {
                                                    var formData = $('#update_location').serialize();
                                                    console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                                    $.ajax({
                                                        type: "POST",
                                                        url: "Back_End_ajax/Org/location_update.php",
                                                        data: formData,
                                                        dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                                        success: function(response) {
                                                            console.log(response);
                                                            if (response.status === 'success') {
                                                                swalWithBootstrapButtons.fire({
                                                                    icon: 'success',
                                                                    title: 'แก้ไข Location (สำนักงาน) สำเร็จ!',
                                                                    text: 'ข้อมูล Location (สำนักงาน) ถูกแก้ไขเรียบร้อย',
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

                    <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-50-p">
                            <form method="post" id="insert_location">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ชื่อ company (บริษัท)</label>
                                            <select name="company_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                <option value="" disabled selected> ระบุ company (บริษัท) </option>
                                                <?php
                                                // สร้าง options สำหรับ dropdown 2
                                                $sqlDropdown5 = "SELECT * FROM company";
                                                $resultDropdown5 = sqlsrv_query($conn, $sqlDropdown5);

                                                // เช็ค error
                                                if ($resultDropdown5 === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }

                                                if ($resultDropdown5) {
                                                    while ($row = sqlsrv_fetch_array($resultDropdown5, SQLSRV_FETCH_ASSOC)) {
                                                        echo "<option value='"  . $row['company_id'] . "'>" . $row['company_id'] . ' : '  . $row['name_thai'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ชื่อ Location (TH)</label>
                                            <input name="name_thai" type="text" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ชื่อ Location (ENG)</label>
                                            <input name="name_eng" type="text" class="form-control" required="true" autocomplete="off" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary" onclick="insert_Location_Form(event);">เพิ่ม Location (สำนักงาน)</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- script -->
                        <script>
                            function insert_Location_Form(event) {
                                event.preventDefault();
                                console.log("INSERT Location Form send!");
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "green-swal",
                                        cancelButton: "delete-swal"
                                    },
                                    buttonsStyling: false
                                });
                                swalWithBootstrapButtons.fire({
                                    title: 'ยืนยันการเพิ่ม Location (สำนักงาน)',
                                    text: 'Location (สำนักงาน) จะถูกเพิ่มลงฐานข้อมูลในระบบ',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formData = $('#insert_location').serialize();
                                        console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                        $.ajax({
                                            type: "POST",
                                            url: "Back_End_ajax/Org/location_add.php",
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
                                                        title: "เพิ่ม Location (สำนักงาน) สำเร็จ"
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

            <?php include('../admin/include/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

    <?php include('../admin/include/scripts.php') ?>
</body>

</html>