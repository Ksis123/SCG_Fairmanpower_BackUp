<?php
//session_start();
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');
$currentYear = date('Y');
$filterData = $_SESSION['filter'] ?? null;
$sqlConditions_plan = "year = '{$currentYear}'"; // เงื่อนไขเริ่มต้นคือข้อมูลของปีปัจจุบัน
$sqlConditions_actual_working_day = "year = '{$currentYear}'";
// $sqlConditions_actual = "date_start BETWEEN '{$filterData['startMonthDate']}' AND '{$filterData['endMonthDateCurrent']}'"; //แก้การรับค่าจากวัน
// echo $filterData['startMonthDate'];
// echo $filterData['endMonthDateCurrent'];
// echo $
$currentYear = date('Y'); // ปีปัจจุบัน
$startYear = $currentYear . '-01-01'; // วันที่ 1 มกราคมของปีปัจจุบัน
$currentDate = date('Y-m-d'); // วันที่ปัจจุบัน

$sqlConditions_actual = "date_start BETWEEN '{$startYear}' AND '{$currentDate}'";


//query %Plan OT compare Normal Time
if ($filterData) {
    if (!empty($filterData['startYear']) && !empty($filterData['endYearDecember'])) {
        $sqlConditions_plan = "year BETWEEN '{$filterData['startYear']}' AND '{$filterData['endYearDecember']}'";
    }

    if (!empty($filterData['startMonth']) && !empty($filterData['endMonthDecember'])) {
        $sqlConditions_plan .= " AND month BETWEEN '{$filterData['startMonth']}' AND '{$filterData['endMonthDecember']}'";
    }

    if (!empty($filterData['sectionId'])) {
        $sqlConditions_plan .= " AND cc.section_id = '{$filterData['sectionId']}'";
    }
    elseif (!empty($filterData['departmentId'])) {
        $sqlConditions_plan .= " AND s.department_id = '{$filterData['departmentId']}'";
    }
    elseif (!empty($filterData['divisionId'])) {
        $sqlConditions_plan .= " AND d.division_id = '{$filterData['divisionId']}'";
    }
    elseif (!empty($filterData['locationId'])) {
        $sqlConditions_plan .= " AND dv.location_id = '{$filterData['locationId']}'";
    }
    elseif (!empty($filterData['companyId'])) {
        $sqlConditions_plan .= " AND l.company_id = '{$filterData['companyId']}'";
    }
    elseif (!empty($filterData['organizationId'])) {
        $sqlConditions_plan .= " AND c.organization_id = '{$filterData['organizationId']}'";
    }
    elseif (!empty($filterData['sub_businessId'])) {
        $sqlConditions_plan .= " AND o.sub_business_id = '{$filterData['sub_businessId']}'";
    }
    elseif (!empty($filterData['businessId'])) {
    $sqlConditions_plan .= " AND sb.business_id = '{$filterData['businessId']}'";
    }

}

$sql = "SELECT 
            SUM(otp.total_hours) AS totalHours, 
            SUM(otp.cal_percent_OT_plan_normaltime) AS totalOTPercent 
        FROM 
            ot_plan otp
        INNER JOIN 
            cost_center cc ON otp.cost_center_id = cc.cost_center_id
        INNER JOIN 
            section s ON cc.section_id = s.section_id
        INNER JOIN
            department d ON s.department_id = d.department_id
        INNER JOIN 
            division dv ON d.division_id = dv.division_id
        INNER JOIN
            location l ON dv.location_id = l.location_id
        INNER JOIN
            company c ON l.company_id = c.company_id
        INNER JOIN
            organization o ON c.organization_id = o.organization_id
        INNER JOIN
            sub_business sb ON o.sub_business_id = sb.sub_business_id
        INNER JOIN
            business b on sb.business_id = b.business_id
        WHERE 
            $sqlConditions_plan";


$stmt = sqlsrv_query($conn, $sql); 
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

    $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($data['totalOTPercent'] != 0) { 
    $percentage_plan = ($data['totalHours'] / $data['totalOTPercent']) * 100;
} else {
    $percentage_plan = 0; 
}

