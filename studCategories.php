<?php
session_start();
include 'db.php';

$sql = "SELECT * FROM Categories"; // Make sure this table exists
$result = $conn->query($sql);
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="ManageCategories.css">
</head>
<body>
    <div class="container">
    <div class="back">
            <button type="BACK" onclick="window.location.href='students.php';">BACK</button>
        </div>
        <h2>Manage Categories</h2>
        <table>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
            </tr>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['categoryID']); ?></td>
                    <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
