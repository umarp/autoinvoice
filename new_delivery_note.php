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

            <h4>New Delivery Note</h4>
            <form class="formdn" action="save_delivery_note.php" method="POST" target="_blank" onsubmit="validate()">

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
                                    <select name="clientName" class="result form-control" id="selectBox" required>
                                    </select>
                                </div>
                            </div>
                            <div id="clientInfo"></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 form-box">
                    <div class="col-12">
                        <table class="table table-bordered table-hover mt-4" id="dnItems">
                            <thead>
                                <tr>
                                    <th><input id="checkAll1" class="formcontrol" type="checkbox"></th>
                                    <th>Desctiption</th>
                                    <th>Quantity</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="itemRow1"></td>
                                    <td><input type="text" name="description[]" id="description_1" class="form-control"
                                            required></td>
                                    <td><input type="number" name="quantity[]" id="quantity_1"
                                            class="form-control quantity" required></td>
                                    <td><input type="text" name="remarks[]" id="remarks_1" class="form-control"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="btn-group" role="group">
                                <a class="btn btn-danger" id="removeRows1">- Remove</a>
                                <a class="btn btn-success" id="addRows1">+ Add More</a>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


        // Validate before form submission
        $('form').submit(function (event) {
            var rowCount = $('#dnItems tbody tr').length;
            if (rowCount === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please add at least one row in the table.',
                });
                event.preventDefault(); // Prevent form submission if no row is present
            }
        });
    });
    //deliver Note JS

    //check All
    $(document).on("click", "#checkAll1", function () {
        $(".itemRow1").prop("checked", this.checked);
    });

    $(document).on("click", ".itemRow1", function () {
        if ($(".itemRow1:checked").length == $(".itemRow1").length) {
            $("#checkAll1").prop("checked", true);
        } else {
            $("#checkAll1").prop("checked", false);
        }
    });

    // add row
    var count1 = $(".itemRow1").length;
    $(document).on("click", "#addRows1", function () {
        count1++;
        console.log(count1);
        var newRow1 = "";
        newRow1 += "<tr>";
        newRow1 += '<td><input class="itemRow1" type="checkbox"></td>';
        newRow1 +=
            '<td><input class="form-control" type="text" id="description_' +
            count1 +
            '" name="description[]" required></td>';
        newRow1 +=
            '<td><input class="form-control quantity" type="number" id="quantity_' +
            count1 +
            '" name="quantity[]" required></td>';

        newRow1 +=
            '<td><input class="form-control" type="text" id="remarks_' +
            count1 +
            '" name="remarks[]"> </td>';

        newRow1 += "</tr>";
        $("#dnItems").append(newRow1);
    });

    //Remove Rows
    $(document).on("click", "#removeRows1", function () {
        $(".itemRow1:checked").each(function () {
            $(this).closest("tr").remove();
        });
        $("#checkAll1").prop("checked", false);
    });
</script>
<script>
    function validate() {
        window.location.href = "delivery_note.php"
    }
</script>




</html>