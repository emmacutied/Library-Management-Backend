<?php
session_start();
include 'db.php';

// Fetch returned books data with join to get book and category names
$sql = "
    SELECT rb.return_id, rb.borrow_id, b.title AS Book_Name, c.category_name AS Category, rb.return_date 
    FROM returnedbooks rb
    JOIN borrowedbooks bb ON rb.borrow_id = bb.borrow_id
    JOIN books b ON bb.bookID = b.id
    JOIN categories c ON b.categoryid = c.categoryID
    WHERE rb.return_date IS NOT NULL"; // Show only books that have been returned
$result = $conn->query($sql);
$returnedBooks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Returned Books</title>
    <link rel="stylesheet" href="studReturn.css">
</head>
<body>
    <div class="container">
        <div class="back">
            <button type="BACK" onclick="window.location.href='students.php';">BACK</button>
        </div>
        <h2>Your Returned Books</h2>
        <table>
            <tr>
                <th>Return ID</th>
                <th>Borrow ID</th>
                <th>Book Name</th>
                <th>Category</th>
                <th>Return Date</th>
            </tr>
            <?php foreach ($returnedBooks as $returned): ?>
                <tr>
                    <td><?php echo htmlspecialchars($returned['return_id']); ?></td>
                    <td><?php echo htmlspecialchars($returned['borrow_id']); ?></td>
                    <td><?php echo htmlspecialchars($returned['Book_Name']); ?></td>
                    <td><?php echo htmlspecialchars($returned['Category']); ?></td>
                    <td><?php echo htmlspecialchars($returned['return_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
