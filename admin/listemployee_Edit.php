<?php
// Include your database connection file here
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// ตรวจสอบว่ามีการส่ง card_id มาจากหน้า listemployee หรือไม่
if (isset($_GET['card_id'])) {
    $card_id = $_GET['card_id'];

    // ตรวจสอบว่ามีข้อมูลพนักงานที่ต้องการแก้ไขหรือไม่
    $query = "SELECT * FROM employee WHERE card_id = ?";
    $params = array($card_id);

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        $employee = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    } else {
        die("ไม่พบข้อมูลพนักงานที่ต้องการแก้ไข");
    }
} else {
    die("ไม่ได้รับข้อมูล card_id");
}
?>

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
                                <h3>ข้อมูลพนักงานเบื้องต้น</h3>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation" class="pt-3">
                                <ol class="breadcrumb">
                                    <a class="btn-back" href='listemployee.php'>
                                        <i class="fa-solid fa-circle-left fa-xl"></i> |
                                    </a>

                                    <li class="breadcrumb-item"><a href="listemployee.php"><i class="fa-solid fa-people-group"></i> พนักงานทั้งหมด</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-user-plus"></i> ข้อมูลพนักงานเบื้องต้น</li>
                                    <li class="breadcrumb-item"><a href="listemployee_Manager.php"><i class="fa-solid fa-user-tie"></i> ผู้จัดการ - Report-to</a></li>

                                    <a class="btn-back" href='listemployee_Manager.php'>
                                        | <i class="fa-solid fa-circle-right fa-xl"></i>
                                    </a>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="col-md-12 col-sm-12">
                        <!-- Upload Image -->
                        <div class="profile-photo">
                            <button href="modal" data-toggle="modal" data-target="#modal" class="edit-pen"><i class="fa fa-pencil"></i></button>
                            <img src="<?php echo (!empty($employee['employee_image'])) ? '../admin/uploads_img/' . $employee['employee_image'] : '../asset/img/admin.png'; ?>" class="border-radius-100 shadow" width="160" height="160">

                            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">แก้ไขรูปพนักงาน <i class="fa-regular fa-image fa-lg" style="color: #2DA57B"></i></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card mx-auto text-center" style="width: 12rem;">
                                                <img class="card-img-top" src="../asset/img/example_IMG.jpg">
                                                <div class="card-body">
                                                    <h5 class="card-title">ตัวอย่างรูปพนักงานที่เหมาะสม</h5>
                                                    <p class="card-text">สวมชุดมีคอปก เรียบร้อย</p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <!-- ตรวจสอบ response จาก uploadimage.php และใช้ Swal ในการแจ้งเตือน -->
                                                <form method="post" enctype="multipart/form-data" id="updateImageForm">
                                                    <div class="col-md-12 pd-5 pt-2">
                                                        <div class="form-group">
                                                            <div class="custom-file">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                                <input name="image" id="file" type="file" class="custom-file-input" accept="image/*" required="true">
                                                                <input type="hidden" name="card_id" value="<?php echo $employee['card_id']; ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button onclick="handleImageUpload(event)" class="btn btn-primary"> อัพโหลดไฟล์รูป </button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- script -->
                                                <script>
                                                    function handleImageUpload(event) {
                                                        event.preventDefault();
                                                        console.log("UPDATE IMAGE send!");

                                                        const swalWithBootstrapButtons = Swal.mixin({
                                                            customClass: {
                                                                confirmButton: "green-swal",
                                                                cancelButton: "delete-swal"
                                                            },
                                                            buttonsStyling: false
                                                        });

                                                        swalWithBootstrapButtons.fire({
                                                            title: 'ยืนยันการอัพโหลดรูป',
                                                            text: 'คุณต้องการแก้ไขรูปพนักงานท่านนี้ ใช่หรือไม่ ?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'ใช่ ,ยืนยัน',
                                                            cancelButtonText: 'ยกเลิก',
                                                        }).then((response) => {
                                                            if (response.isConfirmed) {
                                                                var formData = new FormData($('#updateImageForm')[0]);

                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: "uploadimage.php",
                                                                    data: formData,
                                                                    dataType: "json",
                                                                    contentType: false,
                                                                    processData: false,
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
                                                                                title: "อัพโหลดรูปภาพ สำเร็จ"
                                                                            }).then(() => {
                                                                                location.reload();
                                                                            });
                                                                        } else {
                                                                            swalWithBootstrapButtons.fire({
                                                                                icon: 'error',
                                                                                title: 'เกิดข้อผิดพลาด!',
                                                                                text: response.message || 'ไม่สามารถบันทึกข้อมูลได้',
                                                                            });
                                                                        }
                                                                    },
                                                                    error: function(xhr, textStatus, errorThrown) {
                                                                        console.log(xhr, textStatus, errorThrown);
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
                            </div>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" id="employee_update">
                            <section>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>รหัสบัตรประชาชนพนักงาน </label>
                                            <input name="card_id" type="number" readonly value="<?php echo $employee['card_id']; ?>" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>รหัสส่วนบุคคล (Personal Number)</label>
                                            <input name="person_id" placeholder="1002479" type="number" value="<?php echo $employee['person_id']; ?>" maxlength="7" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>รหัสประจำตัวบุคคล</label>
                                            <input name="personnel_number" placeholder="1002247" type="number" value="<?php echo $employee['personnel_number']; ?>" maxlength="7" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>รหัสพนักงาน (SCG Employee)</label>
                                            <input name="scg_employee_id" placeholder="0150-000000" type="text" value="<?php echo $employee['scg_employee_id']; ?>" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>คำนำหน้าชื่อ (TH)</label>
                                            <select name="prefix_thai" class="custom-select form-control" autocomplete="off">
                                                <option value="นาย" <?php echo ($employee["prefix_thai"] == 'นาย') ? 'selected' : ''; ?>>นาย</option>
                                                <option value="นาง" <?php echo ($employee["prefix_thai"] == 'นาง') ? 'selected' : ''; ?>>นาง</option>
                                                <option value="นางสาว" <?php echo ($employee["prefix_thai"] == 'นางสาว') ? 'selected' : ''; ?>>นางสาว</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อจริง (TH) </label>
                                            <input name="firstname_thai" type="text" class="form-control wizard-required" value="<?php echo $employee["firstname_thai"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>นามสกุล (TH) </label>
                                            <input name="lastname_thai" type="text" class="form-control wizard-required" value="<?php echo $employee["lastname_thai"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อเล่น (TH) </label>
                                            <input name="nickname_thai" type="text" class="form-control wizard-required" value="<?php echo $employee["nickname_thai"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันเกิดพนักงาน</label>
                                            <input name="birth_date" type="date" class="form-control" value="<?php echo $employee['birth_date']->format('Y-m-d'); ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>คำนำหน้าชื่อ (ENG)</label>
                                            <select name="prefix_eng" class="custom-select form-control" autocomplete="off">
                                                <option value="Mr." <?php echo ($employee["prefix_eng"] == 'Mr.') ? 'selected' : ''; ?>>Mr.</option>
                                                <option value="Mrs." <?php echo ($employee["prefix_eng"] == 'Mrs.') ? 'selected' : ''; ?>>Mrs</option>
                                                <option value="Miss" <?php echo ($employee["prefix_eng"] == 'Miss') ? 'selected' : ''; ?>>Miss</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อจริง (ENG)</label>
                                            <input name="firstname_eng" type="text" class="form-control wizard-required" value="<?php echo $employee["firstname_eng"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>นามสกุล (ENG)</label>
                                            <input name="lastname_eng" type="text" class="form-control wizard-required" value="<?php echo $employee["lastname_eng"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อเล่น (ENG)</label>
                                            <input name="nickname_eng" type="text" class="form-control wizard-required" value="<?php echo $employee["nickname_eng"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เพศสภาพ (Sex)</label>
                                            <div class="text-left flex col-md-4 col-2" style="display: flex;">
                                                <input type="radio" name="gender" value="ชาย" <?php echo ($employee["gender"] == 'ชาย') ? 'checked' : ''; ?> >
                                                <i class="fa-solid fa-mars fa-lg mt-2 ml-2" style="color: #3fa7f2"></i><a style="color: #8f8f8f">ชาย</a><br>

                                                <input class="ml-2" type="radio" name="gender" value="หญิง" <?php echo ($employee["gender"] == 'หญิง') ? 'checked' : ''; ?>>
                                                <i class="fa-solid fa-venus fa-lg mt-2 ml-2" style="color: #fc5ba1"></i><a style="color: #8f8f8f">หญิง</a><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 col-sm-12">
                                        <div class="form-group">
                                            <label>กรุ๊ปเลือด</label>
                                            <select name="blood_type" class="custom-select form-control" autocomplete="off">
                                                <option value="A" <?php echo ($employee["blood_type"] == 'A') ? 'selected' : ''; ?>>A</option>
                                                <option value="B" <?php echo ($employee["blood_type"] == 'B') ? 'selected' : ''; ?>>B</option>
                                                <option value="AB" <?php echo ($employee["blood_type"] == 'AB') ? 'selected' : ''; ?>>AB</option>
                                                <option value="O" <?php echo ($employee["blood_type"] == 'O') ? 'selected' : ''; ?>>O</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>สถานะความสัมพันธ์</label>
                                            <select name="marital_status" class="custom-select form-control" autocomplete="off">
                                                <option value="โสด" <?php echo ($employee["marital_status"] == 'โสด') ? 'selected' : ''; ?>>โสด</option>
                                                <option value="มีแฟนแล้ว" <?php echo ($employee["marital_status"] == 'มีแฟนแล้ว') ? 'selected' : ''; ?>>มีแฟนแล้ว</option>
                                                <option value="แต่งงานแล้ว" <?php echo ($employee["marital_status"] == 'แต่งงานแล้ว') ? 'selected' : ''; ?>>แต่งงานแล้ว</option>
                                                <option value="หม้าย" <?php echo ($employee["marital_status"] == 'หม้าย') ? 'selected' : ''; ?>>หม้าย</option>
                                                <option value="หย่าระหว่างปี" <?php echo ($employee["marital_status"] == 'หย่าระหว่างปี') ? 'selected' : ''; ?>>หย่าระหว่างปี</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>สัญชาติ</label>
                                            <select name="nation" class="custom-select form-control" autocomplete="off">
                                                <option value="ไทย" <?php echo ($employee["nation"] == 'ไทย') ? 'selected' : ''; ?>>ไทย</option>
                                                <option value="ต่างชาติ" <?php echo ($employee["nation"] == 'ต่างชาติ') ? 'selected' : ''; ?>>ต่างชาติ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เชื้อชาติ</label>
                                            <select name="ethnicity" class="custom-select form-control" autocomplete="off">
                                                <option value="ไทย" <?php echo ($employee["ethnicity"] == 'ไทย') ? 'selected' : ''; ?>>ไทย</option>
                                                <option value="ต่างชาติ" <?php echo ($employee["ethnicity"] == 'ต่างชาติ') ? 'selected' : ''; ?>>ต่างชาติ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ศาสนา</label>
                                            <select name="religion" class="custom-select form-control" autocomplete="off">
                                                <option value="พุทธ" <?php echo ($employee["religion"] == 'พุทธ') ? 'selected' : ''; ?>>พุทธ</option>
                                                <option value="คริสต์" <?php echo ($employee["religion"] == 'คริสต์') ? 'selected' : ''; ?>>คริสต์</option>
                                                <option value="อิสลาม" <?php echo ($employee["religion"] == 'อิสลาม') ? 'selected' : ''; ?>>อิสลาม </option>
                                                <option value="ฮินดู" <?php echo ($employee["religion"] == 'ฮินดู') ? 'selected' : ''; ?>>ฮินดู</option>
                                                <option value="ไม่นับถือ" <?php echo ($employee["religion"] == 'ไม่นับถือ') ? 'selected' : ''; ?>>ไม่นับถือ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>เบอร์โทรพนักงาน</label>
                                            <input name="phone_number" type="number" placeholder="0650000000" value="<?php echo $employee["phone_number"]; ?>" class="form-control" autocomplete="off" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลขประกันสังคม</label>
                                            <input name="social_security_id" type="number" placeholder=" ************* " value="<?php echo $employee["social_security_id"]; ?>" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลขประจำตัวผู้เสียภาษี</label>
                                            <input name="tax_id" type="number" placeholder=" ************* " value="<?php echo $employee["tax_id"]; ?>" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>รูปแบบสัญญาจ้าง <b class="text-danger"> * </b></label>
                                            <select name="contract_type_id" class="custom-select form-control" required="true" autocomplete="off">
                                                <?php
                                                $sqlDropdown_type = "SELECT * FROM contract_type";
                                                $resultDropdown_type = sqlsrv_query($conn, $sqlDropdown_type);

                                                if ($resultDropdown_type === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }

                                                while ($contract = sqlsrv_fetch_array($resultDropdown_type, SQLSRV_FETCH_ASSOC)) {
                                                    $selected = ($contract['contract_type_id'] == $employee["contract_type_id"]) ? 'selected' : '';
                                                    echo "<option value='" . $contract['contract_type_id'] . "' $selected>" . $contract['name_thai'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>หมายเลข Cost-Center Organization<b class="text-danger"> * </b></label>
                                            <select name="cost_center_organization_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off" id="exampleSelect">
                                                <?php
                                                $sqlDropdown_cost = "SELECT cost_center_id, cost_center_code, section.name_thai as section, department.name_thai as department 
                                                FROM cost_center 								
                                                INNER JOIN section ON section.section_id = cost_center.section_id
                                                INNER JOIN department ON department.department_id = section.department_id";

                                                $resultDropdown_cost = sqlsrv_query($conn, $sqlDropdown_cost);

                                                if ($resultDropdown_cost === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown_cost) {
                                                    while ($cost_org = sqlsrv_fetch_array($resultDropdown_cost, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = ($cost_org['cost_center_id'] == $employee["cost_center_organization_id"]) ? 'selected' : '';
                                                        echo "<option value='"  . $cost_org['cost_center_id'] . "' $selected>" . $cost_org['cost_center_code'] . ' : ' . $cost_org['department'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>อีเมลพนักงาน</label>
                                            <input name="employee_email" placeholder="example@scg.com" value="<?php echo $employee["employee_email"]; ?>" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>บทบาทสิทธิ์การเข้าถึง <b class="text-danger"> * </b></label>
                                            <select name="permission_id" class="custom-select form-control" required="true" autocomplete="off">
                                                <?php
                                                $sqlDropdown_cost = "SELECT * FROM permission";
                                                $resultDropdown_cost = sqlsrv_query($conn, $sqlDropdown_cost);

                                                if ($resultDropdown_cost === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown_cost) {
                                                    while ($permission = sqlsrv_fetch_array($resultDropdown_cost, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = ($permission['permission_id'] == $employee["permission_id"]) ? 'selected' : '';
                                                        echo "<option value='"  . $permission['permission_id'] . "' $selected>" . $permission['permission_id'] . ' : ' . $permission['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>หมายเลข Cost-Center Payement <b class="text-danger"> * </b></label>
                                            <select name="cost_center_payment_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                <?php
                                                $sqlDropdown_cost = "SELECT cost_center_id , cost_center_code, section.name_thai as section, department.name_thai as department 
                                                FROM cost_center 								
                                                INNER JOIN section ON section.section_id = cost_center.section_id
                                                INNER JOIN department ON department.department_id = section.department_id";

                                                $resultDropdown_cost = sqlsrv_query($conn, $sqlDropdown_cost);

                                                if ($resultDropdown_cost === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown_cost) {
                                                    while ($cost_pay = sqlsrv_fetch_array($resultDropdown_cost, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = ($cost_pay['cost_center_id'] == $employee["cost_center_payment_id"]) ? 'selected' : '';
                                                        echo "<option value='"  . $cost_pay['cost_center_id'] . "' $selected>" . $cost_pay['cost_center_code'] . ' : ' . $cost_pay['department'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>สถานะการทำงาน</label>
                                            <select name="employment_status" class="custom-select form-control" autocomplete="off">
                                                <option value="ACTIVE" <?php echo ($employee["employment_status"] == 'ACTIVE') ? 'selected' : ''; ?>>ทำงาน</option>
                                                <option value="IN-ACTIVE" <?php echo ($employee["employment_status"] == 'IN-ACTIVE') ? 'selected' : ''; ?>>พ้นสภาพ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันที่เริ่มทดลองงาน</label>
                                            <input name="probation_date_start" type="date" class="form-control" <?php echo (!empty($employee['probation_date_start'])) ? 'value="' . $employee['probation_date_start']->format('Y-m-d') . '"' : ''; ?> autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ระยะเวลาทดลองงาน</label>
                                            <input name="probation_period" type="number" value="<?php echo $employee["probation_period"]; ?>" class="form-control" autocomplete="off" maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันที่เริ่มงาน SCG</label>
                                            <input name="scg_hiring_date" type="date" class="form-control" <?php echo (!empty($employee['scg_hiring_date'])) ? 'value="' . $employee['scg_hiring_date']->format('Y-m-d') . '"' : ''; ?> autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันที่เกษียณ</label>
                                            <input name="retired_date" type="date" class="form-control" <?php echo (!empty($employee['retired_date'])) ? 'value="' . $employee['retired_date']->format('Y-m-d') . '"' : ''; ?> autocomplete="off">

                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุดการจ้าง</label>
                                            <input name="termination_date" type="date" class="form-control" <?php echo (!empty($employee['termination_date'])) ? 'value="' . $employee['termination_date']->format('Y-m-d') . '"' : ''; ?> autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ประเภทพนักงาน</label>
                                            <select name="employee_type" class="custom-select form-control" autocomplete="off">
                                                <option value="พนักงานปกติ" <?php echo ($employee["employee_type"] == 'พนักงานปกติ') ? 'selected' : ''; ?>>พนักงานปกติ</option>
                                                <option value="พนักงานกะ" <?php echo ($employee["employee_type"] == 'พนักงานกะ') ? 'selected' : ''; ?>>พนักงานกะ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>work_format_code</label>
                                            <select name="work_format_code" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off" id="exampleSelect1">
                                                <?php
                                                $sqlDropdown = "SELECT * FROM work_format";

                                                $resultDropdown = sqlsrv_query($conn, $sqlDropdown);

                                                if ($resultDropdown === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown) {
                                                    while ($work_format = sqlsrv_fetch_array($resultDropdown, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = ($work_format['cost_center_id'] == $employee["cost_center_payment_id"]) ? 'selected' : '';
                                                        echo "<option value='"  . $work_format['work_format_code'] . "' $selected>" . $work_format['work_format_code'] . ' | ' . $work_format['format'] . ' : ' . $work_format['remark'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลือกธนาคาร</label>
                                            <select name="bank_name" class="custom-select form-control" autocomplete="off">
                                                <option value="KBANK" <?php echo ($employee["bank_name"] == 'KBANK') ? 'selected' : ''; ?>>KBANK กสิกรไทย</option>
                                                <option value="BBL" <?php echo ($employee["bank_name"] == 'BBL') ? 'selected' : ''; ?>>BBL กรุงเทพ</option>
                                                <option value="KTB" <?php echo ($employee["bank_name"] == 'KTB') ? 'selected' : ''; ?>>KTB กรุงไทย</option>
                                                <option value="BAY" <?php echo ($employee["bank_name"] == 'BAY') ? 'selected' : ''; ?>>BAY กรุงศรี</option>
                                                <option value="TMB" <?php echo ($employee["bank_name"] == 'TMB') ? 'selected' : ''; ?>>TMB ทหารไทยธนชาต</option>
                                                <option value="SCB" <?php echo ($employee["bank_name"] == 'SCB') ? 'selected' : ''; ?>>SCB ไทยพาณิชย์</option>
                                                <option value="GSB" <?php echo ($employee["bank_name"] == 'GSB') ? 'selected' : ''; ?>>GSB ออมสิน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>สาขาธนาคาร</label>
                                            <input name="bank_branch_name" placeholder="ระบุสาขาธนาคาร" value="<?php echo $employee["bank_branch_name"]; ?>" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลขบัญชีธนาคาร</label>
                                            <input name="back_account_id" value="<?php echo $employee["back_account_id"]; ?>" type="number" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันทำงาน / สัปดาห์</label>
                                            <select name="work_per_day" class="custom-select form-control" autocomplete="off">
                                                <option value="5" <?php echo ($employee["work_per_day"] == '5') ? 'selected' : ''; ?>>5 วัน ต่อ สัปดาห์</option>
                                                <option value="6" <?php echo ($employee["work_per_day"] == '6') ? 'selected' : ''; ?>>6 วัน ต่อ สัปดาห์</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ประสบการณ์ทำงานภายนอก (จำนวนปี)</label>
                                            <input name="outside_equivalent_year" placeholder="ระบุจำนวนปีการทำงาน" value="<?php echo $employee["outside_equivalent_year"]; ?>" type="number" class="form-control" autocomplete="off" min="0" max="60" oninput="validateInput_y(this)">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group">
                                            <label>ประสบการณ์ทำงานภายนอก (จำนวนเดือน)</label>
                                            <input name="outside_equivalent_month" placeholder="ระบุจำนวนเดือนการทำงาน" value="<?php echo $employee["outside_equivalent_month"]; ?>" type="number" class="form-control" autocomplete="off" min="0" max="12" oninput="validateInput_m(this)">
                                        </div>

                                    </div>

                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-3 col-sm-1">
                                    </div>
                                    <div class="col-md-9 col-sm-1 text-right">
                                        <button class="btn btn-primary" onclick="updateForm(event);">อัปเดต ข้อมูลพนักงาน</button>
                                    </div>
                                </div>
                            </section>
                        </form>
                        <!-- script -->
                        <script>
                            function updateForm(event) {
                                event.preventDefault();
                                console.log("UPDATE Form send!");
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "green-swal",
                                        cancelButton: "delete-swal"
                                    },
                                    buttonsStyling: false
                                });

                                swalWithBootstrapButtons.fire({
                                    title: 'ยืนยันการแก้ไข',
                                    text: 'คุณต้องการแก้ไขข้อมูลพนักงานท่านนี้ ใช่หรือไม่ ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formData = $('#employee_update').serialize();
                                        console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                        $.ajax({
                                            type: "POST",
                                            url: "Back_End_ajax/Employee/listemployee_update.php",
                                            data: formData,
                                            dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                            success: function(response) {
                                                console.log(response);

                                                if (response.status === 'success') {
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'success',
                                                        title: 'แก้ไขข้อมูลพนักงานท่านนี้ สำเร็จ!',
                                                        text: 'ข้อมูลพนักงานถูกเแก้ไขเรียบร้อย',
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
            <?php include('../admin/include/footer.php') ?>
        </div>
    </div>
    <!-- js -->
    <?php include('../admin/include/scripts.php') ?>

</body>

</html>