<?php include('../head/include/header.php') ?>

<body>
    <?php include('../head/include/navbar.php') ?>
    <?php include('../head/include/sidebar.php') ?>
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
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="listemployee.php">หน้าหลัก</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">ข้อมูลพนักงานเบื้องต้น</li>
                                    <li class="breadcrumb-item"><a href="listemployee_Info.php">ประวัติส่วนตัว</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Education.php">ประวัติการศึกษา</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Workinfo.php">ประวัติการทำงาน</a></li>
                                    <!-- <li class="breadcrumb-item"><a href="listemployee_Manager.php">ผู้จัดการ</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Report_to.php">report-to</a></li> -->

                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">แบบฟอร์มข้อมูลพนักงานเบื้องต้น</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">

                        <!-- Upload Image -->
                        <div class="profile-photo">
                            <button href="modal" data-toggle="modal" data-target="#modal" class="edit-pen"><i class="fa fa-pencil"></i></button>
                            <img src="<?php echo (!empty($row['employee_image'])) ? '../admin/uploads_img/' . $row['employee_image'] : '../asset/img/admin.png'; ?>" class="border-radius-100 shadow" width="160" height="160">

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
                                                                <input type="hidden" name="card_id" value="<?php echo $row['card_id']; ?>">
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
                        <form method="POST" id="update_emp">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>รหัสบัตรประชาชนพนักงาน</label>
                                        <input name="card_id" type="number" class="form-control" value="<?php echo $row['card_id'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>รหัสส่วนบุคคล (Personal Number)</label>
                                        <input name="person_id" placeholder="1002479" type="number" value="<?php echo $row['person_id']; ?>" maxlength="7" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>รหัสประจำตัวบุคคล</label>
                                        <input name="personnel_number" placeholder="1002247" type="number" value="<?php echo $row['personnel_number']; ?>" maxlength="7" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>รหัสพนักงาน (SCG Employee)</label>
                                        <input name="scg_employee_id" placeholder="0150-000000" type="text" disabled value="<?php echo $row['scg_employee_id']; ?>" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>คำนำหน้าชื่อ (TH)</label>
                                        <select name="prefix_thai" class="custom-select form-control" autocomplete="off">
                                            <option value="นาย" <?php echo ($row["prefix_thai"] == 'นาย') ? 'selected' : ''; ?>>นาย</option>
                                            <option value="นาง" <?php echo ($row["prefix_thai"] == 'นาง') ? 'selected' : ''; ?>>นาง</option>
                                            <option value="นางสาว" <?php echo ($row["prefix_thai"] == 'นางสาว') ? 'selected' : ''; ?>>นางสาว</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>ชื่อจริง (TH) </label>
                                        <input name="firstname_thai" type="text" class="form-control wizard-required" value="<?php echo $row["firstname_thai"]; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>นามสกุล (TH) </label>
                                        <input name="lastname_thai" type="text" class="form-control wizard-required" value="<?php echo $row["lastname_thai"]; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>ชื่อเล่น (TH) </label>
                                        <input name="nickname_thai" type="text" class="form-control wizard-required" value="<?php echo $row["nickname_thai"]; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>วันเกิดพนักงาน</label>
                                        <input name="birth_date" type="date" class="form-control" value="<?php echo $row['birth_date']->format('Y-m-d'); ?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>คำนำหน้าชื่อ (ENG)</label>
                                        <select name="prefix_eng" class="custom-select form-control" autocomplete="off">
                                            <option value="Mr." <?php echo ($row["prefix_eng"] == 'Mr.') ? 'selected' : ''; ?>>Mr.</option>
                                            <option value="Mrs." <?php echo ($row["prefix_eng"] == 'Mrs.') ? 'selected' : ''; ?>>Mrs</option>
                                            <option value="Miss" <?php echo ($row["prefix_eng"] == 'Miss') ? 'selected' : ''; ?>>Miss</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>ชื่อจริง (ENG)</label>
                                        <input name="firstname_eng" type="text" class="form-control wizard-required" value="<?php echo $row["firstname_eng"]; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>นามสกุล (ENG)</label>
                                        <input name="lastname_eng" type="text" class="form-control wizard-required" value="<?php echo $row["lastname_eng"]; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>ชื่อเล่น (ENG)</label>
                                        <input name="nickname_eng" type="text" class="form-control wizard-required" value="<?php echo $row["nickname_eng"]; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group ">
                                        <label>เพศสภาพ (Sex)</label>
                                        <div class="text-left flex col-md-4 col-2" style="justify-content: space-between;">
                                            <input type="radio" name="gender" value="ชาย" <?php echo ($row["gender"] == 'ชาย') ? 'checked' : ''; ?> disabled>
                                            <a style="color: #8f8f8f"><i class="fa-solid fa-mars fa-lg" style="color: #3fa7f2"></i>ชาย</a><br>

                                            <input type="radio" name="gender" value="หญิง" <?php echo ($row["gender"] == 'หญิง') ? 'checked' : ''; ?> disabled>
                                            <a style="color: #8f8f8f"><i class="fa-solid fa-venus fa-lg" style="color: #fc5ba1"></i>หญิง</a><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 col-sm-12">
                                    <div class="form-group">
                                        <label>กรุ๊ปเลือด</label>
                                        <select name="blood_type" class="custom-select form-control" autocomplete="off">
                                            <option value="A" <?php echo ($row["blood_type"] == 'A') ? 'selected' : ''; ?>>A</option>
                                            <option value="B" <?php echo ($row["blood_type"] == 'B') ? 'selected' : ''; ?>>B</option>
                                            <option value="AB" <?php echo ($row["blood_type"] == 'AB') ? 'selected' : ''; ?>>AB</option>
                                            <option value="O" <?php echo ($row["blood_type"] == 'O') ? 'selected' : ''; ?>>O</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>สถานะความสัมพันธ์</label>
                                        <select name="marital_status" class="custom-select form-control" autocomplete="off">
                                            <option value="โสด" <?php echo ($row["marital_status"] == 'โสด') ? 'selected' : ''; ?>>โสด</option>
                                            <option value="มีแฟนแล้ว" <?php echo ($row["marital_status"] == 'มีแฟนแล้ว') ? 'selected' : ''; ?>>มีแฟนแล้ว</option>
                                            <option value="แต่งงานแล้ว" <?php echo ($row["marital_status"] == 'แต่งงานแล้ว') ? 'selected' : ''; ?>>แต่งงานแล้ว</option>
                                            <option value="หม้าย" <?php echo ($row["marital_status"] == 'หม้าย') ? 'selected' : ''; ?>>หม้าย</option>
                                            <option value="หย่าระหว่างปี" <?php echo ($row["marital_status"] == 'หย่าระหว่างปี') ? 'selected' : ''; ?>>หย่าระหว่างปี</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>สัญชาติ</label>
                                        <select name="nation" class="custom-select form-control" autocomplete="off">
                                            <option value="ไทย" <?php echo ($row["nation"] == 'ไทย') ? 'selected' : ''; ?>>ไทย</option>
                                            <option value="ต่างชาติ" <?php echo ($row["nation"] == 'ต่างชาติ') ? 'selected' : ''; ?>>ต่างชาติ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>เชื้อชาติ</label>
                                        <select name="ethnicity" class="custom-select form-control" autocomplete="off">
                                            <option value="ไทย" <?php echo ($row["ethnicity"] == 'ไทย') ? 'selected' : ''; ?>>ไทย</option>
                                            <option value="ต่างชาติ" <?php echo ($row["ethnicity"] == 'ต่างชาติ') ? 'selected' : ''; ?>>ต่างชาติ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>ศาสนา</label>
                                        <select name="religion" class="custom-select form-control" autocomplete="off">
                                            <option value="พุทธ" <?php echo ($row["religion"] == 'พุทธ') ? 'selected' : ''; ?>>พุทธ</option>
                                            <option value="คริสต์" <?php echo ($row["religion"] == 'คริสต์') ? 'selected' : ''; ?>>คริสต์</option>
                                            <option value="อิสลาม" <?php echo ($row["religion"] == 'อิสลาม') ? 'selected' : ''; ?>>อิสลาม </option>
                                            <option value="ฮินดู" <?php echo ($row["religion"] == 'ฮินดู') ? 'selected' : ''; ?>>ฮินดู</option>
                                            <option value="ไม่นับถือ" <?php echo ($row["religion"] == 'ไม่นับถือ') ? 'selected' : ''; ?>>ไม่นับถือ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>เบอร์โทรพนักงาน</label>
                                        <input name="phone_number" type="number" placeholder="0650000000" value="<?php echo $row["phone_number"]; ?>" class="form-control" autocomplete="off" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>เลขประกันสังคม</label>
                                        <input name="social_security_id" type="number" placeholder=" ************* " value="<?php echo $row["social_security_id"]; ?>" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>เลขประจำตัวผู้เสียภาษี</label>
                                        <input name="tax_id" type="number" placeholder=" ************* " value="<?php echo $row["tax_id"]; ?>" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>ประเภทพนักงาน </label>
                                        <select disabled class="custom-select form-control" required="true" autocomplete="off">
                                            <?php
                                            $sqlDropdown_type = "SELECT * FROM contract_type";
                                            $resultDropdown_type = sqlsrv_query($conn, $sqlDropdown_type);

                                            if ($resultDropdown_type === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }

                                            while ($contract = sqlsrv_fetch_array($resultDropdown_type, SQLSRV_FETCH_ASSOC)) {
                                                $selected = ($contract['contract_type_id'] == $row["contract_type_id"]) ? 'selected' : '';
                                                echo "<option value='" . $contract['contract_type_id'] . "' $selected>" . $contract['name_thai'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>หมายเลข Cost-Center สำหรับระบุองค์กรภายใน SCG<b class="text-danger"> * </b></label>
                                        <select disabled class="selectpicker form-control" required="true" autocomplete="off" id="exampleSelect">
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
                                                    $selected = ($cost_org['cost_center_id'] == $row["cost_center_organization_id"]) ? 'selected' : '';
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
                                        <input name="employee_email" placeholder="example@scg.com" value="<?php echo $row["employee_email"]; ?>" type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>บทบาทสิทธิ์การเข้าถึง <b class="text-danger"> * </b></label>
                                        <select disabled class="custom-select form-control" required="true" autocomplete="off">
                                            <?php
                                            $sqlDropdown_cost = "SELECT * FROM permission";
                                            $resultDropdown_cost = sqlsrv_query($conn, $sqlDropdown_cost);

                                            if ($resultDropdown_cost === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($resultDropdown_cost) {
                                                while ($permission = sqlsrv_fetch_array($resultDropdown_cost, SQLSRV_FETCH_ASSOC)) {
                                                    $selected = ($permission['permission_id'] == $row["permission_id"]) ? 'selected' : '';
                                                    echo "<option value='"  . $permission['permission_id'] . "' $selected>" . $permission['permission_id'] . ' : ' . $permission['name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><b class="text-danger"> กรณี </b> หมายเลข Cost-Center สำหรับระบุองค์กรภายนอก <b class="text-danger"> * </b></label>
                                        <select disabled class="form-control selectpicker" required="true" autocomplete="off" id="exampleSelect1">
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
                                                    $selected = ($cost_pay['cost_center_id'] == $row["cost_center_payment_id"]) ? 'selected' : '';
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
                                        <select disabled class="custom-select form-control" autocomplete="off">
                                            <option value="ACTIVE" <?php echo ($row["employment_status"] == 'ACTIVE') ? 'selected' : ''; ?>>ทำงาน</option>
                                            <option value="IN-ACTIVE" <?php echo ($row["employment_status"] == 'IN-ACTIVE') ? 'selected' : ''; ?>>ลางาน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>วันที่เริ่มทดลองงาน</label>
                                        <input type="date" class="form-control" disabled <?php echo (!empty($row['probation_date_start'])) ? 'value="' . $row['probation_date_start']->format('Y-m-d') . '"' : ''; ?> autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>ระยะเวลาทดลองงาน</label>
                                        <input type="number" disabled value="<?php echo $row["probation_period"]; ?>" class="form-control" autocomplete="off" maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>วันที่เริ่มงาน SCG</label>
                                        <input type="date" class="form-control" disabled <?php echo (!empty($row['scg_hiring_date'])) ? 'value="' . $row['scg_hiring_date']->format('Y-m-d') . '"' : ''; ?> autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>วันที่เกษียณ</label>
                                        <input type="date" class="form-control" disabled <?php echo (!empty($row['retired_date'])) ? 'value="' . $row['retired_date']->format('Y-m-d') . '"' : ''; ?> autocomplete="off">

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>เลือกธนาคาร</label>
                                        <select name="bank_name" class="custom-select form-control" autocomplete="off">
                                            <option value="KBANK" <?php echo ($row["bank_name"] == 'KBANK') ? 'selected' : ''; ?>>KBANK กสิกรไทย</option>
                                            <option value="BBL" <?php echo ($row["bank_name"] == 'BBL') ? 'selected' : ''; ?>>BBL กรุงเทพ</option>
                                            <option value="KTB" <?php echo ($row["bank_name"] == 'KTB') ? 'selected' : ''; ?>>KTB กรุงไทย</option>
                                            <option value="BAY" <?php echo ($row["bank_name"] == 'BAY') ? 'selected' : ''; ?>>BAY กรุงศรี</option>
                                            <option value="TMB" <?php echo ($row["bank_name"] == 'TMB') ? 'selected' : ''; ?>>TMB ทหารไทยธนชาต</option>
                                            <option value="SCB" <?php echo ($row["bank_name"] == 'SCB') ? 'selected' : ''; ?>>SCB ไทยพาณิชย์</option>
                                            <option value="GSB" <?php echo ($row["bank_name"] == 'GSB') ? 'selected' : ''; ?>>GSB ออมสิน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>สาขาธนาคาร</label>
                                        <input name="bank_branch_name" placeholder="ระบุสาขาธนาคาร" value="<?php echo $row["bank_branch_name"]; ?>" type="text" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>เลขบัญชีธนาคาร</label>
                                        <input name="back_account_id" value="<?php echo $row["back_account_id"]; ?>" type="number" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>วันทำงาน / สัปดาห์</label>
                                        <select name="work_per_day" class="custom-select form-control" autocomplete="off">
                                            <option value="5" <?php echo ($row["work_per_day"] == '5') ? 'selected' : ''; ?>>5 วัน ต่อ สัปดาห์</option>
                                            <option value="6" <?php echo ($row["work_per_day"] == '6') ? 'selected' : ''; ?>>6 วัน ต่อ สัปดาห์</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label>ประสบการณ์ทำงานภายนอก (จำนวนปี)</label>
                                        <input name="outside_equivalent_year" placeholder="ระบุจำนวนปีการทำงาน" value="<?php echo $row["outside_equivalent_year"]; ?>" type="number" class="form-control" autocomplete="off" min="0" max="120">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>ประสบการณ์ทำงานภายนอก (จำนวนเดือน)</label>
                                        <input name="outside_equivalent_month" placeholder="ระบุจำนวนเดือนการทำงาน" value="<?php echo $row["outside_equivalent_month"]; ?>" type="number" class="form-control" autocomplete="off" min="0" max="12" oninput="validateInput(this)">
                                    </div>
                                </div>

                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-9 col-sm-1 text-right">
                                    <button type="submit" class="btn btn-primary" onclick="updateForm(event);">อัปเดต ข้อมูลพนักงาน</button>
                                </div>
                            </div>
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
                                    title: 'ยืนยันการบันทึก',
                                    text: 'คุณต้องการแก้ไขข้อมูลพนักงาน ใช่หรือไม่ ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formData = $('#update_emp').serialize();
                                        console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                        $.ajax({
                                            type: "POST",
                                            url: "Update_emp.php",
                                            data: formData,
                                            dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                            success: function(response) {
                                                console.log(response);
                                                if (response.status === 'success') {
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'success',
                                                        title: 'แก้ไขประวัติการศึกษาของคุณ สำเร็จ!',
                                                        text: 'ข้อมูลประวัติการศึกษาถูกเแก้ไขเรียบร้อย',
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
            <?php include('../head/include/footer.php') ?>
        </div>
    </div>
    <!-- js -->
    <?php include('../admin/include/scripts.php') ?>

</body>

</html>