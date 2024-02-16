<script src="../vendors/scripts/core.js"></script>
<script src="../vendors/scripts/script.min.js"></script>
<script src="../vendors/scripts/process.js"></script>
<script src="../vendors/scripts/layout-settings.js"></script>
<script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
<script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

<!-- buttons for Export datatable -->
<script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
<script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
<script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
<script src="../src/plugins/datatables/js/pdfmake.min.js"></script>
<script src="../src/plugins/datatables/js/vfs_fonts.js"></script>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>



<!-- Add Modal for OpenEdit_Business  -->
<script>
    function openEdit_Business_Modal(business_id, name_thai, name_eng) {
        document.getElementById('editBusinessIdInput').value = business_id;
        document.getElementById('editNameThai').value = name_thai;
        document.getElementById('editNameEng').value = name_eng;
        $('#editModal').modal('show');
    }

    // <!-- Add Modal for OpenEdit_SubBusiness -->
    function openEdit_SubBusiness_Modal(business_id, sub_business_id, name_thai, name_eng) {
        document.getElementById('editBusinessIdInput').value = business_id;
        document.getElementById('editSubBusinessId').value = sub_business_id;
        document.getElementById('editNameThai').value = name_thai;
        document.getElementById('editNameEng').value = name_eng;
        $('#editModal').modal('show');
    }

    // <!-- Add Modal for OpenEdit_Org -->

    function openEdit_OrgID_Modal() {
        $('#editModal').modal('show');
    }

    // <!-- Add Modal for OpenEdit_Company -->

    function openEdit_Cost_Modal() {
        $('#editModal').modal('show');
    }

    // <!-- Add Modal for OpenEdit_Company -->

    function openEdit_Company_Modal(company_id, organization_id, name_thai, name_eng) {
        // Set values in the modal form
        document.getElementById('editCompanyIdInput').value = company_id;
        document.getElementById('editOrganizationId').value = organization_id;
        document.getElementById('editNameThai').value = name_thai;
        document.getElementById('editNameEng').value = name_eng;
        // Open the modal
        $('#editCompanyModal').modal('show');
    }

    // <!--Add Modal for OpenEdit_Location-- >
    function openEdit_Location_Modal(location_id, company_id, name, name_eng) {
        // Set values in the modal form
        document.getElementById('editLocationIdInput').value = location_id;
        document.getElementById('editCompany').value = company_id;
        document.getElementById('editLocationName').value = name;
        document.getElementById('editLocationName_ENG').value = name_eng;


        // Open the modal
        $('#editLocationModal').modal('show');
    }

    // <!--Add Modalfor OpenEdit_Division-- >
    function openEdit_Division_Modal(division_id, location_id, name_thai, name_eng) {
        // Set values in the modal form
        document.getElementById('editDivisionIdInput').value = division_id;
        document.getElementById('editLocation').value = location_id;
        document.getElementById('editDivisionNameThai').value = name_thai;
        document.getElementById('editDivisionNameEng').value = name_eng;

        // Open the modal
        $('#editDivisionModal').modal('show');
    }

    // <!--Add Modal for OpenEdit_Department-- >
    function openEdit_Department_Modal(department_id, division_id, name_thai, name_eng) {
        // Set values in the modal form
        document.getElementById('editDepartmentIdInput').value = department_id;
        document.getElementById('editDivision').value = division_id;
        document.getElementById('editDepartmentNameThai').value = name_thai;
        document.getElementById('editDepartmentNameEng').value = name_eng;
        // Open the modal
        $('#editDepartmentModal').modal('show');
    }

    // <!--Add Modalfor OpenEdit_Section-- >
    function openEdit_Section_Modal(section_id, department_id, name_thai, name_eng) {
        // Set values in the modal form
        document.getElementById('editSectionIdInput').value = section_id;
        document.getElementById('editDepartment').value = department_id;
        document.getElementById('editSectionNameThai').value = name_thai;
        document.getElementById('editSectionNameEng').value = name_eng;
        // Open the modal
        $('#editSectionModal').modal('show');
    }
