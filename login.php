<?php
session_start();
include 'db.php'; // Include the database connection

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Escape user inputs to prevent SQL injection
    $inputUsername = mysqli_real_escape_string($conn, $inputUsername);

    // Prepare the SQL statement to fetch the user
    $sql = "SELECT * FROM Users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUsername); // Bind the username parameter
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set from the prepared statement
    $user = $result->fetch_assoc(); // Fetch the result as an associative array

    // Check if user exists
    if ($user) {
        // Check if the account is approved by the admin
        if ($user['status'] !== 'Active') {
            $errorMessage = "Your account is awaiting approval from an administrator.";
        } else {
            // Check if password is hashed
            if (password_verify($inputPassword, $user['password'])) {
                // Password is verified through hashing
                $_SESSION['user_id'] = $user['userID'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
            } elseif ($inputPassword === $user['password']) {
                // Temporary plain text comparison if passwords are not yet hashed
                $_SESSION['user_id'] = $user['userID'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
            } else {
                $errorMessage = "Invalid username or password.";
            }

            // Redirect based on user role if no errors occurred
            if (empty($errorMessage)) {
                if ($user['role'] === 'admin') {
                    header("Location: index.php"); // Admin dashboard
                } elseif ($user['role'] === 'student') {
                    header("Location: students.php"); // Student dashboard
                }
                exit();
            }
        }
    } else {
        // Display an error message if username or password is incorrect
        $errorMessage = "Invalid username or password.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">  
            <button type="button" onclick="window.location.href='register.php';">Register</button>
        </form>
        <?php if (!empty($errorMessage)) echo "<p class='error'>$errorMessage</p>"; ?>
    </div>
</body>
</html>
