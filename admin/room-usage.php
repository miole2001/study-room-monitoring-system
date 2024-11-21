<?php 
    include('../components/admin-header.php'); 

    if (isset($_POST['delete_usage'])) {
        $delete_id = $_POST['delete_id'];

        $verify_delete = $connForReservation->prepare("SELECT * FROM `room_reservations` WHERE id = ?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_usage = $connForReservation->prepare("DELETE FROM `room_reservations` WHERE id = ?");
            if ($delete_usage->execute([$delete_id])) {
                $success_msg[] = 'usage deleted!';
            } else {
                $error_msg[] = 'Error deleting usage.';
            }
        } else {
            $warning_msg[] = 'usage already deleted!';
        }
    }


    

    $room_usage = $connForReservation->query("SELECT * FROM `room_reservations`")->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <?php include("../components/topbar.php"); ?>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="text-center mb-4">
            <h1 class="mb-0 text-gray-800">ROOM USAGE</h1>
        </div>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room Name</th>
                                <th>Location</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Date</th>
                                <th>Time Check-in</th>
                                <th>Time Check-out</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Room Name</th>
                                <th>Location</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Date</th>
                                <th>Time Check-in</th>
                                <th>Time Check-out</th>
                                <th>Action(s)</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                $count = 1;
                                foreach ($room_usage as $usage):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo ($usage['room_name']); ?></td>
                                    <td><?php echo ($usage['location']); ?></td>
                                    <td><?php echo ($usage['student_id']); ?></td>
                                    <td><?php echo ($usage['student_name']); ?></td>
                                    <td><?php echo date("M j, Y", strtotime($usage['date'])); ?></td>
                                    <td><?php echo date("g:i A", strtotime($usage['check_in'])); ?></td>
                                    <td><?php echo date("g:i A", strtotime($usage['check_out'])); ?></td>
                                    <td>
                                        <form method="POST" action="" class="delete-form">
                                            <input type="hidden" name="delete_id" value="<?php echo ($usage['id']); ?>">
                                            <input type="hidden" name="delete_usage" value="1">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<script>
    // Delete confirmation
        $('.delete-btn').on('click', function() {
            const form = $(this).closest('.delete-form');
            const reviewId = form.find('input[name="delete_id"]').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Deleting log ID: " + reviewId); // Debug log
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
</script>

<!-- Footer -->
<?php include("../components/footer.php"); ?>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
<?php include('../components/scripts.php'); ?>

</body>

</html>
