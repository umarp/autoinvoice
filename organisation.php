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
                    foreach ($rows as $row): ?>
                        <?php if ($row["o_name"] == "Logo"): ?>
                            <tr>
                                <td>
                                    <?php echo $row['o_id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['o_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['o_description']; ?>
                                </td>
                                <td><img src='<?php echo $row['o_value']; ?>' width='100px'></td>
                                <td>
                                    <button class='btn btn-primary' onclick="selectLogo()">Change
                                        Logo</button>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr data-oId="<?php echo $row['o_id']; ?>">
                                <td>
                                    <?php echo $row['o_id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['o_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['o_description']; ?>
                                </td>
                                <td>
                                    <?php echo $row['o_value']; ?>
                                </td>
                                <td>
                                    <!-- Modify the onclick attribute to trigger the dataEditingModal -->
                                    <button class='btn btn-primary'
                                        onclick=" openDataEditingModal(<?php echo $row['o_id']; ?>)">Edit</button>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>


                </tbody>
            </table>

            <script>
                function selectLogo(oId) {
                    // Show the modal for selecting a new logo
                    $('#logoSelectionModal').modal('show');

                    // Store the oId of the logo being updated
                    $('#logoSelectionModal').data('oId', oId);
                }
            </script>
            <!-- Modal for selecting logo -->
            <div class="modal fade" id="logoSelectionModal" tabindex="-1" role="dialog"
                aria-labelledby="logoSelectionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logoSelectionModalLabel">Select Logo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Display photos from the folder -->
                            <?php
                            // Define the path to your photo folder
                            $photoFolder = 'image/logo';
                            // Get list of photos
                            $photos = glob($photoFolder . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                            ?>
                            <div class="row">
                                <?php foreach ($photos as $photo): ?>
                                    <div class="col-md-3">
                                        <img src="<?php echo $photo; ?>" class="img-fluid select-logo"
                                            style="cursor: pointer;" onclick="updateLogo( '<?php echo $photo; ?>');">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function openDataEditingModal(oId) {

                    $('#oid').val(oId);


                    // Open the dataEditingModal
                    $('#dataEditingModal').modal('show');
                }
            </script>



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
                                    <input type="hidden" id="oid">
                                    <label for="editedData" class="form-label">New Value:</label>
                                    <input type="text" class="form-control" id="editedData" name="editedData">
                                </div>
                                <button type="button" class="btn btn-primary" onclick="updateData()">Save
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
        function updateLogo(editedData) {
            var oId = $('#logoSelectionModal').data('oId');

            $.ajax({
                type: 'POST',
                url: 'update_organisation.php',
                data: {
                    oId: oId,
                    editedData: editedData
                },
                success: function (response) {
                    // Update the corresponding logo image with the new value
                    $('#logo_' + oId).attr('src', editedData);

                    $('#logoSelectionModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Logo updated successfully!'
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating logo: ' + error
                    });
                }
            });
        }

        function updateData() {
            var editedData = $('#editedData').val();
            var oId = $('#oid').val();

            $.ajax({
                type: 'POST',
                url: 'update_organisation.php',
                data: {
                    oId: oId,
                    editedData: editedData
                },
                success: function (response) {
                    // Update the corresponding table cell with the new value
                    var row = $('tr[data-oId="' + oId + '"]');
                    row.find('td:eq(3)').html(editedData);

                    $('#dataEditingModal').modal('hide');

                    // Optionally, redraw the DataTable if you're using it
                    $('#inTable').DataTable().draw();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data updated successfully!'
                    });
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