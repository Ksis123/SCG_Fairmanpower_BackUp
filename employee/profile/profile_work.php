                                        <!-- education Tab start -->
                                        <div class="tab-pane fade height-100-p" id="work" role="tabpanel">
                                            <div class="row flex">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="pd-30 card-box height-100-p">
                                                        <div class="profile-setting">
                                                            <div class="col-md-12">
                                                                <h4 class="text-blue mb-20"><i class="fa-solid fa-briefcase"></i> ประวัติการทำงาน</h4>
                                                            </div>
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="wizard-content">
                                                                    <div class="row">
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>รหัสบัตรประชาชนของพนักงาน</label>
                                                                                <input name="card_id" type="number" readonly value="<?php echo $card_id; ?>" class="form-control"  autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>ชื่อจริง (ภาษาไทย)</label>
                                                                                <input name="firstname_thai" type="text" readonly value="<?php echo $fname; ?>" class="form-control"  autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>นามสกุล (ภาษาไทย)</label>
                                                                                <input name="lastname_thai" type="text" readonly value="<?php echo $lname; ?>" class="form-control"  autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>วุฒิการศึกษา</label>
                                                                                <select name="education_level_entry_degree" class="custom-select form-control"  autocomplete="off">
                                                                                    <option value=""></option>
                                                                                    <option value="บัณฑิตปี">บัณฑิตปี 4-6</option>
                                                                                    <option value="บัณฑิต (ปริญญาตรี)">บัณฑิต (ปริญญาตรี)</option>
                                                                                    <option value="มหาบัณฑิต (ปริญญาโท)">มหาบัณฑิต (ปริญญาโท)</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">

                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>ใบรับรองการศึกษา</label>
                                                                                <input name="image" id="file" type="file" class="form-control" accept="uploads_pdf/" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>คณะ</label>
                                                                                <!-- <select name="faculty_entry_degree" class="custom-select form-control" required="true" autocomplete="off">
                                                                                    <option value=""></option>
                                                                                </select> -->
                                                                                <input name="faculty_entry_degree" type="text" class="form-control" autocomplete="off">

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>วิชาเอก</label>
                                                                                <select name="major_entry_degree" class="custom-select form-control" autocomplete="off">
                                                                                    <option value=""></option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>สถาบัน</label>
                                                                                <select name="institute_entry_degree" class="custom-select form-control" autocomplete="off">
                                                                                    <option value=""></option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-2 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>เกรดเฉลี่ย</label>
                                                                                <input name="grade_entry_degree" type="text" class="form-control" autocomplete="off">

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label>ปีที่สำเร็จการศึกษา</label>
                                                                                <input name="year_acquired_entry_degree" type="text" class="form-control date-picker" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label></label>
                                                                            <div class="modal-footer justify-content-center">
                                                                                <button class="btn btn-primary" name="new_update" data-toggle="modal">บันทึก แก้ไขข้อมูล</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- education Tab End -->