//query ชั่วโมงการทำงานจริง
if ($filterData) {
    
    if (!empty($filterData['startMonthDate']) && !empty($filterData['endMonthDateCurrent'])) {
        $sqlConditions_actual = "date_start BETWEEN '{$filterData['startMonthDate']}' AND '{$filterData['endMonthDateCurrent']}'";
 
    }
    if (!empty($filterData['sectionId'])) {
        $sqlConditions_actual .= " AND cc.section_id = '{$filterData['sectionId']}'";
    }
    elseif (!empty($filterData['departmentId'])) {
        $sqlConditions_actual .= " AND s.department_id = '{$filterData['departmentId']}'";
    }
    elseif (!empty($filterData['divisionId'])) {
        $sqlConditions_actual .= " AND d.division_id = '{$filterData['divisionId']}'";
    }
    elseif (!empty($filterData['locationId'])) {
        $sqlConditions_actual .= " AND dv.location_id = '{$filterData['locationId']}'";
    }
    elseif (!empty($filterData['companyId'])) {
        $sqlConditions_actual .= " AND l.company_id = '{$filterData['companyId']}'";
    }
    elseif (!empty($filterData['organizationId'])) {
        $sqlConditions_actual .= " AND c.organization_id = '{$filterData['organizationId']}'";
    }
    elseif (!empty($filterData['sub_businessId'])) {
        $sqlConditions_actual .= " AND o.sub_business_id = '{$filterData['sub_businessId']}'";
    }
    elseif (!empty($filterData['businessId'])) {
        $sqlConditions_actual .= " AND sb.business_id = '{$filterData['businessId']}'";
    }
}

$sql = "SELECT 
            SUM(otr.attendance_hours) AS totalAttendanceHours
        FROM 
            ot_record otr
        INNER JOIN 
            employee e ON otr.card_id = e.card_id
        INNER JOIN 
            cost_center cc ON e.cost_center_payment_id = cc.cost_center_id
        INNER JOIN 
            section s ON cc.section_id = s.section_id
        INNER JOIN
            department d ON s.department_id = d.department_id
        INNER JOIN 
            division dv ON d.division_id = dv.division_id
        INNER JOIN
            location l ON dv.location_id = l.location_id
        INNER JOIN
            company c ON l.company_id = c.company_id
        INNER JOIN
            organization o ON c.organization_id = o.organization_id
        INNER JOIN
            sub_business sb ON o.sub_business_id = sb.sub_business_id
        INNER JOIN
            business b on sb.business_id = b.business_id
        WHERE 
            {$sqlConditions_actual}
        ";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

$totalAttendanceHours = $row['totalAttendanceHours'] ?? 0;


//query จำนวนคนทำงานในแต่ละเดือน
$sql = "SELECT 
            YEAR(otr.date_start) AS otYear,
            MONTH(otr.date_start) AS otMonth,
            cc.cost_center_id AS costCenterId,
            COUNT(otr.card_id) AS totalEmployees
        FROM 
            ot_record otr
        INNER JOIN 
            employee e ON otr.card_id = e.card_id
        INNER JOIN 
            cost_center cc ON e.cost_center_payment_id = cc.cost_center_id
        INNER JOIN 
            section s ON cc.section_id = s.section_id
        INNER JOIN
            department d ON s.department_id = d.department_id
        INNER JOIN 
            division dv ON d.division_id = dv.division_id
        INNER JOIN
            location l ON dv.location_id = l.location_id
        INNER JOIN
            company c ON l.company_id = c.company_id
        INNER JOIN
            organization o ON c.organization_id = o.organization_id
        INNER JOIN
            sub_business sb ON o.sub_business_id = sb.sub_business_id
        INNER JOIN
            business b on sb.business_id = b.business_id
        
        WHERE 
            {$sqlConditions_actual}
        GROUP BY 
            YEAR(otr.date_start), 
            MONTH(otr.date_start), 
            cc.cost_center_id";


$result = sqlsrv_query($conn, $sql);
$monthlyOtData = [];

