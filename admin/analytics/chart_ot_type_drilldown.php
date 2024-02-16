<?php
//session_start();
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

$currentYear = date('Y');
$filterData = $_SESSION['filter'] ?? null;
$currentYear = date('Y'); // ปีปัจจุบัน
$startYear = $currentYear . '-01-01'; // วันที่ 1 มกราคมของปีปัจจุบัน
$currentDate = date('Y-m-d'); // วันที่ปัจจุบัน

$sqlConditions_actual = "date_start BETWEEN '{$startYear}' AND '{$currentDate}'";


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
            ott.type_fix_nonfix AS TYPE_OT,
            ott.name AS NAME_OT,
            SUM(otr.attendance_hours) AS SUM_HOURS
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
            $sqlConditions_actual
        GROUP BY 
            ott.type_fix_nonfix,
            ott.name";

$result = sqlsrv_query($conn, $sql);

$ot_data = [];
if ($result) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $type = $row['TYPE_OT'];
        $name = $row['NAME_OT'];
        $totalHours = $row['SUM_HOURS'];

        // สะสมข้อมูลสำหรับแผนภูมิ
        if (!isset($ot_data[$type])) {
            $ot_data[$type] = [
                'total_hours' => 0,
                'details' => []
            ];
        }
        $ot_data[$type]['total_hours'] += $totalHours;
        $ot_data[$type]['details'][$name] = $totalHours;
    }
}

$ot_data_json = json_encode($ot_data);
?>

