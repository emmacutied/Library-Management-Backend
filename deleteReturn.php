<?php
session_start();
include 'db.php';

if (isset($_POST['returnID'])) {
    $returnID = $_POST['returnID'];

    // Retrieve the record to find associated username and bookName
    $selectSql = "SELECT username, bookName FROM Returned_Books WHERE return_id = ?";
    $stmt = $conn->prepare($selectSql);
    $stmt->bind_param("i", $returnID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
        $username = $record['username'];
        $bookName = $record['bookName'];

        // Begin transaction for safe deletion
        $conn->begin_transaction();

        try {
            // Delete from Returned_Books
            $deleteReturnedSql = "DELETE FROM Returned_Books WHERE return_id = ?";
            $stmt = $conn->prepare($deleteReturnedSql);
            $stmt->bind_param("i", $returnID);
            $stmt->execute();

            // Delete matching record from BorrowedBooks
            $deleteBorrowedSql = "
                DELETE FROM BorrowedBooks 
                WHERE userID = (SELECT userID FROM Users WHERE username = ?) 
                  AND bookID = (SELECT id FROM Books WHERE title = ? LIMIT 1)
            ";
            $stmt = $conn->prepare($deleteBorrowedSql);
            $stmt->bind_param("ss", $username, $bookName);
            $stmt->execute();

            $conn->commit(); // Commit transaction
        } catch (Exception $e) {
            $conn->rollback(); // Rollback on error
            echo "Error deleting record: " . $e->getMessage();
        }
    } else {
        echo "Record not found.";
    }

    // Redirect back to manage_Returned.php
    header("Location: manage_Returned.php");
    exit();
} else {
    echo "No record ID provided.";
}
?>
