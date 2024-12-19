<?php
session_start();
include 'db.php'; // Ensure this file exists and is correctly configured

// Fetch borrowers who have not returned books
$sql = "
SELECT 
    u.username,
    u.strand_gradeLevel,
    u.full_name AS fullName,
    u.gender,
    u.address,
    u.contactNumber,
    b.title AS bookName,
    'Not Returned' AS status
FROM 
    users u
JOIN 
    borrowedbooks bb ON u.userID = bb.userID
JOIN 
    books b ON bb.bookID = b.id
WHERE 
    u.role = 'student' AND 
    bb.return_date IS NULL  -- Show only books that are not returned
ORDER BY 
    u.userID, bb.borrow_id  -- Optional: Sort by user and borrow ID for better readability
";
$result = $conn->query($sql);
$borrowers = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrower List</title>
    <link rel="stylesheet" href="ManageList.css">
</head>
<body>
    <div class="container">
    <div class="back">
            <button type="BACK" onclick="window.location.href='index.php';">BACK</button>
        </div>
        <h2>Borrower List</h2>
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
            </tr>
            <?php foreach ($borrowers as $borrower): ?>
                <tr>
                    <td><?php echo htmlspecialchars($borrower['username']); ?></td>
                    <td><?php echo htmlspecialchars($borrower['strand_gradeLevel']); ?></td>
                    <td><?php echo htmlspecialchars($borrower['fullName']); ?></td>
                    <td><?php echo htmlspecialchars($borrower['gender']); ?></td>
                    <td><?php echo htmlspecialchars($borrower['address']); ?></td>
                    <td><?php echo htmlspecialchars($borrower['contactNumber']); ?></td>
                    <td><?php echo htmlspecialchars($borrower['bookName']); ?></td>
                    <td><?php echo htmlspecialchars($borrower['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
