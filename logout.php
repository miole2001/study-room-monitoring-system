<?php

include 'connection.php';

// Check if user is logged in
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];

    // Fetch user details to determine user type
    $verify_user = $connForAccounts->prepare("SELECT email, user_type FROM `user_accounts` WHERE id = ?");
    $verify_user->execute([$user_id]);
    $user = $verify_user->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $email = $user['email'];
        $user_type = $user['user_type'];

        // Log the logout action
        if ($user_type === 'admin') {
            // Prepare statement for admin logs
            $log_stmt = $connForLogs->prepare("INSERT INTO admin_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
        } else if ($user_type === 'user') {
            // Prepare statement for user logs
            $log_stmt = $connForLogs->prepare("INSERT INTO user_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
        } else {
            // Optional: log unexpected user types or handle them
        }

        // Execute the log statement if it was prepared
        if (isset($log_stmt)) {
            $log_stmt->execute([$email, $user_type]);
        } else {
            // Optional: handle the case where no log statement was prepared
            error_log("No log statement prepared for user type: $user_type");
        }
    }
}

// Clear the cookie
setcookie('user_id', '', time() - 1, '/' );

// Redirect to homepage
header('location: login.php');
exit();

?>
