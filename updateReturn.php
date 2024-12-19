<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['returnID'])) {
    $returnID = $_POST['returnID'];

    // Fetch the existing record details to ensure it's being updated
    $stmt = $conn->prepare("SELECT * FROM Returned_Books WHERE return_id = ?");
    $stmt->bind_param("i", $returnID);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
    $stmt->close();

    if ($record) {
        // Update logic
        if (isset($_POST['update'])) {
            $username = $_POST['username'];
            $strand_gradeLevel = $_POST['strand_gradeLevel']; 
            $fullName = $_POST['fullName'];
            $gender = $_POST['gender'];
            $address = $_POST['address'];
            $contactNumber = $_POST['contactNumber'];
            $bookName = $_POST['bookName'];
            $status = $_POST['status'];
            $returnDate = $_POST['returnDate'];

            // Begin transaction for safe updating
            $conn->begin_transaction();

            try {
                // Update Returned_Books table
                $updateReturnedSql = "
                    UPDATE Returned_Books SET 
                        username = ?, strand_gradeLevel = ?, fullName = ?, gender = ?, 
                        address = ?, contactNumber = ?, bookName = ?, status = ?, returnDate = ? 
                    WHERE return_id = ?
                ";
                $stmt = $conn->prepare($updateReturnedSql);
                $stmt->bind_param("sssssssssi", $username, $strand_gradeLevel, $fullName, $gender, $address, $contactNumber, $bookName, $status, $returnDate, $returnID);
                $stmt->execute();

                // Ensure only one book and user are matched for updating BorrowedBooks
                $updateBorrowedSql = "
                    UPDATE BorrowedBooks SET 
                        return_date = ? 
                    WHERE userID = (
                        SELECT userID FROM Users WHERE username = ? LIMIT 1
                    ) 
                    AND bookID = (
                        SELECT id FROM Books WHERE title = ? LIMIT 1
                    ) 
                    AND return_date IS NULL
                ";
                $stmt = $conn->prepare($updateBorrowedSql);
                $stmt->bind_param("sss", $returnDate, $username, $bookName);
                $stmt->execute();

                $conn->commit(); // Commit transaction

                $_SESSION['message'] = "Record updated successfully.";
            } catch (Exception $e) {
                $conn->rollback(); // Rollback on error
                $_SESSION['message'] = "Error updating record: " . $e->getMessage();
            }

            // Redirect back to manage_Returned.php to show updated records
            header("Location: manage_Returned.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Record not found.";
        header("Location: manage_Returned.php");
        exit();
    }
} else {
    header("Location: manage_Returned.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Returned Book</title>
    <link rel="stylesheet" href="adminUpdate.css">
</head>
<body>
    <div class="container">
        <h2>Update Returned Book</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="returnID" value="<?php echo htmlspecialchars($record['return_id']); ?>">
            
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($record['Username']); ?>" required>

            <label>Strand/Grade Level:</label>
            <input type="text" name="strand_gradeLevel" value="<?php echo htmlspecialchars($record['strand_gradeLevel']); ?>" required>

            <label>Full Name:</label>
            <input type="text" name="fullName" value="<?php echo htmlspecialchars($record['fullName']); ?>" required>

            <label>Gender:</label>
            <input type="text" name="gender" value="<?php echo htmlspecialchars($record['gender']); ?>" required>

            <label>Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($record['address']); ?>" required>

            <label>Contact Number:</label>
            <input type="text" name="contactNumber" value="<?php echo htmlspecialchars($record['contactNumber']); ?>" required>

            <label>Book Name:</label>
            <input type="text" name="bookName" value="<?php echo htmlspecialchars($record['bookName']); ?>" required>

            <label>Status:</label>
            <input type="text" name="status" value="<?php echo htmlspecialchars($record['status']); ?>" required>

            <label>Return Date:</label>
            <input type="date" name="returnDate" value="<?php echo htmlspecialchars($record['returnDate']); ?>" required>

            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