</script>

<script>
    function confirmDeleteSubmit() {
        Swal.fire({
            title: "ยืนยันการลบข้อมูลใช่ หรือ ไม่?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "ใช่, ยืนยันการลบ",
            cancelButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("deleteForm").submit();
            }
        });
    }
</script>

<script>
    function swalAddAlert1() {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: "บันทึกข้อมูลสำเร็จ"
        });
    };
</script>

<!-- Delete cornfirm sweetalert2-->

<script>
    function confirmDelete(business_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบ Business Unit นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org1_Business_unit_Delete.php',
                    data: {
                        delete_business: true,
                        business_id: business_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล Business Unit ถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้',
                            });
                        }
                    },
                    error: function() {
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

    function confirmDelete_Sub(sub_business_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบ Sub Business Unit นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org2_Sub_Business_unit_Delete.php',
                    data: {
                        delete_sub_business: true,
                        sub_business_id: sub_business_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล Sub Business Unit ถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้',
                            });
                        }
                    },
                    error: function() {
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

    function confirmDelete_Org(organization_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบ Organization ID นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org3_Organizaion_Delete.php',
                    data: {
                        delete_organization: true,
                        organization_id: organization_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล Organization ID ถูกลบออกเรียบร้อย',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้',
                            });
                        }
                    },
                    error: function() {
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

    function confirmDelete_Company(company_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบข้อมูล บริษัท นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org4_Company_Delete.php',
                    data: {
                        delete_company: true,
                        company_id: company_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล บริษัท ถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้ โปรดเช็คหน่วยย่อย Location',
                            });
                        }
                    },
                    error: function() {
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

    function confirmDelete_Location(location_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบข้อมูล Location (สำนักงาน) นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org5_Location_Delete.php',
                    data: {
                        delete_location: true,
                        location_id: location_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล Location (สำนักงาน) ถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้ โปรดเช็คหน่วยย่อย Division',
                            });
                        }
                    },
                    error: function() {
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

    function confirmDelete_Division(division_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบข้อมูล Division นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org6_Division_Delete.php',
                    data: {
                        delete_division: true,
                        division_id: division_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล Division  ถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้ โปรดเช็คหน่วยย่อย แผนก',
                            });
                        }
                    },
                    error: function() {
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

    function confirmDelete_Department(department_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบข้อมูล แผนก นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org7_Department_Delete.php',
                    data: {
                        delete_department: true,
                        department_id: department_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล แผนก ถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้ โปรดเช็คหน่วยย่อย Section',
                            });
                        }
                    },
                    error: function() {
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

    function confirmDelete_Section(section_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบข้อมูล Section นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org8_Section_Delete.php',
                    data: {
                        delete_section: true,
                        section_id: section_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล Section ถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้ โปรดเช็ค Cost Center',
                            });
                        }
                    },
                    error: function() {
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

    function confirmDelete_Cost(cost_center_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบหมายเลข Cost Center นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'org9_Costcenter_Delete.php',
                    data: {
                        delete_cost_center: true,
                        cost_center_id: cost_center_id
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'หมายเลข Organization ID ถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้ ',
                            });
                        }
                    },
                    error: function() {
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

    function deleteEmployee(cardId) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบข้อมูลพนักงานนี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่ง request ไปยังไฟล์ PHP ที่ทำการลบข้อมูล
                $.ajax({
                    type: 'POST',
                    url: 'listemployee_Delete.php',
                    data: {
                        delete_employee: true,
                        card_id_to_delete: cardId
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูลพนักงานถูกลบออกจากระบบแล้ว',
                            }).then(() => {
                                // ทำการรีเฟรชหน้าหลังจากลบสำเร็จ
                                location.reload();
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถลบข้อมูลได้',
                            });
                        }
                    },
                    error: function() {
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


