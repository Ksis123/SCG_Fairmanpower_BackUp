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
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">แบบฟอร์มข้อมูลพนักงานเบื้องต้น</h4>
                            <p class="mb-20"></p>
                        </div>
                    </div>
                    <div class="wizard-content">
                        <form method="post" id="employee_insert">
                            <section>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>รหัสบัตรประชาชนพนักงาน <b class="text-danger"><i class="fa-solid fa-circle-exclamation"></i> </b></label>
                                            <input name="card_id" placeholder="1949999999991" type="number" maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">รหัสส่วนบุคคล (Personal Number) <h5 class="text-danger"> * </h5> </label>
                                            <input name="person_id" placeholder="1002479" type="number" maxlength="7" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">รหัสประจำตัวบุคคล <h5 class="text-danger"> * </h5> </label>
                                            <input name="personnel_number" placeholder="1002247" type="number" maxlength="7" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">รหัสพนักงาน (SCG Employee) <h5 class="text-danger"> * </h5> </label>
                                            <input name="scg_employee_id" placeholder="0150-000000" type="text" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>คำนำหน้าชื่อ (TH)</label>
                                            <select name="prefix_thai" class="custom-select form-control" autocomplete="off">
                                                <option value="" disabled selected>ระบุคำนำหน้าชื่อ</option>
                                                <option value="นาย">นาย</option>
                                                <option value="นาง">นาง</option>
                                                <option value="นางสาว">นางสาว</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">ชื่อจริง (TH) <h5 class="text-danger"> * </h5></label>
                                            <input name="firstname_thai" type="text" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">นามสกุล (TH) <h5 class="text-danger"> * </h5></label>
                                            <input name="lastname_thai" type="text" class="form-control wizard-required" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อเล่น (TH) </label>
                                            <input name="nickname_thai" type="text" class="form-control wizard-required" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันเกิดพนักงาน</label>
                                            <input name="birth_date" type="date" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>คำนำหน้าชื่อ (ENG)</label>
                                            <select name="prefix_eng" class="custom-select form-control" autocomplete="off">
                                                <option disabled selected>ระบุคำนำหน้าชื่อ</option>
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Miss.">Miss.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อจริง (ENG)</label>
                                            <input name="firstname_eng" type="text" class="form-control wizard-required" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>นามสกุล (ENG)</label>
                                            <input name="lastname_eng" type="text" class="form-control wizard-required" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ชื่อเล่น (ENG)</label>
                                            <input name="nickname_eng" type="text" class="form-control wizard-required" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group ">
                                            <label class="text-left">เพศสภาพ (Sex)</label>
                                            <div class="text-left flex col-md-4 col-2" style="justify-content: space-between;">
                                                <input type="radio" name="gender" value="ชาย">
                                                <i class="fa-solid fa-mars fa-lg mt-2 ml-2" style="color: #3fa7f2"></i><a style="color: #8f8f8f">ชาย</a><br>
                                                <input class="ml-2" type="radio" name="gender" value="หญิง">
                                                <i class="fa-solid fa-venus fa-lg mt-2 ml-2" style="color: #fc5ba1"></i><a style="color: #8f8f8f">หญิง</a><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-1 col-sm-12 col-4">
                                        <div class="form-group">
                                            <label>กรุ๊ปเลือด</label>
                                            <select name="blood_type" class="custom-select form-control" autocomplete="off">
                                                <option disabled selected></option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-8">
                                        <div class="form-group">
                                            <label>สถานะความสัมพันธ์</label>
                                            <select name="marital_status" class="custom-select form-control" autocomplete="off">
                                                <option value="" disabled selected>ระบุสถานะความสัมพันธ์</option>
                                                <option value="โสด">โสด</option>
                                                <option value="มีแฟนแล้ว">มีแฟนแล้ว</option>
                                                <option value="แต่งงานแล้ว">แต่งงานแล้ว</option>
                                                <option value="หม้าย">หม้าย</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-4">
                                        <div class="form-group">
                                            <label>สัญชาติ</label>
                                            <select name="nation" class="custom-select form-control" autocomplete="off">
                                                <option value="" disabled selected>ระบุสัญชาติ</option>
                                                <option value="ไทย">ไทย</option>
                                                <option value="ต่างชาติ">ต่างชาติ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-4">
                                        <div class="form-group">
                                            <label>เชื้อชาติ</label>
                                            <select name="ethnicity" class="custom-select form-control" autocomplete="off">
                                                <option value="" disabled selected>ระบุเชื้อชาติ</option>
                                                <option value="ไทย">ไทย</option>
                                                <option value="ต่างชาติ">ต่างชาติ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-4">
                                        <div class="form-group">
                                            <label>ศาสนา</label>
                                            <select name="religion" class="custom-select form-control" autocomplete="off">
                                                <option value="" disabled selected>ระบุศาสนา</option>
                                                <option value="พุทธ">พุทธ</option>
                                                <option value="คริสต์">คริสต์</option>
                                                <option value="อิสลาม">อิสลาม </option>
                                                <option value="ฮินดู">ฮินดู</option>
                                                <option value="ไม่นับถือ">ไม่นับถือ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>เบอร์โทรพนักงาน</label>
                                            <input name="phone_number" type="number" placeholder="0650000000" class="form-control" autocomplete="off" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email พนักงาน</label>
                                            <input name="employee_email" placeholder="example@scg.com" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">บทบาทสิทธิ์การเข้าถึง <h5 class="text-danger"> * </h5></label>
                                            <select name="permission_id" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="" disabled selected>ระบุสิทธิ์การเข้าถึง</option>
                                                <?php
                                                $sqlDropdown_cost = "SELECT * FROM permission";
                                                $resultDropdown_cost = sqlsrv_query($conn, $sqlDropdown_cost);

                                                if ($resultDropdown_cost === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown_cost) {
                                                    while ($row = sqlsrv_fetch_array($resultDropdown_cost, SQLSRV_FETCH_ASSOC)) {
                                                        echo "<option value='"  . $row['permission_id'] . "'>" . $row['permission_id'] . ' : ' . $row['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">ประเภทพนักงาน <h5 class="text-danger"> * </h5></label>
                                            <select name="contract_type_id" class="custom-select form-control" required="true" autocomplete="off">
                                                <option value="" disabled selected>ระบุประเภทพนักงาน</option>
                                                <?php
                                                $sqlDropdown_type = "SELECT * FROM contract_type";
                                                $resultDropdown_type = sqlsrv_query($conn, $sqlDropdown_type);

                                                if ($resultDropdown_type === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown_type) {
                                                    while ($row = sqlsrv_fetch_array($resultDropdown_type, SQLSRV_FETCH_ASSOC)) {
                                                        echo "<option value='"  . $row['contract_type_id'] . "'>" . $row['name_thai'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลขประกันสังคม</label>
                                            <input name="social_security_id" type="number" placeholder=" ************* " maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลขประจำตัวผู้เสียภาษี</label>
                                            <input name="tax_id" type="number" placeholder=" ************* " maxlength="13" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">หมายเลข Cost-Center Organization<h5 class="text-danger"> * </h5></label>
                                            <select name="cost_center_organization_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                <option value="" disabled selected>ระบุหมายเลข Cost-Center</option>
                                                <?php

                                                $sql = "SELECT
                                                cc.cost_center_id AS CostCenterID,
                                                cc.cost_center_code AS CostCenterORG,
                                                MAX ( CASE WHEN p.permission_id = 2 THEN CONCAT (  e.prefix_thai, e.firstname_thai, ' ', e.lastname_thai ) ELSE NULL END ) AS Manager_Name,
                                                MAX ( CASE WHEN p.permission_id = 2 THEN e.card_id ELSE NULL END ) AS CardID_Manager,
                                                s.name_eng AS SECTION,
                                                d.name_eng AS Department 
                                                FROM
                                                cost_center cc
                                                INNER JOIN SECTION s ON cc.section_id = s.section_id
                                                INNER JOIN department d ON s.department_id = d.department_id
                                                LEFT JOIN employee e ON cc.cost_center_id = e.cost_center_organization_id
                                                LEFT JOIN permission p ON e.permission_id = p.permission_id 
                                                GROUP BY
                                                cc.cost_center_id,
                                                cc.cost_center_code,
                                                s.name_eng,
                                                d.name_eng";

                                                $resultDropdown_cost = sqlsrv_query($conn, $sql);

                                                if ($resultDropdown_cost === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown_cost) {
                                                    while ($row = sqlsrv_fetch_array($resultDropdown_cost, SQLSRV_FETCH_ASSOC)) {
                                                        echo "<option value='"  . $row['CostCenterID'] . "'>" . $row['CostCenterORG'] . ' : ' . $row['Department'] . ' | ' . $row['Manager_Name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ผู้จัดการ</label>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">หมายเลข Cost-Center Payment<h5 class="text-danger"> * </h5></label>
                                            <select name="cost_center_payment_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off" id="exampleSelect1">
                                                <option value="" disabled selected>ระบุหมายเลข Cost-Center</option>
                                                <?php
                                                $sql = "SELECT
                                                cc.cost_center_id AS CostCenterID,
                                                cc.cost_center_code AS CostCenterORG,
                                                MAX ( CASE WHEN p.permission_id = 2 THEN CONCAT (  e.prefix_thai, e.firstname_thai, ' ', e.lastname_thai ) ELSE NULL END ) AS Manager_Name,
                                                MAX ( CASE WHEN p.permission_id = 2 THEN e.card_id ELSE NULL END ) AS CardID_Manager,
                                                s.name_eng AS SECTION,
                                                d.name_eng AS Department 
                                                FROM
                                                cost_center cc
                                                INNER JOIN SECTION s ON cc.section_id = s.section_id
                                                INNER JOIN department d ON s.department_id = d.department_id
                                                LEFT JOIN employee e ON cc.cost_center_id = e.cost_center_organization_id
                                                LEFT JOIN permission p ON e.permission_id = p.permission_id 
                                                GROUP BY
                                                cc.cost_center_id,
                                                cc.cost_center_code,
                                                s.name_eng,
                                                d.name_eng";

                                                $resultDropdown_cost = sqlsrv_query($conn, $sql);

                                                if ($resultDropdown_cost === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown_cost) {
                                                    while ($row = sqlsrv_fetch_array($resultDropdown_cost, SQLSRV_FETCH_ASSOC)) {
                                                        echo "<option value='"  . $row['CostCenterID'] . "'>" . $row['CostCenterORG'] . ' : ' . $row['Department'] . ' | ' . $row['Manager_Name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>Report - to</label>
                                            <input type="text" class="form-control" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>สถานะการทำงาน</label>
                                            <select name="employment_status" class="custom-select form-control" autocomplete="off">
                                                <option value="" disabled selected>ระบุสถานะการทำงาน</option>
                                                <option value="ACTIVE">ทำงาน</option>
                                                <option value="DEACTIVE">พักงาน / ลางาน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">วันที่เริ่มทดลองงาน <h5 class="text-danger"> * </h5></label>
                                            <input name="probation_date_start" type="date" class="form-control" required="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label class="flex">ระยะเวลาทดลองงาน <h5 class="text-danger"> * </h5></label>
                                            <input name="probation_period" placeholder="60 (วัน)" type="number" class="form-control" required="true" autocomplete="off" maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control wizard-required" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันที่เริ่มงาน SCG </label>
                                            <input name="scg_hiring_date" type="date" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันที่เกษียณ </label>
                                            <input name="retired_date" type="date" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุดการจ้าง</label>
                                            <input name="termination_date" type="date" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>ประเภทพนักงาน</label>
                                            <select name="employee_type" class="custom-select form-control" autocomplete="off">
                                                <option value="" disabled selected>ระบุประเภทพนักงาน</option>
                                                <option value="พนักงานปกติ">พนักงานปกติ</option>
                                                <option value="พนักงานกะ">พนักงานกะ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>work_format_code</label>
                                            <select name="work_format_code" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off" id="exampleSelect1">
                                                <option value="" disabled selected>ระบุรหัสสำหรับการลา</option>

                                                <?php
                                                $sqlDropdown = "SELECT * FROM work_format";

                                                $resultDropdown = sqlsrv_query($conn, $sqlDropdown);

                                                if ($resultDropdown === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                }
                                                if ($resultDropdown) {
                                                    while ($work_format = sqlsrv_fetch_array($resultDropdown, SQLSRV_FETCH_ASSOC)) {
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
                                                <option value="" disabled selected>ระบุธนาคาร</option>
                                                <option value="KBANK">KBANK กสิกรไทย</option>
                                                <option value="BBL">BBL กรุงเทพ</option>
                                                <option value="KTB">KTB กรุงไทย</option>
                                                <option value="BAY">BAY กรุงศรี</option>
                                                <option value="TMB">TMB ทหารไทยธนชาต</option>
                                                <option value="SCB">SCB ไทยพาณิชย์</option>
                                                <option value="GSB">GSB ออมสิน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>สาขาธนาคาร</label>
                                            <input name="bank_branch_name" placeholder="ระบุสาขาธนาคาร" type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>เลขบัญชีธนาคาร</label>
                                            <input name="back_account_id" placeholder="ระบุหมายเลขบัญชี" type="number" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" autocomplete="off" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-group">
                                            <label>วันทำงาน / สัปดาห์</label>
                                            <select name="work_per_day" class="custom-select form-control" autocomplete="off">
                                                <option value="" disabled selected> ระบุวันทำงาน / สัปดาห์ </option>
                                                <option value="5">5 วัน ต่อ สัปดาห์</option>
                                                <option value="6">6 วัน ต่อ สัปดาห์</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label>ประสบการณ์ทำงานภายนอก (จำนวนปี)</label>
                                            <input name="outside_equivalent_year" placeholder="ระบุจำนวนปีการทำงาน" type="number" class="form-control" autocomplete="off" oninput="validateInput_y(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>ประสบการณ์ทำงานภายนอก (จำนวนเดือน)</label>
                                            <input name="outside_equivalent_month" placeholder="ระบุจำนวนเดือนการทำงาน" type="number" class="form-control" autocomplete="off" min="0" max="12" oninput="validateInput_m(this)">
                                        </div>
                                    </div>

                                </div>
                                <hr />

                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="pt-10 pb-20">
                                            <a class="btn-back" href='listemployee_Manager.php'><i class="fa-solid fa-circle-left fa-xl"> </i> ย้อนกลับ </a>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-3">
                                        <div class="form-group">
                                            <div class="text-right">
                                                <button class="btn btn-primary" onclick="insert_empeForm(event);">บันทึก ข้อมูลพนักงาน</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </section>
                        </form>
                        <!-- script -->
                        <script>
                            function insert_empeForm(event) {
                                event.preventDefault();
                                console.log("INSERT Form send!");
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "green-swal",
                                        cancelButton: "delete-swal"
                                    },
                                    buttonsStyling: false
                                });

                                swalWithBootstrapButtons.fire({
                                    title: 'ยืนยันการ บันทึกข้อมูลพนักงานใหม่',
                                    text: 'คุณต้องการบันทึกข้อมูลพนักงานท่านนี้ ใช่หรือไม่ ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formData = $('#employee_insert').serialize();
                                        console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                        $.ajax({
                                            type: "POST",
                                            url: "Back_End_ajax/Employee/listemployee_Insert.php",
                                            data: formData,
                                            dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                            success: function(response) {
                                                console.log(response);

                                                if (response.status === 'success') {
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'success',
                                                        title: 'บันทึกข้อมูลพนักงานใหม่ สำเร็จ!',
                                                        text: 'ข้อมูลพนักงานถูกบันทึกเรียบร้อย',
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