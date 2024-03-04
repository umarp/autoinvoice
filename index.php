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
    $userEmail = $_SESSION['userLogin'];

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

    $stmt4 = $conn->prepare("SELECT l.l_firstName, l.l_lastName, l.l_id AS user_id,
                            COUNT(po.po_user) AS num_purchase_orders,
                            COUNT(i.i_user) AS num_invoices,
                            COUNT(dn.d_user) AS num_delivery_notes
                        FROM login l
                        LEFT JOIN purchase_order po ON l.l_id = po.po_user
                        LEFT JOIN invoice i ON l.l_id = i.i_user
                        LEFT JOIN delivery_note dn ON l.l_id = dn.d_user
                        GROUP BY l.l_id");
    $stmt4->execute();
    $result4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
    // Format data for Google Chart
    $chart_data = array();
    foreach ($result4 as $row) {
        $chart_data[] = '["' . $row['l_firstName'] . ' ' . $row['l_lastName'] . '",' . $row['num_purchase_orders'] . ',' . $row['num_invoices'] . ',' . $row['num_delivery_notes'] . ']';
    }
    $json_data = implode(",", $chart_data);
    echo $json_data;

    //$userId = $_SESSION['userLogin'];
    $userId = 1;
    $stmt5 = $conn->prepare("SELECT 
                            COUNT(DISTINCT po.po_id) AS num_purchase_orders,
                            COUNT(DISTINCT i.i_id) AS num_invoices,
                            COUNT(DISTINCT dn.d_id) AS num_delivery_notes
                        FROM 
                            purchase_order po
                        LEFT JOIN 
                            invoice i ON po.po_user = i.i_user
                        LEFT JOIN 
                            delivery_note dn ON po.po_user = dn.d_user
                        WHERE 
                            po.po_user = :userId");
    $stmt5->bindParam(':userId', $userId);

    $stmt5->execute();
    $result5 = $stmt5->fetch(PDO::FETCH_ASSOC);

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
                ['Number', 'Documents'],
                ['Purchase Order', <?php echo $totalpo; ?>],
                ['Invoice', <?php echo $totali; ?>],
                ['Delivery Note', <?php echo $totaldn; ?>]
            ]);

            var options = {
                title: 'Number of documents Issued'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
        function drawChart1() {

            var data1 = google.visualization.arrayToDataTable(
                [
                    ['Document', 'Count'],
                    ['Purchase Orders', <?php echo $result5['num_purchase_orders']; ?>],
                    ['Invoices', <?php echo $result5['num_invoices']; ?>],
                    ['Delivery Notes', <?php echo $result5['num_delivery_notes']; ?>]
                ]
            );


            var options1 = {
                title: 'Documents Generated by User'

            };

            var chart1 = new google.visualization.PieChart(document.getElementById('piechart1'));

            chart1.draw(data1, options1);
        }


        google.charts.setOnLoadCallback(drawChart2);
        function drawChart2() {
            var data = google.visualization.arrayToDataTable([
                ['User', 'Purchase Orders', 'Invoices', 'Delivery Notes'],
                <?php echo $json_data; ?>
            ]);

            var view = new google.visualization.DataView(data);


            var options3 = {
                title: 'Number of Purchase Orders, Invoices, and Delivery Notes by User',
                height: 400,
                legend: { position: 'top', maxLines: 3 },
                bar: { groupWidth: '75%' },
                isStacked: true,
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options3);
        }

    </script>
</body>

</html>