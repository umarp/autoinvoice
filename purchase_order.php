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
            <h4 class="mt-2">Purchase Orders</h4>
            <hr>

            <div class="row mt-2 mb-4">
                <div class="col-12">
                    <a href="new_purchase_order.php">
                        <button class="btn btn-primary">Create New Purchase Order</button>
                    </a>
                </div>

            </div>



            <table class="table table-hover cell-border" id="poTable">
                <thead>
                    <tr>
                        <th>View</th>
                        <th>ID</th>
                        <th>Refference</th>
                        <th>Supplier</th>
                        <th>Issued By</th>
                        <th>Total</th>
                        <th>Date Issued</th>

                        <th>Edit</th>
                        <th>Reprint</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM purchase_order po, supplier s, login l WHERE po.po_supplierId  = s.s_id AND l.l_id = po.po_user";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row):
                        echo "<tr>
                    <td><a href='view_po.php?id=" . $row['po_id'] . "'><button class='btn btn-secondary'>View</button></a></td>
                    <td>" . $row['po_id'] . "</td>
                    <td>" . $row['po_refference'] . "</td>
                    <td>" . $row['s_name'] . "</td>
                    <td>" . $row['l_firstName'] . "</td>
                    <td>" . $row['po_total'] . "</td>
                    <td>" . $row['po_date'] . "</td>

                    <td><a href='edit_purchase_order.php?id=" . $row['po_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                    <td><a href='print_po.php?id=" . $row['po_id'] . "' target='_blank'><button class='btn btn-primary'>Reprint</button></a></td>

                    <td><button class='btn btn-danger' onclick='deletePo( " . $row['po_id'] . ",this.closest(`tr`))'>Delete</button></td>
                </tr>";
                    endforeach;
                    ?>

                </tbody>
            </table>

        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#poTable').DataTable();
        });
    </script>
    <script>
        function deletePo(poId, row) {
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
                        url: 'delete_po.php',
                        data: { poId: poId },
                        success: function (response) {
                            // Remove the row from the table
                            $(row).remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'PO deleted successfully!'
                            });
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error deleting PO: ' + error
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