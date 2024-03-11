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
    $currency = $rows[0]['po_currency'];
    $po_supplierId = $rows[0]['po_supplierId'];
    $po_subTotal = $rows[0]['po_subTotal'];
    $po_vatAmount = $rows[0]['po_vatAmount'];
    $po_total = $rows[0]['po_total'];
    $po_remarks = $rows[0]['po_remarks'];
    $po_date = $rows[0]['po_date'];
    $companyAttn = $rows[0]['po_companyAttn'];
    $supplierAttn = $rows[0]['po_supplierAttn'];

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
                    <td style='border: solid 1px black; width: 40%; padding: 8px;'>" . $product['pop_description'] . "</td>
                    <td style='border: solid 1px black; width: 10%; padding: 8px;'>" . $product['pop_quantity'] . "</td>
                    <td style='border: solid 1px black; width: 18%; padding: 8px;'>" . $product['pop_unitPrice'] . "</td>
                    <td style='border: solid 1px black; width: 18%; padding: 8px;'>" . $product['pop_totalPrice'] . "</td>
                    <td style='border: solid 1px black; width: 14%; padding: 8px;'>" . $product['pop_remarks'] . "</td>
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
$query7 = "SELECT * FROM organisation WHERE o_id=2";
$stmt7 = $conn->query($query7);
$row7 = $stmt7->fetch(PDO::FETCH_ASSOC);
if ($row7) {
    $o_poMessage = $row7['o_value'];
}

$query8 = "SELECT * FROM organisation WHERE o_id=1";
$stmt8 = $conn->query($query8);
$row8 = $stmt8->fetch(PDO::FETCH_ASSOC);
if ($row8) {
    $o_logo = $row8['o_value'];
}

$html = "<body>
            <table style='width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;'>
                <tr>
                    <td colspan='3' style='text-align: center;'>
                        <img src='" . $o_logo . "' style='height: 40px;' />
                    </td>
                </tr>
                <hr>
                <tr>
                    <td style='width: 33%;'>" . $o_name . "</td>
                    <td style='width: 33%;'>Supplier: " . $s_name . "</td>
                    <td style='width: 33%; text-align: right;'>PO Reference: " . $po_reference . "</td>
                </tr>
                <tr>
                    <td>BRN:" . $o_brn . "</td>
                    <td>Phone: " . $s_phone . "</td>
                    <td style='text-align: right;'>Currency: " . $currency . "</td>
                </tr>
                <tr>
                    <td>Vat:" . $o_vat . "</td>
                    <td>Address: " . $s_address . "</td>
                    <td style='text-align: right;'>PO Date: " . $po_date . "</td>
                </tr>
                  <tr>
                    <td>From: " . $companyAttn . "</td>
                    <td></td>
                    <td style='text-align: right;'>Attention: </td>: " . $supplierAttn . "</td>
                </tr>
            </table>
            <hr />
            <table style='width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;'>
                <thead>
                    <tr>
                        <th style='border: solid 1px black; width: 40%; padding: 8px;'>Description</th>
                        <th style='border: solid 1px black; width: 10%; padding: 8px;'>Quantity</th>
                        <th style='border: solid 1px black; width: 18%; padding: 8px;'>Unit Price</th>
                        <th style='border: solid 1px black; width: 18%; padding: 8px;'>Total Price</th>
                        <th style='border: solid 1px black; width: 14%; padding: 8px;'>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    " . $table . "
                    <tr>
                    <td></td>
                    <td></td>
                    <td style='border: solid 1px black; width: 40%; padding: 8px;font-weight:bold;'>Sub Total</td>
                    <td style='border: solid 1px black; width: 40%; padding: 8px;'>" . $po_subTotal . "</td>
                    <td></td>
                    </tr>
                    <tr>
                    <td></td>
                    <td></td>
                    <td style='border: solid 1px black; width: 40%; padding: 8px;font-weight:bold;'>Vat Ammount</td>
                    <td style='border: solid 1px black; width: 40%; padding: 8px;'>" . $po_vatAmount . "</td>
                    <td></td>
                    </tr><tr>
                    <td></td>
                    <td></td>
                    <td style='border: solid 1px black; width: 40%; padding: 8px;font-weight:bold;'>Total</td>
                    <td style='border: solid 1px black; width: 40%; padding: 8px;'>" . $po_total . "</td>
                    <td></td>
                    </tr>
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
          <!-- Thank you message -->
          <div style='position: absolute; bottom: 20px; width: 100%; text-align: center; left: 0;font-weight:bold;'>
              <p>" . $o_poMessage . "</p>
          </div>
        </body>";

$mpdf->WriteHtml($html);
$mpdf->Output();
?>