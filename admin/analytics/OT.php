<?php
require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');
?>

<?php include('../analytics/include/header.php') ?>

<body>
<?php include('../analytics/include/navbar.php') ?>

    <?php include('../analytics/include/sidebar.php') ?>
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="card-box lower-box pd-20 mb-30" style="background-color: #eeeeee;  min-height: 1100px; border: 4px solid #3E4080;
                        border-radius: 15px; box-shadow: 10px 10px 8px #3E4080">

                <!-- หัวข้อรายงาน OT -->
                <div class="row mb-4">
                    <div class="col-3">
                        <h2 class="text-white bg-dark p-2" style="background-color: #1C1D3A ;text-align: center; border: 2px solid #3E4080;
                        border-radius: 15px; box-shadow: 10px 10px 10px #3E4080">รายงาน OT</h2>
                    </div>
                    <div class="col-4 justify-content-end">
                        <?php include('../analytics/filter.php') ?>
                    </div>
                </div>

                <!-- บัตรด้านบน -->
                <div  style="max-width: 1000px; width: auto; margin: auto; justify-content: center; display: flex; align-items: center;">
                    <div class="container-fluid" style="background-color: white; padding: 15px; margin-bottom: 20px; border: 2px solid #3E4080; border-radius: 15px; box-shadow: 5px 5px 5px #3E4080;">
                        <div class="row" style="justify-content: center;">
                            <div class="col-md-3 mb-5 d-flex">
                                <?php include('../analytics/chart_cal_percent.php') ?>
                                <div class="card custom-card text-white"
                                    style="background-color: #41446B; flex-grow: 1; border-radius: 15px; box-shadow: 2px 4px 5px #3E4080">
                                    <div class="card-header text-center"
                                        style="background-color: #313456; border-top-right-radius: 15px; border-top-left-radius: 15px;">
                                        Plan % Normal Time
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center"
                                        style="height: 70px;">
                                        <h5 class="card-title">
                                            <?php
                                            echo "<span style='font-size: 40px; color: white;'>" . number_format($percentage_plan, 2) . "%</span><br>";
                                            ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-5 d-flex">
                                <div class="card custom-card text-white"
                                    style="background-color: #41446B; flex-grow: 1; border-radius: 15px; box-shadow: 2px 4px 5px #3E4080">
                                    <div class="card-header text-center"
                                        style="background-color: #313456; border-top-right-radius: 15px; border-top-left-radius: 15px;">
                                        Actual % Normal Time
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center"
                                        style="height: 70px;">
                                        <h5 class="card-title">
                                            <?php
                                            echo "<span style='font-size: 40px; color: white;'>" . number_format($percentage_actual, 2) . "%</span><br>";
                                            ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-5 d-flex">
                                <div class="card custom-card text-white"
                                    style="background-color: #41446B ; flex-grow: 1; border-radius: 15px; box-shadow: 2px 4px 5px <?php echo $colorClass ?>">
                                    <div class="card-header text-center"
                                        style="background-color: #313456; border-top-right-radius: 15px; border-top-left-radius: 15px;">
                                        Percentage
                                        Difference
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center"
                                        style="height: 70px;">
                                        <h5 class="card-title">
                                            <?php
                                            echo "<span style='font-size: 40px; color: white;'>" . number_format($diff_percentage_plan_actual, 2) . "%</span><br>";
                                            ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- กราฟแนวโน้มการวางแผน OT -->
                <div class="row" style="padding-bottom: 15px;">
                    <!-- สัดส่วนของ OT จริง -->
                    <div class="col-md-6" >
                        <?php include('../analytics/chart_ot_type_drilldown.php'); ?>
                    </div>
                    
                    <div class="col-md-6" >
                        <?php include('../analytics/chart_planning_trend.php'); ?>
                    </div>
                </div>

                <!-- สัดส่วนของ OT จริงและค่าเฉลี่ย OT ต่อบุคคล -->
                <div class="row">
                    <!-- ค่าเฉลี่ย OT ต่อบุคคลจริง -->
                    <div class="col-md-6">
                        <?php include('../analytics/chart_ot_per_person.php'); ?>
                    </div>
                    <div class="col-md-6 pt-2">
                        <?php include('../analytics/chart_top5_emp.php'); ?>
                    </div>
                </div>

            </div>
        </div>
        <?php include('../analytics/include/footer.php'); ?>
    </div>

    <!-- js -->
    <?php include('../../admin/include/scripts.php') ?>
</body>

</html>