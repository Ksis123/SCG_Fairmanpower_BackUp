<?php
// uploadimage.php

require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ตรวจสอบว่ามีไฟล์ถูกอัปโหลดหรือไม่
        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];

            // ตรวจสอบว่ามีข้อผิดพลาดในการอัปโหลดไฟล์หรือไม่
            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileTmpName = $file['tmp_name'];
                $fileName = $file['name'];

                // ตรวจสอบว่ามีข้อผิดพลาดในการอัปโหลดไฟล์หรือไม่
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $fileTmpName = $file['tmp_name'];
                    $fileName = $file['name'];

                    // รับไฟล์อัปโหลดไปยังโฟลเดอร์ที่ต้องการ
                    $uploadPath = 'uploads_img/';  // แก้ตำแหน่งที่เก็บไฟล์
                    $targetFilePath = $uploadPath . $fileName;
                    move_uploaded_file($fileTmpName, $targetFilePath);

                    // รับ card_id จาก FormData
                    $card_id = isset($_POST['card_id']) ? $_POST['card_id'] : '';

                    // อัปเดตคอลัมน์ employee_image ในฐานข้อมูล
                    $updateQuery = "UPDATE employee SET employee_image = ? WHERE card_id = ?";
                    $params = array($fileName, $card_id);
                    $stmt = sqlsrv_query($conn, $updateQuery, $params);

                    if ($stmt === false) {
                        $response = array('status' => 'error', 'message' => 'Error updating image.');
                        echo json_encode($response);
                        exit();
                    } else {
                        $response = array('status' => 'success', 'message' => 'Image updated successfully.');
                        echo json_encode($response);
                        exit();
                    }
                } else {
                    $response = array('status' => 'error', 'message' => 'No file uploaded.');
                    echo json_encode($response);
                    exit();
                }
            }
        }
    
}
