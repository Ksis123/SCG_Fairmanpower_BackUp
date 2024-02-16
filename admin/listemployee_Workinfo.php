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
                                <h3>ประวัติการทำงาน</h3>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="listemployee.php">รายการข้อมูลพนักงานทั้งหมด</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Create.php">ข้อมูลพนักงานเบื้องต้น</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Info.php">ประวัติส่วนตัว</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Education.php">ประวัติการศึกษา</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">ประวัติการทำงาน</li>
                                    <li class="breadcrumb-item"><a href="listemployee_Manager.php">ผู้จัดการ</a></li>
                                    <li class="breadcrumb-item"><a href="listemployee_Report_to.php">report-to</a></li>
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
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="pd-30 card-box height-100-p">
                                <div class="profile-setting">
                                    <div class="col-md-12">
                                        <h4 class="text-blue mb-20"><i class="fa-solid fa-user-tie"></i> ผู้จัดการ | Report-to</h4>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-30 pl-30">
                                    <div class="pd-20 card-box height-50-p">
                                        <div class="profile-photo">
                                            <img src="<?php echo (!empty($manger['em_img'])) ? '../admin/uploads_img/' . $manger['em_img'] : '../asset/img/admin.png'; ?>" alt="" class="avatar-photo">
                                        </div>
                                        <h5 class="text-center text-blue">
                                            <?php echo $manger["em_scg_id"]; ?>
                                            <b><br />
                                                <a class="text-blue"><?php echo $manger["em_pre"], ' ', $manger["em_fname"], ' ', $manger["em_lname"]  ?>
                                            </b>
                                        </h5>
                                        <div class="profile-info">
                                            <ul>
                                                <li class="pb-3">
                                                    <b class="text-blue" style="padding-right: 5px;">
                                                        <i class="fa-solid fa-circle-user fa-xl" style="color: #1FBAC0;"></i>
                                                        ตำแหน่ง :
                                                    </b>
                                                    <b style="padding: 5px" class='permission-<?php echo $manger["pm_id"]; ?>'>
                                                        <?php echo  $manger["pm_name"]; ?>
                                                    </b>
                                                </li>
                                                <li>
                                                    <b class="text-blue"><i class="fa-solid fa-envelope fa-xl" style="color: #1FBAC0;"></i> Email : </b><a class='text-primary'><?php echo  ' ' . $manger["em_email"]; ?></a>
                                                </li>
                                                <li>
                                                    <b class="text-blue"><i class="fa-solid fa-phone fa-xl" style="color: #1FBAC0;"></i> เบอร์โทร : </b>
                                                    <a class='text-primary'>
                                                        <?php
                                                        $phone_number = $manger["em_phone"];

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
                            </div>
                        </div>
                    </div>
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