if ($result) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $year = $row['otYear'];
        $month = $row['otMonth'];
        $costCenterId = $row['costCenterId'];
        $totalEmployees = $row['totalEmployees'];

        // กำหนดค่าให้กับ array
        $monthlyOtData[$year][$month][$costCenterId] = $totalEmployees;
    }
}

$totalEmployeesSum = 0;
foreach ($monthlyOtData as $year => $months) {
    foreach ($months as $month => $costCenters) {
        foreach ($costCenters as $costCenterId => $totalEmployees) {
            $totalEmployeesSum += $totalEmployees;
        }
    }
}

// foreach ($monthlyOtData as $year => $months) {
//     foreach ($months as $month => $costCenters) {
//         foreach ($costCenters as $costCenterId => $totalEmployees) {
//             echo "Year: " . $year . ", Month: " . $month . ", Cost Center ID: " . $costCenterId . ", Total Employees: " . $totalEmployees . "<br>";
//         }
//     }
// }



//query working day
$sql = "SELECT 
            op.year AS PlanYear,
            op.month AS PlanMonth,
            op.cost_center_id AS costCenterId,
            op.working_day AS WorkingDay
        FROM 
            ot_plan op
        INNER JOIN 
            cost_center cc ON op.cost_center_id = cc.cost_center_id
        INNER JOIN 
            section s ON cc.section_id = s.section_id 
        INNER JOIN
            department d ON s.department_id = d.department_id
        INNER JOIN 
            division dv ON d.division_id = dv.division_id 
            INNER JOIN
            location l ON dv.location_id = l.location_id
        INNER JOIN
            company c ON l.company_id = c.company_id
        INNER JOIN
            organization o ON c.organization_id = o.organization_id
        INNER JOIN
            sub_business sb ON o.sub_business_id = sb.sub_business_id
        INNER JOIN
            business b on sb.business_id = b.business_id
        WHERE 
         {$sqlConditions_plan}";

$result = sqlsrv_query($conn, $sql);
$WorkingDay = [];

if ($result) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $plan_year = $row['PlanYear'];
        $plan_month = $row['PlanMonth'];
        $plan_costCenterId = $row['costCenterId'];
        $plan_workingday = $row['WorkingDay'];

        // กำหนดค่าให้กับ array
        $WorkingDay[$plan_year][$plan_month][$plan_costCenterId] = $plan_workingday;
    }
}

$for_percentage_actual = [];
foreach ($monthlyOtData as $year => $months) {
    foreach ($months as $month => $costCentersData) {
        foreach ($costCentersData as $costCenterId => $totalEmployees) {
            // ตรวจสอบว่ามีข้อมูล working day สำหรับ cost center นี้ในเดือนและปีเดียวกันหรือไม่
            if (isset($WorkingDay[$year][$month][$costCenterId])) {
                $workingDays = $WorkingDay[$year][$month][$costCenterId];
                // คำนวณชั่วโมง OT โดยการคูณจำนวนพนักงานด้วยจำนวนวันทำงาน
                $for_percentage_actual[$year][$month][$costCenterId] = $totalEmployees * $workingDays * 8;
            } else {
                // หากไม่มีข้อมูล working day, กำหนดค่าเป็น 0
                $for_percentage_actual[$year][$month][$costCenterId] = 0;
            }
        }
    }
}

$totalOtHoursSum = 0;
foreach ($for_percentage_actual as $year => $months) {
    foreach ($months as $month => $costCentersData) {
        foreach ($costCentersData as $costCenterId => $hours) {
            $totalOtHoursSum += $hours; // บวกผลรวมของชั่วโมง OT สำหรับทุก cost center
        }
    }
}

if ($totalOtHoursSum != 0) { 
    $percentage_actual = ($totalAttendanceHours / $totalOtHoursSum) * 100;
} else {
    $percentage_actual = 0; 
}

$diff_percentage_plan_actual = $percentage_plan - $percentage_actual; 

if ($percentage_plan > $percentage_actual){
    $colorClass = '#09B39D';
} else {
    $colorClass = '#F06549';
}

?>
