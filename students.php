<?php
session_start();
include 'db.php';

// Ensure user is logged in and is a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
  die("Access denied. Only students can access this page.");
}

$user_id = $_SESSION['user_id'];

// Fetch total counts for the logged-in student
$totalBooks = $conn->query("SELECT COUNT(*) AS total FROM Books")->fetch_assoc()['total'];
$totalBorrowedBooks = $conn->query("SELECT COUNT(*) AS total FROM borrowedbooks WHERE userID = $user_id AND return_date IS NULL")->fetch_assoc()['total'];
$totalCategories = $conn->query("SELECT COUNT(*) AS total FROM Categories")->fetch_assoc()['total'];

// Get the username for greeting
$username = $_SESSION['username'];

// Fetch categories with limited books
$categories = $conn->query("SELECT * FROM Categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="student.css">
    <title>Student Dashboard</title>
</head>
<body>
    <div class="header">
        <h1>Student Dashboard</h1>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
            <div class="user-icon" onclick="toggleDropdown()">
                <img src="images/icon1.jpg" alt="User Icon" style="width: 30px; height: 30px; border-radius: 50%;">
            </div>
            <div id="userDropdown" class="dropdown">
                <a href="account_info.php">Account Info</a>
                <a href="login.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="dashboard">
            <div class="sidebar">
                <div class="manage-widget">
                    <h2>Manage</h2>
                    <ul>
                        <li><a href="studReturn.php">Return Books</a></li>
                        <li><a href="studBorrow.php">Borrow Books</a></li>
                        <li><a href="studView_BooksBorrowed.php">View Books Borrowed</a></li>
                        <li><a href="studCategories.php">View Categories</a></li>
                    </ul>
                </div>
            </div>
            <div class="dashboard-content">
                <div class="stats">
                    <div class="stat1">
                        <h3>Total Books</h3>
                        <p><?php echo $totalBooks; ?></p>
                    </div>
                    <div class="stat2">
                        <h3>Total Borrowed Books</h3>
                        <p><?php echo $totalBorrowedBooks; ?></p>
                    </div>
                    <div class="stat3">
                        <h3>Total Categories</h3>
                        <p><?php echo $totalCategories; ?></p>
                    </div>
                </div>

                <div class="books">
    <?php while ($category = $categories->fetch_assoc()) : ?>
        <?php 
        $categoryID = $category['categoryID'];
        $categoryName = htmlspecialchars($category['category_name']);
        
        // Set a condition for a specific category ID (example: category ID 1)
        $categoryBackground = '';
        if ($categoryID == 1) {
            $categoryBackground = 'category-bg-1'; // Add a CSS class for this category
        }
        else if($categoryID == 2){
            $categoryBackground = 'category-bg-2';
        }
        else if($categoryID == 3){
            $categoryBackground = 'category-bg-3';
        }
        else if($categoryID == 4){
            $categoryBackground = 'category-bg-4';
        }
        else if($categoryID == 5){
            $categoryBackground = 'category-bg-5';
        }
        else if($categoryID == 6){
            $categoryBackground = 'category-bg-6';
        }
        ?>
        <div class="category-section" id="category-<?php echo $categoryID; ?>">
            <h2><?php echo $categoryName; ?></h2>
            <div class="category-books">
                <?php
                // Fetch up to 5 books for the current category
                $books = $conn->query("SELECT * FROM Books WHERE categoryID = $categoryID LIMIT 5");
                while ($book = $books->fetch_assoc()) :
                ?>
                   <div class="book <?php echo $categoryBackground; ?>"> <!-- Add the dynamic class here -->
    <?php
    // Check if title has more than 3 words
    $titleClass = str_word_count($book['title']) > 3 ? 'compressed-text' : '';
    // Check if author name has more than 3 words
    $authorClass = str_word_count($book['author']) > 3 ? 'compressed-text' : '';
    ?>
    <h4 class="<?php echo $titleClass; ?>"><?php echo htmlspecialchars($book['title']); ?></h4>
    <p class="<?php echo $authorClass; ?>">by <?php echo htmlspecialchars($book['author']); ?></p>
</div>

                <?php endwhile; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
