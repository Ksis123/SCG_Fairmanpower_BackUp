<script src="../vendors/scripts/core.js"></script>
<script src="../vendors/scripts/script.min.js"></script>
<script src="../vendors/scripts/process.js"></script>
<script src="../vendors/scripts/layout-settings.js"></script>
<script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="../vendors/scripts/datagraph.js"></script>

<!-- buttons for Export datatable -->
<script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
<script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
<script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
<script src="../src/plugins/datatables/js/pdfmake.min.js"></script>
<script src="../src/plugins/datatables/js/vfs_fonts.js"></script>
<script>
    // datatable
    $('document').ready(function() {
        $('.data-table').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                targets: "datatable-nosort",
                orderable: false,
            }],
            "lengthMenu": [
                [5, 10, 15, -1],
                [5, 10, 20, "ทั้งหมด"]
            ],

            "language": {
                "info": "หน้า _START_ - _END_ จากทั้งหมด _TOTAL_ รายการ",
                "lengthMenu": "แสดง _MENU_ รายการ",
                "search": "<a style='color: #7a7a7a'><i class='fa-solid fa-magnifying-glass' ></i> ค้นหา : </a>",
                "paginate": {
                    "next": '▶',
                    "previous": '◀'
                },
                "infoEmpty": "ไม่มีรายการที่แสดง",
                "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)",
                searchPlaceholder: "ค้นหา",

            },
            dom: '<"top"lBfr<"clear">>rt<"bottom"ip<"clear">>', // ให้แสดงทุกอย่างในบรรทัดเดียวกัน
            buttons: [{
                    extend: 'copyHtml5',
                    text: 'คัดลอก',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                // {
                //     extend: 'csvHtml5',
                //     text: 'CSV',
                //     exportOptions: {
                //         columns: ':visible'
                //     }
                // },
                {
                    text: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: 'พิมพ์',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });



        var table = $('.select-row').DataTable();
        $('.select-row tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        var multipletable = $('.multiple-select-row').DataTable();
        $('.multiple-select-row tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected');
        });
        var table = $('.checkbox-datatable').DataTable({
            'scrollCollapse': true,
            'autoWidth': false,
            'responsive': true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "language": {
                "info": "_START_-_END_ of _TOTAL_",
                searchPlaceholder: "ค้นหา",
                paginate: {
                    next: '▶',
                    previous: '◀'
                }
            },
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    return '<div class="dt-checkbox"><input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '"><span class="dt-checkbox-label"></span></div>';
                }
            }],
            'order': [
                [1, 'asc']
            ]
        });

        $('#example-select-all').on('click', function() {
            var rows = table.rows({
                'search': 'applied'
            }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        $('.checkbox-datatable tbody').on('change', 'input[type="checkbox"]', function() {
            if (!this.checked) {
                var el = $('#example-select-all').get(0);
                if (el && el.checked && ('indeterminate' in el)) {
                    el.indeterminate = true;
                }
            }
        });
    });
</script>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

<script>
    function validateInput_m(input) {
        // ดึงค่าที่ป้อนเข้ามา
        var inputValue = input.value;

        // ทำการแปลงค่าเป็นจำนวนเต็ม
        var intValue = parseInt(inputValue);

        // ตรวจสอบว่าค่าอยู่ในช่วงที่ต้องการหรือไม่
        if (intValue < 0 || intValue > 12 || isNaN(intValue)) {
            // ถ้าไม่อยู่ในช่วงหรือไม่ใช่ตัวเลข 1-12 ให้ล้างค่า
            input.value = "";
        }
    }
</script>
<script>
    function validateInput_y(input) {
        // ดึงค่าที่ป้อนเข้ามา
        var inputValue = input.value;

        // ทำการแปลงค่าเป็นจำนวนเต็ม
        var intValue = parseInt(inputValue);

        // ตรวจสอบว่าค่าอยู่ในช่วงที่ต้องการหรือไม่
        if (intValue < 0 || intValue > 60 || isNaN(intValue)) {
            // ถ้าไม่อยู่ในช่วงหรือไม่ใช่ตัวเลข 1-12 ให้ล้างค่า
            input.value = "";
        }
    }
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

    // <!--Add Modal for openEdit_Manager -- >
    function openEdit_Manager_Modal(manager_id, card_id, manager_card_id, edit_detail) {
        // Set values in the modal form
        document.getElementById('editManagerInput').value = manager_id;
        document.getElementById('editCard_id').value = card_id;
        document.getElementById('editManager_card_id').value = manager_card_id;
        document.getElementById('editDetail').value = edit_detail;
        // Open the modal
        $('#editManagerModal').modal('show');
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
                                title: 'ไม่สามารถลบข้อมูลได้!',
                                text: response.message || 'เนื่องจาก ข้อมูลถูกดึงไปใช้งาน',
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

    function deletemanager(managerId) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบรายชื่อลูกน้องคนนี้ ใช่ หรือไม่?',
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
                    url: 'listemployee_Manager_Delete.php',
                    data: {
                        delete_manager: true,
                        manager_id_to_delete: managerId
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล ผู้จัดการ-ลูกน้อง ถูกลบออกจากระบบแล้ว',
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

    function deletereport_to(reportId) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "delete-swal",
                cancelButton: "edit-swal"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบรายชื่อลูกน้องของ Report-to คนนี้ ใช่ หรือไม่?',
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
                    url: 'listemployee_Report_to_Delete.php',
                    data: {
                        delete_report_to: true,
                        report_id_to_delete: reportId
                    },
                    success: function(response) {
                        // ตรวจสอบคำตอบที่ได้จาก PHP
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: 'ข้อมูล Report-to ถูกลบออกจากระบบแล้ว',
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

<!-- EVALUATE -->
<script>
    const navItems = document.querySelectorAll('.nav-item');

    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove 'active' class from all items
            navItems.forEach(navItem => {
                navItem.classList.remove('active');
            });

            // Add 'active' class to the clicked item
            this.classList.add('active');
        });
    });


    // ฟังก์ชันสำหรับเพิ่มคำถามและคำตอบ
    function addQuestion() {
        var question = document.getElementById('question').value;
        var answer = document.getElementById('answer').value;

        var questionElement = document.createElement('div');
        questionElement.innerHTML = '<strong>คำถาม:</strong> ' + question + '<br><strong>คำตอบ:</strong> ' + answer + '<hr>';

        var questionList = document.getElementById('questionList');
        questionList.appendChild(questionElement);

        document.getElementById('question').value = '';
        document.getElementById('answer').value = '';
    }

    // เชื่อมต่อฟังก์ชันกับปุ่มเพิ่มคำถามและคำตอบ
    document.getElementById('addQuestionButton').addEventListener('click', addQuestion);


    // ฟังขั่นส่งค่า tr_id ไปหน้า do_assessment.php
    function redirectTodoassessment(tr_id, contract_type_id) {
        window.location.href = 'do_assessment.php?id=' + tr_id + '&emp=' + contract_type_id;
    }

    // ฟังขั่นส่งค่า tr_id, review_to, role ไปหน้า edit_reviewer.php
    function redirectToAssessment(tr_id, review_to, role) {
        window.location.href = 'edit_reviewer.php?id=' + tr_id + '&rt=' + review_to + '&role=' + role;
    }

    // ฟังชั่น Modal เหตุผลถูกปฏิเสธ หน้า main
    function showDetail(encodedDetail) {

        var detail = decodeURIComponent(encodedDetail);

        // ตรวจสอบว่าค่าเป็น NULL หรือไม่
        if (detail !== null) {
            // ถ้าไม่เป็น NULL ให้แสดงค่า
            document.getElementById('detailIdInput').innerText = detail;
        } else {
            // ถ้าเป็น NULL ให้แสดงข้อความที่ต้องการ
            document.getElementById('detailIdInput').innerText = 'No data available';
        }

        // เรียกใช้ Modal
        $('#editModal').modal('show');
    }
</script>