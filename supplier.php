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
            <h4 class="mt-2">View Supplier</h4>


            <hr>
            <div class="row mt-2 mb-4">
                <div class="col-12">
                    <a href="add_supplier.php">
                        <button class="btn btn-primary">Create New Supplier</button>
                    </a>
                </div>

            </div>

            <table class="table table-hover cell-border" id="supplierTable">
                <thead>
                    <tr>
                        <th>View</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Date Added</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM supplier";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row):
                        echo "<tr>
                    <td><a href='view_supplier.php?id=" . $row['s_id'] . "'><button class='btn btn-secondary'>View</button></a></td>
                    <td>" . $row['s_id'] . "</td>
                    <td>" . $row['s_name'] . " </td>
                    <td>" . $row['s_email'] . " </td>
                    <td>" . $row['s_address'] . " </td>
                    <td>" . $row['s_phone'] . " </td>
                    <td>" . $row['s_dateAdded'] . " </td>
                    <td><a href='edit_supplier.php?id=" . $row['s_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                    <td><button class='btn btn-danger' onclick='deleteSupplier(" . $row['s_id'] . ")'>Delete</button></td>
                </tr>";
                    endforeach;
                    ?>

                </tbody>
            </table>

        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#supplierTable').DataTable();
        });
    </script>
    <script>
        function deleteSupplier(supplierId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_supplier.php',
                        data: { supplierId: supplierId },
                        success: function (response) {
                            // Reload the page or update the table after successful deletion
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error deleting user: ' + error
                            });
                        }
                    });
                }
            });
        }
    </script>
    <!-- Include SweetAlert script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>