<?php 

    include("../components/admin-header.php"); 

    // Fetch all votes using PDO
    $room_usage = $connForReservation->query("SELECT * FROM `room_reservations`")->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT COUNT(*) AS student_count FROM `user_accounts`";
    $run_query = $connForAccounts->prepare($query);
    $run_query->execute();
    $student_count = $run_query->fetch(PDO::FETCH_ASSOC)['student_count'];


    $query = "SELECT COUNT(*) AS room_count FROM `rooms`";
    $run_query = $connForReservation->prepare($query);
    $run_query->execute();
    $room_count = $run_query->fetch(PDO::FETCH_ASSOC)['room_count'];


    $query = "SELECT COUNT(*) AS usage_count FROM `room_reservations`";
    $run_query = $connForReservation->prepare($query);
    $run_query->execute();
    $usage_count = $run_query->fetch(PDO::FETCH_ASSOC)['usage_count'];

?>


<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <?php include("../components/topbar.php"); ?>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Student Accounts
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $student_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Room Usage
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $usage_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Rooms
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $room_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-building fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTable -->
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

<!-- Footer -->
<?php include("../components/footer.php"); ?>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include("../components/scripts.php"); ?>
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable();
        
    });
</script>
</body>

</html>