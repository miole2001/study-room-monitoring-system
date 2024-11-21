<?php
    ob_start(); 
    include("../components/user-header.php"); 

    // Fetch user details
    $select_user = $connForAccounts->prepare("SELECT * FROM `user_accounts` WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $user = $select_user->fetch(PDO::FETCH_ASSOC);

    // Handle the update profile form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student_id = $_POST['student_id'];
        $name = $_POST['name'];
        $year_level = $_POST['year_level'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!empty($password)) {

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        } else {

            $hashed_password = $user['password'];
        }

        $update_sql = "UPDATE `user_accounts` SET `student_id` = ?, `name` = ?, `year_level` = ?, `email` = ?, `password` = ? WHERE `id` = ?";
        $stmt_update = $connForAccounts->prepare($update_sql);
        
        $stmt_update->execute([$student_id, $name, $year_level, $email, $hashed_password, $user_id]);

        header('Location: profile.php');
        exit;
    }
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
            <h1 class="mb-0 text-gray-800">Dashboard</h1>
        </div>

        <div class="main-body">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="main-breadcrumb">
      <ol class="breadcrumb">

      </ol>
    </nav>
    <!-- /Breadcrumb -->

    <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="<?php echo "../image/profile/" . $user['image']; ?>" alt="profile" class="rounded-circle" width="150">
                        <div class="mt-3">
                            <h4><?php echo ($user['name']); ?></h4>
                            <p class="text-secondary mb-1"><?php echo ($user['email']); ?></p>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#profileModal">
                                Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Student ID</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo ($user['student_id']); ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo ($user['name']); ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Year Level</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo ($user['year_level']); ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo ($user['email']); ?>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo ($user['password']); ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="post">

                    <!-- student id Input -->
                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo ($user['student_id']); ?>">
                    </div>

                    <!-- Name Input -->
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo ($user['name']); ?>">
                    </div>

                    <!-- year level Input -->
                    <div class="form-group">
                        <label for="year_level">Year Level</label>
                        <input type="text" class="form-control" id="year_level" name="year_level" value="<?php echo ($user['year_level']); ?>">
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo ($user['email']); ?>">
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave empty to keep current password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
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

</body>

</html>