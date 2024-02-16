<?php
require 'C:\xampp\htdocs\SCG_Fairmanpower\vendor\autoload.php'; // ต้องติดตั้งและให้ที่อยู่ของไฟล์ autoload.php ของ PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// เปลี่ยนเป็นที่อยู่ของไฟล์ Excel ของคุณ
$existingFile = 'excel_sample/Template_Fair_Manpower.xlsx';
date_default_timezone_set('Asia/Bangkok');


$filename = 'Template_Fairmanpower_' . date('dmY_Hi') . '.xlsx'; // เพิ่มวันที่และเวลาให้กับชื่อไฟล์

// สร้างสเปรดชีทใหม่
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($existingFile);

// กำหนดการส่งออกไฟล์ Excel
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// ส่งออกไฟล์ Excel ที่ดาวน์โหลดได้
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
