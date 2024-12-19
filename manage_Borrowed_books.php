<?php
session_start();
include 'db.php';

$sql = "
    SELECT bb.borrow_id, u.userID, u.full_name AS full_name, b.title AS book_name, bb.borrow_date, bb.return_date
    FROM BorrowedBooks bb
    JOIN Books b ON bb.bookID = b.id
    JOIN Users u ON bb.userID = u.userID
";
$result = $conn->query($sql);
$borrowedBooks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Borrowed Books</title>
    <link rel="stylesheet" href="ManageBooks.css">
</head>
<body>
    <div class="container">
        <div class="back">
            <button type="BACK" onclick="window.location.href='index.php';">BACK</button>
        </div>
        <h2>Manage Borrowed Books</h2>
        <table>
            <tr>
                <th>Borrow ID</th>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Book Name</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
            </tr>
            <?php foreach ($borrowedBooks as $borrowed): ?>
                <tr>
                    <td><?php echo htmlspecialchars($borrowed['borrow_id']); ?></td>
                    <td><?php echo htmlspecialchars($borrowed['userID']); ?></td>
                    <td><?php echo htmlspecialchars($borrowed['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($borrowed['book_name']); ?></td>
                    <td><?php echo htmlspecialchars($borrowed['borrow_date']); ?></td>
                    <td><?php echo htmlspecialchars($borrowed['return_date'] ?? 'Not Returned'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
