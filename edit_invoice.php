<!doctype html>
<html lang="en">

<head>
    <?php require_once("main/head.php") ?>
</head>

<body id="body-pd">


    <?php
    require_once("main/header.php");
    // Check if the purchase order ID is provided via GET request
    if (isset($_GET['id'])) {
        $i_id = $_GET['id'];

        try {
            // Retrieve the purchase order details from the database
            $stmt = $conn->prepare("SELECT * FROM invoice WHERE i_id = :i_id");
            $stmt->bindParam(':i_id', $i_id);
            $stmt->execute();
            $i = $stmt->fetch(PDO::FETCH_ASSOC);

            $client_id = $i['i_clientId'];
            $i_currency = $i['i_currency'];
            $i_subTotal = $i['i_subTotal'];
            $i_vatAmount = $i['i_vatAmount'];
            $i_total = $i['i_total'];
            $i_remarks = $i['i_remarks'];


            $stmt1 = $conn->prepare("SELECT * FROM clients WHERE c_id = :c_id");
            $stmt1->bindParam(':c_id', $client_id);
            $stmt1->execute();
            $client = $stmt1->fetch(PDO::FETCH_ASSOC);

            $stmt3 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=5");
            $stmt3->execute();
            $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $companyname = $result3['o_value'];

            $stmt4 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=6");
            $stmt4->execute();
            $result4 = $stmt4->fetch(PDO::FETCH_ASSOC);
            $vat = $result4['o_value'];

            $stmt5 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=7");
            $stmt5->execute();
            $result5 = $stmt5->fetch(PDO::FETCH_ASSOC);
            $brn = $result5['o_value'];

            $stmt6 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=8");
            $stmt6->execute();
            $result6 = $stmt6->fetch(PDO::FETCH_ASSOC);
            $address = $result6['o_value'];

            $stmt7 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=9");
            $stmt7->execute();
            $result7 = $stmt7->fetch(PDO::FETCH_ASSOC);
            $phone = $result7['o_value'];



            // Check if the purchase order exists
            if ($i) {
                // Retrieve product details associated with the purchase order
                $stmt2 = $conn->prepare("SELECT * FROM invoice_products WHERE ip_i_id = :i_id");
                $stmt2->bindParam(':i_id', $i_id);
                $stmt2->execute();
                $prod = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Redirect to an error page or show an error message
                echo "Purchase order not found.";
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Redirect to an error page or show an error message
        echo "Purchase order ID not provided.";
        exit();
    }
    ?>
    <!--Container Main start-->
    <div class="container">
        <div class="container-fluid">

            <h4>Invoice</h4>
            <form class="form" action="do_edit_invoice.php" method="POST">

                <div class="row">
                    <div class="col-6">
                        <div class="form-box">
                            <h2>Company Details</h2>
                            <label for="Company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="Company" readonly
                                value="<?php echo $companyname; ?>">

                            <label for="Address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="Address" readonly
                                value="<?php echo $address; ?>">

                            <label for="Phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="Phone" readonly value="<?php echo $phone; ?>">


                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-box form-group search-box">
                            <h2>Client Details</h2>
                            <div class="row">
                                <div class="col">
                                    <label for="companyName">Select Client name</label>
                                    <input type="text" class="form-control" placeholder="Type to search...">
                                </div>
                                <div class="col">
                                    <label>&nbsp;</label>
                                    <select name="clientName" class="result form-control" id="selectBox">
                                        <option>Click to select</option>
                                    </select>
                                </div>
                            </div>
                            <div id="clientInfo">
                                <label for="Company" class="form-label">Client</label>
                                <input type="text" class="form-control" id="Company" readonly
                                    value="<?php echo $client["c_firstName"] . " " . $client["c_lastName"]; ?>">

                                <label for="Address" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" readonly
                                    value="<?php echo $client["c_email"]; ?>">

                                <label for="Phone" class="form-label">Phone</label>
                                <input type="number" class="form-control" id="Phone" readonly
                                    value="<?php echo $client["c_phone"]; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 form-box">
                    <div class="col-12">
                        <select name="currency" id="currency" class="btn btn-primary">
                            <option value="MUR">Mauritian Rupee (MUR)</option>
                            <option value="USD">US Dollar (USD)</option>
                            <option value="EUR">Euro (EUR)</option>
                            <option value="GBP">British Pound (GBP)</option>
                            <option value="JPY">Japanese Yen (JPY)</option>
                            <option value="AUD">Australian Dollar (AUD)</option>
                            <option value="CAD">Canadian Dollar (CAD)</option>
                            <option value="CHF">Swiss Franc (CHF)</option>
                            <option value="CNY">Chinese Yuan (CNY)</option>
                            <option value="INR">Indian Rupee (INR)</option>
                            <option value="RUB">Russian Ruble (RUB)</option>
                            <option value="KRW">South Korean Won (KRW)</option>
                        </select>


                        <table class="table table-bordered table-hover mt-4" id="poItems">
                            <thead>
                                <tr>
                                    <th><input id="checkAll" class="formcontrol" type="checkbox"></th>
                                    <th>Desctiption</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($prod as $ip) {
                                    $count++;
                                    echo '<tr>
                                    <td><input type="checkbox" class="itemRow"></td>
                                    <td><input type="text" name="description[]" id="description_' . $count . '" class="form-control"
                                            required value=' . $ip['ip_description'] . '></td>
                                    <td><input type="number" name="quantity[]" id="quantity_' . $count . '"
                                            class="form-control quantity" required value=' . $ip['ip_unitPrice'] . '></td>
                                    <td><input type="number" name="unitPrice[]" id="unitPrice_' . $count . '" step=".01"
                                            class="form-control unitPrice" required value=' . $ip['ip_quantity'] . '></td>
                                    <td><input type="number" name="totalPrice[]" id="totalPrice_' . $count . '" step=".01"
                                            class="form-control totalPrice" required value=' . $ip['ip_totalPrice'] . '></td>
                                    <td><input type="text" name="remarks[]" id="remarks_' . $count . '" class="form-control" value=' . $ip['ip_remarks'] . '></td>
                                </tr>';
                                }
                                ?>

                            </tbody>
                        </table>


                    </div>
                    <style>
                        .checkbox-button {
                            margin-bottom: 0;
                            cursor: pointer;
                        }

                        .checkbox-button input[type="checkbox"] {
                            display: none;
                        }

                        .checkbox-button label {
                            color: white;
                            display: inline-block;
                            padding: 6px 12px;
                            margin-bottom: 0;
                            text-align: center;
                            white-space: nowrap;
                            vertical-align: middle;
                            cursor: pointer;
                            border: 1px solid transparent;
                            border-radius: 4px;
                            background-color: grey;
                        }

                        .checkbox-button label:hover {
                            background-color: #f5f5f5;
                        }

                        .checkbox-button input[type="checkbox"]:checked+label {
                            background-color: #5cb85c;
                            color: #fff;
                            border-color: #4cae4c;
                        }
                    </style>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="btn-group" role="group">
                                <a class="btn btn-danger" id="removeRows">- Remove</a>
                                <a class="btn btn-success" id="addRows">+ Add More</a>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <a class="btn btn-secondary" onclick="calculate()">ReCalculate</a>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <label for="ExcludeVat">Vat options</label>
                            <span class="checkbox-button">
                                <input type="checkbox" name="excludeVat" id="excludeVat">
                                <label for="excludeVat">Exclude</label>
                            </span>
                            <span class="checkbox-button ms-2">
                                <input class="btn btn-success" type="checkbox" name="includeVat" id="includeVat"
                                    value="includeVat">
                                <label for="includeVat">Include</label>
                            </span>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3 form-group">
                            <label for="subTotal" class="mr-2">Sub total:</label>
                            <input type="number" class="form-control" name="subTotal" id="subTotal"
                                placeholder="Sub Total" step=".01" required value="<?php echo $i_subTotal; ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="vatAmount" class="mr-2">Vat Amount:</label>
                            <input type="number" class="form-control" name="vatAmount" id="vatAmount"
                                placeholder="Vat Amount" step=".01" required value="<?php echo $i_vatAmount; ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="total" class="mr-2">Total:</label>
                            <input type="number" class="form-control" name="total" id="total" placeholder="Total"
                                step=".01" required value="<?php echo $i_total; ?>">
                        </div>
                    </div>

                </div>


                <div class="row mt-4 form-box">
                    <div class="col-12"><label>General Remarks</label>
                        <textarea name="generalRemarks" class="form-control" id="generalRemarks" rows="3"></textarea>

                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>


<!-- Your JavaScript code -->
<script>
    $(document).ready(function () {
        $('.search-box input[type="text"]').on("keyup input", function () {
            var inputVal = $(this).val();
            var resultDropdown = $('#selectBox'); // Selecting the selectBox element
            if (inputVal.length) {
                $.get("searchClients.php", {
                    term: inputVal,
                }).done(function (data) {
                    resultDropdown.html(data); // Update the selectBox with the search results
                });
            } else {
                resultDropdown.empty();
            }
        });

        $(document).on("click", "#selectBox", function () {

            var selectedValue = $(this).val();
            if (selectedValue !== 'Click to select') {
                $.get("clientDetails.php", {
                    id: selectedValue,
                }).done(function (data) {
                    $('#clientInfo').html(data);
                    // Set the HTML of #supplierInfo
                });
            } else {
                $('#clientInfo').empty();
            }
        });
    });

</script>





</html>