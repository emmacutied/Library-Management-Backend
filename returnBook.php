<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

// Handle the return request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrowedBookId'])) {
    $borrowedBookId = $_POST['borrowedBookId'];

    // Insert into ReturnedBooks table
    $sql = "INSERT INTO returnedbooks (borrow_id) VALUES (?)";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("i", $borrowedBookId);
    
    if ($stmt->execute()) {
        // Update borrowedbooks to set return_date
        $sqlUpdate = "UPDATE borrowedbooks SET return_date = NOW() WHERE borrow_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("i", $borrowedBookId);
        $stmtUpdate->execute();

        // Redirect to ViewBooksBorrowed.php with success parameter to trigger success message
        header("Location: studView_BooksBorrowed.php?returnSuccess=true");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    } 
}
?>
