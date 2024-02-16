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
                                <h3>ข้อมูลโครงสร้างองค์กร : Sub Business Unit (หน่วยย่อยของธุรกิจ)</h3>
                                <p class="text-primary">โครงสร้างทั้ง 9 ลำดับขั้นจะเริ่มเรียงจากซ้าย-ขวาเสมอ

                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item "><a href="org1_Business_unit.php">Business Unit</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Sub-business-unit</li>
                                    <li class="breadcrumb-item"><a href="org3_Organizaion.php">Organization-ID</a></li>
                                    <li class="breadcrumb-item"><a href="org4_Company.php">Company</a></li>
                                    <li class="breadcrumb-item"><a href="org5_Location.php">Location</a></li>
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
                                    <a class="btn-back" href='org1_Business_unit.php'>
                                        <i class="fa-solid fa-circle-left fa-xl">
                                        </i>
                                    </a>
                                    <a class="btn-back" href='org3_Organizaion.php'>
                                        <i class="fa-solid fa-circle-right fa-xl"></i>
                                    </a>
                                </div>
                            </div>
                            <h2 class="pt-3 h4 text-blue">รายการ Sub business unit ทั้งหมดในระบบ</h2>
                            <p class="text-danger">* หมายเหตุ : หากต้องการลบระดับ Sub business unit ต้องลบหมายเลข OrganizationID ที่เกี่ยวข้องก่อนเสมอ</p>

                            <div class="pb-20">
                                <table class="data-table table stripe hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>Business</th>
                                            <th>Sub-business-unit (TH)</th>
                                            <th>Sub-business-unit (ENG)</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // เตรียมคำสั่ง SQL
                                        $sql2 = "SELECT * FROM sub_business";
                                        $params2 = array();
                                        $i = 1;
                                        // ดึงข้อมูลจากฐานข้อมูล
                                        $stmt2 = sqlsrv_query($conn, $sql2, $params2);
                                        // ตรวจสอบการทำงานของคำสั่ง SQL
                                        if ($stmt2 === false) {
                                            die(print_r(sqlsrv_errors(), true));
                                        }
                                        // แสดงผลลัพธ์ในรูปแบบของตาราง HTML
                                        while ($row = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . $i++ . "</td>";

                                            echo "<td>" . $row["business_id"] . "</td>";
                                            echo "<td>" . $row["name_thai"] . "</td>";
                                            echo "<td>" . $row["name_eng"] . "</td>";

                                            echo '<td><div class="flex">',
                                            '<button type="button" name="delete_sub_business" class="delete-btn_Org" onclick="confirmDelete_Sub(\'' . $row['sub_business_id'] . '\');"><i class="fa-solid fa-trash-can"></i></button>';

                                            echo "<button type='button' class='edit-btn_Org' onclick='openEdit_SubBusiness_Modal(\"" . $row['business_id'] . "\",\"" . $row['sub_business_id'] . "\", \"" . $row['name_thai'] . "\", \"" . $row['name_eng'] . "\");'>";
                                            echo "<i class='fa-solid fa-pencil'></i>";
                                            echo "</button>";

                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Start -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">แก้ไขรายชื่อ Sub-Business Unit</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for editing data -->
                                    <form id="update_sub_business" method="post">
                                        <input name="sub_business_id" type="hidden" id="editSubBusinessId">
                                        <div class="form-group">
                                            <label for="editBusinessIdInput">Business ID</label>
                                            <select name="business_id" class="form-control" required="true" autocomplete="off" id="editBusinessIdInput">
                                                <?php
                                                // สร้าง options สำหรับ dropdown 2
                                                $sqlDropdown = "SELECT * FROM business";
                                                $resultDropdown = sqlsrv_query($conn, $sqlDropdown);

                                                // เช็ค error
                                                if ($resultDropdown === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }

                                                if ($resultDropdown) {
                                                    while ($row = sqlsrv_fetch_array($resultDropdown, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = ($row['business_id'] == $value_from_editBusinessIdInput) ? 'selected' : ''; // ตรวจสอบว่าค่าเท่ากันหรือไม่
                                                        echo "<option value='" . $row['business_id'] . "' $selected>" . $row['business_id'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editNameThai">ชื่อ Sub Business Unit (TH)</label>
                                            <input type="text" class="form-control" id="editNameThai" name="name_thai" required autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="editNameEng">ชื่อ Sub Business Unit (ENG)</label>
                                            <input type="text" class="form-control" id="editNameEng" name="name_eng" required autocomplete="off">
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-primary" onclick="update_sub_businessForm(event);">บันทึกการแก้ไข</button>
                                        </div>
                                    </form>
                                    <!-- script -->
                                    <script>
                                        function update_sub_businessForm(event) {
                                            event.preventDefault();
                                            console.log("UPDATE sub_business Form send!");
                                            const swalWithBootstrapButtons = Swal.mixin({
                                                customClass: {
                                                    confirmButton: "green-swal",
                                                    cancelButton: "delete-swal"
                                                },
                                                buttonsStyling: false
                                            });
                                            swalWithBootstrapButtons.fire({
                                                title: 'ยืนยันแก้ไข Sub Business Unit',
                                                text: 'Sub Business Unit จะถูกแก้ไขใหม่ตามที่ระบุ',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'ใช่ ,ยืนยัน',
                                                cancelButtonText: 'ยกเลิก',
                                            }).then((response) => {
                                                if (response.isConfirmed) {
                                                    var formData = $('#update_sub_business').serialize();
                                                    console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                                    $.ajax({
                                                        type: "POST",
                                                        url: "Back_End_ajax/Org/sub_business_update.php",
                                                        data: formData,
                                                        dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                                        success: function(response) {
                                                            console.log(response);
                                                            if (response.status === 'success') {
                                                                swalWithBootstrapButtons.fire({
                                                                    icon: 'success',
                                                                    title: 'แก้ไข Sub Business Unit สำเร็จ!',
                                                                    text: 'ข้อมูล Sub Business Unit ถูกแก้ไขเรียบร้อย',
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
                            <h2 class="mb-30 h4"></h2>
                            <section>
                                <form method="post" id="insert_sub_business">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>ระบุ Business ID</label>
                                                <select id="business_id" name="business_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected> ระบุ Business ID </option>
                                                    <?php
                                                    // สร้าง options สำหรับ dropdown 2
                                                    $sqlDropdown2 = "SELECT * FROM business";
                                                    $resultDropdown2 = sqlsrv_query($conn, $sqlDropdown2);

                                                    // เช็ค error
                                                    if ($resultDropdown2 === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }

                                                    if ($resultDropdown2) {
                                                        while ($row = sqlsrv_fetch_array($resultDropdown2, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['business_id'] . "'>" . $row['business_id'] . ' ' . $row['name_thai'] . "</option>";
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
                                                <label>ชื่อ Sub Business (TH)</label>
                                                <input name="name_thai" type="text" class="form-control" required="true" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>ชื่อ Sub Business (ENG)</label>
                                                <input name="name_eng" type="text" class="form-control" required="true" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary" onclick="insert_sub_businessForm(event);">เพิ่ม Sub-Business</button>

                                        </div>
                                    </div>
                                </form>
                                <!-- script -->
                                <script>
                                    function insert_sub_businessForm(event) {
                                        event.preventDefault();
                                        console.log("INSERT sub_business Form send!");
                                        const swalWithBootstrapButtons = Swal.mixin({
                                            customClass: {
                                                confirmButton: "green-swal",
                                                cancelButton: "delete-swal"
                                            },
                                            buttonsStyling: false
                                        });
                                        swalWithBootstrapButtons.fire({
                                            title: 'ยืนยันการเพิ่ม Sub Business Unit',
                                            text: 'Sub Business Unit จะถูกเพิ่มลงฐานข้อมูลในระบบ',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'ใช่ ,ยืนยัน',
                                            cancelButtonText: 'ยกเลิก',
                                        }).then((response) => {
                                            if (response.isConfirmed) {
                                                var formData = $('#insert_sub_business').serialize();
                                                console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                                $.ajax({
                                                    type: "POST",
                                                    url: "Back_End_ajax/Org/sub_business_add.php",
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
                                                                title: "เพิ่ม Sub Business Unit สำเร็จ"
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
                </div>
                <div>
                </div>

                <?php include('../admin/include/footer.php'); ?>
            </div>
        </div>
        <!-- js -->

        <?php include('../admin/include/scripts.php') ?>
</body>

</html>