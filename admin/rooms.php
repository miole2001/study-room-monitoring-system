<?php 
    ob_start(); 
    include('../components/admin-header.php'); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
        $room = $_FILES['room']['name'];
        $name = $_POST['name'];
        $location = $_POST['location'];
        $capacity = $_POST['capacity'];
        $status = $_POST['status'];

        $insert_sql = "INSERT INTO `rooms` (`image`, `room_name`, `location`, `capacity`, `status`) 
        VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $connForReservation->prepare($insert_sql);
        $stmt_insert->execute([$room, $name, $location, $capacity, $status]);

        header('Location: rooms.php');
        exit;

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_room'])) {
        
        $name = $_POST['name'];
        $location = $_POST['location'];
        $capacity = $_POST['capacity'];
        $status = $_POST['status'];
        $room_id = $_POST['room_id'];

        $update_sql = "UPDATE `rooms` SET `room_name` = ?, `location` = ?, `capacity` = ?, `status` = ? WHERE `id` = ?";
        $stmt_update = $connForReservation->prepare($update_sql);
        $stmt_update->execute([$name, $location, $capacity, $status, $room_id]);

        header('Location: rooms.php');
        exit;
    }

    if (isset($_GET['delete_room'])) {
        $room_id = $_GET['delete_room'];

        $delete_sql = "DELETE FROM `rooms` WHERE `id` = ?";
        $stmt_delete = $connForReservation->prepare($delete_sql);
        $stmt_delete->execute([$room_id]);

        header('Location: rooms.php');
        exit;
    }


    $all_rooms = $connForReservation->query("SELECT * FROM `rooms`")->fetchAll(PDO::FETCH_ASSOC);

?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mt-4 mb-5" data-toggle="modal" data-target="#addRoom">
            Add New Room
        </button>

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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editRoom">
                                Edit
                            </button>
                            <!-- Delete activity Button -->
                            <button type="button" class="btn btn-danger delete-btn" data-id="<?php echo($room['id']); ?>">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

    <!-- add room Modal -->
    <div class="modal fade" id="addRoom" tabindex="-1" role="dialog" aria-labelledby="addRoomTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomTitle">Add New Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="room">Room Image</label>
                            <input type="file" class="form-control" id="room" name="room" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Room Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="location">Room Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>

                        <div class="form-group">
                            <label for="capacity">Capacity</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="" disabled selected>Select Status</option>
                                <option value="Occupied">Occupied</option>
                                <option value="Available">Available</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_room">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- edit room Modal -->
    <div class="modal fade" id="editRoom" tabindex="-1" role="dialog" aria-labelledby="editRoomLabel" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomLabel">Edit Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="room_id" value="<?php echo ($room['id']); ?>">

                        <div class="form-group">
                            <label for="name">Room Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo ($room['room_name']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="location">Room Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo ($room['location']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="capacity">Capacity</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo ($room['capacity']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Occupied" <?php echo ($room['status'] === 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
                                <option value="Available" <?php echo ($room['status'] === 'Available') ? 'selected' : ''; ?>>Available</option>
                                <option value="Maintenance" <?php echo ($room['status'] === 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                                <option value="Closed" <?php echo ($room['status'] === 'Closed') ? 'selected' : ''; ?>>Closed</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit_room">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "rooms.php?delete_room=" + roomId;
                }
            });
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

