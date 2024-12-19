<?php
session_start();
include 'db.php';

// Fetch all available books along with their categories
$sql = "
    SELECT b.id, b.title, b.author, c.category_name 
    FROM books b
    JOIN categories c ON b.categoryid = c.categoryID
    WHERE b.status = 'available'";
$result = $conn->query($sql);
$books = $result->fetch_all(MYSQLI_ASSOC);

// Process borrowing request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow'])) {
    $bookId = $_POST['book_id'];
    $userId = $_SESSION['user_id']; // Ensure this matches the session variable name from login

    // Insert a new borrow request
    $sql_request = "INSERT INTO borrow_requests (userID, bookID, request_date, status) VALUES (?, ?, NOW(), 'pending')";
    $stmt = $conn->prepare($sql_request);
    $stmt->bind_param("ii", $userId, $bookId);
    $stmt->execute();

    header("Location: studBorrow.php"); // Redirect after processing
    exit();
}
?>

<!-- HTML Display -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Books</title>
    <link rel="stylesheet" href="studBorrow.css">
</head>
<body>
    <div class="container">
        <div class="back">
            <button type="BACK" onclick="window.location.href='students.php';">BACK</button>
        </div>
        <h2>Available Books</h2>
        <table>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['id']); ?></td>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['category_name']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['id']); ?>">
                            <button type="submit" name="borrow">Borrow</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