<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var chart; // Global variable for the chart
        var data; // Global variable for the chart data
        var ot_data = JSON.parse('<?php echo $ot_data_json; ?>'); // ข้อมูล OT ในรูปแบบ JSON

        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawDonutChart);

        function drawDonutChart() {
            data = new google.visualization.DataTable();
            data.addColumn('string', 'OT Type');
            data.addColumn('number', 'Hours');

            for (var type in ot_data) {
                if (ot_data.hasOwnProperty(type)) {
                    data.addRow([type, ot_data[type]['total_hours']]);
                }
            }

            var options = {
                title: 'Proportion Of Actual OT',
                pieHole: 0.4,
                colors: ['#0BF8DF', '#15928E'], // ตั้งค่าสีตามต้องการ
                width: '100%',
                height: 300, // ปรับขนาดความสูงตามที่ต้องการ
                chartArea: {
                    width: '70%', // ตั้งค่าความกว้างของพื้นที่กราฟ
                    height: '70%' // ตั้งค่าความสูงของพื้นที่กราฟ
                },
                legend: {
                    position: 'bottom', // ตั้งค่าตำแหน่งของ legend
                    textStyle: {
                        color: 'white', // ตั้งค่าสีของตัวอักษร
                        fontSize: 10 // ตั้งค่าขนาดของตัวอักษร
                    }
                },
                backgroundColor: '#1C1D3A', // ตั้งค่าสีพื้นหลังของกราฟ
                titleTextStyle: {
                    color: 'white', // ตั้งค่าสีของหัวข้อ
                    fontSize: 14, // ตั้งค่าขนาดของหัวข้อ
                    bold: true // ตั้งค่าหัวข้อให้เป็นตัวหนา
                },
                pieSliceText: 'both', // แสดงทั้งค่าจริงและเปอร์เซ็นต์
                pieSliceTextStyle: {
                    color: '#1C1D3A', // ตั้งค่าสีของตัวเลขและเปอร์เซ็นต์ที่แสดงบนชิ้นส่วน
                    fontSize: 11, // ตั้งค่าขนาดของตัวอักษร
                    bold: true // ตั้งค่าให้ข้อความเป็นตัวหนา
                },
                tooltip: {
                    text: 'value' // ตั้งค่าให้ tooltip แสดงค่า
                },


            };

            chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);

            google.visualization.events.addListener(chart, 'select', selectHandler);
            if (ot_data.hasOwnProperty('FIX')) {
                drawDetailChart('FIX', ot_data['FIX']['details']);
            }
        }

        function selectHandler() {
            var selectedItem = chart.getSelection()[0];
            if (selectedItem) {
                var type = data.getValue(selectedItem.row, 0);
                drawDetailChart(type, ot_data[type]['details']);
            }
        }

        function drawDetailChart(type, details) {
            var detailData = new google.visualization.DataTable();
            detailData.addColumn('string', 'OT Name');
            detailData.addColumn('number', 'Hours');

            for (var name in details) {
                if (details.hasOwnProperty(name)) {
                    // ตรวจสอบและแปลงค่าเป็นตัวเลข
                    var hours = parseFloat(details[name]);
                    if (!isNaN(hours)) {
                        detailData.addRow([name, hours]);
                    }
                }
            }

            var options = {
                title: 'Detail Hours for ' + type,
                pieHole: 0.4,
                colors: ['#92B5B6', '#004A4F', '#199BA7', '#15323A', '#F39D82', '#C7D090',
                         '#D4C0B2', '#376C66', '#A2C99F', '#DDA4A5', '#065C76'], // ตั้งค่าสีตามต้องการ
                pieHole: 0.4,
                width: '100%',
                height: 300, // ปรับขนาดความสูงตามที่ต้องการ
                chartArea: {
                    width: '70%', // ตั้งค่าความกว้างของพื้นที่กราฟ
                    height: '70%' // ตั้งค่าความสูงของพื้นที่กราฟ
                },
                legend: {
                    position: 'bottom', // ตั้งค่าตำแหน่งของ legend
                    textStyle: {
                        color: 'white', // ตั้งค่าสีของตัวอักษร
                        fontSize: 10 // ตั้งค่าขนาดของตัวอักษร
                    }
                },
                backgroundColor: '#1C1D3A', // ตั้งค่าสีพื้นหลังของกราฟ
                titleTextStyle: {
                    color: 'white', // ตั้งค่าสีของหัวข้อ
                    fontSize: 14, // ตั้งค่าขนาดของหัวข้อ
                    bold: true // ตั้งค่าหัวข้อให้เป็นตัวหนา
                },
                pieSliceText: 'both', // แสดงทั้งค่าจริงและเปอร์เซ็นต์
                pieSliceTextStyle: {
                    color: 'white', // ตั้งค่าสีของตัวเลขและเปอร์เซ็นต์ที่แสดงบนชิ้นส่วน
                    fontSize: 11, // ตั้งค่าขนาดของตัวอักษร
                    bold: true // ตั้งค่าให้ข้อความเป็นตัวหนา
                },
                tooltip: {
                    text: 'value' // ตั้งค่าให้ tooltip แสดงค่า
                },
            };

            var detailChart = new google.visualization.PieChart(document.getElementById('detailchart'));
            detailChart.draw(detailData, options);
        }
    </script>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-5" style="padding: 0; margin: 5px;">
                <div style="border: 2px solid #3E4080; max-width: 400px; box-shadow: 2px 4px 5px #3E4080;">
                    <div id="donutchart" style="width: 100%;  height:300px;"></div>
                </div>
            </div>
            <div class="col-md-5" style="padding: 0; margin-left: 50px;">
                <div style="border: 2px solid #3E4080; box-shadow: 2px 4px 5px #3E4080;">
                    <div id="detailchart" style="width: 100%;  height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container">
        <div class="row">
            <div class="col-md-5" style="padding: 0; margin: 5px;">
                <div id="donutchart"
                    style="border: 2px solid #3E4080; box-shadow: 2px 4px 5px #3E4080; width: 100%; height: 100%;">
                </div>
                <div id="detailchart"
                    style="border: 2px solid #3E4080; box-shadow: 2px 4px 5px #3E4080; width: 100%; height: 100%;">
                </div>
            </div>
        </div>
    </div> -->
</body>

</html>