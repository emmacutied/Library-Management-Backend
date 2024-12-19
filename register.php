<?php
session_start();
include 'db.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Store as plain text
    $role = $_POST['role'];
    $gender = $_POST['gender'];
    $contactNumber = $_POST['contactNumber'];
    $strand_gradeLevel = $_POST['strand_gradeLevel'];
    $address = $_POST['address'];
    $full_name = $_POST['full_name'];
    $status = 'Not Active'; // Set default status to 'Not Active'

    if ($role === 'Admin' || $role === 'Librarian') {
        $strand_gradeLevel = 'N/A';
    }

    // Check if the username already exists
    $sql = "SELECT * FROM Users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already exists. Please choose another.";
    } else {
        $sql = "INSERT INTO Users (username, email, password, role, gender, contactNumber, strand_gradeLevel, address, full_name, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $username, $email, $password, $role, $gender, $contactNumber, $strand_gradeLevel, $address, $full_name, $status);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    }

    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="registers.css">
    <script>
    function toggleGradeStrandFields() {
        var role = document.getElementById("role").value;
        var gradeLevelContainer = document.getElementById("gradeLevelContainer");
        var strandContainer = document.getElementById("strandContainer");

        // Check if the selected role is "Admin" or "Librarian"
        if (role === "Admin" || role === "Librarian") {
            // Hide Grade Level and Strand options
            gradeLevelContainer.style.display = "none";
            strandContainer.style.display = "none";
            document.getElementById("gradeLevel").required = false;
            document.getElementById("strandDropdown").required = false;
        } else {
            // Show Grade Level and make it required
            gradeLevelContainer.style.display = "block";
            document.getElementById("gradeLevel").required = true;
            showStrandOptions(); // Check if strand options need to be shown based on grade level
        }
    }

    function showStrandOptions() {
        var gradeLevel = document.getElementById("gradeLevel").value;
        var strandContainer = document.getElementById("strandContainer");

        // Only show strand options for Grade 11 and Grade 12 if grade level is visible
        if (gradeLevel === "Grade 11" || gradeLevel === "Grade 12") {
            strandContainer.style.display = "block";
            document.getElementById("strandDropdown").required = true;
        } else {
            strandContainer.style.display = "none";
            document.getElementById("strandDropdown").selectedIndex = 0; // Reset strand dropdown
            document.getElementById("strandDropdown").required = false;
        }
    }
</script>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <!-- Role Dropdown with toggle function -->
            <select name="role" id="role" required onchange="toggleGradeStrandFields()">
                <option value="" disabled selected>Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Librarian">Librarian</option>
                <option value="Student">Student</option>
            </select>

            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <input type="text" name="contactNumber" placeholder="Contact Number" required>

            <!-- Grade Level Dropdown -->
            <div id="gradeLevelContainer">
                <select name="strand_gradeLevel" id="gradeLevel" required onchange="showStrandOptions()">
                    <option value="" disabled selected>Select Grade Level</option>
                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>
                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>
                </select>
            </div>

            <!-- Strand Dropdown, initially hidden -->
            <div id="strandContainer" style="display: none;">
                <select name="strand_gradeLevel" id="strandDropdown">
                    <option value="" disabled selected>Select Strand</option>
                    <option value="ICT Grade 11">ICT Grade 11</option>
                    <option value="ICT Grade 12">ICT Grade 12</option>
                    <option value="GAS Grade 11">GAS Grade 11</option>
                    <option value="GAS Grade 12">GAS Grade 12</option>
                    <option value="STEM Grade 11">STEM Grade 11</option>
                    <option value="STEM Grade 12">STEM Grade 12</option>
                    <option value="ADAS Grade 11">ADAS Grade 11</option>
                    <option value="ADAS Grade 12">ADAS Grade 12</option>
                    <option value="HE Grade 11">HE Grade 11</option>
                    <option value="HE Grade 12">HE Grade 12</option>
                </select>
            </div>

            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="submit" value="Register">  
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
