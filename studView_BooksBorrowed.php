<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

$user_id = $_SESSION['user_id'];

// Fetch books borrowed by this student that have not yet been returned
$sql = "
    SELECT b.id AS book_id, b.title, b.author, bb.borrow_date, 
           'Not Yet Returned' AS status,
           bb.borrow_id
    FROM borrowedbooks bb
    JOIN books b ON bb.bookID = b.id
    WHERE bb.userID = ? AND bb.return_date IS NULL"; // Show only books that are not returned
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$borrowedBooks = $result->fetch_all(MYSQLI_ASSOC);

// Check if return success message is set in the URL
$returnSuccess = isset($_GET['returnSuccess']) && $_GET['returnSuccess'] == 'true';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Borrowed Books</title>
    <link rel="stylesheet" href="studView.css">
    <script>
        // Show success message if return was successful
        function showSuccessMessage() {
            alert("Successfully Returned");
            window.location.href = "studView_BooksBorrowed.php"; // Redirect to students.php after alert
        }
    </script>
</head>
<body>
    <div class="container">
        <?php if ($returnSuccess): ?>
            <script>showSuccessMessage();</script>
        <?php endif; ?>
        
        <div class="back">
            <button type="BACK" onclick="window.location.href='students.php';">BACK</button>
        </div>

        <h2>Your Borrowed Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Borrow Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($borrowedBooks as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['borrow_date']); ?></td>
                    <td><?php echo htmlspecialchars($book['status']); ?></td>
                    <td>
                        <form action="returnBook.php" method="POST" onsubmit="return confirm('Are you sure you want to return this book?');">
                            <input type="hidden" name="borrowedBookId" value="<?php echo $book['borrow_id']; ?>">
                            <button type="submit">Return Book</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
