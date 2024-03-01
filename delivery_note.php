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
            <h4 class="mt-2">Delivery Note</h4>
            <hr>

            <div class="row mt-2 mb-2">
                <div class="col-3">
                    <div class="box">number of users: 10</div>
                </div>
                <div class="col-3">
                    <div class="box">number of users: 10</div>
                </div>
                <div class="col-3">
                    <div class="box">number of users: 10</div>
                </div>


                <div class="col-3">
                    <a href="add_user.php">
                        <div class="box">Add User</div>
                    </a>
                </div>
            </div>
            <hr>

            <div class="row  mb-4">
                <div class="col-12">
                    <a href="add_delivery_note.php">
                        <button class="btn btn-primary">Create New Delivery Note</button>
                    </a>
                </div>

            </div>



            <table class="table table-hover cell-border" id="dnTable">
                <thead>
                    <tr>
                        <th>View</th>
                        <th>ID</th>
                        <th>Refference</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Date Issued</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM delivery_note";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row):

                        if ($row['sn_cs_type'] == "Client") {
                            $query1 = "SELECT * FROM clients WHERE " . $row['dn_cs_id'] . " = c_id  ";
                            $stmt1 = $conn->query($query1);
                            $rows1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                            $rows1[''];
                        }
                        echo "<tr>
                    <td><a href='view_dn.php?id=" . $row['dn_id'] . "'><button class='btn btn-secondary'>View</button></a></td>
                    <td>" . $row['dn_id'] . "</td>
                    <td>" . $row['dn_refference'] . "</td>
                    <td>" . $row['dn_supplier_client_name'] . "</td>
                    <td>" . $row['dn_cs_type'] . "</td>
                    <td>" . $row['dn_date'] . "</td>
                     <td><a href='edit_dn.php?id=" . $row['dn_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                    <td><button class='btn btn-danger' onclick='deleteDn(" . $row['dn_id'] . ")'>Delete</button></td>
                </tr>";
                    endforeach;
                    ?>

                </tbody>
            </table>

        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#dnTable').DataTable();
        });
    </script>
    <script>
        function deleteDn(dnId) {
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
                        url: 'delete_dn.php',
                        data: { dnId: dnId },
                        success: function (response) {
                            // Reload the page or update the table after successful deletion
                            location.reload();
                            //console.log(response);
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error deleting Delivery Note: ' + error
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