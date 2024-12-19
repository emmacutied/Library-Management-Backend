<?php
session_start();
include 'db.php';

// Fetch all available books
$sql = "SELECT * FROM books WHERE status = 'available'";
$result = $conn->query($sql);
$books = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all borrow requests
$sql_requests = "SELECT br.request_id, u.username, u.userID, b.title, b.id AS bookID, br.request_date 
                 FROM borrow_requests br
                 JOIN users u ON br.userID = u.userID
                 JOIN books b ON br.bookID = b.id
                 WHERE br.status = 'pending'";
$result_requests = $conn->query($sql_requests);
$borrowRequests = $result_requests->fetch_all(MYSQLI_ASSOC);

$successMessage = ''; // Variable to hold success message

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
    $requestId = $_POST['request_id'];
    $userId = $_POST['user_id'];
    $bookId = $_POST['book_id'];

    // Approve request and update tables as needed
    $update_sql = "UPDATE borrow_requests SET status = 'approved' WHERE request_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();

    // Add book to borrowedbooks table
    $insert_sql = "INSERT INTO borrowedbooks (userID, bookID, borrow_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ii", $userId, $bookId);
    $stmt->execute();

    // Update book status to 'borrowed'
    $update_book_sql = "UPDATE books SET status = 'borrowed' WHERE id = ?";
    $stmt = $conn->prepare($update_book_sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();

    $successMessage = 'Book request approved successfully!'; // Set success message
}

// Add a script to display the success message if set
?>

<!-- HTML Display -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Requests</title>
    <link rel="stylesheet" href="manageBorrower_request.css">
    <script>
        // Function to show alert if success message is set
        function showAlert() {
            <?php if ($successMessage): ?>
                alert('<?php echo addslashes($successMessage); ?>');
            <?php endif; ?>
        }
    </script>
</head>
<body onload="showAlert()"> <!-- Call showAlert when page loads -->
    <div class="container">
    <div class="back">
            <button type="BACK" onclick="window.location.href='index.php';">BACK</button>
        </div>
        <h2>Borrow Requests</h2>
        <table>
            <tr>
                <th>Request ID</th>
                <th>Username</th>
                <th>Book Title</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>
            <?php foreach ($borrowRequests as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['request_id']); ?></td>
                    <td><?php echo htmlspecialchars($request['username']); ?></td>
                    <td><?php echo htmlspecialchars($request['title']); ?></td>
                    <td><?php echo htmlspecialchars($request['request_date']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['request_id']); ?>">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($request['userID']); ?>">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($request['bookID']); ?>">
                            <button type="submit" name="approve">Approve</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
