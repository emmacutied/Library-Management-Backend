<?php
session_start();
include 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's account information, including the password
$sql = "SELECT username, email, role, gender, contactNumber, strand_gradeLevel, address, full_name, password FROM Users WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// If the user information is found, display it
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User information not found.";
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Information</title>
    <link rel="stylesheet" href="account_info.css">
</head>
<body>
    <div class="header">
        <h1>Account Information</h1>
    </div>
    <div class="container">
        <div class="back">
            <!-- Redirect based on the user's role -->
            <button type="BACK" onclick="redirectToDashboard('<?php echo $user['role']; ?>')">BACK</button>
        </div>
        <table>
            <tr>
                <th>Username</th>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><?php echo htmlspecialchars($user['password']); ?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo htmlspecialchars($user['gender']); ?></td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td><?php echo htmlspecialchars($user['contactNumber']); ?></td>
            </tr>
            <tr>
                <th>Strand/Grade Level</th>
                <td><?php echo htmlspecialchars($user['strand_gradeLevel']); ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
            </tr>
            <tr>
                <th>Full Name</th>
                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
            </tr>
        </table>
    </div>

    <script>
        // Function to redirect based on user role
        function redirectToDashboard(role) {
            if (role === 'student') {
                window.location.href = 'students.php';
            } else if (role === 'admin' || role === 'librarian') {
                window.location.href = 'index.php';
            } else {
                alert("Invalid role. Cannot redirect to dashboard.");
            }
        }
    </script>
</body>
</html>
