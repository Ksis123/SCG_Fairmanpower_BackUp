<div class="header">
	<div class="header-left">
		<div class="menu-icon">
			<i class="fa-solid fa-bars"></i>
		</div>
		<div class="search-toggle-icon" data-toggle="header_search"></div>

	</div>
	<div class="header-right">
		<div class="dashboard-setting user-notification">
			<div class="dropdown">
				<button class="notification-btn">
					<i class="fa-regular fa-bell"></i>
				</button>
			</div>
		</div>
		<div class="dashboard-setting user-notification">
			<div class="dropdown">
				<button class="notification-btn">
					<i class="fa-solid fa-comment-dots"></i>
				</button>
			</div>
		</div>
		<div class="user-info-dropdown">
			<div class="dropdown ">
				<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
					<span class="user-icon">
						<img src="<?php echo (!empty($row['employee_image'])) ? '../admin/uploads_img/' . $row['employee_image'] : '../asset/img/admin.png'; ?>" width="60" height="60">
					</span>
					<span class="user-name">
						<label>
							<?php echo  $row['prefix_thai'] . $row['firstname_thai'] . ' ' . $row['lastname_thai'] ?><br/>
							ตำแหน่ง : <?php echo $row['permission'] ?>
						</label>

					</span>

				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="profile.php"><i class="fa-regular fa-user" style=" padding-right: 5px;"><br /> </i> โปรไฟล์</a>
					<a class="dropdown-item" href="../../SCG_Fairmanpower/index.php"><i class="fa-solid fa-arrow-right-from-bracket" style=" padding-right: 5px;"></i> ออกจากระบบ</a>
				</div>
			</div>
		</div>
	</div>
</div>