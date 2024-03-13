<!doctype html>
<html lang="en">

<head>
    <?php require_once("main/head.php") ?>
</head>

<body id="body-pd">


    <?php
    require_once("main/header.php");

    $stmt = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=5");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $companyname = $result['o_value'];

    $stmt1 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=6");
    $stmt1->execute();
    $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    $vat = $result1['o_value'];

    $stmt2 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=7");
    $stmt2->execute();
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $brn = $result2['o_value'];

    $stmt3 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=8");
    $stmt3->execute();
    $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    $address = $result3['o_value'];

    $stmt4 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=9");
    $stmt4->execute();
    $result4 = $stmt4->fetch(PDO::FETCH_ASSOC);
    $phone = $result4['o_value'];
    ?>
    <!--Container Main start-->
    <div class="container">
        <div class="container-fluid">

            <h4>Purchase Order</h4>
            <form class="form" action="save_purchase_order.php" method="POST" target="_blank" onsubmit="validate()">

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

                            <label for="Attention" class="form-label">Attention</label>
                            <input type="text" class="form-control" id="Attention" name="Companyattention">
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-box form-group search-box">
                            <h2>Supplier Details</h2>
                            <div class="row">
                                <div class="col">
                                    <label for="companyName">Select Supplier name</label>
                                    <input type="text" class="form-control" placeholder="Type to search...">
                                </div>
                                <div class="col">
                                    <label>&nbsp;</label>
                                    <select name="companyName" class="result form-control" id="selectBox" required>
                                    </select>
                                </div>
                            </div>
                            <div id="supplierInfo"></div>
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
                                <tr>
                                    <td><input type="checkbox" class="itemRow"></td>
                                    <td><input type="text" name="description[]" id="description_1" class="form-control"
                                            required></td>
                                    <td><input type="number" name="quantity[]" id="quantity_1"
                                            class="form-control quantity" required></td>
                                    <td><input type="number" name="unitPrice[]" id="unitPrice_1" step=".01"
                                            class="form-control unitPrice" required></td>
                                    <td><input type="number" name="totalPrice[]" id="totalPrice_1" step=".01"
                                            class="form-control totalPrice" required></td>
                                    <td><input type="text" name="remarks[]" id="remarks_1" class="form-control"></td>
                                </tr>

                            </tbody>
                        </table>


                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="btn-group" role="group">
                                <a class="btn btn-danger" id="removeRows">- Remove</a>
                                <a class="btn btn-success" id="addRows">+ Add More</a>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <a class="btn btn-secondary" onclick="calculateTotal()">ReCalculate</a>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <label for="ExcludeVat">Vat options</label>
                            <span class="checkbox-button">
                                <input type="checkbox" name="excludeVat" id="excludeVat"
                                    onchange="handleVatChange(this)">
                                <label for="excludeVat">Exclude</label>
                            </span>
                            <span class="checkbox-button ms-2">
                                <input class="btn btn-success" type="checkbox" name="includeVat" id="includeVat"
                                    value="includeVat" onchange="handleVatChange(this)">
                                <label for="includeVat">Include</label>
                            </span>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3 form-group">
                            <label for="subTotal" class="mr-2">Sub total:</label>
                            <input type="number" class="form-control" name="subTotal" id="subTotal"
                                placeholder="Sub Total" step=".01" required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="vatAmount" class="mr-2">Vat Amount:</label>
                            <input type="number" class="form-control" name="vatAmount" id="vatAmount"
                                placeholder="Vat Amount" step=".01" required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="total" class="mr-2">Total:</label>
                            <input type="number" class="form-control" name="total" id="total" placeholder="Total"
                                step=".01" required>
                        </div>
                    </div>

                </div>


                <div class="row mt-4 mb-2 form-box">
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
                $.get("searchSupplierClients.php", {
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
                $.get("supplierCompanyDetails.php", {
                    id: selectedValue,
                }).done(function (data) {
                    $('#supplierInfo').html(data); // Set the HTML of #supplierInfo
                });
            } else {
                $('#supplierInfo').empty();
            }
        });
    });

</script>
<script>
    function validate() {
        window.location.href = "purchase_order.php"
    }
</script>




</html>