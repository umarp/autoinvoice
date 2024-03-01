<!doctype html>
<html lang="en">

<head>
    <?php require_once("main/head.php") ?>
</head>

<body id="body-pd">


    <?php
    require_once("main/header.php");
    ?>
    <!--Container Main start-->
    <div class="container">

        <h1 class="mt-5">Dashboard</h1>
        <div class="row">
            <div class="col-6">
                <div id="piechart"></div>
            </div>
            <div class="col-6">
                <div id="piechart1"></div>
            </div>
        </div>
        <div class="row mt-4">
            <div id="columnchart_values">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4">
                <div class="dashboard-box">
                    <h2>Number of Invoice Generated</h2>
                    <h4>5</h4>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-box">
                    <h2>Number of Purchase Order Generated</h2>
                    <h4>3</h4>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-box">
                    <h2>Number of Delivery Note Generated</h2>
                    <h4>1</h4>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-box">
                    <h2>Invoice Generated this month</h2>
                    <h4>12</h4>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-box">
                    <h2>Purchase Order Generated this month</h2>
                    <h4>23</h4>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-box">
                    <h2>Delivery Note Generated this month</h2>
                    <h4>22</h4>
                </div>
            </div>
        </div>

    </div>

    <?php
    $stmt1 = $conn->prepare("SELECT count(*) as total_po FROM purchase_order");
    $stmt1->execute();
    $po = $stmt1->fetch(PDO::FETCH_ASSOC);
    $totalpo = $po['total_po'];

    $stmt2 = $conn->prepare("SELECT count(*) as total_invoice FROM purchase_order");
    $stmt2->execute();
    $invoice = $stmt2->fetch(PDO::FETCH_ASSOC);
    $totali = $invoice['total_invoice'];

    $stmt3 = $conn->prepare("SELECT count(*) as total_dn FROM delivery_note");
    $stmt3->execute();
    $dn = $stmt3->fetch(PDO::FETCH_ASSOC);
    $totaldn = $dn['total_dn'];


    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Number', 'Hours per Day'],
                ['Purchase Order', 11],
                ['Invoice', 2],
                ['Delivery Note', 2]
            ]);

            var options = {
                title: 'Number of documents Issued'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
        function drawChart1() {

            var data1 = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Work', 11],
                ['Eat', 2],
                ['Commute', 2],
                ['Watch TV', 2],
                ['Sleep', 7]
            ]);

            var options1 = {
                title: 'My Daily Activities'
            };

            var chart1 = new google.visualization.PieChart(document.getElementById('piechart1'));

            chart1.draw(data1, options1);
        }


        google.charts.setOnLoadCallback(drawChart2);
        function drawChart2() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", { role: "style" }],
                ["Copper", 8.94, "#b87333"],
                ["Silver", 10.49, "silver"],
                ["Gold", 19.30, "gold"],
                ["Platinum", 21.45, "color: #e5e4e2"]
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2]);

            var options3 = {
                title: "Number of documents generated per supplier/customer",

                height: 400,
                bar: { groupWidth: "95%" },
                legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options3);
        }

    </script>
</body>

</html>