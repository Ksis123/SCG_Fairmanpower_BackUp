<?php
//session_start();
// require_once('C:\xampp\htdocs\dashboard analytics\config\connection.php');
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

$currentYear = date('Y');
$filterData = $_SESSION['filter'] ?? null;
$sqlConditions_plan = "year = '{$currentYear}'"; // เงื่อนไขเริ่มต้นคือข้อมูลของปีปัจจุบัน
// $sqlConditions_actual = "date_start BETWEEN '{$filterData['startMonthDate']}' AND '{$filterData['endMonthDateCurrent']}'";
$currentYear = date('Y'); // ปีปัจจุบัน
$startYear = $currentYear . '-01-01'; // วันที่ 1 มกราคมของปีปัจจุบัน
$currentDate = date('Y-m-d'); // วันที่ปัจจุบัน

$sqlConditions_actual = "date_start BETWEEN '{$startYear}' AND '{$currentDate}'";

if ($filterData) {
    if (!empty($filterData['startYear']) && !empty($filterData['endYearDecember'])) {
        $sqlConditions_plan = "year BETWEEN '{$filterData['startYear']}' AND '{$filterData['endYearDecember']}'";
    }

    if (!empty($filterData['startMonth']) && !empty($filterData['endMonthDecember'])) {
        $sqlConditions_plan .= " AND month BETWEEN '{$filterData['startMonth']}' AND '{$filterData['endMonthDecember']}'";
    }

    if (!empty($filterData['sectionId'])) {
        $sqlConditions_plan .= " AND cc.section_id = '{$filterData['sectionId']}'";
    } elseif (!empty($filterData['departmentId'])) {
        $sqlConditions_plan .= " AND s.department_id = '{$filterData['departmentId']}'";
    } elseif (!empty($filterData['divisionId'])) {
        $sqlConditions_plan .= " AND d.division_id = '{$filterData['divisionId']}'";
    } elseif (!empty($filterData['locationId'])) {
        $sqlConditions_plan .= " AND dv.location_id = '{$filterData['locationId']}'";
    } elseif (!empty($filterData['companyId'])) {
        $sqlConditions_plan .= " AND l.company_id = '{$filterData['companyId']}'";
    } elseif (!empty($filterData['organizationId'])) {
        $sqlConditions_plan .= " AND c.organization_id = '{$filterData['organizationId']}'";
    } elseif (!empty($filterData['sub_businessId'])) {
        $sqlConditions_plan .= " AND o.sub_business_id = '{$filterData['sub_businessId']}'";
    } elseif (!empty($filterData['businessId'])) {
        $sqlConditions_plan .= " AND sb.business_id = '{$filterData['businessId']}'";
    }
}

$sql = "SELECT 
            otp.[year] AS PlanOT_Year,
            otp.[month] AS PlanOT_Month,
            otp.sum_fix AS Plan_FIX,
            otp.nonfix AS Plan_NONFIX
        FROM 
            ot_plan as otp
        INNER JOIN 
            cost_center as cc ON otp.cost_center_id = cc.cost_center_id
        INNER JOIN 
            section as s ON cc.section_id = s.section_id
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
$PlanOtData = [];

if ($result) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $year = $row['PlanOT_Year'];
        $month = $row['PlanOT_Month'];
        $sum_fix = $row['Plan_FIX'];
        $sum_nonfix = $row['Plan_NONFIX'];

        // ตรวจสอบว่า key สำหรับปีและเดือนนั้นมีอยู่แล้วหรือไม่ ถ้าไม่มีก็สร้างขึ้น
        if (!isset($PlanOtData[$year])) {
            $PlanOtData[$year] = [];
        }
        if (!isset($PlanOtData[$year][$month])) {
            $PlanOtData[$year][$month] = ['Plan_FIX' => 0, 'Plan_NONFIX' => 0];
        }

        // เพิ่มค่าชั่วโมงที่วางแผนลงใน array
        $PlanOtData[$year][$month]['Plan_FIX'] += $sum_fix;
        $PlanOtData[$year][$month]['Plan_NONFIX'] += $sum_nonfix;
    }
}


//query ชั่วโมงทำงานจริงแบ่งตามเดือน
if ($filterData) {

    if (!empty($filterData['startMonthDate']) && !empty($filterData['endMonthDateCurrent'])) {
        $sqlConditions_actual = "date_start BETWEEN '{$filterData['startMonthDate']}' AND '{$filterData['endMonthDateCurrent']}'";

    }
    if (!empty($filterData['sectionId'])) {
        $sqlConditions_actual .= " AND cc.section_id = '{$filterData['sectionId']}'";
    } elseif (!empty($filterData['departmentId'])) {
        $sqlConditions_actual .= " AND s.department_id = '{$filterData['departmentId']}'";
    } elseif (!empty($filterData['divisionId'])) {
        $sqlConditions_actual .= " AND d.division_id = '{$filterData['divisionId']}'";
    } elseif (!empty($filterData['locationId'])) {
        $sqlConditions_actual .= " AND dv.location_id = '{$filterData['locationId']}'";
    } elseif (!empty($filterData['companyId'])) {
        $sqlConditions_actual .= " AND l.company_id = '{$filterData['companyId']}'";
    } elseif (!empty($filterData['organizationId'])) {
        $sqlConditions_actual .= " AND c.organization_id = '{$filterData['organizationId']}'";
    } elseif (!empty($filterData['sub_businessId'])) {
        $sqlConditions_actual .= " AND o.sub_business_id = '{$filterData['sub_businessId']}'";
    } elseif (!empty($filterData['businessId'])) {
        $sqlConditions_actual .= " AND sb.business_id = '{$filterData['businessId']}'";
    }
}

