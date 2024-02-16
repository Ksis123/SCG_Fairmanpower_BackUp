<?php include('../employee/include/header.php') ?>


<body>
    <?php include('../employee/include/navbar.php') ?>
    <?php include('../employee/include/sidebar.php') ?>

    
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="row">
                <div class="col-xl-3 col-lg-2 col-md-6 mb-10 title pb-20">
                    <h2 class="h3 mb-0">แบบประเมินทั้งหมด</h2>
                </div>
            </div>
            <div class="card-box pd-20 height-100-p mb-30">
                <div class="btn-add">
                    <span class="small-section">กรุณาเลือกคนที่ท่านต้องการให้ประเมินท่าน</span>
                    <button onclick="window.location.href = 'addreviewer.php'" class='btn btn-primary'><i class="bi bi-plus"></i></button></button>

                </div>

                <div class="section">
                    <span class="section">สถานะการประเมินของท่าน</span>
                </div>
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>บทบาท</th>
                            <th>สถานะ</th>
                            <th>หัวหน้ายอมรับ</th>
                            <th>แก้ไข</th>
                            <th>เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // เตรียมคำสั่ง SQL                    
                        $sql = "SELECT tr.detail,tr.tr_id, tr.review_to, tr.reviewer, tr.role, tr.status, tr.date, e.firstname_thai, e.lastname_thai, rs.status AS score_status
                    FROM transaction_review tr
                    INNER JOIN employee e ON tr.reviewer = e.card_id
                    JOIN review_score rs ON rs.tr_id = tr.tr_id
                    WHERE tr.review_to = ? 
                    ORDER BY
                     tr.date DESC 
                    OFFSET 0 ROWS FETCH NEXT 5 ROWS ONLY";

                        $params = array($card_id);

                        $stmt = sqlsrv_query($conn, $sql, $params);

                        // ตรวจสอบการทำงานของคำสั่ง SQL
                        if ($stmt === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        // แสดงผลลัพธ์ในรูปแบบของตาราง HTML
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row["firstname_thai"] . " " . $row["lastname_thai"] . "</td>";
                            echo "<td>" . $row["role"] . "</td>";
                            echo "<td>";
                            if (is_null($row["score_status"])) {
                                echo '<div class="text-wait">รอดำเนินการ</div>';
                            } elseif ($row["score_status"] === "success") {
                                echo '<div class="text-approve">เรียบร้อยแล้ว</div>';
                            }
                            echo "</td>";
                            echo "<td>";
                            if (is_null($row["status"])) {
                                echo '<div class="text-wait">รอการอนุมัติ</div>';
                            } elseif ($row["status"] === "approve") {
                                echo '<div class="text-approve">อนุมัติ</div>';
                            } elseif ($row["status"] === "reject") {
                                echo '<div class="text-reject">ไม่อนุมัติ</div>';
                            }
                            echo "</td>";
                            if ($row["status"] === "reject") {
                                echo "<td><button class='edit-btn' onclick=\"redirectToAssessment('" . urlencode($row["tr_id"]) . "','" . urlencode($row["review_to"]) . "','" . urlencode($row["role"]) . "')\"><span class='checkmark'>✎</span></button></td>";
                            } else {
                                echo "<td><button class='edit-btn-disabled' disabled ><span class='checkmark'>✎</span></button></td>";
                            }
                            if ($row["detail"] !== null) {
                                echo "<td><button class='edit-btn' onclick=\"showDetail('" . urlencode($row["detail"]) . "')\"><span class='checkmark'>?</span></button></td>";
                            } else {
                                echo "<td><button class='edit-btn-disabled'disabled><span class='checkmark'>?</span></button></td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- end ส่วนตารางสถานะการประเมิน -->

            <!-- start ส่วนของประเมินตนเอง -->
            <div class="btn-add">
                <?php
                $sqlme = "SELECT tr.review_to,tr.reviewer,tr.role,tr.tr_id,tr.status,e.firstname_thai,e.lastname_thai,e.contract_type_id FROM transaction_review tr
                            INNER JOIN employee e ON tr.review_to = e.card_id AND tr.review_to = tr.reviewer
                            INNER JOIN review_score rs ON rs.tr_id = tr.tr_id
                            WHERE tr.reviewer = ? AND rs.status IS NULL ";
                $params = array($card_id);
                // ดึงข้อมูลจากฐานข้อมูล
                $stmtme = sqlsrv_query($conn, $sqlme, $params);

                // ตรวจสอบการทำงานของคำสั่ง SQL
                if ($stmtme === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
                while ($row = sqlsrv_fetch_array($stmtme, SQLSRV_FETCH_ASSOC)) {
                    echo "<span class='small-section'>กรุณาประเมินตัวเอง</span>";
                    echo "<button class='btn-doassessment-me' style='margin-left:20px;'  onclick=\"redirectTodoassessment('" . urlencode($row["tr_id"]) . "','" . urlencode($row["contract_type_id"]) . "')\"><span>ทำแบบทดสอบตัวเอง</span></button>";
                }
                ?>
            </div>

                <div class="">
                    <span class="">คนที่ขอให้ท่านประเมิน</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>บทบาท</th>
                            <th>เวลาดำเนินการ</th>
                            <th>ทำแบบทดสอบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // เตรียมคำสั่ง SQL
                        $sql = "SELECT a.date_start,a.date_end,tr.review_to,tr.reviewer,tr.role,tr.tr_id,tr.status,e.firstname_thai,e.lastname_thai, rs.status, e.contract_type_id FROM transaction_review tr
                    INNER JOIN employee e ON tr.review_to = e.card_id AND tr.review_to != tr.reviewer
                    INNER JOIN assessment a ON a.contract_type_id = e.contract_type_id
                    INNER JOIN review_score rs ON rs.tr_id = tr.tr_id
                    WHERE tr.reviewer = ? AND tr.status = 'approve' AND rs.status IS NULL
                    ORDER BY a.date_start DESC
                    ";
                        $params = array($card_id);
                        // ดึงข้อมูลจากฐานข้อมูล
                        $stmt = sqlsrv_query($conn, $sql, $params);

                        // ตรวจสอบการทำงานของคำสั่ง SQL
                        if ($stmt === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        // แสดงผลลัพธ์ในรูปแบบของตาราง HTML
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $time_start  = $row["date_start"]; // สร้างวัตถุ DateTime
                            $formattedDateStart = $time_start->format('d-m-Y');

                            $time_end  = $row["date_end"]; // สร้างวัตถุ DateTime
                            $formattedDateEnd =  $time_end->format('d-m-Y');

                            echo "<tr>";
                            echo "<td>" . $row["firstname_thai"] . " " . $row["lastname_thai"] . "</td>";
                            echo "<td>" . $row["role"] . "</td>";
                            echo "<td>" . $formattedDateStart . ' - ' . $formattedDateEnd .  "</td>";
                            echo "<td><button class='btn-doassessment' onclick=\"redirectTodoassessment('" . urlencode($row["tr_id"]) . "','" . urlencode($row["contract_type_id"]) . "')\"><span>ทำแบบทดสอบ</span></button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <!-- main end -->
            <div class="btn-permiss">
                <button onclick="window.location.href = 'boss_main.php'" class='btn-pm'>เปลี่ยนเป็นหัวหน้า</button>
                <button onclick="window.location.href = 'addmin_main.php'" class='btn-addmin'>เปลี่ยนเป็นแอดมิน</button>
            </div>
            <?php
            // ตรวจสอบว่า $row ถูกกำหนดค่าและมี $row["detail"] หรือไม่
            if (isset($row) && isset($row["detail"])) {
                $encodedDetail = urlencode($row["detail"]);
            } else {
                $encodedDetail = '';
            }
            ?>

            <script>
                var encodedData = <?php echo json_encode($encodedDetail); ?>;

                // ตรวจสอบว่า encodedData ไม่เป็น null หรือ undefined ก่อนที่จะใช้
                if (encodedData) {
                    showDetail(encodedData);
                } else {
                    // กรณีที่ encodedData เป็น null หรือ undefined
                    console.error('Error: encodedData is null or undefined');
                }
            </script>
            <!-- modal -->
            <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">เหตุผลที่ถูกปฏิเสธ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h1 id="detailIdInput">Loading...</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('../admin/include/footer.php') ?>
    </div>

    <?php include('../employee/include/scripts.php') ?>

</body>

</html>