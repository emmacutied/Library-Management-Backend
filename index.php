<?php
session_start();
include 'db.php';

// Check if the role is set in session and if it is 'admin'
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// Query to fetch all categories from the database
$categories = $conn->query("SELECT * FROM Categories");

// Get the username from the session for greeting
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';

// Query to get the total count of different entities
$totalBooks = $conn->query("SELECT COUNT(*) AS total FROM Books")->fetch_assoc()['total'];
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM Users")->fetch_assoc()['total'];
$totalBorrowedBooks = $conn->query("SELECT COUNT(*) AS total FROM BorrowedBooks")->fetch_assoc()['total'];
$totalReturnedBooks = $conn->query("SELECT COUNT(*) AS total FROM Returned_Books")->fetch_assoc()['total'];
$totalCategories = $conn->query("SELECT COUNT(*) AS total FROM Categories")->fetch_assoc()['total'];

// Query to fetch books with category name, limited to 5 books per category
$sql = "SELECT b.*, c.category_Name 
        FROM Books b 
        JOIN Categories c ON b.categoryID = c.categoryID 
        ORDER BY c.category_Name";
$result = $conn->query($sql);

// Organize books by category
$booksByCategory = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categoryName = $row['category_Name'];
        if (!isset($booksByCategory[$categoryName])) {
            $booksByCategory[$categoryName] = [];
        }
        if (count($booksByCategory[$categoryName]) < 5) {
            $booksByCategory[$categoryName][] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="index.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="header">
        <h1>Librarian Dashboard</h1>
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
                    <h2>Management</h2>
                    <ul>
                        <li><a href="manageUser.php">Manage Users</a></li>
                        <li><a href="manage_Books.php">Manage Books</a></li>
                        <li><a href="manage_Returned.php">Manage Return Books</a></li>
                        <li><a href="manage_Categories.php">Manage Categories</a></li>
                        <li><a href="manage_Borrowed_books.php">Manage Borrowed Books</a></li>
                        <li><a href="manage_Borrower_list.php">Manage Borrowed List</a></li>
                        <li><a href="manage_Borrower_request.php">Manage Borrowed Request</a></li>
                    </ul>
                </div>
            </div>
            <div class="dashboard-content">
                <div class="stats">
                    <div class="stat1"><h3>Total Books</h3><p><?php echo $totalBooks; ?></p></div>
                    <div class="stat2"><h3>Total Users</h3><p><?php echo $totalUsers; ?></p></div>
                    <div class="stat3"><h3>Total Borrowed Books</h3><p><?php echo $totalBorrowedBooks; ?></p></div>
                    <div class="stat4"><h3>Total Returned Books</h3><p><?php echo $totalReturnedBooks; ?></p></div>
                    <div class="stat5"><h3>Total Categories</h3><p><?php echo $totalCategories; ?></p></div>
                </div>

                <!-- Display books per category -->
                <div class="books">
    <?php while ($category = $categories->fetch_assoc()) : ?>
        <?php 
        $categoryID = $category['categoryID'];
        $categoryName = htmlspecialchars($category['category_name']);
        
        // Mag-assign tayo ng background depende sa category ID
        $categoryBackground = '';
        if ($categoryID == 1) {
            $categoryBackground = 'category-bg-1'; // Kung category 1, ito ang background
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
                // Kukunin natin ang mga libro ng bawat category, maximum of 5 books
                $books = $conn->query("SELECT * FROM Books WHERE categoryID = $categoryID LIMIT 5");
                while ($book = $books->fetch_assoc()) :
                ?>
                   <div class="book <?php echo $categoryBackground; ?>"> <!-- Dynamically set the category background -->
    <?php
    // Check kung mahigit 3 words ang title, kung oo, may div class na compressed-text
    $titleClass = str_word_count($book['title']) > 3 ? 'compressed-text' : '';
    // Check kung mahigit 3 words ang author, kung oo, may div class na compressed-text
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
