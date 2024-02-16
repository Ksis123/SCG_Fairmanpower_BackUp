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
                                <h3>ประวัติส่วนตัว</h3>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="listemployee.php">หน้าหลัก</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Edit.php">ข้อมูลพนักงานเบื้องต้น</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">ประวัติส่วนตัว</li>
                                    <li class="breadcrumb-item"><a href="listemployee_Education.php">ประวัติการศึกษา</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Manager.php">ผู้จัดการ report-to</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <!-- <div class="pull-left">
							<h4 class="text-blue h4">แบบฟอร์มข้อมูลพนักงานเบื้องต้น</h4>
							<p class="mb-20"></p>
						</div> -->
                    </div>
                    <div class="wizard-content">
                        <form method="post" id="update_empinfo">
                            <div class="wizard-content">
                                <div class="row">
                                    <input name="employee_info_id" type="hidden" value="<?php echo $e_info["employee_info_id"]; ?>">

                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>รหัสบัตรประชาชน</label>
                                            <input name="card_id" class="form-control wizard-required" readonly value="<?php echo $e_info["card_id"]; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อผู้ใช้งาน</label>
                                            <input name="employee_user" type="text" class="form-control wizard-required" value="<?php echo is_null($e_info["employee_user"]) ? $fname : $e_info["employee_user"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>อีเมลทางธุรกิจ</label>
                                            <input name="business_email" type="text" class="form-control wizard-required" value="<?php echo $e_info["business_email"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>เบอร์โทรศัพท์ทางธุรกิจ</label>
                                            <input name="telephone_business" type="number" class="form-control wizard-required" value="<?php echo $e_info["telephone_business"]; ?>" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลขที่บ้าน</label>
                                            <input name="address_no" type="text" class="form-control wizard-required" value="<?php echo $e_info["address_no"]; ?>" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-12">
                                        <div class="form-group">
                                            <label>หมู่</label>
                                            <input name="village_no" type="number" class="form-control wizard-required" value="<?php echo $e_info["village_no"]; ?>" maxlength="2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ถนน</label>
                                            <input name="street" type="text" class="form-control wizard-required" value="<?php echo $e_info["street"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ตำบล</label>
                                            <input name="sub_district" type="text" class="form-control wizard-required" value="<?php echo $e_info["sub_district"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>อำเภอ</label>
                                            <input name="district" type="text" class="form-control wizard-required" value="<?php echo $e_info["district"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>จังหวัด</label>
                                            <input name="province" type="text" class="form-control wizard-required" value="<?php echo $e_info["province"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>รหัสไปรษณีย์</label>
                                            <input name="postal_id" type="number" class="form-control wizard-required" value="<?php echo $e_info["postal_id"]; ?>" maxlength="5" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ประเทศ</label>
                                            <input name="country" type="text" class="form-control wizard-required" value="<?php echo $e_info["country"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เบอร์โทรศัพท์บ้าน</label>
                                            <input name="telephone_home" type="number" class="form-control wizard-required" value="<?php echo $e_info["telephone_home"]; ?>" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <div class="form-group">
                                            <label>ที่อยู่ออฟฟิศ</label>
                                            <input name="office_address" type="text" class="form-control wizard-required" value="<?php echo $e_info["office_address"]; ?>" autocomplete="on">
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="text-blue mb-20"><i class="fa-solid fa-heart-circle-plus"></i> คู่สมรส <b class="text-danger"> กรณีแต่งงานแล้ว </b></h4>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อ</label>
                                            <input name="spourse_firstname" type="text" class="form-control wizard-required" value="<?php echo $e_info["spourse_firstname"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>นามสกุล</label>
                                            <input name="spourse_lastname" type="text" class="form-control wizard-required" value="<?php echo $e_info["spourse_lastname"]; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label>จำนวนบุตร <b class="text-danger"> (ถ้ามี) </b></label>
                                            <div class="flex">
                                                <input name="number_of_child" type="number" placeholder="จำนวนบุตร" class="form-control wizard-required" value="<?php echo $e_info["number_of_child"]; ?>" maxlength="2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลขประจำตัวผู้เสียภาษี</label>
                                            <div class="flex">
                                                <input name="spourse_tax_id" type="number" placeholder="XXXXXXXXXXXXX" class="form-control wizard-required" value="<?php echo $e_info["spourse_tax_id"]; ?>" maxlength="8" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label></label>
                                        <div class="modal-footer justify-content-center">
                                            <button class="btn btn-primary" onclick="update_info(event);">บันทึก แก้ไขข้อมูล</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                            function update_info(event) {
                                event.preventDefault();
                                console.log("Info send!");
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "green-swal",
                                        cancelButton: "delete-swal"
                                    },
                                    buttonsStyling: false
                                });

                                swalWithBootstrapButtons.fire({
                                    title: 'ยืนยันการบันทึก',
                                    text: 'คุณต้องการแก้ไขประวัติส่วนตัว ใช่หรือไม่ ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formDatainfo = $('#update_empinfo').serialize();
                                        console.log("Form Data: ", formDatainfo); // Log ค่า FormData ที่จะส่งไป

                                        $.ajax({
                                            type: "POST",
                                            url: "profile/Update_info.php",
                                            data: formDatainfo,
                                            dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                            success: function(response) {
                                                if (response.status === 'success') {
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'success',
                                                        title: 'แก้ไขประวัติส่วนตัวของคุณ สำเร็จ!',
                                                        text: 'ข้อมูลประวัติส่วนตัวถูกเแก้ไขเรียบร้อย',
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