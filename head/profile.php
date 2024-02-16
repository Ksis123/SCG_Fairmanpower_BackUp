<?php include('../head/include/header.php') ?>

<body>

    <?php include('../head/include/navbar.php') ?>
    <?php include('../head/include/sidebar.php') ?>

    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#profile" role="tab"><i class="fa-solid fa-address-card"></i> ข้อมูลพนักงานพื้นฐาน</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#employee_info" role="tab"><i class="fa-solid fa-user-tag"></i> ประวัติส่วนตัว</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#education" role="tab"><i class="fa-solid fa-user-tie"></i> ประวัติการศึกษา</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#manager" role="tab"><i class="fa-solid fa-user-tie"></i> ผู้จัดการ | Report-to</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        <!-- ข้อมูลพนักงานพื้นฐาน -->
                                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                            <?php include('../admin/profile/profile_info.php') ?>
                                        </div>

                                        <!-- ประวัติส่วนตัว -->
                                        <div class="tab-pane fade" id="employee_info" role="tabpanel">
                                            <?php include('../admin/profile/profile_employee_info.php') ?>
                                        </div>

                                        <!-- ประวัติการศึกษา -->
                                        <div class="tab-pane fade" id="education" role="tabpanel">
                                            <?php include('../admin/profile/profile_education.php') ?>
                                        </div>

                                        <!-- ผู้จัดการ | Report-to -->
                                        <div class="tab-pane fade" id="manager" role="tabpanel">
                                        <?php include('../admin/profile/profile_manager_report.php') ?>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
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