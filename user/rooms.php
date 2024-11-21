<?php 
    ob_start(); 
    include("../components/user-header.php"); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enter_room'])) {
        $room_name = $_POST['room_name'];
        $location = $_POST['location'];
        $student_id = $_POST['student_id'];
        $student_name = $_POST['student_name'];
        $date = $_POST['date'];
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];

        $insert_sql = "INSERT INTO `room_reservations` (`room_name`, `location`, `student_id`, `student_name`, `date`, `check_in`, `check_out`) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $connForReservation->prepare($insert_sql);
        $stmt_insert->execute([$room_name, $location, $student_id, $student_name, $date, $check_in, $check_out]);

        header('Location: rooms.php');
        exit;

    }

    $all_rooms = $connForReservation->query("SELECT * FROM `rooms`")->fetchAll(PDO::FETCH_ASSOC);

    $student_information = $connForAccounts->query("SELECT * FROM `user_accounts`")->fetchAll(PDO::FETCH_ASSOC);

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
            <h1 class="mb-0 text-gray-800">ALL ROOMS</h1>
        </div>



        <div class="row">
            <?php foreach ($all_rooms as $room): ?>
                <div class="col-sm-3 mb-3">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo "../image/rooms/" . $room['image']; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h2 class="card-title text-uppercase text-center"><?php echo($room['room_name']); ?></h2>
                            <p class="card-text">Location: <?php echo($room['location']); ?></p>
                            <p class="card-text">Capacity: <?php echo($room['capacity']); ?></p>
                            <p class="card-text">Status: <?php echo($room['status']); ?></p>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#enterRoom">
                                Enter Room
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

    <!-- add Modal -->
    <div class="modal fade" id="enterRoom" tabindex="-1" role="dialog" aria-labelledby="enterRoomLabel" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enterRoomLabel">Enter Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">

                        <input type="hidden" class="form-control" id="room_name" name="room_name" value="<?php echo ($room['room_name']); ?>" readonly>

                        <input type="hidden" class="form-control" id="location" name="location" value="<?php echo ($room['location']); ?>" readonly>


                        <?php foreach ($student_information as $student): ?>
                            <div class="form-group">
                                <label for="student_id">Student ID</label>
                                <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo($student['student_id']); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="student_name">Student Name</label>
                                <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo($student['name']); ?>" readonly>
                            </div>
                        <?php endforeach; ?>

                        <div class="form-group">
                            <label for="date">Date Entered</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>

                        <div class="form-group">
                            <label for="check_in">Check in time</label>
                            <input type="time" class="form-control" id="check_in" name="check_in" required>
                        </div>

                        <div class="form-group">
                            <label for="check_out">Check out time</label>
                            <input type="time" class="form-control" id="check_out" name="check_out" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="enter_room">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Footer -->
<?php include("../components/footer.php"); ?>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include("../components/scripts.php"); ?>
</body>

</html>