$sql = "SELECT 
            YEAR(otr.date_start) AS ActualOT_Year,
            MONTH(otr.date_start) AS ActualOT_Month,
            ott.type_fix_nonfix,
            sum(otr.attendance_hours) AS SUM_HOURS
        FROM 
            ot_record as otr
        INNER JOIN 
            ot_type as ott ON otr.ot_type_id = ott.ot_type_id
        INNER JOIN 
            employee as e ON otr.card_id = e.card_id
        INNER JOIN 
            cost_center as cc ON e.cost_center_payment_id = cc.cost_center_id
        INNER JOIN 
            section as s ON cc.section_id = s.section_id
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
                ott.type_fix_nonfix
                ";

// $stmt = sqlsrv_query($conn, $sql);
// if ($stmt === false) {
//     die(print_r(sqlsrv_errors(), true));
// }
// $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// $ActualOtData = [];
// while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
//     $year = $row['ActualOT_Year'];
//     $month = $row['ActualOT_Month'];
//     $type = $row['type_fix_nonfix'];
//     $hours = $row['SUM_HOURS'];

//     // ตรวจสอบและสร้าง array ถ้ายังไม่มี
//     if (!isset($ActualOtData[$year])) {
//         $ActualOtData[$year] = [];
//     }
//     if (!isset($ActualOtData[$year][$month])) {
//         $ActualOtData[$year][$month] = ['FIX' => 0, 'NONFIX' => 0];
//     }

//     // สะสมข้อมูลจำนวนชั่วโมงตามประเภท OT
//     if ($type === 'FIX') {
//         $ActualOtData[$year][$month]['FIX'] += $hours;
//     } else if ($type === 'NONFIX') {
//         $ActualOtData[$year][$month]['NONFIX'] += $hours;
//     }
// }
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$ActualOtData = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $year = $row['ActualOT_Year'];
    $month = $row['ActualOT_Month'];
    $type = $row['type_fix_nonfix'];
    $hours = $row['SUM_HOURS'];

    if (!isset($ActualOtData[$year])) {
        $ActualOtData[$year] = [];
    }
    if (!isset($ActualOtData[$year][$month])) {
        $ActualOtData[$year][$month] = ['FIX' => 0, 'NONFIX' => 0];
    }

    // สะสมข้อมูลจำนวนชั่วโมงตามประเภท OT
    if ($type === 'FIX') {
        $ActualOtData[$year][$month]['FIX'] += $hours;
    } else if ($type === 'NONFIX') {
        $ActualOtData[$year][$month]['NONFIX'] += $hours;
    }
}


// foreach ($ActualOtData as $year => $months) {
//     foreach ($months as $month => $data) {
//         echo "Year: $year, Month: $month, Actual FIX: {$data['FIX']}, Actual NONFIX: {$data['NONFIX']}<br>";
//     }
// }

$planJson = json_encode($PlanOtData);
$actualJson = json_encode($ActualOtData);
?>

<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {
            var planData = JSON.parse('<?php echo $planJson; ?>');
            var actualData = JSON.parse('<?php echo $actualJson; ?>');

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'เดือน');
            data.addColumn('number', 'วางแผน FIX');
            data.addColumn('number', 'วางแผน NONFIX');
            data.addColumn('number', 'จริง FIX');
            data.addColumn('number', 'จริง NONFIX');

            for (var year in planData) {
                for (var month in planData[year]) {
                    var planFix = planData[year][month]['Plan_FIX'] || 0;
                    var planNonFix = planData[year][month]['Plan_NONFIX'] || 0;
                    var actualFix = actualData[year] && actualData[year][month] ? actualData[year][month]['FIX'] : 0;
                    var actualNonFix = actualData[year] && actualData[year][month] ? actualData[year][month]['NONFIX'] : 0;
                    data.addRow([month, planFix, planNonFix, actualFix, actualNonFix]);
                }
            }

            var options = {
                title: 'แนวโน้มการวางแผน OT',
                vAxis: {
                    title: 'ชั่วโมง',
                    textStyle: { color: 'white' } // กำหนดสีข้อความของแกน Y
                },
                hAxis: {
                    title: 'เดือน',
                    textStyle: { color: 'white' } // กำหนดสีข้อความของแกน X
                },
                seriesType: 'bars',
                series: {
                    0: { color: '#0BF8DF' }, // สีแท่งกราฟสำหรับ 'วางแผน FIX'
                    1: { color: '#15928E' }, // สีแท่งกราฟสำหรับ 'วางแผน NONFIX'
                    2: { color: '#E5AC61', type: 'line' }, // สีกราฟเส้นสำหรับ 'จริง FIX'
                    3: { color: '#EE943A', type: 'line' } // สีกราฟเส้นสำหรับ 'จริง NONFIX'
                },
                titleTextStyle: {
                    color: 'white', // กำหนดสีหัวข้อของกราฟ
                    fontSize: 16,
                    bold: true
                },
                legend: { 
                    textStyle: { color: 'white' } // กำหนดสีข้อความของ legend
                },
                backgroundColor: '#1C1D3A', // สีพื้นหลังของกราฟ
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

    </script>
</head>

<body>
    <!-- <div class="col" style="padding: 0; margin-right: 30px;">
        <div style="border: 2px solid #3E4080; box-shadow: 2px 4px 5px #3E4080;">
            <div id="chart_div" style="width: 100%; height:300px;"></div>
        </div>
    </div> -->
    <div id="chart_div" style="border: 2px solid #3E4080; box-shadow: 2px 4px 5px #3E4080; width: 100%; height: 100%;"></div>

</body>

</html>