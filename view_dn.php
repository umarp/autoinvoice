<!doctype html>
<html lang="en">

<head>
    <?php require_once("main/head.php") ?>
</head>

<body id="body-pd">


    <?php
    require_once("main/header.php");
    if (isset($_GET['id'])) {
        $d_id = $_GET['id'];

        try {
            // Retrieve the delivery note details from the database
            $stmt = $conn->prepare("SELECT * FROM delivery_note WHERE d_id = :d_id");
            $stmt->bindParam(':d_id', $d_id);
            $stmt->execute();
            $d = $stmt->fetch(PDO::FETCH_ASSOC);

            $client_id = $d['d_clientId'];
            $d_remarks = $d['d_remarks'];

            $stmtc = $conn->prepare("SELECT * FROM clients WHERE c_id = :c_id");
            $stmtc->bindParam(':c_id', $client_id);
            $stmtc->execute();
            $client = $stmtc->fetch(PDO::FETCH_ASSOC);

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


            // Check if the delivery note exists
            if ($d) {
                // Retrieve product details associated with the delivery noter
                $stmt2 = $conn->prepare("SELECT * FROM delivery_products WHERE dp_d_id = :d_id");
                $stmt2->bindParam(':d_id', $d_id);
                $stmt2->execute();
                $prod = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Redirect to an error page or show an error message
                echo "Delivery Note not found.";
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Redirect to an error page or show an error message
        echo "Delivery Note ID not provided.";
        exit();
    }
    ?>
    <!--Container Main start-->
    <div class="container">
        <div class="container-fluid">

            <h4>Delivery Note</h4>
            <form class="formdn">
                <input readonly type="hidden" name="d_id" value="<?php echo $d['d_id']; ?>">

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

                            </div>
                            <div id="clientInfo">
                                <label for="Company" class="form-label">Client Name</label>
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
        </div>
        <div class="row mt-4 form-box">
            <div class="col-12">
                <table class="table table-bordered table-hover mt-4" id="dnItems">
                    <thead>
                        <tr>
                            <th>Desctiption</th>
                            <th>Quantity</th>

                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count1 = 0;
                        foreach ($prod as $dp) {
                            $count1++;
                            echo '<tr>
                                    
                                    <td><input readonly type="text" name="description[]" id="description_' . $count1 . '" class="form-control"
                                            required value=' . $dp['dp_description'] . '></td>
                                    <td><input readonly type="number" name="quantity[]" id="quantity_' . $count1 . '"
                                            class="form-control quantity" required value=' . $dp['dp_quantity'] . '></td>
      
                                    <td><input readonly type="text" name="remarks[]" id="remarks_' . $count1 . '" class="form-control" value=' . $dp['dp_remarks'] . '></td>
                                </tr>';
                        }
                        ?>

                    </tbody>
                </table>

            </div>



        </div>


        <div class="row mt-4 mb-2 form-box">
            <div class="col-12"><label>General Remarks</label>
                <textarea readonly name="generalRemarks" class="form-control" id="generalRemarks" rows="3">
                    <?php echo $d_remarks; ?>
                </textarea>

            </div>

        </div>

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
        // Validate before form submission
        $('.formdn').submit(function (event) {
            var rowCount = $('#dnItems tbody tr').length;
            alert(rowCount);
            if (rowCount == 0) {
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

        var newRow1 = "";
        newRow1 += "<tr>";
        newRow1 += '<td><input class="itemRow1" type="checkbox"></td>';
        newRow1 +=
            '<td><input class="form-control" type="text" id="description_' +
            count1 +
            '" name="description[]"></td>';
        newRow1 +=
            '<td><input class="form-control quantity" type="number" id="quantity_' +
            count1 +
            '" name="quantity[]"></td>';

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
            $(this).closest("tr").removed;
        });
        $("#checkAll1").prop("checked", false);
    });
</script>





</html>