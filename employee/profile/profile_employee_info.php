                                        <!-- employee_info Tab start -->
                                        <!-- <div class="tab-pane fade" id="employee_info"> -->
                                            <div class="row flex">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="pd-30 card-box height-100-p">
                                                        <div class="profile-setting">
                                                            <div class="col-md-12">
                                                                <h4 class="text-blue mb-20"><i class="fa-solid fa-user-tag"></i> ประวัติส่วนตัว</h4>
                                                            </div>
                                                            <form method="post" id="update_empinfo">
                                                                <div class="wizard-content">
                                                                    <div class="row">
                                                                        <input name="employee_info_id" type="hidden" value="<?php echo isset($e_info["employee_info_id"]) ? $e_info["employee_info_id"] : ''; ?>">

                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>รหัสบัตรประชาชน</label>
                                                                                <input name="card_id" class="form-control wizard-required" readonly value="<?php echo isset($e_info["card_id"]) ? $e_info["card_id"] : ''; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>ชื่อผู้ใช้งาน</label>
                                                                                <input name="employee_user" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["employee_user"]) ? $e_info["employee_user"] : $fname; ?>" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>อีเมลทางธุรกิจ</label>
                                                                                <input name="business_email" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["business_email"]) ? $e_info["business_email"] : ''; ?>" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>เบอร์โทรศัพท์ทางธุรกิจ</label>
                                                                                <input name="telephone_business" type="number" class="form-control wizard-required" value="<?php echo isset($e_info["telephone_business"]) ? $e_info["telephone_business"] : ''; ?>" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>เลขที่บ้าน</label>
                                                                            <input name="address_no" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["address_no"]) ? $e_info["address_no"] : ''; ?>" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>หมู่</label>
                                                                            <input name="village_no" type="number" class="form-control wizard-required" value="<?php echo isset($e_info["village_no"]) ? $e_info["village_no"] : ''; ?>" maxlength="2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ถนน</label>
                                                                            <input name="street" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["street"]) ? $e_info["street"] : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ตำบล</label>
                                                                            <input name="sub_district" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["sub_district"]) ?  $e_info["sub_district"] : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>อำเภอ</label>
                                                                            <input name="district" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["district"]) ? $e_info["district"] : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>จังหวัด</label>
                                                                            <input name="province" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["province"]) ? $e_info["province"] : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>รหัสไปรษณีย์</label>
                                                                            <input name="postal_id" type="number" class="form-control wizard-required" value="<?php echo isset($e_info["postal_id"]) ? $e_info["postal_id"] : ''; ?>" maxlength="5" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ประเทศ</label>
                                                                            <input name="country" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["country"]) ? $e_info["country"] : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>เบอร์โทรศัพท์บ้าน</label>
                                                                            <input name="telephone_home" type="number" class="form-control wizard-required" value="<?php echo isset($e_info["telephone_home"]) ? $e_info["telephone_home"] : ''; ?>" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ที่อยู่ออฟฟิศ</label>
                                                                            <input name="office_address" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["office_address"]) ? $e_info["office_address"] : ''; ?>" autocomplete="on">
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
                                                                            <input name="spourse_firstname" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["spourse_firstname"]) ? $e_info["spourse_firstname"] : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>นามสกุล</label>
                                                                            <input name="spourse_lastname" type="text" class="form-control wizard-required" value="<?php echo isset($e_info["spourse_lastname"]) ? $e_info["spourse_lastname"] : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-2">
                                                                        <div class="form-group">
                                                                            <label>จำนวนบุตร <b class="text-danger"> (ถ้ามี) </b></label>
                                                                            <div class="flex">
                                                                                <input name="number_of_child" type="number" placeholder="จำนวนบุตร" class="form-control wizard-required" value="<?php echo isset($e_info["number_of_child"]) ? $e_info["number_of_child"] : ''; ?>" maxlength="2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>เลขประจำตัวผู้เสียภาษี</label>
                                                                            <div class="flex">
                                                                                <input name="spourse_tax_id" type="number" placeholder="XXXXXXXXXXXXX" class="form-control wizard-required" value="<?php echo isset($e_info["spourse_tax_id"]) ? $e_info["spourse_tax_id"] : ''; ?>" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="on">
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
                                                            </form>
                                                        </div>
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
                                        <!-- </div> -->

                                        <!-- employee_info Tab End -->