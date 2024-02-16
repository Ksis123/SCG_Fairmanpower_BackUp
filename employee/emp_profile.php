<?php include('../employee/include/header.php') ?>

<body>

    <?php include('../employee/include/navbar.php') ?>
    <?php include('../employee/include/sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h3>โปรไฟล์ของคุณ</h3>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home.php">หน้าหลัก</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">โปรไฟล์ของคุณ</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">โปรไฟล์พนักงาน</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#setting" role="tab">ประวัติส่วนตัว</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- Timeline Tab start -->
                                        <div class="tab-pane fade show active" id="timeline" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-30 pl-30 mb-30">
                                                    <div class="pd-20 card-box height-100-p">
                                                        <div class="profile-photo">
                                                            <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                                                            <img src="<?php echo (!empty($row['employee_image'])) ? '../uploads_img/' . $row['employee_image'] : '../asset/img/employeeicon.png'; ?>" alt="" class="avatar-photo">
                                                            <form method="post" enctype="multipart/form-data">
                                                                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="weight-500 col-md-12 pd-5">
                                                                                <div class="form-group">
                                                                                    <div class="custom-file">
                                                                                        <input name="image" id="file" type="file" class="custom-file-input">
                                                                                        <label class="custom-file-label" for="file" id="selector">Choose file</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="submit" name="update_image" value="Update" class="btn btn-primary">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <h5 class="text-center h5 mb-0">
                                                        </h5>
                                                        <p class="text-center text-muted font-14">
                                                        </p>
                                                        <div class="profile-info">
                                                            <ul>
                                                                <li>
                                                                    <b class="text-blue"><i class="fa-solid fa-envelope" style="color: #1FBAC0;"></i> Email : </b><a class='text-primary'><?php echo  ' ' . $row["employee_email"]; ?></a>
                                                                </li>
                                                                <li>
                                                                    <b class="text-blue"><i class="fa-solid fa-phone" style="color: #1FBAC0;"></i> เบอร์โทร : </b><a class='text-primary'><?php echo  ' ' . $row["phone_number"]; ?></a>
                                                                </li>
                                                                <li>
                                                                    <b class="text-blue" style="padding-right: 5px;">
                                                                        <i class="fa-solid fa-user" style="color: #1FBAC0;"></i> บทบาท :
                                                                    </b>
                                                                    <b style="padding: 5px" class='permission-<?php echo $row["permissionID"]; ?>'><?php echo  $row["permission"]; ?></b>
                                                                </li>
                                                                <li>
                                                                    <b class="text-blue"><i class="fa-solid fa-location-dot" style="color: #1FBAC0;"></i> ที่อยู่ : </b>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Timeline Tab End -->
                                        <!-- Setting Tab start -->
                                        <div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
                                            <div class="profile-setting">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="profile-edit-list row">
                                                        <div class="col-md-12">
                                                            <h4 class="text-blue h5 mb-20">แก้ไขประวัติส่วนตัว</h4>
                                                        </div>

                                                        <div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>ชื่อ</label>
                                                                <input name="fname" class="form-control form-control-lg" type="text" required="true" autocomplete="off" value="<?php echo $fname; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>นามสกุล</label>
                                                                <input name="lastname" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $lname; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Email Address</label>
                                                                <input name="email" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $emp_email; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Phone Number</label>
                                                                <input name="phonenumber" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['Phonenumber']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Date Of Birth</label>
                                                                <input name="dob" class="form-control form-control-lg date-picker" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['Dob']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Gender</label>
                                                                <select name="gender" class="custom-select form-control" required="true" autocomplete="off">
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="weight-500 col-md-6">

                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <input name="address" class="form-control form-control-lg" type="text" placeholder="" required="true" autocomplete="off" value="<?php echo $row['Address']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Department</label>
                                                                <select name="department" class="custom-select form-control" required="true" autocomplete="off">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label></label>
                                                                <div class="modal-footer justify-content-center">
                                                                    <button class="btn btn-primary" name="new_update" id="new_update" data-toggle="modal">Save & &nbsp;Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Setting Tab End -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('../employee/include/footer.php') ?>
        </div>
    </div>
    <!-- js -->
    <?php include('../employee/include/scripts.php') ?>
</body>

</html>