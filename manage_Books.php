<?php
session_start();
include 'db.php';

// Update the status of books based on returned records
$updateSql = "
    UPDATE Books b
    INNER JOIN BorrowedBooks bb ON b.id = bb.bookID
    INNER JOIN ReturnedBooks rb ON bb.borrow_id = rb.borrow_id
    SET b.status = 'available'
    WHERE rb.return_date IS NOT NULL
";
$conn->query($updateSql);

// Fetch all books from the Books table
$sql = "SELECT * FROM Books";
$result = $conn->query($sql);
$books = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books</title>
    <link rel="stylesheet" href="ManageBooks.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <div class="back">
            <button type="BACK" onclick="window.location.href='index.php';">BACK</button>
        </div>
        <h2>Manage Books</h2>
        <table>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Status</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['id']); ?></td>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['genre']); ?></td>
                    <td class="<?php echo htmlspecialchars($book['status'] == 'available' ? 'available' : 'borrowed'); ?>">
                        <?php echo htmlspecialchars($book['status']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
