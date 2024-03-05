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



            <div class="row  mb-4">
                <div class="col-12">
                    <a href="new_delivery_note.php">
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
                        <th>Client</th>
                        <th>Issued By</th>
                        <th>Date Issued</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM delivery_note d , clients c , LOGIN l WHERE c.c_id = d.d_clientId AND d.d_user = l.l_id";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row):

                        $stmt = $conn->query($query);
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        echo "<tr>
                    <td><a href='view_dn.php?id=" . $row['d_id'] . "'><button class='btn btn-secondary'>View</button></a></td>
                    <td>" . $row['d_id'] . "</td>
                    <td>" . $row['d_refference'] . "</td>
                    <td>" . $row['c_firstName'] . " " . $row['c_lastName'] . "</td>
                    <td>" . $row['l_firstName'] . " " . $row['l_lastName'] . "</td>
                    <td>" . $row['d_date'] . "</td>
                     <td><a href='edit_delivery_note.php?id=" . $row['d_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                    <td><button class='btn btn-danger' onclick='deleteDn(" . $row['d_id'] . ")'>Delete</button></td>
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
        function deleteDn(dId) {
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
                        data: { dId: dId },
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