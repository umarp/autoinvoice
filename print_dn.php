<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4'
]);

require_once("connection/connection.php");
$id = $_GET["id"];

$query = "SELECT * FROM deliver_note WHERE d_id = " . $id;
$stmt = $conn->query($query);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($rows) {
    $i_id = $rows[0]['d_id'];
    $i_reference = $rows[0]['d_refference'];
    $i_clientId = $rows[0]['d_clientId'];
    $i_remarks = $rows[0]['d_remarks'];
    $i_date = $rows[0]['d_date'];


}

$query2 = "SELECT * FROM clients WHERE c_id = " . $d_clientId;
$stmt2 = $conn->query($query2);
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
if ($row2) {
    $s_name = $row2['c_name'];
    $s_email = $row2['c_email'];
    $s_address = $row2['c_address'];
    $s_phone = $row2['c_phone'];
}

$query3 = "SELECT * FROM delivery_products WHERE dp_d_id = " . $id;
$stmt3 = $conn->query($query3);
$rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
$table = '';
foreach ($rows3 as $product) {
    $table .= "<tr>
                    <td style='border: solid 1px black; width: 40%; padding: 8px;'>" . $product['dp_description'] . "</td>
                    <td style='border: solid 1px black; width: 10%; padding: 8px;'>" . $product['dp_quantity'] . "</td>
                    <td style='border: solid 1px black; width: 14%; padding: 8px;'>" . $product['dp_remarks'] . "</td>
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
$query7 = "SELECT * FROM organisation WHERE o_id=4";
$stmt7 = $conn->query($query7);
$row7 = $stmt7->fetch(PDO::FETCH_ASSOC);
if ($row7) {
    $o_IMessage = $row7['o_value'];
}

$html = "<body>
            <table style='width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;'>
                <tr>
                    <td colspan='3' style='text-align: center;'>
                        <img src='image\logo\logo-no-background.png' style='height: 40px;' />
                    </td>
                </tr>
                <hr>
                <tr>
                    <td style='width: 33%;'>" . $o_name . "</td>
                    <td style='width: 33%;'>Supplier: " . $c_name . "</td>
                    <td style='width: 33%; text-align: right;'>Delivery Note Reference: " . $i_reference . "</td>
                </tr>
                <tr>
                    <td>BRN:" . $o_brn . "</td>
                    <td>Phone: " . $c_phone . "</td>
                </tr>
                <tr>
                    <td>Vat:" . $o_vat . "</td>
                    <td>Address: " . $c_address . "</td>
                    <td style='text-align: right;'>Deliver Note Date: " . $i_date . "</td>
                </tr>
                
            </table>
            <hr />
            <table style='width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;'>
                <thead>
                    <tr>
                        <th style='border: solid 1px black; width: 40%; padding: 8px;'>Description</th>
                        <th style='border: solid 1px black; width: 10%; padding: 8px;'>Quantity</th>
                        <th style='border: solid 1px black; width: 14%; padding: 8px;'>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    " . $table . "
                
                </tbody>
            </table>
            <hr />
            <p style='width: 100%;'>" . $i_remarks . "</p>
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
              <p>" . $o_IMessage . "</p>
          </div>
        </body>";

$mpdf->WriteHtml($html);
$mpdf->Output();
?>