<?php
session_start();
include 'db.php';

// Synchronization query for returned books
$syncSql = "
    INSERT INTO Returned_Books (username, strand_gradeLevel, fullName, gender, address, contactNumber, bookName, status, returnDate)
    SELECT 
        u.username, 
        u.strand_gradeLevel, 
        u.full_name AS fullName, 
        u.gender, 
        u.address, 
        u.contactNumber, 
        b.title AS bookName, 
        'Returned' AS status, 
        bb.return_date AS returnDate
    FROM BorrowedBooks bb
    JOIN Users u ON bb.userID = u.userID
    JOIN Books b ON bb.bookID = b.id
    WHERE bb.return_date IS NOT NULL
      AND NOT EXISTS (
          SELECT 1 
          FROM Returned_Books rb 
          WHERE rb.returnDate = bb.return_date 
            AND rb.bookName = b.title 
            AND rb.username = u.username
      )
";
$conn->query($syncSql);

$totalReturnedBooksResult = $conn->query("SELECT COUNT(*) AS totalReturned FROM Returned_Books");
$totalReturnedBooks = $totalReturnedBooksResult->fetch_assoc()['totalReturned'];

$sql = "
    SELECT 
        return_id, 
        username, 
        strand_gradeLevel, 
        fullName, 
        gender, 
        address, 
        contactNumber, 
        bookName, 
        status, 
        returnDate 
    FROM Returned_Books
";
$result = $conn->query($sql);
$returnedBooks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Returned Books</title>
    <link rel="stylesheet" href="managereturn.css">
</head>
<body>
    <div class="container">
        <div class="back">
            <button type="BACK" onclick="window.location.href='index.php';">BACK</button>
        </div>
        <h2>Manage Returned Books</h2>
        <p>Total Returned Books: <?php echo htmlspecialchars($totalReturnedBooks); ?></p>
        <table>
            <tr>
                <th>Username</th>
                <th>Strand/Grade Level</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Book Name</th>
                <th>Status</th>
                <th>Return Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($returnedBooks as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['username']); ?></td>
                    <td><?php echo htmlspecialchars($book['strand_gradeLevel']); ?></td>
                    <td><?php echo htmlspecialchars($book['fullName']); ?></td>
                    <td><?php echo htmlspecialchars($book['gender']); ?></td>
                    <td><?php echo htmlspecialchars($book['address']); ?></td>
                    <td><?php echo htmlspecialchars($book['contactNumber']); ?></td>
                    <td><?php echo htmlspecialchars($book['bookName']); ?></td>
                    <td><?php echo htmlspecialchars($book['status']); ?></td>
                    <td><?php echo htmlspecialchars($book['returnDate']); ?></td>
                    <td>
                        <form action="updateReturn.php" method="post" style="display:inline;">
                            <input type="hidden" name="returnID" value="<?php echo htmlspecialchars($book['return_id']); ?>">
                            <button type="submit">Update</button>
                        </form>
                        <form action="deleteReturn.php" method="post" style="display:inline;">
                           <input type="hidden" name="returnID" value="<?php echo htmlspecialchars($book['return_id']); ?>">
                              <button type="submit" onclick="return confirm('Are you sure you want to delete this return record?');">Delete</button>
                                </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
