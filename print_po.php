<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4'
]);

require_once("connection/connection.php");
$id = $_GET["id"];

$query = "SELECT * FROM purchase_order WHERE po_id = " . $id;
$stmt = $conn->query($query);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($rows) {
    $po_id = $rows[0]['po_id'];
    $po_reference = $rows[0]['po_refference'];
    $currency = $rows[0]['currency'];
    $po_supplierId = $rows[0]['po_supplierId'];
    $po_subTotal = $rows[0]['po_subTotal'];
    $po_vatAmount = $rows[0]['po_vatAmount'];
    $po_total = $rows[0]['po_total'];
    $po_remarks = $rows[0]['po_remarks'];
}

$query2 = "SELECT * FROM supplier WHERE s_id = " . $po_supplierId;
$stmt2 = $conn->query($query2);
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
if ($row2) {
    $s_name = $row2['s_name'];
    $s_email = $row2['s_email'];
    $s_address = $row2['s_address'];
    $s_phone = $row2['s_phone'];
    $s_country = $row2['s_country'];
}

$query3 = "SELECT * FROM po_products WHERE pop_po_id = " . $id;
$stmt3 = $conn->query($query3);
$rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
$table = '';
foreach ($rows3 as $product) {
    $table .= "<tr>
                    <td style='border: solid 1px black; width: 40%;'>" . $product['pop_description'] . "</td>
                    <td style='border: solid 1px black; width: 10%;'>" . $product['pop_quantity'] . "</td>
                    <td style='border: solid 1px black; width: 18%;'>" . $product['pop_unitPrice'] . "</td>
                    <td style='border: solid 1px black; width: 18%;'>" . $product['pop_totalPrice'] . "</td>
                    <td style='border: solid 1px black; width: 14%;'>" . $product['pop_remarks'] . "</td>
               </tr>";
}

$query4 = "SELECT * FROM organisation WHERE o_id=5";
$stmt4 = $conn->query($query4);
$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
if ($row4) {
    $o_name = $row4['o_value'];
}

$query5 = "SELECT * FROM organisation WHERE o_id=6";
$stmt5 = $conn->query($query5);
$row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
if ($row5) {
    $o_vat = $row5['o_value'];
}

$query6 = "SELECT * FROM organisation WHERE o_id=7";
$stmt6 = $conn->query($query6);
$row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
if ($row6) {
    $o_brn = $row6['o_value'];
}

$html = "<body>
            <table style='width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;'>
                <tr>
                    <td colspan='3' style='text-align: center;'>
                        <img src='image\logo\logo-no-background.png' style='height: 40px;' />
                    </td>
                </tr>
                <tr>
                    <td style='width: 33%;'>" . $o_name . "</td>
                    <td style='width: 33%;'>Supplier: " . $s_name . "</td>
                    <td style='width: 33%; text-align: right;'>PO Reference: " . $po_reference . "</td>
                </tr>
                <tr>
                    <td>" . $o_brn . "</td>
                    <td>Phone: " . $s_phone . "</td>
                    <td style='text-align: right;'>Currency: " . $currency . "</td>
                </tr>
                <tr>
                    <td>" . $o_vat . "</td>
                    <td>Address: " . $s_address . "</td>
                    <td style='text-align: right;'>PO Date: " . $po_date . "</td>
                </tr>
            </table>
            <hr />
            <table style='width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;'>
                <thead>
                    <tr>
                        <th style='border: solid 1px black; width: 40%;'>Description</th>
                        <th style='border: solid 1px black; width: 10%;'>Quantity</th>
                        <th style='border: solid 1px black; width: 18%;'>Unit Price</th>
                        <th style='border: solid 1px black; width: 18%;'>Total Price</th>
                        <th style='border: solid 1px black; width: 14%;'>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    " . $table . "
                </tbody>
            </table>
            <hr />
            <p style='width: 100%;'>" . $po_remarks . "</p>
            <div style='margin-top: 20px;'>
                <table style='width: 100%;'>
                    <tr>
                        <td style='width: 50%;'>Name: __________________________</td>
                        <td style='width: 50%; text-align: right;'>Signature: ______________________</td>
                    </tr>
                </table>
            </div>
        </body>";

$mpdf->WriteHtml($html);
$mpdf->Output();
?>