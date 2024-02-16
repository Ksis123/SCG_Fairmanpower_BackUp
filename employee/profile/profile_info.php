                                        <!-- profile Tab start -->
                                        <!-- <div class="tab-pane fade show active" id="profile"> -->
                                            <div class="row flex">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-30 pl-30">
                                                    <div class="pd-20 card-box height-50-p">
                                                        <div class="profile-photo">
                                                            <button href="modal" data-toggle="modal" data-target="#modal" class="edit-pen"><i class="fa fa-pencil"></i></button>
                                                            <img src="<?php echo (!empty($row['employee_image'])) ? '../admin/uploads_img/' . $row['employee_image'] : '../asset/img/admin.png'; ?>" alt="" class="border-radius-100 shadow" width="160" height="160">

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
                                                                                <form method="post" enctype="multipart/form-data" id="updateImageprofile">
                                                                                    <div class="col-md-12 pd-5 pt-2">
                                                                                        <div class="form-group">
                                                                                            <div class="custom-file">
                                                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                                                                <input name="image" id="file" type="file" class="custom-file-input" accept="image/*" required="true">
                                                                                                <input type="hidden" name="card_id" value="<?php echo $card_id; ?>">
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button onclick="handleImageUpload_profile(event)" class="btn btn-primary"> อัพโหลดไฟล์รูป </button>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                                <!-- script -->
                                                                                <script>
                                                                                    function handleImageUpload_profile(event) {
                                                                                        event.preventDefault();
                                                                                        console.log("UPDATE Profile IMAGE send!");

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
                                                                                                var formData = new FormData($('#updateImageprofile')[0]);

                                                                                                $.ajax({
                                                                                                    type: "POST",
                                                                                                    url: "emp_uploadimage.php",
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
                                                        <h5 class="text-center text-blue">
                                                            <?php echo $row["scg_employee_id"]; ?>
                                                            <b><br />
                                                                <a class="text-blue"><?php echo $row["prefix_thai"], ' ', $row["firstname_thai"], ' ', $row["lastname_thai"]  ?>
                                                            </b><br />
                                                            <a class="text-blue"><?php echo $row["prefix_eng"], ' ', $row["firstname_eng"], ' ', $row["lastname_eng"]  ?>

                                                        </h5>
                                                        <h6 class="text-center text-blue pb-2">
                                                        </h6>
                                                        <div class="profile-info">
                                                            <ul>
                                                                <li class="pb-3">
                                                                    <b class="text-blue" style="padding-right: 5px;">
                                                                        <!-- <i class="fa-solid fa-user" style="color: #1FBAC0;"></i>  -->
                                                                        ตำแหน่ง :
                                                                    </b>
                                                                    <b style="padding: 5px" class='permission-<?php echo $row["permissionID"]; ?>'>
                                                                        <?php echo  $row["permission"]; ?>
                                                                    </b>

                                                                </li>
                                                                <li>
                                                                    <b class="text-blue"> รูปแบบสัญญาจ้าง : </b><a class='text-primary'><?php echo  ' ' . $row["contract_th"]; ?></a>
                                                                </li>
                                                                <li>
                                                                    <b class="text-blue"> ประเภทพนักงาน : </b><a class='text-primary'><?php echo  ' ' . $row["employee_type"]; ?></a>
                                                                </li>
                                                                <li>
                                                                    <b class="text-blue"> วันเริ่มงาน SCG : </b><a class='text-primary'><?php echo  ' ' . $row["scg_hiring_date"]->format('d-m-Y'); ?></a>
                                                                </li>
                                                                <li>
                                                                    <b class="text-blue"> วันเกษียณ SCG : </b><a class='text-primary'><?php echo  ' ' . $row["retired_date"]->format('d-m-Y'); ?></a>
                                                                </li>
                                                                <li>
                                                                    <b class="text-blue"> ประสบการณ์ทำงาน </b><a class='text-primary'><?php echo  ' : ' . $row["equivalent_year"] . ' ปี ' . $row["equivalent_month"] . ' เดือน'; ?></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="profile-info">
                                                            <ul>
                                                                <li>
                                                                    <b class="text-blue"><i class="fa-solid fa-envelope" style="color: #1FBAC0;"></i> Email : </b><a class='text-primary'><?php echo  ' ' . $row["employee_email"]; ?></a>
                                                                </li>
                                                                <li>
                                                                    <b class="text-blue"><i class="fa-solid fa-phone" style="color: #1FBAC0;"></i> เบอร์โทร : </b>
                                                                    <a class='text-primary'>
                                                                        <?php
                                                                        $phone_number = $row["phone_number"];

                                                                        // ตรวจสอบว่าเบอร์โทรมีขนาดเพียงพอ
                                                                        if (strlen($phone_number) == 10) {
                                                                            $formatted_phone = substr($phone_number, 0, 3) . '-' . substr($phone_number, 3);
                                                                            echo ' ' . $formatted_phone;
                                                                        } else {
                                                                            // กรณีที่ไม่ตรงตามรูปแบบที่ต้องการ
                                                                            echo "รูปแบบเบอร์โทรไม่ถูกต้อง";
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                </li>

                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- main -->
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mt-30 mb-30 pr-30">
                                                    <div class="pd-20 card-box height-100-p">
                                                        <div class="">
                                                            <div class="col-md-12">
                                                                <h4 class="text-blue mb-20"><i class="fa-solid fa-address-card"></i> ข้อมูลพนักงานพื้นฐาน</h4>
                                                            </div>
                                                            <div class="wizard-content">
                                                                <form id="update_info" method="post">
                                                                    <div class="row">
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>รหัสบัตรประชาชน</label>
                                                                                <input type="text" name="card_id" class="form-control" value="<?php echo $row["card_id"]; ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>รหัสส่วนบุคคล</label>
                                                                                <input name="person_id" type="number" maxlength="7" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" value="<?php echo $row["person_id"]; ?>" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>รหัสประจำตัวบุคคล</label>
                                                                                <input name="personnel_number" type="number" maxlength="7" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" value="<?php echo $row["personnel_number"]; ?>" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>อายุ</label>
                                                                                <div class="form-control pd-10">
                                                                                    <label class='text-primary '> <?php echo ' ' .  $row["age_year"] . ' ปี ' .  $row["age_month"] . ' เดือน '; ?> </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr />
                                                                    <div class="row">
                                                                        <div class="col-md-3 col-sm-3 col-6">
                                                                            <div class="form-group">
                                                                                <label>คำนำหน้า (TH)</label>
                                                                                <select name="prefix_thai" class="custom-select form-control" type="text" autocomplete="off" value="<?php echo $row["prefix_thai"]; ?>">
                                                                                    <option value="นาย" <?php echo ($row["prefix_thai"] == 'นาย') ? 'selected' : ''; ?>>นาย</option>
                                                                                    <option value="นาง" <?php echo ($row["prefix_thai"] == 'นาง') ? 'selected' : ''; ?>>นาง</option>
                                                                                    <option value="นางสาว" <?php echo ($row["prefix_thai"] == 'นางสาว') ? 'selected' : ''; ?>>นางสาว</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-4 ">
                                                                            <div class="form-group">
                                                                                <label>ชื่อ (TH)</label>
                                                                                <input name="firstname_thai" class="form-control wizard-required" type="text" autocomplete="off" value="<?php echo $row["firstname_thai"]; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-sm-4">
                                                                            <div class="form-group">
                                                                                <label>นามสกุล (TH)</label>
                                                                                <input name="lastname_thai" class="form-control wizard-required" type="text" autocomplete="off" value="<?php echo $row["lastname_thai"]; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-sm-3">
                                                                            <div class="form-group">
                                                                                <label>ชื่อเล่น (TH)</label>
                                                                                <input name="nickname_thai" class="form-control wizard-required" type="text" autocomplete="off" value="<?php echo $row['nickname_thai']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-3 col-sm-12 col-6">
                                                                            <div class="form-group">
                                                                                <label>คำนำหน้า (ENG)</label>
                                                                                <select name="prefix_eng" class="custom-select form-control" type="text" autocomplete="off" value="<?php echo $row["prefix_eng"]; ?>">
                                                                                    <option value="Mr." <?php echo ($row["prefix_eng"] == 'Mr.') ? 'selected' : ''; ?>>Mr.</option>
                                                                                    <option value="Mrs." <?php echo ($row["prefix_eng"] == 'Mrs.') ? 'selected' : ''; ?>>Mrs</option>
                                                                                    <option value="Miss" <?php echo ($row["prefix_eng"] == 'Miss') ? 'selected' : ''; ?>>Miss</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>ชื่อ (ENG)</label>
                                                                                <input name="firstname_eng" class="form-control wizard-required" type="text" required="true" autocomplete="off" value="<?php echo $row['firstname_eng']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>นามสกุล (ENG)</label>
                                                                                <input name="lastname_eng" class="form-control wizard-required" type="text" autocomplete="off" value="<?php echo $row['lastname_eng']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>ชื่อเล่น (ENG)</label>
                                                                                <input name="nickname_eng" class="form-control wizard-required" type="text" autocomplete="off" value="<?php echo $row['nickname_eng']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group ">
                                                                                <label>เพศสภาพ (Sex)</label>
                                                                                <div class="text-left flex col-md-4 col-2" style="justify-content: space-between;">
                                                                                    <input type="radio" name="gender" value="ชาย" <?php echo ($row["gender"] == 'ชาย') ? 'checked' : ''; ?>>
                                                                                    <a style="color: #8f8f8f"><i class="fa-solid fa-mars fa-lg" style="color: #3fa7f2"></i>ชาย</a><br>

                                                                                    <input type="radio" name="gender" value="หญิง" <?php echo ($row["gender"] == 'หญิง') ? 'checked' : ''; ?>>
                                                                                    <a style="color: #8f8f8f"><i class="fa-solid fa-venus fa-lg" style="color: #fc5ba1"></i>หญิง</a><br>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>วันเกิดพนักงาน</label>
                                                                                <input name="birth_date" type="date" class="form-control" value="<?php echo $row['birth_date']->format('Y-m-d'); ?>" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-sm-12 col-4">
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
                                                                        <div class="col-md-4 col-sm-12 col-7">
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
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>อีเมลพนักงาน</label>
                                                                                <input name="employee_email" placeholder="example@scg.com" value="<?php echo $row["employee_email"]; ?>" type="text" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>เบอร์โทรพนักงาน</label>
                                                                                <input name="phone_number" type="number" placeholder="0650000000" value="<?php echo $row["phone_number"]; ?>" class="form-control" autocomplete="off" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>เลขประกันสังคม</label>
                                                                                <input name="social_security_id" type="number" placeholder=" ************* " value="<?php echo $row["social_security_id"]; ?>" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-2 col-sm-2 col-4">
                                                                            <div class="form-group ">
                                                                                <div class="form-group">
                                                                                    <label>สัญชาติ</label>
                                                                                    <select name="nation" class="custom-select form-control" autocomplete="off">
                                                                                        <option value="ไทย" <?php echo ($row["nation"] == 'ไทย') ? 'selected' : ''; ?>>ไทย</option>
                                                                                        <option value="ต่างชาติ" <?php echo ($row["nation"] == 'ต่างชาติ') ? 'selected' : ''; ?>>ต่างชาติ</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-sm-2 col-4">
                                                                            <div class="form-group">
                                                                                <label>เชื้อชาติ</label>
                                                                                <select name="ethnicity" class="custom-select form-control" autocomplete="off">
                                                                                    <option value="ไทย" <?php echo ($row["ethnicity"] == 'ไทย') ? 'selected' : ''; ?>>ไทย</option>
                                                                                    <option value="ต่างชาติ" <?php echo ($row["ethnicity"] == 'ต่างชาติ') ? 'selected' : ''; ?>>ต่างชาติ</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-2 col-4">
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
                                                                        <div class="col-md-4 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>เลขประจำตัวผู้เสียภาษี</label>
                                                                                <input name="tax_id" type="number" placeholder=" ************* " value="<?php echo $row["tax_id"]; ?>" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>หมายเลข Cost-Center Organization</label>
                                                                                <select disabled class="form-control selectpicker" autocomplete="off">

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
                                                                                            $selected = ($cost_org['cost_center_id'] == $row["cost_center_payment_id"]) ? 'selected' : '';
                                                                                            echo "<option value='"  . $cost_org['cost_center_id'] . "' $selected>" . $cost_org['cost_center_code'] . ' : ' . $cost_org['department'] . "</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>หมายเลข Cost-Center Payment</label>
                                                                                <select disabled class="form-control selectpicker" autocomplete="off">
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
                                                                        <div class="col-lg-5 col-sm-5">
                                                                            <div class="form-group">
                                                                                <label>ประสบการณ์ทำงานภายนอก (จำนวนปี)</label>
                                                                                <input name="outside_equivalent_year" placeholder="ระบุจำนวนปีการทำงาน" value="<?php echo $row["outside_equivalent_year"]; ?>" type="number" class="form-control" autocomplete="off" oninput="validateInput_y(this)">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5 col-sm-5">
                                                                            <div class="form-group">
                                                                                <label>ประสบการณ์ทำงานภายนอก (จำนวนเดือน)</label>
                                                                                <input name="outside_equivalent_month" placeholder="ระบุจำนวนเดือนการทำงาน" value="<?php echo $row["outside_equivalent_month"]; ?>" type="number" class="form-control" autocomplete="off" min="0" max="12" oninput="validateInput_m(this)">
                                                                            </div>
                                                                            <script>
                                                                                function validateInput_m(input) {
                                                                                    // ดึงค่าที่ป้อนเข้ามา
                                                                                    var inputValue = input.value;

                                                                                    // ทำการแปลงค่าเป็นจำนวนเต็ม
                                                                                    var intValue = parseInt(inputValue);

                                                                                    // ตรวจสอบว่าค่าอยู่ในช่วงที่ต้องการหรือไม่
                                                                                    if (intValue < 1 || intValue > 12 || isNaN(intValue)) {
                                                                                        // ถ้าไม่อยู่ในช่วงหรือไม่ใช่ตัวเลข 1-12 ให้ล้างค่า
                                                                                        input.value = "";
                                                                                    }
                                                                                }
                                                                            </script>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label></label>
                                                                            <div class="modal-footer justify-content-center">
                                                                                <button class="btn btn-primary" name="employee_update" onclick="updateForm(event);">บันทึก แก้ไขข้อมูล</button>
                                                                            </div>
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
                                                                                var formData = $('#update_info').serialize();

                                                                                $.ajax({
                                                                                    type: "POST",
                                                                                    url: "profile/Update_emp.php",
                                                                                    data: formData,
                                                                                    dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                                                                    success: function(response) {
                                                                                        if (response.status === 'success') {
                                                                                            swalWithBootstrapButtons.fire({
                                                                                                icon: 'success',
                                                                                                title: 'แก้ไขข้อมูลพนักงานของคุณ สำเร็จ!',
                                                                                                text: 'ข้อมูลพนักงานถูกเแก้ไขเรียบร้อย',
                                                                                            }).then(() => {
                                                                                                location.reload();
                                                                                            });
                                                                                        } else {
                                                                                            swalWithBootstrapButtons.fire({
                                                                                                icon: 'error',
                                                                                                title: 'เกิดข้อผิดพลาด!',
                                                                                                text: 'ไม่สามารถบันทึกข้อมูลได้',
                                                                                            });
                                                                                        }
                                                                                    },
                                                                                    error: function() {
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
                                        <!-- </div> -->

                                        <!-- Timeline Tab End -->