                                        <!-- education Tab start -->
                                        <!-- <div class="tab-pane fade" id="education"> -->
                                        <div class="row flex">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="pd-30 card-box">
                                                    <div class="profile-setting">
                                                        <div class="col-md-12">
                                                            <h4 class="text-blue mb-20"><i class="fa-solid fa-graduation-cap"></i> ประวัติการศึกษา</h4>
                                                        </div>
                                                        <form method="post" id="update_edu_info">
                                                            <div class="wizard-content">
                                                                <div class="row">
                                                                    <input name="education_info_id" type="hidden" value="<?php echo isset($e_info["education_info_id"]) ? $e_info["education_info_id"] : ''; ?>">

                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>รหัสบัตรประชาชนของพนักงาน</label>
                                                                            <input name="card_id" type="number" readonly value="<?php echo isset($e_info["card_id"]) ? $e_info["card_id"] : ''; ?>" class="form-control" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>วุฒิการศึกษา</label>
                                                                            <select name="education_level_degree" class="custom-select form-control" autocomplete="off">
                                                                                <option value="" disabled> ระบุวุฒิการศึกษา</option>
                                                                                <option value="บัณฑิต (ปริญญาตรี)" <?php echo (isset($e_edu["education_level_degree"]) && $e_edu["education_level_degree"] == 'บัณฑิต (ปริญญาตรี)') ? 'selected' : ''; ?>>บัณฑิต (ปริญญาตรี)</option>
                                                                                <option value="มหาบัณฑิต (ปริญญาโท)" <?php echo (isset($e_edu["education_level_degree"]) && $e_edu["education_level_degree"] == 'มหาบัณฑิต (ปริญญาโท)') ? 'selected' : ''; ?>>มหาบัณฑิต (ปริญญาโท)</option>
                                                                                <option value="ปวช." <?php echo (isset($e_edu["education_level_degree"]) && $e_edu["education_level_degree"] == 'ปวช.') ? 'selected' : ''; ?>>ปวช.</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>คณะ</label>
                                                                            <input name="faculty_degree" type="text" class="form-control" value="<?php echo isset($e_edu["faculty_degree"]) ? $e_edu["faculty_degree"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>วิชาเอก</label>
                                                                            <input name="major_degree" type="text" class="form-control" value="<?php echo isset($e_edu["major_degree"]) ? $e_edu["major_degree"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>สถาบัน</label>
                                                                            <input name="institute_degree" type="text" class="form-control" value="<?php echo isset($e_edu["institute_degree"]) ? $e_edu["institute_degree"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ประเทศ</label>
                                                                            <input name="country_degree" type="text" class="form-control" value="<?php echo isset($e_edu["country_degree"]) ? $e_edu["country_degree"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>เกรดเฉลี่ย</label>
                                                                            <input name="grade_degree" type="text" class="form-control" value="<?php echo isset($e_edu["grade_degree"]) ? $e_edu["grade_degree"] : ''; ?>" oninput="formatDecimal(this)" autocomplete="off" pattern="\d+(\.\d{1,2})?" title="กรุณากรอกเป็นตัวเลขที่มีทศนิยมไม่เกิน 2 ตำแหน่ง">
                                                                        </div>
                                                                        <script>
                                                                            function formatDecimal(input) {
                                                                                // ลบทุกอักขระที่ไม่ใช่ตัวเลขหรือจุดทศนิยม
                                                                                input.value = input.value.replace(/[^\d.]/g, '');
                                                                                // ตรวจสอบการมีจุดทศนิยมมากกว่า 1 ตำแหน่ง
                                                                                var decimalCount = (input.value.match(/\./g) || []).length;
                                                                                if (decimalCount > 1) {
                                                                                    input.value = input.value.slice(0, -1);
                                                                                }
                                                                                // กำหนดรูปแบบตามที่ต้องการ
                                                                                input.value = input.value.replace(/(\.\d\d)\d+$/, '$1');
                                                                            }
                                                                        </script>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ปีที่สำเร็จการศึกษา</label>
                                                                            <input name="year_acquired_degree" type="date" class="form-control" value="<?php echo isset($e_edu['year_acquired_degree']) ? $e_edu['year_acquired_degree']->format('Y-m-d') : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row pb-5">
                                                                    <div class="col-md-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ใบรับรองการศึกษา</label>
                                                                            <input name="certificate_degree" type="file" id="certificate_degree" class="form-control" accept="application/pdf" disabled />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="justify-content-center pt-20">
                                                                                <button class="btn btn-primary" onclick="update_education(event);">บันทึก แก้ไขข้อมูล</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h4 class="text-blue mb-20"><i class="fa-solid fa-circle-plus"></i><b class="text-danger"> กรณีได้รับ </b> ทุนการศึกษา </h4>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>วุฒิการศึกษา</label>
                                                                            <select name="education_level_scholarship" class="custom-select form-control" autocomplete="off">
                                                                                <option value=" " disabled selected> ระบุวุฒิการศึกษาจากทุนที่ได้รับ</option>
                                                                                <option value="บัณฑิต (ปริญญาตรี)" <?php echo (isset($e_edu["education_level_scholarship"]) && $e_edu["education_level_scholarship"] == 'บัณฑิต (ปริญญาตรี)') ? 'selected' : ''; ?>>บัณฑิต (ปริญญาตรี)</option>
                                                                                <option value="มหาบัณฑิต (ปริญญาโท)" <?php echo (isset($e_edu["education_level_scholarship"]) && $e_edu["education_level_scholarship"] == 'มหาบัณฑิต (ปริญญาโท)') ? 'selected' : ''; ?>>มหาบัณฑิต (ปริญญาโท)</option>
                                                                                <option value="ปวช." <?php echo (isset($e_edu["education_level_scholarship"]) && $e_edu["education_level_scholarship"] == 'ปวช.') ? 'selected' : ''; ?>>ปวช.</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <input name="certificate_scholarship" type="hidden" class="form-control" />
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>คณะ </label>
                                                                            <input name="faculty_scholarship" type="text" class="form-control" value="<?php echo isset($e_edu["faculty_scholarship"]) ? $e_edu["faculty_scholarship"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>วิชาเอก </label>
                                                                            <input name="major_scholarship" type="text" class="form-control" value="<?php echo isset($e_edu["major_scholarship"]) ? $e_edu["major_scholarship"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>สถาบัน</label>
                                                                            <input name="institute_scholarship" type="text" class="form-control" value="<?php echo isset($e_edu["institute_scholarship"]) ? $e_edu["institute_scholarship"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ประเทศ </label>
                                                                            <input name="country_scholarship" type="text" class="form-control" value="<?php echo isset($e_edu["country_scholarship"]) ? $e_edu["country_scholarship"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>เกรดเฉลี่ย</label>
                                                                            <input name="grade_scholarship" type="text" class="form-control" value="<?php echo isset($e_edu["grade_scholarship"]) ? $e_edu["grade_scholarship"] : ''; ?>" oninput="formatDecimal(this)" autocomplete="off" pattern="\d+(\.\d{1,2})?" title="กรุณากรอกเป็นตัวเลขที่มีทศนิยมไม่เกิน 2 ตำแหน่ง">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ปีที่สำเร็จการศึกษา</label>
                                                                            <input name="year_acquired_scholarship" type="date" class="form-control" value="<?php echo isset($e_edu['year_acquired_scholarship']) ? $e_edu['year_acquired_scholarship']->format('Y-m-d') : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>วุฒิการศึกษา</label>
                                                                            <select name="education_level_other1" class="custom-select form-control" autocomplete="off">
                                                                                <option value="" disabled selected> ระบุวุฒิการศึกษา</option>
                                                                                <option value="บัณฑิต (ปริญญาตรี)" <?php echo (isset($e_edu["education_level_other1"]) && $e_edu["education_level_other1"] == 'บัณฑิต (ปริญญาตรี)') ? 'selected' : ''; ?>>บัณฑิต (ปริญญาตรี)</option>
                                                                                <option value="มหาบัณฑิต (ปริญญาโท)" <?php echo (isset($e_edu["education_level_other1"]) && $e_edu["education_level_other1"] == 'มหาบัณฑิต (ปริญญาโท)') ? 'selected' : ''; ?>>มหาบัณฑิต (ปริญญาโท)</option>
                                                                                <option value="ปวช." <?php echo (isset($e_edu["education_level_other1"]) && $e_edu["education_level_other1"] == 'ปวช.') ? 'selected' : ''; ?>>ปวช.</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <label>ใบรับรองการศึกษา </label> -->
                                                                    <input name="certificate_other1" type="hidden" class="form-control" />
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>คณะ </label>
                                                                            <input name="faculty_other1" type="text" class="form-control" value="<?php echo isset($e_edu["faculty_other1"]) ? $e_edu["faculty_other1"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>วิชาเอก </label>
                                                                            <input name="major_other1" type="text" class="form-control" value="<?php echo isset($e_edu["major_other1"]) ? $e_edu["major_other1"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>สถาบัน</label>
                                                                            <input name="institute_other1" type="text" class="form-control" value="<?php echo isset($e_edu["institute_other1"]) ? $e_edu["institute_other1"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ประเทศ </label>
                                                                            <input name="country_other1" type="text" class="form-control" value="<?php echo isset($e_edu["country_other1"]) ? $e_edu["country_other1"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>เกรดเฉลี่ย</label>
                                                                            <input name="grade_other1" type="text" class="form-control" value="<?php echo isset($e_edu["grade_other1"]) ? $e_edu["grade_other1"] : ''; ?>" oninput="formatDecimal(this)" autocomplete="off" pattern="\d+(\.\d{1,2})?" title="กรุณากรอกเป็นตัวเลขที่มีทศนิยมไม่เกิน 2 ตำแหน่ง">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ปีที่สำเร็จการศึกษา</label>
                                                                            <input name="year_acquired_other1" type="date" class="form-control" value="<?php echo isset($e_edu['year_acquired_other1']) ? $e_edu['year_acquired_other1']->format('Y-m-d') : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>วุฒิการศึกษา</label>
                                                                            <select name="education_level_other2" class="custom-select form-control" autocomplete="off">
                                                                                <option value="" disabled selected> ระบุวุฒิการศึกษา</option>
                                                                                <option value="บัณฑิต (ปริญญาตรี)" <?php echo (isset($e_edu["education_level_other2"]) && $e_edu["education_level_other2"] == 'บัณฑิต (ปริญญาตรี)') ? 'selected' : ''; ?>>บัณฑิต (ปริญญาตรี)</option>
                                                                                <option value="มหาบัณฑิต (ปริญญาโท)" <?php echo (isset($e_edu["education_level_other2"]) && $e_edu["education_level_other2"] == 'มหาบัณฑิต (ปริญญาโท)') ? 'selected' : ''; ?>>มหาบัณฑิต (ปริญญาโท)</option>
                                                                                <option value="ปวช." <?php echo (isset($e_edu["education_level_other2"]) && $e_edu["education_level_other2"] == 'ปวช.') ? 'selected' : ''; ?>>ปวช.</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <label>ใบรับรองการศึกษา </label> -->
                                                                    <input name="certificate_other2" type="hidden" class="form-control" />
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>คณะ </label>
                                                                            <input name="faculty_other2" type="text" class="form-control" value="<?php echo isset($e_edu["faculty_other2"]) ? $e_edu["faculty_other2"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>วิชาเอก </label>
                                                                            <input name="major_other2" type="text" class="form-control" value="<?php echo isset($e_edu["major_other2"]) ? $e_edu["major_other2"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>สถาบัน</label>
                                                                            <input name="institute_other2" type="text" class="form-control" value="<?php echo isset($e_edu["institute_other2"]) ? $e_edu["institute_other2"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ประเทศ </label>
                                                                            <input name="country_other2" type="text" class="form-control" value="<?php echo isset($e_edu["country_other2"]) ? $e_edu["country_other2"] : ''; ?>" autocomplete="on" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>เกรดเฉลี่ย</label>
                                                                            <input name="grade_other2" type="text" class="form-control" value="<?php echo isset($e_edu["grade_other2"]) ? $e_edu["grade_other2"] : ''; ?>" oninput="formatDecimal(this)" autocomplete="off" pattern="\d+(\.\d{1,2})?" title="กรุณากรอกเป็นตัวเลขที่มีทศนิยมไม่เกิน 2 ตำแหน่ง">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label>ปีที่สำเร็จการศึกษา</label>
                                                                            <input name="year_acquired_other2" type="date" class="form-control" value="<?php echo isset($e_edu['year_acquired_other2']) ? $e_edu['year_acquired_other2']->format('Y-m-d') : ''; ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <script>
                                                            function update_education(event) {
                                                                event.preventDefault();
                                                                console.log("Education Info send!");
                                                                const swalWithBootstrapButtons = Swal.mixin({
                                                                    customClass: {
                                                                        confirmButton: "green-swal",
                                                                        cancelButton: "delete-swal"
                                                                    },
                                                                    buttonsStyling: false
                                                                });

                                                                swalWithBootstrapButtons.fire({
                                                                    title: 'ยืนยันการบันทึก',
                                                                    text: 'คุณต้องการแก้ไขประวัติการศึกษา ใช่หรือไม่ ?',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                                                    cancelButtonText: 'ยกเลิก',
                                                                }).then((response) => {
                                                                    if (response.isConfirmed) {
                                                                        var formData_edu = $('#update_edu_info').serialize();
                                                                        console.log("Form Data: ", formData_edu); // Log ค่า FormData ที่จะส่งไป

                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "profile/Update_education.php",
                                                                            data: formData_edu,
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
                                                                            // error: function(xhr, textStatus, errorThrown) {
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
                                        <!-- </div> -->
                                        <!-- education Tab End -->