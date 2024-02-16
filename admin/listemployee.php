<?php include('../admin/include/header.php') ?>

<body>
	<?php include('../admin/include/navbar.php') ?>
	<?php include('../admin/include/sidebar.php') ?>

	<div class="mobile-menu-overlay"></div>
	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-10-10">
			<div class="page-header">
				<div class="title pb-2 ">
					<h3 class="text-primary h3 mb-0">รายการพนักงานทั้งหมด</h3>
				</div>
				<div class="row">
					<div class="col-xl-2 col-lg-2 col-md-5 mb-10">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<!-- Upload Exel.xlsx -->
								<button href="modal" data-toggle="modal" data-target="#modal" class="importexcel-btn"><i class="fa-regular fa-file-excel"></i> นำเข้าไฟล์ Excel</button>
								<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="editModalLabel">นำเข้าข้อมูลพนักงาน ด้วย Excel.xlsx <i class="fa-regular fa-file-excel fa-lg" style="color: #2DA57B"></i></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="col-md-12">

													<form method="post" enctype="multipart/form-data" id="importExcel">
														<div class="col-md-12 pd-5">
															<div class="form-group">
																<div class="custom-file">
																	<!-- เปลี่ยนประเภทไฟล์เป็น .xlsx -->
																	<label class="custom-file-label" for="customFile">Choose file</label>
																	<input name="import_file" id="file" type="file" class="custom-file-input" accept=".xlsx">
																</div>
																<div class="modal-footer">
																	<button onclick="importExcel(event)" class="btn btn-primary"> อัพโหลดไฟล์รูป </button>
																</div>
															</div>
														</div>
													</form>
													<!-- script -->
													<script>
														function importExcel(event) {
															event.preventDefault();
															console.log("Excel send!");

															const swalWithBootstrapButtons = Swal.mixin({
																customClass: {
																	confirmButton: "green-swal",
																	cancelButton: "delete-swal"
																},
																buttonsStyling: false
															});

															swalWithBootstrapButtons.fire({
																title: 'ยืนยัน import Excel',
																text: 'คุณต้องการอัพโหลด Excel ไฟล์นี้ ใช่หรือไม่ ?',
																icon: 'warning',
																showCancelButton: true,
																confirmButtonText: 'ใช่ ,ยืนยัน',
																cancelButtonText: 'ยกเลิก',
															}).then((response) => {
																if (response.isConfirmed) {
																	var formData = new FormData($('#importExcel')[0]);

																	$.ajax({
																		type: "POST",
																		url: "importexcelData.php",
																		data: formData,
																		dataType: "json",
																		contentType: false,
																		processData: false,
																		success: function(response) {
																			console.log(response);

																			if (response.status === 'success') {
																				swalWithBootstrapButtons.fire({
																					icon: 'success',
																					title: 'import Excel สำเร็จ!',
																					text: 'ข้อมูลพนักงานถูกนำเข้าเรียบร้อย',
																				}).then(() => {
																					location.reload();
																				});
																			} else {
																				swalWithBootstrapButtons.fire({
																					icon: 'error',
																					title: 'เกิดข้อผิดพลาด!',
																					text: response.message || 'ไม่สามารถบันทึกข้อมูลได้',
																				});
																			}
																		},
																		error: function(xhr, textStatus, errorThrown) {
																			console.log(xhr, textStatus, errorThrown);
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
							</div>
						</div>
					</div>
					<div class="col-xl-7 col-lg-3 col-md-6 mb-10">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<button class="downloadexcel-btn" onclick="downloadSampleExcel()"><i class="fa-regular fa-circle-down"></i> ดาวน์โหลดตัวอย่าง Excel</button>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-2 col-md-6 mb-10">
						<div class="d-flex flex-wrap">
							<div class="widget-data">
								<div class="weight-700 font-24 text-right"></div>
								<button class="createdemp-btn" onclick="location.href='listemployee_Create.php'"> + เพิ่มพนักงานใหม่ </button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="pl-20 mb-30">
			<div class="pd-20 card-box">
				<div class="pb-20">
					<table class="data-table table stripe hover nowrap">
						<thead>
							<tr>
								<th class="col-sm-2">รหัสพนักงาน SCG</th>
								<th class="col-lg-3">รายชื่อพนักงาน</th>
								<th>ตำแหน่ง</th>
								<th class="col-lg-2">ประเภทพนักงาน</th>
								<th>สังกัดแผนก - Section</th>
								<th class="datatable-nosort">การจัดการ</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// เตรียมคำสั่ง SQL
							$sql = "SELECT *,
								permission.name as permission, permission.permission_id as permissionID, contract_type.name_thai as contracts, 
								section.name_thai as section, department.name_thai as department, company.name_thai as com, location.name as lo, division.name_thai as di
								
								FROM employee
								INNER JOIN  cost_center ON cost_center.cost_center_id = employee.cost_center_organization_id
								INNER JOIN section ON section.section_id = cost_center.section_id
								INNER JOIN department ON department.department_id = section.department_id
								INNER JOIN division ON division.division_id = department.division_id
								INNER JOIN location ON location.location_id = division.location_id
								INNER JOIN company ON company.company_id = location.company_id


								INNER JOIN permission ON permission.permission_id = employee.permission_id
								INNER JOIN contract_type ON contract_type.contract_type_id = employee.contract_type_id";


							$params = array();
							$totalRows = 0;

							// ดึงข้อมูลจากฐานข้อมูล
							$stmt = sqlsrv_query($conn, $sql, $params);

							// ตรวจสอบการทำงานของคำสั่ง SQL
							if ($stmt === false) {
								die(print_r(sqlsrv_errors(), true));
							}

							// แสดงผลลัพธ์ในรูปแบบของตาราง HTML
							while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
								echo "<tr>";
								echo "<td>" . $row["scg_employee_id"] . "</td>";
								echo "<td class='table-plus'><div class='row'>",
								"<div style= 'padding-right: 5px;'>",
								'<img src="' . (!empty($row['employee_image']) ? '../admin/uploads_img/' . $row['employee_image'] : '../asset/img/admin.png') . '" class="border-radius-100 shadow" width="40" height="40" alt="">',
								"</div>",
								"<div><b>" . '  ' . $row["prefix_thai"] . '  ' . $row["firstname_thai"] . ' ' . $row["lastname_thai"] . ' (' . $row["nickname_thai"] . ')' . " </b><br/>", "<a class ='text-primary'>" . $row["employee_email"] . " </a><br/>";
								echo "<td><div class='permission-" . $row["permissionID"] . "'><b>" . $row["permission"] . "</b></div></td>";
								echo "<td>" . $row["contracts"] . "</td>";
								echo "<td><a>" . $row["department"] . "</a><br><a>" . ' ' . $row["section"] . " </a></td>";
								echo '<td><div class="flex">',
								'<button type="button" name="delete_employee" class="delete-btn_Org" onclick="deleteEmployee(\'' . $row['card_id'] . '\');"><i class="fa-solid fa-trash-can"></i></button>';
								echo '<button type="button" class="edit-btn_Org" onclick="editEmployee(\'' . $row['card_id'] . '\');">';
								echo '<i class="fa-solid fa-pencil"></i>';
								echo '</button>';
								echo '</div></td>';
								$totalRows++;
							}

							?>
						</tbody>
						<p class='text-primary h4'> พนักงานทั้งหมด : <?php echo $totalRows  ?> คน</p>

					</table>

				</div>
			</div>
		</div>
		<?php include('../admin/include/footer.php') ?>
	</div>
	<!-- js -->
	<script>
		function editEmployee(cardId) {
			// ส่งค่า card_id ไปยังหน้า Edit_employee.php
			window.location.href = 'listemployee_Edit.php?card_id=' + cardId;
		}
	</script>

	<script>
		function downloadSampleExcel() {
			// Redirect to the PHP file for download
			window.location.href = 'downloadExcel.php';
		}
	</script>



	<?php include('../admin/include/scripts.php') ?>
</body>

</html>