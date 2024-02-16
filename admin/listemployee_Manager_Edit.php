<?php
// Include your database connection file here
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// ตรวจสอบว่ามีการส่ง manager_id  m_id มาจากหน้า listemployee หรือไม่
if (isset($_GET['m_id'])) {
    $manager_id = $_GET['m_id'];

    // ตรวจสอบว่ามีข้อมูลพนักงานที่ต้องการแก้ไขหรือไม่
    $query = "SELECT * FROM manager WHERE manager_id = ?";
    $params = array($manager_id);

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        $manager = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // Now, let's fetch data from the "report_to" table based on the "card_id"
        $reportToQuery = "SELECT * FROM report_to WHERE card_id = ?";
        $reportToParams = array($manager['card_id']); // Use the card_id from the manager

        $reportToStmt = sqlsrv_query($conn, $reportToQuery, $reportToParams);

        if ($reportToStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_has_rows($reportToStmt)) {
            $report_to = sqlsrv_fetch_array($reportToStmt, SQLSRV_FETCH_ASSOC);
        } else {
            die("ไม่พบข้อมูลพนักงานที่ต้องการแก้ไข report_to");
        }
    } else {
        die("ไม่พบข้อมูลพนักงานที่ต้องการแก้ไข");
    }
} else {
    die("ไม่ได้รับข้อมูล manager_id");
}
?>

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
                                <h3>ข้อมูล ผู้จัดการของพนักงาน</h3>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation" class="pt-3">
                                <ol class="breadcrumb">
                                    <a class="btn-back" href='listemployee_Manager.php'>
                                        <i class="fa-solid fa-circle-left fa-xl"></i> |
                                    </a>
                                    <li class="breadcrumb-item"><a href="listemployee.php"><i class="fa-solid fa-people-group"></i> พนักงานทั้งหมด</a></li>
                                    <li class="breadcrumb-item"><a><i class="fa-solid fa-user-plus"></i> ข้อมูลพนักงานเบื้องต้น</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-user-tie"></i> ผู้จัดการ - Report-to</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="wizard-content">
                        <div class="col-md-6 col-sm-6 col-6">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue"> แบบฟอร์มสำหรับเปลี่ยน ผู้จัดการ <i class="fa-solid fa-pen-nib"></i></h4>
                                    <p class="mb-20"></p>
                                </div>
                            </div>
                        </div>

                        <form method="post" id="update_manager">
                            <section>
                                <input type="hidden" name="manager_id" value="<?php echo $manager['manager_id']; ?>">

                                <div class="row">

                                    <div class="col-lg-3 col-mb-3 col-sm-4 pt-2">
                                        <b style="color: #7d7d7d"><i class="fa-solid fa-clock"></i> ถูกแก้ไขล่าสุดเมื่อวันที่</b>
                                        <?php
                                        // กำหนดโซนเวลาของประเทศไทย
                                        date_default_timezone_set('Asia/Bangkok');

                                        // ตรวจสอบว่า $manager['edit_time'] ไม่ใช่ NULL และไม่ว่างเปล่า
                                        if (!is_null($manager['edit_time']) && $manager['edit_time'] !== '') {
                                            $editTime = $manager['edit_time'];
                                        } else {
                                            $editTime = new DateTime();
                                        }

                                        // แปลงวัตถุ DateTime เป็นรูปแบบที่รองรับใน SQL Server (Y-m-d\TH:i)
                                        $editTimeFormatted = $editTime->format('Y-m-d\TH:i:s');
                                        ?>
                                        <input type="datetime-local" class="form-control" value="<?php echo $editTimeFormatted; ?>" readonly>
                                    </div>

                                    <div class="col-lg-3 col-mb-3 col-sm-4 pt-2">
                                        <b style="color: #7d7d7d">ผู้จัดการ คนก่อน</b>
                                        <?php
                                        // ตรวจสอบว่า $manager['old_manager_name'] ไม่ใช่ NULL
                                        if ($manager['old_manager_name'] !== null) {
                                            $oldManagerName = $manager['old_manager_name'];
                                            echo "<select name='old_manager_name' class='form-control selectpicker'>";
                                            // Query เพื่อดึงข้อมูลจากตาราง employee โดยเลือกเฉพาะ record ที่มี card_id เท่ากับ $editManagerCardId
                                            $sql = "SELECT * FROM employee WHERE card_id = ?";
                                            $params = array($oldManagerName);
                                            $result = sqlsrv_query($conn, $sql, $params);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='{$row['card_id']}' selected>{$row['prefix_thai']}{$row['firstname_thai']} {$row['lastname_thai']}</option>";
                                                }
                                            }
                                            echo "</select>";
                                        } else {
                                            $ManagerName = $manager['manager_card_id'];
                                            echo "<select name='old_manager_name' class='form-control selectpicker'>";
                                            // Query เพื่อดึงข้อมูลจากตาราง employee โดยเลือกเฉพาะ record ที่มี card_id เท่ากับ $editManagerCardId
                                            $sql = "SELECT * FROM employee WHERE card_id = ?";
                                            $params = array($ManagerName);
                                            $result = sqlsrv_query($conn, $sql, $params);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='{$row['card_id']}' selected>{$row['prefix_thai']}{$row['firstname_thai']} {$row['lastname_thai']}</option>";
                                                }
                                            }
                                            echo "</select>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-3 col-mb-3 col-sm-4 pt-2 pb-3">
                                        <b style="color: #7d7d7d">ผู้จัดการ คนปัจจุบัน</b>
                                        <?php
                                        // ตรวจสอบว่า $manager['edit_manager_card_id'] เป็น NULL
                                        $editManagerCardId = $manager['manager_card_id'];

                                        if ($manager['edit_manager_card_id'] === null) {
                                            echo "<select name='manager_card_id' class='form-control selectpicker'>";
                                            // Query เพื่อดึงข้อมูลจากตาราง employee โดยเลือกเฉพาะ record ที่มี card_id เท่ากับ $editManagerCardId
                                            $sql = "SELECT * FROM employee WHERE card_id = ?";
                                            $params = array($editManagerCardId);
                                            $result = sqlsrv_query($conn, $sql, $params);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='{$row['card_id']}' selected>{$row['prefix_thai']}{$row['firstname_thai']} {$row['lastname_thai']}</option>";
                                                }
                                            }
                                            echo "</select>";
                                        } else {
                                            // ถ้า $manager['edit_manager_card_id'] ไม่เท่ากับ null ให้แสดงค่าของมัน
                                            echo "<select name='manager_card_id' class='form-control selectpicker'>";
                                            // Query เพื่อดึงข้อมูลจากตาราง employee โดยเลือกเฉพาะ record ที่มี card_id เท่ากับ $editManagerCardId
                                            $sql = "SELECT * FROM employee WHERE card_id = ?";
                                            $params = array($editManagerCardId);
                                            $result = sqlsrv_query($conn, $sql, $params);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='{$row['card_id']}' selected>{$row['prefix_thai']}{$row['firstname_thai']} {$row['lastname_thai']}</option>";
                                                }
                                            }
                                            echo "</select>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-3 col-mb-3 col-sm-4 pt-2">
                                        <b style="color: #7d7d7d"><i class="fa-solid fa-clock"></i> วันที่และเวลา ณ ปัจจุบัน</b>
                                        <?php
                                        // กำหนดโซนเวลาของประเทศไทย
                                        date_default_timezone_set('Asia/Bangkok');

                                        // สร้างวัตถุ DateTime ณ ปัจจุบัน
                                        $m_editTime = new DateTime();

                                        // แปลงวัตถุ DateTime เป็นรูปแบบที่รองรับใน SQL Server (Y-m-d\TH:i:s)
                                        $m_editTimeFormatted = $m_editTime->format('Y-m-d\TH:i:s');
                                        ?>
                                        <input name="edit_time" type="datetime-local" class="form-control" value="<?php echo $m_editTimeFormatted; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-40">
                                            <b class="card-header"><i class="fa-solid fa-user-gear fa-xl" style="color: #7d7d7d"></i> พนักงานใต้บังคับบัญชา </b>
                                            <div class="card-body">
                                                <select name="card_id" class="selectpicker form-control text-disable">
                                                    <?php

                                                    $editCardId = $manager['card_id'];

                                                    $sql = "SELECT * FROM employee WHERE card_id = ?";
                                                    $params = array($editCardId);
                                                    $result = sqlsrv_query($conn, $sql, $params);

                                                    if ($result === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    if ($result) {
                                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['card_id'] . "'selected>" . $row['scg_employee_id'] . ' : ' . $row['prefix_thai'] . '' . $row['firstname_thai'] . ' ' . $row['lastname_thai'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-40">
                                            <b class="card-header"> <i class="fa-solid fa-user-tie fa-xl" style="color: #7d7d7d"></i> ผู้จัดการ Organization </b>
                                            <div class="card-body">
                                                <select name="edit_manager_card_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected>เลือกผู้จัดการ</option>
                                                    <?php
                                                    $sql = "SELECT 
                                                    em.card_id as em_id,                                        
                                                    em.prefix_thai as em_pre,                                        
                                                    em.firstname_thai as em_fname,
                                                    em.lastname_thai as em_lname,
                                                    em.scg_employee_id as em_scg_id,
                                                    em.employee_image as em_img, 
                                                    em.employee_email as em_email,
                                                    em.cost_center_organization_id as em_org,
                                                    cos_em.cost_center_code as cos_org,
                                                    sm.name_thai as m_section, 
                                                    dm.name_thai as m_department 
                                                    FROM employee em
                                                    INNER JOIN cost_center cos_em ON cos_em.cost_center_id = em.cost_center_organization_id
                                                    INNER JOIN section sm ON sm.section_id = cos_em.section_id
                                                    INNER JOIN department dm ON dm.department_id = sm.department_id
                                                    WHERE permission_id = 2";

                                                    $result = sqlsrv_query($conn, $sql);

                                                    if ($result === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    if ($result) {
                                                        while ($row_m = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                            $selected = ($row_m['em_id'] == $manager["manager_card_id"]) ? 'selected' : '';
                                                            echo "<option value='"  . $row_m['em_id'] . "'$selected>" . $row_m['em_pre'] . '' . $row_m['em_fname'] . ' ' . $row_m['em_lname'] . ' : ' . $row_m['cos_org'] . ' ' . $row_m['m_department'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-mb-6 pt-2">
                                        <b style="color: #7d7d7d">* เหตุผลของการเปลี่ยน</b>
                                        <?php
                                        // ตรวจสอบว่า $manager['edit_detail'] เป็น NULL หรือเป็นค่าว่าง
                                        if ($manager['edit_detail'] === null || trim($manager['edit_detail']) === '') {
                                            $defaultEditDetail = "พนักงานท่านนี้ยังไม่ถูกเปลี่ยนผู้จัดการ";
                                        } else {
                                            $defaultEditDetail = $manager['edit_detail'];
                                        }
                                        ?>
                                        <textarea type="text" class="form-control" name="edit_detail" required="true" autocomplete="on"><?php echo $defaultEditDetail; ?></textarea>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-3 pt-5 text-center">
                                        <div>
                                            <button class="btn btn-primary" onclick="update_mangerForm(event);">เปลี่ยน ผู้จัดการ</button>
                                        </div>
                                    </div>
                                </div>

                            </section>
                        </form>
                        <!-- script -->
                        <script>
                            function update_mangerForm(event) {
                                event.preventDefault();
                                console.log("UPDATE Manager Form send!");
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "green-swal",
                                        cancelButton: "delete-swal"
                                    },
                                    buttonsStyling: false
                                });

                                swalWithBootstrapButtons.fire({
                                    title: 'ยืนยันการเปลี่ยนมาเป็น ผู้จัดการท่านนี้',
                                    text: 'พนักงานจะถูกเปลี่ยนผู้จัดการใหม่ มีผลทันที ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formData = $('#update_manager').serialize();

                                        $.ajax({
                                            type: "POST",
                                            url: "Back_End_ajax/Manager/Update_manager.php",
                                            data: formData,
                                            dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                            success: function(response) {
                                                console.log(response);
                                                if (response.status === 'success') {
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'success',
                                                        title: 'แก้ไข ผู้จัดการ ใหม่ให้พนักงานท่านนี้ สำเร็จ!',
                                                        text: 'ข้อมูลรายชื่อผู้จัดการถูกแก้ไขเรียบร้อย',
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
                <div class="pd-20 card-box mb-30">
                    <div class="wizard-content">
                        <div class="col-md-6 col-sm-6 col-6">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue "> แบบฟอร์มสำหรับเปลี่ยน Report-to <i class="fa-solid fa-pen-nib"></i></h4>
                                    <p class="mb-20"></p>
                                </div>
                            </div>
                        </div>
                        <form method="post" id="update_report">
                            <section>
                                <input type="hidden" name="report_to_id" value="<?php echo $report_to['report_to_id']; ?>">

                                <div class="row">

                                    <div class="col-lg-3 col-mb-3 col-sm-4 pt-2">
                                        <b style="color: #7d7d7d"><i class="fa-solid fa-clock"></i> ถูกแก้ไขล่าสุดเมื่อวันที่</b>
                                        <?php
                                        // กำหนดโซนเวลาของประเทศไทย
                                        date_default_timezone_set('Asia/Bangkok');

                                        // ตรวจสอบว่า $report_to['edit_time'] ไม่ใช่ NULL และไม่ว่างเปล่า
                                        if (!is_null($report_to['edit_time']) && $report_to['edit_time'] !== '') {
                                            $editTime = $report_to['edit_time'];
                                        } else {
                                            $editTime = new DateTime();
                                        }

                                        // แปลงวัตถุ DateTime เป็นรูปแบบที่รองรับใน SQL Server (Y-m-d\TH:i)
                                        $r_editTimeFormatted = $editTime->format('Y-m-d\TH:i:s');
                                        ?>
                                        <input type="datetime-local" class="form-control" value="<?php echo $r_editTimeFormatted; ?>" readonly>
                                    </div>

                                    <div class="col-lg-3 col-mb-3 col-sm-4 pt-2">
                                        <b style="color: #7d7d7d">Report-to คนก่อน</b>
                                        <?php
                                        // ตรวจสอบว่า $report_to['old_report_to_card_id'] ไม่ใช่ NULL
                                        if ($report_to['old_report_to_name'] !== null) {
                                            $oldreport_to = $report_to['old_report_to_name'];
                                            echo "<select name='old_report_to_name' class='form-control selectpicker'>";

                                            // Query เพื่อดึงข้อมูลจากตาราง employee โดยเลือกเฉพาะ record ที่มี card_id เท่ากับ $editManagerCardId
                                            $sql = "SELECT * FROM employee WHERE card_id = ?";
                                            $params = array($oldreport_to);
                                            $result = sqlsrv_query($conn, $sql, $params);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='{$row['card_id']}' selected>{$row['prefix_thai']}{$row['firstname_thai']} {$row['lastname_thai']}</option>";
                                                }
                                            }
                                            echo "</select>";
                                        } else {
                                            $oldreport_to = $report_to['report_to_card_id'];
                                            echo "<select name='old_report_to_name' class='form-control selectpicker'>";
                                            // Query เพื่อดึงข้อมูลจากตาราง employee โดยเลือกเฉพาะ record ที่มี card_id เท่ากับ $editManagerCardId
                                            $sql = "SELECT * FROM employee WHERE card_id = ?";
                                            $params = array($oldreport_to);
                                            $result = sqlsrv_query($conn, $sql, $params);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='{$row['card_id']}' selected>{$row['prefix_thai']}{$row['firstname_thai']} {$row['lastname_thai']}</option>";
                                                }
                                            }
                                            echo "</select>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-3 col-mb-3 col-sm-4 pt-2 pb-3">
                                        <b style="color: #7d7d7d">Report-to คนปัจจุบัน</b>
                                        <?php
                                        // ตรวจสอบว่า $report_to['report_to_card_id'] เป็น NULL
                                        $editreport_to = $report_to['report_to_card_id'];

                                        if ($report_to['report_to_card_id'] === null) {
                                            echo "<select name='report_to_card_id' class='form-control selectpicker'>";
                                            // Query เพื่อดึงข้อมูลจากตาราง employee โดยเลือกเฉพาะ record ที่มี card_id เท่ากับ $editreport_to
                                            $sql = "SELECT * FROM employee WHERE card_id = ?";
                                            $params = array($editreport_to);
                                            $result = sqlsrv_query($conn, $sql, $params);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='{$row['card_id']}' selected>{$row['prefix_thai']}{$row['firstname_thai']} {$row['lastname_thai']}</option>";
                                                }
                                            }
                                            echo "</select>";
                                        } else {
                                            // ถ้า $report_to['report_to_card_id'] ไม่เท่ากับ null ให้แสดงค่าของมัน
                                            echo "<select name='report_to_card_id' class='form-control selectpicker'>";
                                            // Query เพื่อดึงข้อมูลจากตาราง employee โดยเลือกเฉพาะ record ที่มี card_id เท่ากับ $editreport_to
                                            $sql = "SELECT * FROM employee WHERE card_id = ?";
                                            $params = array($editreport_to);
                                            $result = sqlsrv_query($conn, $sql, $params);
                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            if ($result) {
                                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo "<option value='{$row['card_id']}' selected>{$row['prefix_thai']}{$row['firstname_thai']} {$row['lastname_thai']}</option>";
                                                }
                                            }
                                            echo "</select>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-3 col-mb-3 col-sm-4 pt-2">
                                        <b style="color: #7d7d7d"><i class="fa-solid fa-clock"></i> วันที่และเวลา ณ ปัจจุบัน</b>
                                        <?php
                                        // กำหนดโซนเวลาของประเทศไทย
                                        date_default_timezone_set('Asia/Bangkok');

                                        // สร้างวัตถุ DateTime ณ ปัจจุบัน
                                        $editTime = new DateTime();

                                        // แปลงวัตถุ DateTime เป็นรูปแบบที่รองรับใน SQL Server (Y-m-d\TH:i:s)
                                        $editTimeFormatted = $editTime->format('Y-m-d\TH:i:s');
                                        ?>
                                        <input name="edit_time" type="datetime-local" class="form-control" value="<?php echo $editTimeFormatted; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-40">
                                            <b class="card-header"><i class="fa-solid fa-user-gear fa-xl" style="color: #7d7d7d"></i> พนักงานใต้บังคับบัญชา </b>
                                            <div class="card-body">
                                                <select name="r_card_id" class="selectpicker form-control text-disable">
                                                    <?php

                                                    $r_editCardId = $report_to['card_id'];

                                                    $sql = "SELECT * FROM employee WHERE card_id = ?";
                                                    $params = array($r_editCardId);
                                                    $result = sqlsrv_query($conn, $sql, $params);

                                                    if ($result === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    if ($result) {
                                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['card_id'] . "'selected>" . $row['scg_employee_id'] . ' : ' . $row['prefix_thai'] . '' . $row['firstname_thai'] . ' ' . $row['lastname_thai'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ml-auto">
                                        <div class="card h-40">
                                            <b class="card-header"> <i class="fa-solid fa-user-tie fa-xl" style="color: #7d7d7d"></i> Report-to Organization </b>
                                            <div class="card-body">
                                                <select name="edit_report_to_card_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected>เลือก Report-to</option>
                                                    <?php
                                                    $sql = "SELECT 
                                                    em.card_id as em_id,                                        
                                                    em.prefix_thai as em_pre,                                        
                                                    em.firstname_thai as em_fname,
                                                    em.lastname_thai as em_lname,
                                                    em.scg_employee_id as em_scg_id,
                                                    em.employee_image as em_img, 
                                                    em.employee_email as em_email,
                                                    em.cost_center_organization_id as em_org,
                                                    cos_em.cost_center_code as cos_org,
                                                    sm.name_thai as m_section, 
                                                    dm.name_thai as m_department 
                                                    FROM employee em
                                                    INNER JOIN cost_center cos_em ON cos_em.cost_center_id = em.cost_center_organization_id
                                                    INNER JOIN section sm ON sm.section_id = cos_em.section_id
                                                    INNER JOIN department dm ON dm.department_id = sm.department_id
                                                    WHERE permission_id = 2";

                                                    $result = sqlsrv_query($conn, $sql);

                                                    if ($result === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    if ($result) {
                                                        while ($row_r = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                            $selected = ($row_r['em_id'] == $report_to["report_to_card_id"]) ? 'selected' : '';
                                                            echo "<option value='"  . $row_r['em_id'] . "'$selected>" . $row_r['em_pre'] . '' . $row_r['em_fname'] . ' ' . $row_r['em_lname'] . ' : ' . $row_r['cos_org'] . ' ' . $row_r['m_department'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-mb-6 pt-2">
                                        <b style="color: #7d7d7d">* เหตุผลของการเปลี่ยน</b>
                                        <?php
                                        // ตรวจสอบว่า $report_to['edit_detail'] เป็น NULL หรือเป็นค่าว่าง
                                        if ($report_to['edit_detail'] === null || trim($report_to['edit_detail']) === '') {
                                            $r_defaultEditDetail = "พนักงานท่านนี้ยังไม่ถูกเปลี่ยน Report-to";
                                        } else {
                                            $r_defaultEditDetail = $report_to['edit_detail'];
                                        }
                                        ?>
                                        <textarea type="text" class="form-control" name="edit_detail" required="true" autocomplete="on"><?php echo $r_defaultEditDetail; ?></textarea>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-3 pt-5 text-center">
                                        <div>
                                            <button class="btn btn-primary" onclick="update_reportForm(event);">เปลี่ยน Report-to</button>
                                        </div>
                                    </div>
                                </div>


                            </section>
                        </form>
                        <!-- script -->
                        <script>
                            function update_reportForm(event) {
                                event.preventDefault();
                                console.log("UPDATE Manager Form send!");
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "green-swal",
                                        cancelButton: "delete-swal"
                                    },
                                    buttonsStyling: false
                                });

                                swalWithBootstrapButtons.fire({
                                    title: 'ยืนยันมอบสิทธิ์การดูแลให้ Report-to ท่านนี้',
                                    text: 'พนักงานจะถูกเปลี่ยน Report-to มีผลทันที ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'ใช่ ,ยืนยัน',
                                    cancelButtonText: 'ยกเลิก',
                                }).then((response) => {
                                    if (response.isConfirmed) {
                                        var formData = $('#update_report').serialize();
                                        console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                        $.ajax({
                                            type: "POST",
                                            url: "Back_End_ajax/Manager/Update_report_to.php",
                                            data: formData,
                                            dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
                                            success: function(response) {
                                                console.log(response);
                                                if (response.status === 'success') {
                                                    swalWithBootstrapButtons.fire({
                                                        icon: 'success',
                                                        title: 'แก้ไข Report-to ให้ พนักงานท่านนี้สำเร็จ!',
                                                        text: 'ข้อมูลรายชื่อ Report-to ถูกแก้ไขเรียบร้อย',
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
        </div>
    </div>
    <?php include('../admin/include/footer.php') ?>

    <!-- js -->
    <?php include('../admin/include/scripts.php') ?>


</body>

</html>