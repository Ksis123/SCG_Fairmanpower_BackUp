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
                                <h3>ข้อมูลโครงสร้างองค์กร : Organization ID</h3>
                                <p class="text-primary">โครงสร้างทั้ง 9 ลำดับขั้นจะเริ่มเรียงจากซ้าย-ขวาเสมอ

                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item "><a href="org1_Business_unit.php">Business Unit</a></li>
                                    <li class="breadcrumb-item"><a href="org2_Sub_Business_unit.php">Sub-business-unit</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Organization-ID</li>
                                    <li class="breadcrumb-item"><a href="org4_Company.php">Company</a></li>
                                    <li class="breadcrumb-item"><a href="org5_Location.php">Location</a></li>
                                    <li class="breadcrumb-item"><a href="org6_Division.php">Division</a></li>
                                    <li class="breadcrumb-item"><a href="org7_Department.php">Department</a></li>
                                    <li class="breadcrumb-item"><a href="org8_Section.php">Section</a></li>
                                    <li class="breadcrumb-item"><a href="org9_Costcenter.php">Cost-Center</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-9 col-md-6 col-sm-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-100-p">
                            <div class="row" style="justify-content: space-between; align-items: center;">
                                <div class="col-md-3 col-sm-1 text-left">
                                </div>
                                <div class="col-md-3 col-sm-1 text-right">
                                    <a class="btn-back" href='org2_Sub_Business_unit.php'>
                                        <i class="fa-solid fa-circle-left fa-xl">
                                        </i>
                                    </a>
                                    <a class="btn-back" href='org4_Company.php'>
                                        <i class="fa-solid fa-circle-right fa-xl"></i>
                                    </a>
                                </div>
                            </div>
                            <h2 class="h4 text-blue">หมายเลข Organization ID ทั้งหมดในระบบ</h2>
                            <p class="text-danger">* หมายเหตุ : หากต้องการลบหมายเลข Organization ID จะต้องลบ ชื่อบริษัท ที่เกี่ยวข้องก่อนเสมอ </p>

                            <div class="pb-20">
                                <table class="data-table table stripe hover nowrap">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>Sub-business-unit</th>
                                            <th>หมายเลข OrganizationID</th>
                                            <th>จัดการ <a onclick="openEdit_OrgID_Modal()"><i class="fa-solid fa-circle-exclamation warming-btn_Org"></i></a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // เตรียมคำสั่ง SQL

                                        // $sql3 = "SELECT * FROM organization org INNER JOIN sub_business s ON org.sub_business_id = s.sub_business_id WHERE s.sub_business_id=?";

                                        $sql3 = "SELECT *FROM organization JOIN sub_business ON organization.sub_business_id = sub_business.sub_business_id;";
                                        $params3 = array();
                                        $i = 1;

                                        // ดึงข้อมูลจากฐานข้อมูล
                                        $stmt3 = sqlsrv_query($conn, $sql3, $params3);
                                        // ตรวจสอบการทำงานของคำสั่ง SQL
                                        if ($stmt3 === false) {
                                            die(print_r(sqlsrv_errors(), true));
                                        }

                                        // แสดงผลลัพธ์ในรูปแบบของตาราง HTML
                                        while ($row = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . $i++ . "</td>";
                                            echo "<td>" . $row["name_eng"] . "</td>";
                                            echo "<td>" . $row["organization_id"] . "</td>";
                                            echo '<td><div class="flex">',
                                            '<button type="button" name="delete_sub_business" class="delete-btn_Org" onclick="confirmDelete_Org(\'' . $row['organization_id'] . '\');"><i class="fa-solid fa-trash-can"></i></button>',
                                            '</div></td>';
                                            echo "</tr>";
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Start -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <i class='fa-solid fa-circle-exclamation 2xl'></i>

                                    <h5 class="modal-title">ระบบ<a class="text-danger"> ไม่สามารถแก้ไข
                                            หมายเลข Organization ID</a>ได้
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form for editing data -->
                                    <label class="modal-title">เนื่องจากหมายเลข OrganizationID ถูกกำหนดเป็น Primary Key</label>
                                    <label class="modal-title">จะมีความซ้ำซ้อนเมื่อแก้ไข และส่งผลกระทบต่อลำดับขั้น Company ถัดไป</label>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End -->

                    <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                        <div class="card-box pd-30 pt-10 height-50-p">
                            <section>
                                <form method="post" id="insert_orgid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>ระบุ Sub-Business-ID</label>
                                                <select name="sub_business_id" class="form-control selectpicker" data-live-search="true" required="true" autocomplete="off">
                                                    <option value="" disabled selected> ระบุ Business ID </option>
                                                    <?php
                                                    // สร้าง options สำหรับ dropdown 2
                                                    $sqlDropdown3 = "SELECT * FROM sub_business";
                                                    $resultDropdown3 = sqlsrv_query($conn, $sqlDropdown3);

                                                    // เช็ค error
                                                    if ($resultDropdown3 === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }

                                                    if ($resultDropdown3) {
                                                        while ($row = sqlsrv_fetch_array($resultDropdown3, SQLSRV_FETCH_ASSOC)) {
                                                            echo "<option value='"  . $row['sub_business_id'] . "'>" . $row['name_thai'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>หมายเลข Organization ID</label>
                                                <input name="organization_id" type="number" class="form-control" required="true" autocomplete="off" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary" onclick="insert_orgid_Form(event);">เพิ่ม Organization</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- script -->
                                <script>
                                    function insert_orgid_Form(event) {
                                        event.preventDefault();
                                        console.log("INSERT orgid Form send!");
                                        const swalWithBootstrapButtons = Swal.mixin({
                                            customClass: {
                                                confirmButton: "green-swal",
                                                cancelButton: "delete-swal"
                                            },
                                            buttonsStyling: false
                                        });
                                        swalWithBootstrapButtons.fire({
                                            title: 'ยืนยัน หมายเลข Organization ID',
                                            text: 'หมายเลขจะถูกเพิ่มลงฐานข้อมูลในระบบ',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'ใช่ ,ยืนยัน',
                                            cancelButtonText: 'ยกเลิก',
                                        }).then((response) => {
                                            if (response.isConfirmed) {
                                                var formData = $('#insert_orgid').serialize();
                                                console.log("Form Data: ", formData); // Log ค่า FormData ที่จะส่งไป

                                                $.ajax({
                                                    type: "POST",
                                                    url: "Back_End_ajax/Org/organizationID_add.php",
                                                    data: formData,
                                                    dataType: "json", // ระบุว่าต้องการรับข้อมูลเป็น JSON
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
                                                                title: "เพิ่ม Organization ID สำเร็จ"
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
                            </section>
                        </div>
                    </div>
                </div>

            </div>

            <?php include('../admin/include/footer.php'); ?>
        </div>
    </div>
    <!-- js -->

    <?php include('../admin/include/scripts.php') ?>
</body>

</html>