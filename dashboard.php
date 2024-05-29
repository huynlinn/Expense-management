<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid'] == 0)) {
    header('location:logout.php');
} else {
?>
<?php
    session_start();
    error_reporting(0);
    include('includes/dbconnection.php');
    $query = "SELECT * FROM tblexpense";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    ?>
<?php
    $userid = $_SESSION['detsuid'];
    $array_per = array();
    $array_cat = array();
    $monthdate = date("Y-m-d", strtotime("-1 month"));
    $crrntdte = date("Y-m-d");
    $query_2 = mysqli_query($con, "SELECt c.id_categories as 'cat_id',c.name as 'cat_name', SUM(e.ExpenseCost) AS 'Percent' FROM tblexpense e JOIN tblcategories c ON e.id_categories = c.id_categories WHERE e.UserId ='$userid' GROUP BY c.id_categories; ");

    //Truy vấn lúc đầu 
    // SELECt c.id_categories as 'cat_id',c.name as 'cat_name', SUM(e.ExpenseCost)*100/(SELECT SUM(ExpenseCost) 
    // FROM tblexpense WHERE UserId = '$userid') AS 'Percent'
    // FROM tblexpense e JOIN tblcategories c ON e.id_categories = c.id_categories
    // WHERE e.UserId = '$userid' and ((ExpenseDate) between '$monthdate' and '$crrntdte')
    // GROUP BY c.id_categories;
    $result_2 = mysqli_fetch_array($query_2);
    $array_per[] = $result_2['Percent'];
    $array_cat[] = $result_2['cat_name'];

    while ($row = mysqli_fetch_array($query_2)) {
        $array_per[] = $row['Percent'];
        $array_cat[] = $row['cat_name'];
    }
    // echo json_encode($array_per);
    // echo json_encode($array_cat);
    // echo json_encode(sizeof($array_per));
    $json_array_per = json_encode($array_per);
    $json_array_cat = json_encode($array_cat);
    ?>

<?php
    //--------Tinh tien trong tuan
    $pastdate = date("Y-m-d", strtotime("-1 week"));
    $crrntdte = date("Y-m-d");
    $userid = $_SESSION['detsuid'];
    $array_per_week = array();
    $array_cat_week = array();
    $monthdate = date("Y-m-d", strtotime("-1 month"));
    $crrntdte = date("Y-m-d");
    $query_3 = mysqli_query($con, "SELECt c.id_categories as 'cat_id',c.name as 'cat_name', SUM(e.ExpenseCost) AS 'Percent' FROM tblexpense e JOIN tblcategories c ON e.id_categories = c.id_categories
                 WHERE e.UserId ='$userid' and  ((ExpenseDate) between '$pastdate' and '$crrntdte') GROUP BY c.id_categories; ");

    $result_3 = mysqli_fetch_array($query_3);
    $array_per_week[] = $result_3['Percent'];
    $array_cat_week[] = $result_3['cat_name'];

    while ($row = mysqli_fetch_array($query_3)) {
        $array_per_week[] = $row['Percent'];
        $array_cat_week[] = $row['cat_name'];
    }

    $json_array_per_week = json_encode($array_per_week);
    $json_array_cat_week = json_encode($array_cat_week);
    ?>

<?php
    //--------Tinh tien trong ngay
    $tdate = date('Y-m-d');

    $userid = $_SESSION['detsuid'];
    $array_per_day = array();
    $array_cat_day = array();

    $query_4 = mysqli_query($con, "SELECt c.id_categories as 'cat_id',c.name as 'cat_name', SUM(e.ExpenseCost) AS 'Percent' FROM tblexpense e JOIN tblcategories c ON e.id_categories = c.id_categories
                 WHERE e.UserId ='$userid' and (ExpenseDate)='$tdate'  GROUP BY c.id_categories; ");

    $result_4 = mysqli_fetch_array($query_4);
    $array_per_day[] = $result_4['Percent'];
    $array_cat_day[] = $result_4['cat_name'];

    while ($row = mysqli_fetch_array($query_4)) {
        $array_per_day[] = $row['Percent'];
        $array_cat_day[] = $row['cat_name'];
    }

    $json_array_per_day = json_encode($array_per_day);
    $json_array_cat_day = json_encode($array_cat_day);
    ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Expense Tracker - Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div>
        <!--/.row-->




        <div class="row">
            <div class="col-xs-6 col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <?php
                            //Today Expense
                            $userid = $_SESSION['detsuid'];
                            $tdate = date('Y-m-d');
                            $query = mysqli_query($con, "select sum(ExpenseCost)  as todaysexpense from tblexpense where (ExpenseDate)='$tdate' && (UserId='$userid');");
                            $result = mysqli_fetch_array($query);
                            $sum_today_expense = $result['todaysexpense'];
                            ?>

                        <h4>Today's Expense</h4>
                        <div class="easypiechart" id="easypiechart-blue"
                            data-percent="<?php echo $sum_today_expense; ?>">
                            <span class="percent">
                                <?php if ($sum_today_expense == "") {
                                        echo "0";
                                    } else {
                                        echo $sum_today_expense;
                                    }

                                    ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <?php
                        //Yestreday Expense
                        $userid = $_SESSION['detsuid'];
                        $ydate = date('Y-m-d', strtotime("-1 days"));
                        $query1 = mysqli_query($con, "select sum(ExpenseCost)  as yesterdayexpense from tblexpense where (ExpenseDate)='$ydate' && (UserId='$userid');");
                        $result1 = mysqli_fetch_array($query1);
                        $sum_yesterday_expense = $result1['yesterdayexpense'];
                        ?>
                    <div class="panel-body easypiechart-panel">
                        <h4>Yesterday's Expense</h4>
                        <div class="easypiechart" id="easypiechart-orange"
                            data-percent="<?php echo $sum_yesterday_expense; ?>"><span class="percent">
                                <?php if ($sum_yesterday_expense == "") {
                                        echo "0";
                                    } else {
                                        echo $sum_yesterday_expense;
                                    }

                                    ?>
                            </span></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <?php
                        //Weekly Expense
                        $userid = $_SESSION['detsuid'];
                        $pastdate = date("Y-m-d", strtotime("-1 week"));
                        $crrntdte = date("Y-m-d");
                        $query2 = mysqli_query($con, "select sum(ExpenseCost)  as weeklyexpense from tblexpense where ((ExpenseDate) between '$pastdate' and '$crrntdte') && (UserId='$userid');");
                        $result2 = mysqli_fetch_array($query2);
                        $sum_weekly_expense = $result2['weeklyexpense'];
                        ?>
                    <div class="panel-body easypiechart-panel">
                        <h4>Last 7day's Expense</h4>
                        <div class="easypiechart" id="easypiechart-teal"
                            data-percent="<?php echo $sum_weekly_expense; ?>"><span class="percent">
                                <?php if ($sum_weekly_expense == "") {
                                        echo "0";
                                    } else {
                                        echo $sum_weekly_expense;
                                    }

                                    ?>
                            </span></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <?php
                        //Monthly Expense
                        $userid = $_SESSION['detsuid'];
                        $monthdate = date("Y-m-d", strtotime("-1 month"));
                        $crrntdte = date("Y-m-d");
                        $query3 = mysqli_query($con, "select sum(ExpenseCost)  as monthlyexpense from tblexpense where ((ExpenseDate) between '$monthdate' and '$crrntdte') && (UserId='$userid');");
                        $result3 = mysqli_fetch_array($query3);
                        $sum_monthly_expense = $result3['monthlyexpense'];
                        ?>
                    <div class="panel-body easypiechart-panel">
                        <h4>Last 30day's Expenses</h4>
                        <div class="easypiechart" id="easypiechart-red"
                            data-percent="<?php echo $sum_monthly_expense; ?>"><span class="percent">
                                <?php if ($sum_monthly_expense == "") {
                                        echo "0";
                                    } else {
                                        echo $sum_monthly_expense;
                                    }

                                    ?>
                            </span></div>
                    </div>
                </div>
            </div>

        </div>
        <!--/.row-->
        <div class="row">
            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <?php
                        //Yearly Expense
                        $userid = $_SESSION['detsuid'];
                        $cyear = date("Y");
                        $query4 = mysqli_query($con, "select sum(ExpenseCost)  as yearlyexpense from tblexpense where (year(ExpenseDate)='$cyear') && (UserId='$userid');");
                        $result4 = mysqli_fetch_array($query4);
                        $sum_yearly_expense = $result4['yearlyexpense'];
                        ?>
                    <div class="panel-body easypiechart-panel">
                        <h4>Current Year Expenses</h4>
                        <div class="easypiechart" id="easypiechart-red"
                            data-percent="<?php echo $sum_yearly_expense; ?>"><span class="percent">
                                <?php if ($sum_yearly_expense == "") {
                                        echo "0";
                                    } else {
                                        echo $sum_yearly_expense;
                                    }

                                    ?>
                            </span></div>


                    </div>

                </div>

            </div>

            <div class="col-xs-6 col-md-3">
                <div class="panel panel-default">
                    <?php
                        //Yearly Expense
                        $userid = $_SESSION['detsuid'];
                        $query5 = mysqli_query($con, "select sum(ExpenseCost)  as totalexpense from tblexpense where UserId='$userid';");
                        $result5 = mysqli_fetch_array($query5);
                        $sum_total_expense = $result5['totalexpense'];
                        ?>
                    <div class="panel-body easypiechart-panel">
                        <h4>Total Expenses</h4>
                        <div class="easypiechart" id="easypiechart-red"
                            data-percent="<?php echo $sum_total_expense; ?>"><span class="percent">
                                <?php if ($sum_total_expense == "") {
                                        echo "0";
                                    } else {
                                        echo $sum_total_expense;
                                    }

                                    ?>
                            </span></div>


                    </div>

                </div>

            </div>





        </div>

        <!--/.row-->
        <div class="row">
            <div id="bentrai" style="float:left;width:50%">
                <canvas id="myChart" style="width:100%;max-width:700px"></canvas>

            </div>
            <div id="benphai" style="float:right;width:50%">
                <canvas id="myChart1" style="width:100%;max-width:600px"></canvas>

            </div>

        </div>
        <div class="row">

        </div>
    </div>
    <!--/.main-->
    <?php include_once('includes/footer.php'); ?>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/new_chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
    <script>
    window.onload = function() {
        var chart1 = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(chart1).Line(lineChartData, {
            responsive: true,
            scaleLineColor: "rgba(0,0,0,.2)",
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleFontColor: "#c5c7cc"
        });
    };
    </script>


    <script>
    var percent_data = <?php echo $json_array_per_day; ?>;
    var percen_cat = <?php echo $json_array_cat_day; ?>;
    console.log(percen_cat);

    var xValues = percen_cat;
    var yValues = percent_data;
    var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];

    new Chart("myChart", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "Total Cost in Today"
            }
        }
    });
    </script>
    <script>
    var percent_data = <?php echo $json_array_per_week; ?>;
    var percen_cat = <?php echo $json_array_cat_week; ?>;
    console.log(percen_cat);

    var xValues = percen_cat;
    var yValues = percent_data;
    var barColors = ["red", "green", "blue", "orange", "brown"];

    new Chart("myChart1", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "Total Cost in this Week"
            }
        }
    });
    </script>
</body>

</html>
<?php } ?>