<?php
session_start();
include 'db.php'; // Ensure this file exists and is correctly configured

// Approve user if an admin submits the form to approve a user
if (isset($_POST['approve_user_id'])) {
    $userID = $_POST['approve_user_id'];
    $updateStatusSql = "UPDATE users SET status = 'Active' WHERE userID = ?";
    $stmt = $conn->prepare($updateStatusSql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
}

// Fetch users from the database
$sql = "SELECT `userID`, `username`, `email`, `role`, `gender`, `contactNumber`, `strand_gradeLevel`, `address`, `status` FROM users";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="manageusers.css">
</head>
<body>
    <div class="container">
        <div class="back">
            <button type="BACK" onclick="window.location.href='index.php';">BACK</button>
        </div>
        <h2>Manage Users</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Gender</th>
                <th>Contact Number</th>
                <th>Strand/Grade Level</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['userID']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['gender']); ?></td>
                    <td><?php echo htmlspecialchars($user['contactNumber']); ?></td>
                    <td><?php echo htmlspecialchars($user['strand_gradeLevel']); ?></td>
                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                    <td><?php echo htmlspecialchars($user['status']); ?></td>
                    <td>
                        <?php if ($user['status'] == 'Not Active'): ?>
                            <form method="post" action="">
                                <input type="hidden" name="approve_user_id" value="<?php echo $user['userID']; ?>">
                                <button type="submit">Approve</button>
                            </form>
                        <?php else: ?>
                            Approved
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
