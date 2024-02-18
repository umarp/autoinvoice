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
        <div class="container-fluid">



            <h4 class="mt-2">Organisation Settings</h4>
            <hr>
            <table class="table table-hover cell-border" id="inTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Value</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM organisation";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row):

                        if ($row["o_name"] == "Logo") {
                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td><img src='" . $row['o_value'] . "' width='100px'></td>
                              <td>"; ?><button class='btn btn-primary'
                                onclick="changeData(<?php echo $row['o_id']; ?>, '<?php echo $row['o_name']; ?>')">Edit</button>

                            <?php echo "</td></tr>";
                        } else if ($row["o_name"] == "Purchase order message") {

                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td>" . $row['o_value'] . "</td>

                                <td><button class='btn btn-primary' onclick=changeText(" . $row['o_id'] . ")>Edit</button></td>
                                </tr>";
                        } else if ($row["o_name"] == "Invoice message") {

                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td>" . $row['o_value'] . "</td>

                                <td><button class='btn btn-primary' onclick=changeText(" . $row['o_id'] . ")>Edit</button></td>
                                </tr>";
                        } else if ($row["o_name"] == "Delivery note message") {

                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td>" . $row['o_value'] . "</td>

                                <td>"; ?><button class='btn btn-primary'
                                            onclick="changeData(<?php echo $row['o_id']; ?>, '<?php echo $row['o_name']; ?>')">Edit</button>

                            <?php echo "</td></tr>";
                        } else if ($row["o_name"] == "Company Name") {

                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td>" . $row['o_value'] . "</td>

                                <td>"; ?><button class='btn btn-primary'
                                                onclick="changeData(<?php echo $row['o_id']; ?>, '<?php echo $row['o_name']; ?>')">Edit</button>

                            <?php echo "</td></tr>";
                        } else if ($row["o_name"] == "VAT") {

                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td>" . $row['o_value'] . "</td>

                                <td>"; ?><button class='btn btn-primary'
                                                    onclick="changeData(<?php echo $row['o_id']; ?>, '<?php echo $row['o_name']; ?>')">Edit</button>

                            <?php echo "</td></tr>";
                        } else if ($row["o_name"] == "BRN") {

                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td>" . $row['o_value'] . "</td>

                                <td>"; ?><button class='btn btn-primary'
                                                        onclick="changeData(<?php echo $row['o_id']; ?>, '<?php echo $row['o_name']; ?>')">Edit</button>

                            <?php echo "</td></tr>";
                        } else if ($row["o_name"] == "Address") {

                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td>" . $row['o_value'] . "</td>

                                <td>"; ?><button class='btn btn-primary'
                                                            onclick="changeData(<?php echo $row['o_id']; ?>, '<?php echo $row['o_name']; ?>')">Edit</button>

                            <?php echo "</td></tr>";
                        } else if ($row["o_name"] == "Phone") {

                            echo "<tr>
                                <td>" . $row['o_id'] . "</td>
                                <td>" . $row['o_name'] . "</td>
                                <td>" . $row['o_description'] . "</td>
                                <td>" . $row['o_value'] . "</td>

                                <td>"; ?><button class='btn btn-primary'
                                                                onclick="changeData(<?php echo $row['o_id']; ?>, '<?php echo $row['o_name']; ?>')">Edit</button>

                            <?php echo "</td></tr>";
                        }
                    endforeach;
                    ?>

                </tbody>
            </table>





            <!-- Modal for Data Editing -->
            <div class="modal fade" id="dataEditingModal" tabindex="-1" role="dialog"
                aria-labelledby="dataEditingModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dataEditingModalLabel">Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for data editing -->
                            <form id="dataEditForm">
                                <div class="mb-3">
                                    <label for="editedData" class="form-label">New Value:</label>
                                    <input type="text" class="form-control" id="editedData" name="editedData">
                                </div>
                                <button type="button" class="btn btn-primary"
                                    onclick="updateData(<?php echo $row['o_id']; ?>, '<?php echo $row['o_name']; ?>')">Save
                                    Changes</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <script>


        function changeData(oId, dataType) {
            // Open the data editing modal
            $('#dataEditingModal').modal('show');

            // Set the modal title based on the data type
            $('#dataEditingModalLabel').text('Edit ' + dataType);

            // Set the data type as a data attribute
            $('#dataEditingModal').data('dataType', dataType);
        }

        function updateData(oId, dataType) {
            // Get the edited data from the form
            var editedData = $('#editedData').val();

            // Get the data type from the data attribute
            var dataType = $('#dataEditingModal').data('dataType');

            // Send the updated data to the server via AJAX
            $.ajax({
                type: 'POST',
                url: 'update_data.php', // Replace with your server-side script to update the data
                data: {
                    oId: oId,
                    dataType: dataType,
                    editedData: editedData
                },
                success: function (response) {
                    // Reload the page or update the table after successful data update
                    location.reload();
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating data: ' + error
                    });
                }
            });
        }




    </script>

    <script>
        $(document).ready(function () {
            $('#inTable').DataTable();
        });
    </script>
    <!-- Include SweetAlert script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</body>

</html>